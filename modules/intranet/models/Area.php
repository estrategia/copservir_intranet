<?php

namespace app\modules\intranet\models;

use Yii;

/**
 * This is the model class for table "m_Area".
 *
 * @property string $idArea
 * @property string $nombreArea
 */
class Area extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'm_Area';
    }

    /**
     * @inheritdoc
     */
     public function rules()
    {
        return [
            [['nombreArea'], 'required'],
            [['nombreArea'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inherit
     */
    public function attributeLabels()
    {
        return [
            'idArea' => 'Id Area',
            'nombreArea' => 'Nombre Area',
        ];
    }
}
