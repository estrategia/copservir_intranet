<?php

namespace app\modules\intranet\models;

use Yii;
use yii\helpers\ArrayHelper;
use app\modules\intranet\models\ModuloContenido;
use yii\data\ActiveDataProvider;

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

    public static function tableName() {
        return 't_MenuPortales';
    }

    public function rules() {
        return [
            [['idPortal', 'nombre', 'urlMenu', 'tipo', 'icono', 'fechaInicio', 'fechaFin', 'estado', 'fechaRegistro'], 'required'],
            [['idPortal', 'tipo', 'estado'], 'integer'],
            [['fechaInicio', 'fechaFin', 'fechaRegistro', 'fechaActualizacion'], 'safe'],
            [['nombre'], 'string', 'max' => 50],
            [['urlMenu'], 'string', 'max' => 500],
            [['icono'], 'string', 'max' => 45],
            [['idPortal'], 'exist', 'skipOnError' => true, 'targetClass' => Portal::className(), 'targetAttribute' => ['idPortal' => 'idPortal']],
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
            'fechaInicio' => 'Fecha de Inicio',
            'fechaFin' => 'Fecha de Fin',
            'estado' => 'Estado',
            'fechaRegistro' => 'Fecha Registro',
            'fechaActualizacion' => 'Fecha Actualizacion',
        ];
    }

    // RELACIONES

    public function getObjPortal() {
        return $this->hasOne(Portal::className(), ['idPortal' => 'idPortal']);
    }

    // CONSULTAS

    public static function traerMenuPortalesIndex($nombrePortal) {
        $portalModel = Portal::encontrarModeloPorNombre($nombrePortal);

        $query = MenuPortales::find()->select(['nombre', 'icono', 'tipo', 'urlMenu', 'idMenuPortales'])
                ->where('( idPortal=:idPortal and estado=:estado )')
                ->addParams([':estado' => self::APROBADO, ':idPortal' => $portalModel->idPortal])
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

    public function getListaPortales()
    {
      $opciones = Portal::find()->asArray()->all();
      return ArrayHelper::map($opciones, 'idPortal', 'nombrePortal');
    }


    public function getDataProviderModuloContenido()
    {
      $query = ModuloContenido::find()
      ->where("( tipo =:tipo )")
      ->addParams([':tipo' => ModuloContenido::TIPO_GROUP_MODULES]);

      $dataProvider = new ActiveDataProvider([
        'query' => $query,
        'pagination' => [
          'pageSize' => 10,
        ],
      ]);

      return $dataProvider;
    }

    public static function traerMenuPortal($nombrePortal,$idMenu) {
        return $objMenu = self::find()
                ->joinWith(['objPortal'])
                ->where("m_Portal.nombrePortal=:portal AND t_MenuPortales.idMenuPortales=:menu",
                        [':portal'=>  $nombrePortal,':menu'=>$idMenu])
                ->one();
    }

}
