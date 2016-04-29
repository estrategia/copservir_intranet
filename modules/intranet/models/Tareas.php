<?php

namespace app\modules\intranet\models;


use Yii;
use yii\helpers\ArrayHelper;

use yii\i18n\Formatter;
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

     const ESTADO_TAREA_INACTIVA = 0;
     const ESTADO_TAREA_TERMINADA = 1;
     const ESTADO_TAREA_NO_TERMINADA = 2;
     const ESTADO_TAREA_NO_INDEX = 3;

     const PROGRESO_TAREA_INICIAL = 0;

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
            [['fechaRegistro'], 'safe'],
            [['fechaEstimada'], 'date',  'format'=>'php:Y-m-d H:i:s'],
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
            'fechaRegistro' => 'Fecha de Creacion',
            'estadoTarea' => 'Estado Tarea',
            'fechaEstimada' => 'Fecha Estimada',
            'idPrioridad' => 'Prioridad',
            'progreso' => 'Progreso',
        ];
    }

    /*
    * RELACIONES
    */

    /**
    * Se define la relacion entre los modelos Tarea y PrioridadTarea
    * @param none
    * @return modelo PrioridadTarea
    */
    public function getObjPrioridadTareas(){
        return $this->hasOne(PrioridadTarea::className(), ['idPrioridadTarea' => 'idPrioridad']);
    }

    /*
    * CONSULTAS
    */

    /**
    * consulta para listar las tareas que van en el la vista lista de tareas
    * @param numeroDocumento = identificador del usuario
    * @return array = resultado de la consulta
    */
    public static function getTareasListar($numeroDocumento)
    {
       return  self::find()->with(['objPrioridadTareas'])->where(['numeroDocumento' => $numeroDocumento])->andWhere(['!=', 'estadoTarea', self::ESTADO_TAREA_INACTIVA])->all();
    }

    /**
    * consulta para listar las tareas que van en el index
    * @param numeroDocumento = identificador del usuario
    * @return array = resultado de la consulta
    */
    public static function getTareasIndex($numeroDocumento)
    {
       return self::find()->where(['numeroDocumento' => $numeroDocumento])->andWhere(['!=', 'estadoTarea', self::ESTADO_TAREA_INACTIVA])->andWhere(['!=', 'estadoTarea', self::ESTADO_TAREA_NO_INDEX ])->all();
    }

    /**
    * Se consultan las prioridades y se retornan mapeados por idPrioridadTarea y nombre
    * @param none
    * @return array mapeado
    */
    public static function getListaPrioridad()
    {
        $opciones = PrioridadTarea::find()->asArray()->all();
        return ArrayHelper::map($opciones, 'idPrioridadTarea', 'nombre');
    }


}
