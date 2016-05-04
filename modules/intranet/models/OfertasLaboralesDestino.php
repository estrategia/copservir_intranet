<?php

namespace app\modules\intranet\models;

use Yii;
use yii\data\ActiveDataProvider;
use app\modules\intranet\models\OfertasLaborales;
use app\modules\intranet\models\GrupoInteres;
use app\modules\intranet\models\Ciudad;

/**
* This is the model class for table "t_ofertaslaboralesdestino".
*
* @property integer $idOfertaLaboral
* @property integer $idGrupoInteres
* @property integer $codigoCiudad
*/
class OfertasLaboralesDestino extends \yii\db\ActiveRecord
{
  public static function tableName()
  {
    return 't_OfertasLaboralesDestino';
  }

  public function rules()
  {
    return [
      [['idOfertaLaboral', 'idGrupoInteres',  'codigoCiudad'], 'required'],
      [['idOfertaLaboral', 'idGrupoInteres',  'codigoCiudad'], 'integer']
    ];
  }

  public function attributeLabels()
  {
    return [
      'idOfertaLaboral' => 'Id Oferta Laboral',
      'idGrupoInteres' => 'Id Grupo Interes',
      'codigoCiudad' => 'Codigo Ciudad',
    ];
  }

  // RELACIONES

  public function getObjOfertaLaboral(){
    return $this->hasOne(OfertasLaborales::className(), ['idOfertaLaboral' => 'idOfertaLaboral']);
  }

  public function getObjGrupoInteres(){
    return $this->hasOne(GrupoInteres::className(), ['idGrupoInteres' => 'idGrupoInteres']);
  }

  public function getObjCiudad(){
    return $this->hasOne(Ciudad::className(), ['codigoCiudad' => 'codigoCiudad']);
  }

  // CONSULTAS

  /**
  * Consulta los OfertasLaboralesDestino segun el idOfertaLaboral junto con los objetos cargos relacionados
  * @param idOfertaLaboral
  * @return data provider con OfertasLaboralesDestino
  */
  public static function listaOfertas($idOfertaLaboral)
  {

    $query = self::find()->joinWith(['objOfertaLaboral'])
    ->where("(  t_OfertasLaboralesDestino.idOfertaLaboral =:idOfertaLaboral )")
    ->addParams([':idOfertaLaboral' => $idOfertaLaboral])->with(['objOfertaLaboral','objGrupoInteres','objCiudad']);

    $dataProvider = new ActiveDataProvider([
      'query' => $query,
      'pagination' => [
        'pageSize' => 10,
      ],
    ]);

    return $dataProvider;
  }

}
