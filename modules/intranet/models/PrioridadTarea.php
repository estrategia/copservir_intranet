<?php

namespace app\modules\intranet\models;

use Yii;

/**
 * This is the model class for table "m_prioridadtarea".
 *
 * @property integer $idPrioridadTarea
 * @property string $nombre
 */
class PrioridadTarea extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'm_PrioridadTarea';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idPrioridadTarea'], 'required'],
            [['idPrioridadTarea'], 'integer'],
            [['nombre'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idPrioridadTarea' => 'Id Prioridad Tarea',
            'nombre' => 'Nombre',
        ];
    }
}
