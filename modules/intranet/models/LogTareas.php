<?php

namespace app\modules\intranet\models;

use Yii;
use app\modules\intranet\models\Tareas;

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
    return 't_LogTareas';
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

  /*
  * RELACIONES
  */

  /**
  * Se define la relacion entre los modelos LogTareas y Tareas
  * @param none
  * @return modelo Tareas
  */
  public function getobjLogTareas()
  {
    return $this->hasOne(Tareas::className(), ['idTarea' => 'idTarea']);
  }

  /*
  * CONSULTAS
  */

  /**
  * consulta los dos ultimos logs de las
  * @param numeroDocumento = identificador del usuario
  * @return array = resultado de la consulta
  */
  public static function ultimosDosLogs($idTarea, $idUsuario)
  {
    /*SELECT * FROM  t_logtareas
    left join t_tareas on t_logtareas.idTarea = t_tareas.idTarea
    where ( t_tareas.numeroDocumento = 123456 and t_logtareas.idTarea = 15)
    ORDER BY t_logtareas.fechaRegistro  asc
    limit 2; */

    $query = self::find()->joinWith(['objLogTareas'])
    ->where("( t_Tareas.numeroDocumento =:idUsuario and t_LogTareas.idTarea =:idTarea  )")
    ->addParams([':idUsuario' => $idUsuario,':idTarea'=>$idTarea])->orderBy('t_LogTareas.fechaRegistro  asc')->limit(2)->all();

    return $query;
  }
}
