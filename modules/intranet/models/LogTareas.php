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
  public static function tableName()
  {
    return 't_LogTareas';
  }

  public function rules()
  {
    return [
      [['idTarea', 'estadoTarea', 'fechaRegistro', 'prioridad'], 'required'],
      [['idTarea', 'estadoTarea', 'prioridad'], 'integer'],
      [['fechaRegistro'], 'safe']
    ];
  }

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

  // RELACIONES

  public function getobjLogTareas()
  {
    return $this->hasOne(Tareas::className(), ['idTarea' => 'idTarea']);
  }

  // CONSULTAS

  /**
  * consulta los dos ultimos modelos LogTareas de un modelo Tarea
  * @param numeroDocumento = identificador del usuario
  * @return array = resultado de la consulta
  */
  public static function ultimosDosLogs($idTarea, $idUsuario)
  {
    $query = self::find()->joinWith(['objLogTareas'])
    ->where("( t_Tareas.numeroDocumento =:idUsuario and t_LogTareas.idTarea =:idTarea  )")
    ->addParams([':idUsuario' => $idUsuario,':idTarea'=>$idTarea])->orderBy('t_LogTareas.fechaRegistro  asc')->limit(2)->all();

    return $query;
  }
}
