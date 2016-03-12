<?php

namespace app\modules\intranet\models;

use Yii;

/**
 * This is the model class for table "m_Cargo".
 *
 * @property string $idCargo
 * @property string $codigoCargo
 * @property string $nombreCargo
 */
class Cargo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'm_Cargo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['codigoCargo', 'nombreCargo'], 'required'],
            [['codigoCargo'], 'string', 'max' => 10],
            [['nombreCargo'], 'string', 'max' => 60],
            [['codigoCargo'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idCargo' => 'Id Cargo',
            'codigoCargo' => 'Codigo Cargo',
            'nombreCargo' => 'Nombre Cargo',
        ];
    }
}
