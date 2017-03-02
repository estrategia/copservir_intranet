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
class ModuloContenido extends \yii\db\ActiveRecord
{
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
            [['nombreModulo', 'descripcionModulo', 'fechaCreacion'], 'required'],
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
            'idModulo' => 'Id Modulo',
            'nombreModulo' => 'Nombre Modulo',
            'descripcionModulo' => 'Descripcion Modulo',
            'estadoModulo' => 'Estado Modulo',
            'fechaCreacion' => 'Fecha Creacion',
            'fechaActualizacion' => 'Fecha Actualizacion',
        ];
    }
}
