<?php

namespace app\modules\intranet\models;

use Yii;

/**
 * This is the model class for table "m_portal".
 *
 * @property string $idPortal
 * @property string $nombrePortal
 * @property integer $estado
 */
class Portal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'm_portal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombrePortal', 'estado'], 'required'],
            [['estado'], 'integer'],
            [['nombrePortal'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idPortal' => 'Id Portal',
            'nombrePortal' => 'Nombre Portal',
            'estado' => 'Estado',
        ];
    }
}
