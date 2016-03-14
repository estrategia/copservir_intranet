<?php

namespace app\modules\intranet\models;

use Yii;

/**
 * This is the model class for table "t_logtareas".
 *
 * @property string $idLogTarea
 * @property string $idTarea
 * @property integer $estadoTarea
 * @property string $fechaRegistro
 * @property integer $prioridad
 */
class LogTareas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_logtareas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idTarea', 'estadoTarea', 'fechaRegistro', 'prioridad'], 'required'],
            [['idTarea', 'estadoTarea', 'prioridad'], 'integer'],
            [['fechaRegistro'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idLogTarea' => 'Id Log Tarea',
            'idTarea' => 'Id Tarea',
            'estadoTarea' => 'Estado Tarea',
            'fechaRegistro' => 'Fecha Registro',
            'prioridad' => 'Prioridad',
        ];
    }
}
