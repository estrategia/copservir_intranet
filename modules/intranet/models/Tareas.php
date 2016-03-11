<?php

namespace app\modules\intranet\models;

use Yii;

/**
 * This is the model class for table "t_tareas".
 *
 * @property string $idTarea
 * @property string $titulo
 * @property string $descripcion
 * @property string $idUsuario
 * @property string $fechaRegistro
 * @property integer $estadoTarea
 * @property string $fechaEstimada
 * @property integer $prioridad
 */
class Tareas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_tareas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['titulo', 'descripcion', 'idUsuario', 'fechaRegistro', 'estadoTarea', 'fechaEstimada', 'prioridad'], 'required'],
            [['descripcion'], 'string'],
            [['idUsuario', 'estadoTarea', 'prioridad'], 'integer'],
            [['fechaRegistro', 'fechaEstimada'], 'safe'],
            [['titulo'], 'string', 'max' => 60]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idTarea' => 'Id Tarea',
            'titulo' => 'Titulo',
            'descripcion' => 'Descripcion',
            'idUsuario' => 'Id Usuario',
            'fechaRegistro' => 'Fecha Registro',
            'estadoTarea' => 'Estado Tarea',
            'fechaEstimada' => 'Fecha Estimada',
            'prioridad' => 'Prioridad',
        ];
    }
}
