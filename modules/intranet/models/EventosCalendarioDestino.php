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
class EventosCalendarioDestino extends \yii\db\ActiveRecord {
    
  public static function tableName() {
    return 't_EventosCalendarioDestino';
  }

  public function rules() {
    return [
      [['idEventoCalendario', 'idGrupoInteres', 'codigoCiudad'], 'required'],
      [['idEventoCalendario', 'idGrupoInteres', 'codigoCiudad'], 'integer'],
    ];
  }

  public function attributeLabels() {
    return [
      'idEventoCalendario' => 'Evento Calendario',
      'idGrupoInteres' => 'Grupo Interes',
      'codigoCiudad' => 'Ciudad',
    ];
  }

  public function getObjGrupoInteres(){
    return $this->hasOne(GrupoInteres::className(), ['idGrupoInteres' => 'idGrupoInteres']);
  }

  public function getObjCiudad(){
    return $this->hasOne(Ciudad::className(), ['codigoCiudad' => 'codigoCiudad']);
  }

  public function getObjEventoCalendario(){
    return $this->hasOne(EventosCalendario::className(), ['idEventoCalendario' => 'idEventoCalendario']);
  }

  /**
  * Consulta los OfertasLaboralesDestino segun el idOfertaLaboral junto con los objetos cargos relacionados
  * @param idOfertaLaboral
  * @return data provider con OfertasLaboralesDestino
  */
  public static function listaOfertas($idEventoCalendario)
  {

    $query = self::find()->joinWith(['objEventoCalendario'])
    ->where("(  t_EventosCalendario.idEventoCalendario =:idEventoCalendario )")
    ->addParams([':idEventoCalendario' => $idEventoCalendario])->with(['objEventoCalendario','objGrupoInteres','objCiudad']);

    $dataProvider = new ActiveDataProvider([
      'query' => $query,
      'pagination' => [
        'pageSize' => 10,
      ],
    ]);

    return $dataProvider;
  }

}
