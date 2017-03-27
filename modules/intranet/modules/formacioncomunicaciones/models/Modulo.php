<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\models;

use Yii;

/**
 * This is the model class for table "m_FORCO_Modulo".
 *
 * @property integer $idModulo
 * @property string $nombreModulo
 * @property string $descripcionModulo
 * @property integer $estadoModulo
 * @property string $fechaCreacion
 * @property string $fechaActualizacion
 */
class Modulo extends \yii\db\ActiveRecord
{
    const ESTADO_ACTIVO = 1;
    const ESTADO_INACTIVO = 0;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'm_FORCO_Modulo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombreModulo', 'descripcionModulo', 'estadoModulo'], 'required'],
            [['estadoModulo'], 'integer'],
            [['fechaCreacion', 'fechaActualizacion'], 'safe'],
            [['nombreModulo'], 'string', 'max' => 45],
            [['descripcionModulo'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idModulo' => 'Id Módulo',
            'nombreModulo' => 'Nombre',
            'descripcionModulo' => 'Descripción',
            'estadoModulo' => 'Estado',
            'fechaCreacion' => 'Fecha Creación',
            'fechaActualizacion' => 'Fecha Actualización',
        ];
    }
}
