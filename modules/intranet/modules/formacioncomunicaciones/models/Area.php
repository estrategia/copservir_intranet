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
class Area extends \yii\db\ActiveRecord
{
    const ESTADO_ACTIVO = 1;
    const ESTADO_INACTIVO = 0;
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
            [['nombreArea', 'descripcionArea', 'estadoArea'], 'required'],
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
            'nombreArea' => 'Nombre',
            'descripcionArea' => 'Descripción',
            'estadoArea' => 'Estado',
            'fechaCreacion' => 'Fecha Creación',
            'fechaActualizacion' => 'Fecha Actualización',
        ];
    }
}
