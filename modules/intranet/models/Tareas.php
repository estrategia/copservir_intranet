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

  const ESTADO_TAREA_INACTIVA = 0;
  const ESTADO_TAREA_TERMINADA = 1;
  const ESTADO_TAREA_NO_TERMINADA = 2;
  const ESTADO_TAREA_NO_INDEX = 3;

  const PROGRESO_TAREA_INICIAL = 0;
  const PROGRESO_TAREA_TERMINADA = 100;
  const TAREAS_INDEX = 1;

  public static function tableName()
  {
    return 't_Tareas';
  }

  public function rules()
  {
    return [
      [['titulo', 'descripcion', 'numeroDocumento', 'fechaRegistro', 'estadoTarea', 'fechaEstimada', 'idPrioridad'], 'required'],
      [['descripcion'], 'string'],
      [['numeroDocumento', 'estadoTarea', 'idPrioridad','progreso'], 'integer'],
      [['fechaRegistro'], 'safe'],
      [['fechaEstimada'], 'date',  'format'=>'php:Y-m-d H:i'],
      [['titulo'], 'string', 'max' => 60]
    ];
  }

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
  // RELACIONES

  public function getObjPrioridadTareas(){
    return $this->hasOne(PrioridadTarea::className(), ['idPrioridadTarea' => 'idPrioridad']);
  }

  // CONSULTAS

  /**
  * consulta los modelos Tareas que van en el la vista lista de tareas
  * @param numeroDocumento = identificador del usuario
  * @return array = resultado de la consulta
  */
  public static function getTareasListar($numeroDocumento)
  {
    return  self::find()->with(['objPrioridadTareas'])->where(['numeroDocumento' => $numeroDocumento])->andWhere(['!=', 'estadoTarea', self::ESTADO_TAREA_INACTIVA])->all();
  }

  /**
  * consulta los modelos Tareas que van en el index
  * @param numeroDocumento = identificador del usuario
  * @return array = resultado de la consulta
  */
  public static function getTareasIndex($numeroDocumento)
  {
    return self::find()->where(['numeroDocumento' => $numeroDocumento])->andWhere(['!=', 'estadoTarea', self::ESTADO_TAREA_INACTIVA])->andWhere(['!=', 'estadoTarea', self::ESTADO_TAREA_NO_INDEX ])->all();
  }

  /**
  * consulta un modelo Tarea por sus atributos idTarea y numeroDocumento
  * @param idTarea = llave primaria de la tarea, numeroDocumento = identificador del usuario
  * @return model Tarea
  */
  public static function getTareaIdNumeroDocumento($id, $numeroDocumento)
  {
    return self::findOne(['numeroDocumento' => $numeroDocumento, 'idTarea' => $idTarea]);
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


  //FUNCIONES

  /**
  * funcion para crear un modelo LogTareas
  * si el modelo no se crea devuelve una excepcionss
  * @throws excepcion 101 el modelo no guardo su log
  */
  public function afterSave($inser, $changedAttributes)
  {
    $logTarea = new LogTareas();
    $logTarea->idTarea = $this->idTarea;
    $logTarea->estadoTarea = $this->estadoTarea;
    $logTarea->fechaRegistro =  Date("Y-m-d H:i:s");
    $logTarea->prioridad = $this->idPrioridad;
    $logTarea->progreso = $this->progreso;
    if (!$logTarea->save()) {
      //error al guardar el log
      throw new Exception("Error al guardar el logTarea:".yii\helpers\Json::enconde($logTarea->getErrors()), 101);
    }
    return parent::afterSave($inser, $changedAttributes);
  }

  /**
  * funcion para modificar el formato del atributo fechaEstimada
  */
  public function afterFind()
  {
    $this->fechaEstimada = \DateTime::createFromFormat('Y-m-d H:i:s', $this->fechaEstimada)->format('Y-m-d H:i');
    return parent::afterFind();
  }

  /**
  * Asigna el estado al modelo dependiendo de la locacion
  * @param int $location = indica la vista
  */
  public function setEstadoDependingLocation($location)
  {
    if ($this->isLocationIndex($location)) {
      $this->estadoTarea = Tareas::ESTADO_TAREA_NO_INDEX;
    } else {
      $this->estadoTarea = Tareas::ESTADO_TAREA_INACTIVA;
    }
  }

  /**
  * Indica en que vista que se va a renderizar
  * @param int $location = indica la vista
  * @return String con el nombre de la vista
  */
  public function getRenderViewDependingLocation($location)
  {
    if ($this->isLocationIndex($location)) {
      return '_tareasHome';
    } else {
      return '_listaTareas';
    }
  }

  /**
  * retorna la lista de tareas del usuario dependiendo de la vista
  * @param int $location = indica la vista
  * @return String con el nombre de la vista
  */
  public function getTareasDependingLocation($location)
  {
    $numeroDocumento = Yii::$app->user->identity->numeroDocumento;
    if ($this->isLocationIndex($location)) {
      return self::getTareasIndex($numeroDocumento);
    } else {
      return self::getTareasListar($numeroDocumento);
    }
  }

  /**
  * funcion que permite indicar si las tareas son de la vista sitio/index o de la vista tareas/_listaTareas
  * @param int $location = indica la vista
  */
  public function isLocationIndex($location)
  {
    if ($location == self::TAREAS_INDEX) {
      return true;
    } else {
      return false;
    }
  }

  /**
  * Asigna el estado al modelo dependiendo de la locacion
  */
  public function setEstadoDependingProgress()
  {
    if ($this->progreso == Tareas::PROGRESO_TAREA_TERMINADA) {

      $this->estadoTarea = Tareas::ESTADO_TAREA_TERMINADA;

    } else {
      $this->estadoTarea = Tareas::ESTADO_TAREA_NO_TERMINADA;
    }
  }


  /**
  * devuelve una instancia del modelo Tareas a su estado anterior
  */
  public function volverUltimaInstanciaTarea()
  {
    $numeroDocumento = Yii::$app->user->identity->numeroDocumento;
    $LogTarea = LogTareas::ultimosDosLogs($this->idTarea, $numeroDocumento);
    $this->estadoTarea = $LogTarea[0]->estadoTarea;
    $this->fechaRegistro = $LogTarea[0]->fechaRegistro;
    $this->idPrioridad = $LogTarea[0]->prioridad;
    $this->progreso = $LogTarea[0]->progreso;
  }
}
