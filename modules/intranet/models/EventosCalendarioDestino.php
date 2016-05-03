<?php

namespace app\modules\intranet\models;

use Yii;

/**
* This is the model class for table "t_EventosCalendarioDestino".
*
* @property integer $idEventoCalendario
* @property integer $idGrupoInteres
* @property integer $codigoCiudad
*/
class EventosCalendarioDestino extends \yii\db\ActiveRecord {

  /**
  * @inheritdoc
  */
  public static function tableName() {
    return 't_EventosCalendarioDestino';
  }

  /**
  * @inheritdoc
  */
  public function rules() {
    return [
      [['idEventoCalendario', 'idGrupoInteres', 'codigoCiudad'], 'required'],
      [['idEventoCalendario', 'idGrupoInteres', 'codigoCiudad'], 'integer']
    ];
  }

  /**
  * @inheritdoc
  */
  public function attributeLabels() {
    return [
      'idEventoCalendario' => 'Id Evento Calendario',
      'idGrupoInteres' => 'Id Grupo Interes',
      'codigoCiudad' => 'Codigo Ciudad',
    ];
  }

}
