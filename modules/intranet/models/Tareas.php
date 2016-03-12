<?php

namespace app\modules\intranet\models;


use Yii;
use yii\helpers\ArrayHelper;
use app\modules\intranet\models\PrioridadTarea;
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
        return 't_Tareas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['titulo', 'descripcion', 'numeroDocumento', 'fechaRegistro', 'estadoTarea', 'fechaEstimada', 'idPrioridad'], 'required'],
            [['descripcion'], 'string'],
            [['numeroDocumento', 'estadoTarea', 'idPrioridad','progreso'], 'integer'],
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
            'numeroDocumento' => 'Numero de Documento',
            'fechaRegistro' => 'Fecha Registro',
            'estadoTarea' => 'Estado Tarea',
            'fechaEstimada' => 'Fecha Estimada',
            'idPrioridad' => 'Prioridad',
            'progreso' => 'Progreso',
        ];
    }

    public static function getListaPrioridad()
    {
        $opciones = PrioridadTarea::find()->asArray()->all();
        return ArrayHelper::map($opciones, 'idPrioridadTarea', 'nombre');
    }
}
