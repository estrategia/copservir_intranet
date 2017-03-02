<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\models;

use Yii;

/**
 * This is the model class for table "m_FORCO_Area".
 *
 * @property integer $idAreaConocimiento
 * @property string $nombreArea
 * @property string $descripcionArea
 * @property integer $estadoArea
 * @property string $fechaCreacion
 * @property string $fechaActualizacion
 */
class AreaContenido extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'm_FORCO_Area';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombreArea', 'descripcionArea', 'fechaCreacion'], 'required'],
            [['estadoArea'], 'integer'],
            [['fechaCreacion', 'fechaActualizacion'], 'safe'],
            [['nombreArea'], 'string', 'max' => 45],
            [['descripcionArea'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idAreaConocimiento' => 'Id Area Conocimiento',
            'nombreArea' => 'Nombre Area',
            'descripcionArea' => 'Descripcion Area',
            'estadoArea' => 'Estado Area',
            'fechaCreacion' => 'Fecha Creacion',
            'fechaActualizacion' => 'Fecha Actualizacion',
        ];
    }
}
