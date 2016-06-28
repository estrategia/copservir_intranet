<?php

namespace app\modules\intranet\models;

use Yii;
use app\models\Usuario;
/**
* This is the model class for table "t_Notificaciones".
*
* @property string $idNotificacion
* @property string $numeroDocumentoDirige
* @property string $numeroDocumentoDirigido
* @property string $descripcion
* @property string $idTipoNotificacion
* @property integer $estadoNotificacion
* @property string $fechaRegistro
*/
class Notificaciones extends \yii\db\ActiveRecord {

  const NOTIFICACION_MEGUSTA = 1;
  const NOTIFICACION_COMENTARIO = 2;
  const NOTIFICACION_RECOMENDACION = 3;
  const ESTADO_CREADA = 1;
  const ESTADO_VISTA = 2;

  public static function tableName() {
    return 't_Notificaciones';
  }

  public function rules() {
    return [
      [['numeroDocumentoDirige', 'numeroDocumentoDirigido', 'tipoNotificacion', 'estadoNotificacion', 'idContenido'], 'integer'],
      [['numeroDocumentoDirigido', 'descripcion', 'tipoNotificacion', 'estadoNotificacion', 'idContenido'], 'required'],
      [['descripcion', 'fechaRegistro'], 'string', 'max' => 45]
    ];
  }

  public function attributeLabels() {
    return [
      'idNotificacion' => 'Id Notificacion',
      'numeroDocumentoDirige' => 'Usuario Dirige',
      'numeroDocumentoDirigido' => 'Usuario Dirigido',
      'descripcion' => 'Descripcion',
      'tipoNotificacion' => 'Tipo Notificacion',
      'estadoNotificacion' => 'Estado Notificacion',
      'fechaRegistro' => 'Fecha Registro',
      'idContenido' => 'Id Contenido',
    ];
  }

  public function consultarTiempo() {
    $dateFin = new \DateTime;

    if ($dateFin->format('H:i:s') == '23:59:00') {
      $dateFin->modify('+1 minute');
    }

    $dateInicio = \DateTime::createFromFormat('Y-m-d H:i:s', $this->fechaRegistro);

    if ($dateInicio->format('H:i:s') == '23:59:00') {
      $dateInicio->modify('+1 minute');
    }

    $diff = $dateFin->diff($dateInicio);
    $horas = ($diff->d * 24 + $diff->h);
    $minutos = ($diff->i); //($diff->d * 24 * 60 + $diff->h * 60 + $diff->i);

    return [$horas, $minutos];
  }

  public static function consultarUltimaNotificacion($usuario){
    return self::find()
    ->where("numeroDocumentoDirigido=:usuario")
    ->addParams([':usuario' => $usuario])
    ->orderBy('fechaRegistro DESC')->one();
  }

  public static function consultarNotificaciones($usuario, $dataProvider = false) {
    if ($dataProvider) {
      $query = self::find()
      ->joinWith(['objUsuarioDirige', 'objContenido'])
      ->where("numeroDocumentoDirigido=:usuario")
      ->addParams([':usuario' => $usuario])
      ->orderBy('fechaRegistro DESC');
    } else {
      $query = self::find()
      ->joinWith(['objUsuarioDirige', 'objContenido'])
      ->where("numeroDocumentoDirigido=:usuario")
      ->addParams([':usuario' => $usuario])
      ->limit(\Yii::$app->params['notificaciones']['limiteVisualizar'])
      ->orderBy('fechaRegistro DESC')->all();
    }

    return $query;

    //var_dump($query->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql);
    //exit();
  }

  public static function cantidadNoVistas($usuario) {
    return (new \yii\db\Query())
    ->from(self::tableName())
    ->where('numeroDocumentoDirigido=:usuario AND estadoNotificacion=:estado')
    ->addParams([':usuario' => $usuario, ':estado'=>  self::ESTADO_CREADA])
    ->count();
  }

  public function getObjUsuarioDirige() {
    return $this->hasOne(Usuario::className(), ['numeroDocumento' => 'numeroDocumentoDirige']);
  }

  public function getObjContenido() {
    return $this->hasOne(Contenido::className(), ['idContenido' => 'idContenido']);
  }

}
