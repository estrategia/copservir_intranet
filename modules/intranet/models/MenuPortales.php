<?php

namespace app\modules\intranet\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "t_MenuPortales".
 *
 * @property string $idMenuPortales
 * @property string $idPortal
 * @property string $nombre
 * @property string $urlMenu
 * @property integer $tipo
 * @property string $icono
 * @property string $fechaInicio
 * @property string $fechaFin
 * @property integer $estado
 * @property string $fechaRegistro
 * @property string $fechaActualizacion
 *
 * @property Portal $idPortal
 */
class MenuPortales extends \yii\db\ActiveRecord {

    const APROBADO = 1;
    const INACTIVO = 0;
    const ENLACE_INTERNO = 1;
    const ENLACE_EXTERNO = 2;
    const SIN_ENLACE = 3;

    public static function tableName() {
        return 't_MenuPortales';
    }

    public function rules() {
        return [
            [['idPortal', 'nombre', 'tipo', 'estado'], 'required'],
            [['idPortal', 'tipo', 'estado', 'idMenuPortalPadre'], 'integer'],
            [['fechaRegistro', 'fechaActualizacion'], 'safe'],
            [['nombre'], 'string', 'max' => 50],
            [['urlMenu'], 'string', 'max' => 500],
            [['ordenMenu'], 'integer', 'max' => 99, 'min'=>0],
            [['loginVisualizacion'], 'integer', 'max' => 2, 'min'=>0],
            [['icono'], 'string', 'max' => 45],
            [['idPortal'], 'exist', 'skipOnError' => true, 'targetClass' => Portal::className(), 'targetAttribute' => ['idPortal' => 'idPortal']],
            ['idMenuPortalPadre', 'validateUrlPadre'],
            ['idMenuPortalPadre', 'validateIdPadre'],
            [['idMenuPortalPadre'], 'exist', 'skipOnError' => true, 'targetClass' => self::className(), 'targetAttribute' => [ 'idMenuPortalPadre' => 'idMenuPortales']],
        ];
    }

    public function attributeLabels() {
        return [
            'idMenuPortales' => 'Id Menu Portales',
            'idPortal' => 'Portal',
            'nombre' => 'Nombre',
            'urlMenu' => 'Url Menu',
            'tipo' => 'Tipo',
            'icono' => 'Icono',
            'estado' => 'Estado',
            'fechaRegistro' => 'Fecha Registro',
            'fechaActualizacion' => 'Fecha Actualizacion',
            'idMenuPortalPadre' => 'Menu Padre',
            'ordenMenu' => 'Posicion',
            'loginVisualizacion' => 'Visualizacion Login'
        ];
    }

    public function validateIdPadre($attribute, $params) {
        $padre = self::findOne(['idMenuPortales' => $this->idMenuPortalPadre]);
        if ($this->idPortal != $padre->idPortal) {
            $this->addError($attribute, 'Los portales no corresponden');
        }
    }

    public function validateUrlPadre($attribute, $params) {
        $padre = self::findOne(['idMenuPortales' => $this->idMenuPortalPadre]);
        if ($padre->tipo !== self::SIN_ENLACE) {
            $this->addError($attribute, 'El menu padre no puede tener enlace');
        }
    }

    // RELACIONES

    public function getObjPortal() {
        return $this->hasOne(Portal::className(), ['idPortal' => 'idPortal']);
    }

    public function getObjMenuPadre() {
        return $this->hasOne(self::className(), ['idMenuPortales' => 'idMenuPortalPadre']);
    }

    public function getObjMenuHijos() {
        return $this->hasMany(self::className(), ['idMenuPortalPadre' => 'idMenuPortales'])->orderBy(['ordenMenu'=>SORT_ASC]);;
    }

    // CONSULTAS

    public static function traerMenuPortalesIndex($portal) {
        $query = MenuPortales::find()
                ->select(['t_MenuPortales.idMenuPortales', 't_MenuPortales.nombre', 't_MenuPortales.icono', 't_MenuPortales.tipo', 't_MenuPortales.urlMenu'])
                ->joinWith(['objPortal'])
                ->where('m_Portal.nombrePortal=:portal AND t_MenuPortales.estado=:estado AND t_MenuPortales.idMenuPortalPadre IS NULL ')
                ->addParams([':estado' => self::APROBADO, ':portal' => $portal])
                ->orderBy(['ordenMenu' => SORT_ASC])
                ->all();

        return $query;
    }

    /**
     * Consulta para obtener los padres del menu
     * @return modelos MenuPortales
     */
    public static function getPadres($idPortal) {
        return self::find()->where('idMenuPortalPadre is null and idPortal =:idPortal ') //and idMenuPortales !=:idMenuPortales
                        ->orderBy(['ordenMenu' => SORT_ASC])
                        ->addParams([':idPortal' => $idPortal])
                        ->all();
    }

    /**
     * Consulta para obtener los hijos del un modelo Menu
     * @return modelos MenuPortales
     */
    public static function getHijos($idMenuPortales, $idPortal) {
        $query = self::find()
                ->where("( idMenuPortalPadre =:idMenuPortales and idPortal =:idPortal)") //and idMenuPortales !=:idMenuPortales
                ->orderBy(['ordenMenu' => SORT_ASC])
                ->addParams([':idMenuPortales' => $idMenuPortales, ':idPortal' => $idPortal])
                ->all();

        return $query;
    }

    // FUNCIONES
    public function esExterno() {
        if ($this->tipo == self::ENLACE_EXTERNO) {
            return true;
        } else {
            return false;
        }
    }

    public static function getListaPortales() {
        $opciones = Portal::find()->asArray()->all();
        return ArrayHelper::map($opciones, 'idPortal', 'nombrePortal');
    }

    public static function traerMenuPortal($nombrePortal, $idMenu) {
        $objMenu = self::find()
                ->joinWith(['objPortal'])
                ->where("m_Portal.nombrePortal=:portal AND t_MenuPortales.idMenuPortales=:menu AND t_MenuPortales.estado=:estado", [':portal' => $nombrePortal, ':menu' => $idMenu, ':estado' => self::APROBADO]);

        return $objMenu->one();
        //var_dump($objMenu->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql);exit();
    }

    public function getUrlInterna($nombrePortal) {
        return [ "/$nombrePortal/sitio/contenido?menu=" . $this->idMenuPortales];
    }

    public static function generarMenu($portal) {
        $listMenu = self::traerMenuPortalesIndex($portal);

        foreach ($listMenu as $objMenu) {
            self::generarSubMenu($objMenu, $portal);
        }
    }

    public static function generarSubMenu($objMenu, $portal) {
        $menuClass = "";
        $submenuClass = "dropdown-menu";

        if ($portal != 'intranet') {
            $menuClass = "dropdown";
        }else{
          $submenuClass = "sub-menu";
        }

        if (empty($objMenu->objMenuHijos)) {
            if ($objMenu->tipo == self::ENLACE_EXTERNO) {
                $urlMenu = Funciones::reemplazarPatronDocumentoUsuario($objMenu->urlMenu);
                echo "<li><a href='$urlMenu'
                target='_blank'> <i class='$objMenu->icono'></i> <span class='title'>$objMenu->nombre</span> </a>
                </li>";
            } else if ($objMenu->tipo == self::ENLACE_INTERNO) {
                echo "<li>";
                echo \yii\helpers\Html::a("<i class='$objMenu->icono'></i> <span class='title'>$objMenu->nombre</span>",
                 $objMenu->getUrlInterna($portal), []);
                echo "</li>";
            } else {
                echo "<li><a href='#'>
                <i class='$objMenu->icono'></i> <span class='title'>$objMenu->nombre</span> </a></li>";
            }
        } else {

            if ($objMenu->objMenuHijos && $objMenu->idMenuPortalPadre != NULL) {
              $menuClass = 'dropdown-submenu';
            }
            $icono = '';
            if ($objMenu->objMenuHijos && $objMenu->idMenuPortalPadre == NULL) {
              $icono = "<span class='caret'></span>";
            }
            echo "<li class='$menuClass'>";
            if ($portal == 'intranet') {
                echo "<a href='javascript:;'><i class='$objMenu->icono'></i> <span class='title'>$objMenu->nombre</span><span class='arrow'></span></a>";
            } else {
                echo "<a class='dropdown-toggle' data-toggle='dropdown' href='#'><i class='$objMenu->icono'></i> <span class='title'>$objMenu->nombre</span>$icono</a>";
            }
            echo "<ul class='$submenuClass'>";

            foreach ($objMenu->objMenuHijos as $objSubMenu) {
                self::generarSubMenu($objSubMenu, $portal);
            }
          echo "</ul>";
          echo "</li>";
        }
    }

    public static function construirMenuModal($idPortal, $SoloVisualizar = false) {
        $padres = self::getPadres($idPortal);
        $html = self::crearMenu($padres, ' ', $idPortal, $SoloVisualizar);
        return $html;
    }

    public static function crearMenu($padres, $html, $idPortal, $SoloVisualizar = false) {
        if (empty($padres)) {
            $html = $html . '';
        } else {
            foreach ($padres as $item) {
                $hijos = self::getHijos($item->idMenuPortales, $idPortal);
                $html = self::RenderItemAdmin($item, $hijos, $html, $idPortal, $SoloVisualizar);
            }
        }
        return $html;
    }

    public static function RenderItemAdmin($item, $hijos, $html, $idPortal, $SoloVisualizar= false)
    {
        // $SoloVisualizar = true;
        $htmlBotonAsignar = '';
        $htmlBadgePosicion = '';
        if (!$SoloVisualizar) {
            
          if ($item->tipo == self::SIN_ENLACE) {
            $htmlBotonAsignar = '<button href="#" data-role = "asignar-submenu-portal" data-menu = "'.$item->idMenuPortales.'"
            data-texto = "'.$item->nombre.'" class="btn btn-mini btn-success pull-right" id="button'.$item->idMenuPortales.'">
              asignar
            </button>';
          }
        }
        if ($SoloVisualizar) {
            $htmlBadgePosicion = '<span class="badge"> '.$item->ordenMenu.' </span>';
        }  

      $html = $html .
                      '
                      <a href="#'.$item->idMenuPortales.'" class="list-group-item" data-toggle="collapse" id="item'.$item->idMenuPortales.'">
                        <i class="glyphicon glyphicon-chevron-right"></i>'.$item->nombre.'
                        '.$htmlBotonAsignar.' '.$htmlBadgePosicion.'
                      </a>
                      <div class="list-group collapse" id="' . $item->idMenuPortales . '">
                        ' . self::crearMenu($hijos, '', $idPortal, $SoloVisualizar) . '
                      </div>';

        return $html;
    }

}
