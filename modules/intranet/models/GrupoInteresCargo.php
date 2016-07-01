<?php

namespace app\modules\intranet\models;

use Yii;
use yii\data\ActiveDataProvider;
use app\modules\intranet\models\Cargo;
use yii\helpers\ArrayHelper;


/**
* This is the model class for table "m_grupointerescargo".
*
* @property string $idCargo
* @property string $idGrupoInteres
*/
class GrupoInteresCargo extends \yii\db\ActiveRecord
{
  public static function tableName()
  {
    return 'm_GrupoInteresCargo';
  }

  public function rules()
  {
    return [
      [['idCargo', 'idGrupoInteres', 'nombreCargo'], 'required'],
      [['idGrupoInteres'], 'integer'],
      [['idCargo', 'nombreCargo'], 'string', 'max' => 255]
    ];
  }

  public function attributeLabels()
  {
    return [
      'idCargo' => 'Cargo',
      'nombreCargo' => 'nombre cargo',
      'idGrupoInteres' => 'Grupo Interes',
    ];
  }

  // RELACIONES
  public function getObjGrupoInteres(){
    return $this->hasOne(GrupoInteres::className(), ['idGrupoInteres' => 'idGrupoInteres']);
  }

  // CONSULTAS
  /**
  * consulta todos los objetos del modelo Cargo
  * @param
  * @return retorna todos los modelos Cargo mapeados por nombreCargo y nombreCargo
  */
  public static function getListaCargo()
  {
    $WSResult = self::getTodosCargos();
    $opciones = array();

    foreach ($WSResult as $key => $value) {
      array_push($opciones, $value);
    }

    return ArrayHelper::map($opciones, 'CodigoCargo', 'NombreCargo');
  }

  private static function getTodosCargos()
  {
    $client = new \SoapClient(\Yii::$app->params['webServices']['persona'], array(
        "trace" => 1,
        "exceptions" => 0,
        'connection_timeout' => 5,
        'cache_wsdl' => WSDL_CACHE_NONE
    ));

    try {

        $result = $client->getCargos();
        return $result;

    } catch (SoapFault $exc) {

    } catch (Exception $exc) {

    }
  }


  /**
  * Consulta los GrupoInteresCargo segun el idGrupoInteres junto con los objetos cargos relacionados
  * @param idGrupoInteres
  * @return data provider con GrupoInteresCargo
  */
  public static function listaCargos($idGrupoInteres)
  {
    $query = self::find()->joinWith(['objGrupoInteres'])
    ->where("(  m_GrupoInteresCargo.idGrupoInteres =:idGrupoInteres )")
    ->addParams([':idGrupoInteres' => $idGrupoInteres])->with(['objGrupoInteres']);

    $dataProvider = new ActiveDataProvider([
      'query' => $query,
      'pagination' => [
        'pageSize' => 10,
      ],
    ]);

    return $dataProvider;
  }
}
