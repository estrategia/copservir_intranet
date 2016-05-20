<?php

namespace app\modules\intranet\models;

use Yii;

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
class MenuPortales extends \yii\db\ActiveRecord
{
    const APROBADO = 1;
    const INACTIVO = 0;

    const ENLACE_INTERNO = 1;
    const ENLACE_EXTERNO = 2;

    public static function tableName()
    {
        return 't_MenuPortales';
    }

    public function rules()
    {
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

    public function attributeLabels()
    {
        return [
            'idMenuPortales' => 'Id Menu Portales',
            'idPortal' => 'Id Portal',
            'nombre' => 'Nombre',
            'urlMenu' => 'Url Menu',
            'tipo' => 'Tipo',
            'icono' => 'Icono',
            'fechaInicio' => 'Fecha Inicio',
            'fechaFin' => 'Fecha Fin',
            'estado' => 'Estado',
            'fechaRegistro' => 'Fecha Registro',
            'fechaActualizacion' => 'Fecha Actualizacion',
        ];
    }

    // RELACIONES

    public function getObjPortal()
    {
        return $this->hasOne(Portal::className(), ['idPortal' => 'idPortal']);
    }

    // CONSULTAS

    public static function traerMenuPortalesIndex($nombrePortal)
    {
      $portalModel = Portal::encontrarModeloPorNombre($nombrePortal);

       $query = self::find()->select(['nombre', 'icono', 'tipo', 'urlMenu'])
       ->where('( idPortal=:idPortal )')
       ->addParams([':estado' => self::APROBADO, ':idPortal' => $portalModel->idPortal])
       ->all();

       return $query;
    }
}
