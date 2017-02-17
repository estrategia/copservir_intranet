<?php

namespace app\modules\intranet\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
* This is the model class for table "t_EventosCalendarioDestino".
*
* @property integer $idEventoCalendario
* @property integer $idGrupoInteres
* @property integer $codigoCiudad
*/
class EventosCalendarioPortalesDestino extends \yii\db\ActiveRecord {

  public static function tableName() {
    return 't_EventosCalendarioPortalesDestino';
  }

  public function rules() {
    return [
      [['idEventoCalendario', 'nombrePortal', 'idPortal'], 'required'],
      [['idEventoCalendario', 'idPortal'], 'integer'],
      [['nombrePortal'], 'string'],
    ];
  }

  public function attributeLabels() {
    return [
      'idEventoCalendario' => 'Evento Calendario',
      'nombrePortal' => 'Nombre Portal',
      'idPortal' => 'Id Portal'
    ];
  }

  // public function getObjEventoCalendario(){
  //   return $this->hasOne(EventosCalendario::className(), ['idEventoCalendario' => 'idEventoCalendario']);
  // }
}
