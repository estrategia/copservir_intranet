<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "m_Ciudad".
 *
 * @property string $idCiudad
 * @property integer $codigoCiudad
 * @property string $nombreCiudad
 */
class Ciudad extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'm_Ciudad';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['codigoCiudad', 'nombreCiudad'], 'required'],
            [['codigoCiudad'], 'integer'],
            [['nombreCiudad'], 'string', 'max' => 45],
            [['codigoCiudad'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idCiudad' => 'Id Ciudad',
            'codigoCiudad' => 'Codigo Ciudad',
            'nombreCiudad' => 'Nombre Ciudad',
        ];
    }
}
