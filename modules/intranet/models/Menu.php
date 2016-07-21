<?php

namespace app\modules\intranet\models;

use Yii;

/**
 * This is the model class for table "t_Menu".
 *
 * @property string $idMenu
 * @property string $descripcion
 * @property string $idPadre
 * @property string $idRaiz
 * @property integer $estado
 */
class Menu extends \yii\db\ActiveRecord {

    public static function tableName() {
        return 't_Menu';
    }

    public function rules() {
        return [
            [['descripcion', 'estado', 'orden'], 'required'],
            [['idPadre', 'idRaiz', 'estado', 'orden'], 'integer'],
            [['descripcion', 'icono'], 'string', 'max' => 45]
        ];
    }

    public function attributeLabels() {
        return [
            'idMenu' => 'Id Menu',
            'descripcion' => 'Descripcion',
            'idPadre' => 'Id Padre',
            'idRaiz' => 'Id Raiz',
            'estado' => 'Estado',
            'orden' => 'Orden',
            'icono' => 'Icono'
        ];
    }

    // RELACIONES

    public function getListSubMenu() {
        return $this->hasMany(Menu::className(), ['idPadre' => 'idMenu'])->orderBy('orden');
    }

    public function getActiveListSubMenu() {
        return $this->hasMany(Menu::className(), ['idPadre' => 'idMenu'])->where("estado=1")->orderBy('orden');
    }

    public function getObjPadre() {
        return $this->hasOne(Menu::className(), ['idMenu' => 'idPadre']);
    }

    public function getObjOpcion() {
        return $this->hasOne(Opcion::className(), ['idMenu' => 'idMenu']);
    }

    public static function getMenuPadre($activo = true) {
        if ($activo){
            return self::find()->with('activeListSubMenu')->where('estado=1 AND idPadre is NULL')->orderBy('orden')->all();
        }else{
            return self::find()->with('listSubMenu')->where('idPadre is NULL')->orderBy('orden')->all();
        }
    }

    public static function menuHtml($menuItem, $opciones = []) {

        if (!empty($opciones) && in_array($menuItem->idMenu, $opciones)) {
            if (empty($menuItem->objOpcion)) { // no tiene hipervinculo
                //style=" font-size: 14px; font-weight: normal; color:#ffffff;
                echo '<li class="list-menu-corporativo">
                <a href="javascript:;"> <i class="icon-custom-ui"></i> <span class="title">' . $menuItem->descripcion . '</span> <span class=" arrow" ></span> </a>
                    <ul class="sub-menu">';

                    foreach ($menuItem->activeListSubMenu as $subItem) {
                        self::menuHtml($subItem, $opciones);
                    }

                    echo '</ul>
                </li>';
            } else { // tiene hipervinculo

                if (strpos($menuItem->objOpcion->url, 'https://') !== false || strpos($menuItem->objOpcion->url, 'http://') !== false) {
                    $urlMenu = Funciones::reemplazarPatronDocumentoUsuario($menuItem->objOpcion->url);
                    echo "<li class='list-menu-corporativo'> <a target='_blank' href='$urlMenu'> <i class='icon-custom-ui'></i><span class='title'>$menuItem->descripcion</span> </a> </li>";
                } else {
                    echo "<li class='list-menu-corporativo'>";
                    echo \yii\bootstrap\Html::a("<i class='icon-custom-ui'></i><span class='title'>$menuItem->descripcion</span>", [$menuItem->objOpcion->url]);
                    echo "</li>";
                }
            }
        }
    }

    /**
     * Funcion auxiliar estatica donde se crea el menu para el usuario
     * @param $flagAdmin = indica si renderiza el menu al usuario normal o al administrador
     * @return $opcionesArray = arreglo con la estructura del menu
     */
    public static function construirArrayMenu($flagAdmin, $numeroDocumento) {
        $listMenu = self::getMenuPadre($flagAdmin);
        $opcionArray = [];

        if ($flagAdmin) {
            foreach ($listMenu as $objMenu) {
                $opcionArray[] = self::obtenerHijosArrayAdmin($objMenu);
            }
        } else {
            $opcionesUsuario = UsuariosMenuInactivo::find()->where(['=', 'numeroDocumento', $numeroDocumento])->all();
            $opcionesUsuarioArray = [];

            foreach ($opcionesUsuario as $objMenu) {
                $opcionesUsuarioArray[] = $objMenu->idMenu;
            }

            foreach ($listMenu as $objMenu) {
                $opcionArray[] = self::obtenerHijosArray($objMenu, $opcionesUsuarioArray);
            }
        }

        return $opcionArray;
    }

    /**
     * Funcion auxiliar recursiva y estatica donde se crea el menu para el usuario administrador
     * @param $opcion = modelo Menu, $opcionesUsuario = las opciones que el usuario ha escogido
     * @return array con title = titulo ha renderizar en el menu, children = hijos de esa categoria del menu, folder = ?
     */
    public static function obtenerHijosArray($objMenu, $opcionesUsuario) {
        //si tiene enlace relacionado (es hoja)
        if (!empty($objMenu->objOpcion)) {
            $checked = "";

            if (!in_array($objMenu->idMenu, $opcionesUsuario)) {
                $checked = " checked";
            }
            return ['title' => "<div class='panel-default'><div class=' panel-heading'><input type='checkbox' id='$objMenu->idMenu' data-role='agregar-opcion' data-id='$objMenu->idMenu' $checked> <label class='panel-title' style='display: inline; font-size: 13px;color: #505458;' for='$objMenu->idMenu'><span><span></span></span> $objMenu->descripcion </label></div></div> "];
        } else {
            $children = [];

            foreach ($objMenu->activeListSubMenu as $objSubmenu) {
                $children[] = self::obtenerHijosArray($objSubmenu, $opcionesUsuario);
            }
            return ['title' => "<div class='panel-default'><div class=' panel-heading'> <h6 class='panel-title' style='font-size: 13px;'>$objMenu->descripcion </h6></div></div>", 'children' => $children, 'folder' => true];
        }
    }

    /**
     * Funcion auxiliar recursiva y estatica donde se crea el menu para el usuario administrador
     * @param $objMenu modelo Menu
     * @return array con title = titulo ha renderizar en el menu, children = hijos de esa categoria del menu, folder = ?
     */
    public static function obtenerHijosArrayAdmin($objMenu) {
        $htmlEditar = "<button class='btn btn-mini btn-success' data-role='opcion-menu-render-actualizar' data-opcion='$objMenu->idMenu'>Editar</button>";

        if (!empty($objMenu->objOpcion)) { // es hoja
            $htmlRelacion = '';

            if (!empty($objMenu->objOpcion)) {

                $dataOpcion = $objMenu->objOpcion->idOpcion;
                $htmlRelacion = "<button class='btn btn-mini btn-success' data-role='quitar-enlace-menu'data-opcion='$dataOpcion' >Eliminar enlace</button>"
                        ."<button class='btn btn-mini btn-success' data-role='editar-enlace'data-opcion='$dataOpcion' >Editar enlace</button>"
                        . "<button class='btn btn-mini btn-success' data-toggle='poptooltip' data-content='" . $objMenu->objOpcion->url . "'>Ver enlace</button>";
            }

            return [
                'title' => "
                    <div class='panel-default'>
                    <div class=' panel-heading'>
                    <h6 class='panel-title' style='font-size: 13px;'>
                    $objMenu->descripcion
                    </h6>
                    $htmlEditar
                    $htmlRelacion
                    </div>
                    </div>",
            ];
        } else { // tiene hijos
            $children = [];
            $htmlRelacion = '';

            if (!empty($objMenu->listSubMenu)) {
                foreach ($objMenu->listSubMenu as $objSubMenu) {
                    $children[] = self::obtenerHijosArrayAdmin($objSubMenu);
                }
            } else {
                $htmlRelacion = "<button class='btn btn-mini btn-success' data-role='agregar-enlace-menu' data-opcion='$objMenu->idMenu'> Agregar enlaces</button>";
            }

            return [
                'title' => "
                    <div class='panel-default'>
                    <div class=' panel-heading'>
                    <h6 class='panel-title' style='font-size: 13px;'>
                    $objMenu->descripcion
                    </h6>
                    $htmlEditar
                    <button class='btn btn-mini btn-success' data-role='opcion-menu-render-crear' data-padre='$objMenu->idMenu'>
                    Agregar
                    </button>
                    $htmlRelacion
                    </div>
                    </div>
                    ",
                'children' => $children,
                'folder' => true
            ];
        }
    }

    /**
     * Funcion para asignar el atributo idRaiz al modelo Menu
     */
    public function setIdRaiz() {
        if ($this->esNodoRaiz()) {
            $this->idRaiz = $this->idMenu;
        } else {
            $this->idRaiz = $this->idPadre;
        }
    }

    /**
     * Funcion que indica si un modelo Menu es raiz
     * @return bool true || bool false
     */
    public function esNodoRaiz() {
        if (is_null($this->idPadre)) {
            return true;
        } else {
            return false;
        }
    }

}
