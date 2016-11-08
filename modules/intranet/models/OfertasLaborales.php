<?php

namespace app\modules\intranet\models;

use Yii;
use app\modules\intranet\models\ContenidoDestino;
use app\modules\intranet\models\OfertasLaboralesDestino;
use app\modules\intranet\models\Ciudad;
use app\modules\intranet\models\Area;
use app\modules\intranet\models\Cargo;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
/**
* This is the model class for table "t_OfertasLaborales".
*
* @property string $idOfertaLaboral
* @property string $cargo
* @property string $idCiudad
* @property string $fechaPublicacion
* @property string $fechaCierre
* @property string $numeroDocumento
* @property string $fechaPublicacion
* @property string $fechaCierre
* @property string $tituloOferta
* @property string $urlElEmpleo
* @property integer $idCargo
* @property string $descripcionContactoOferta
* @property string $idInformacionContacto
*/
class OfertasLaborales extends \yii\db\ActiveRecord
{
  const ESTADO_ACTIVO = 1;
  const ESTADO_INACTIVO = 0;

  public static function tableName()
  {
    return 't_OfertasLaborales';
  }

  public function rules()
  {
    return [
      [[ 'idCiudad', 'fechaPublicacion', 'fechaCierre', 'estado', 'numeroDocumento', 'tituloOferta', 'urlElEmpleo', 'nombreCargo', 'descripcionContactoOferta', 'idInformacionContacto'], 'required'],
      [[ 'idCiudad', 'numeroDocumento', 'idInformacionContacto'], 'integer'],
      [['fechaPublicacion', 'fechaCierre'], 'safe'],
      [['descripcionContactoOferta','nombreCargo'], 'string'],
      [['tituloOferta', 'urlElEmpleo'], 'string', 'max' => 45]
    ];
  }

  public function attributeLabels()
  {
    return [
      'idOfertaLaboral' => 'Id Oferta Laboral',
      'idCiudad' => 'Ciudad',
      'fechaPublicacion' => 'Fecha Aplicar Desde',
      'fechaCierre' => 'Fecha Aplicar Hasta',
      'numeroDocumento' => 'Id Usuario Publicacion',
      'tituloOferta' => 'Titulo Oferta',
      'urlElEmpleo' => 'Url El Empleo',
      'nombreCargo' => 'Cargo',
      'descripcionContactoOferta' => 'Descripcion Contacto Oferta',
      'idInformacionContacto' => 'Plantilla',
      'estado' => 'Estado'
    ];
  }

  // RELACIONES

  public function getObjCiudad(){
    return $this->hasOne(Ciudad::className(), ['idCiudad' => 'idCiudad']);
  }

  public function getObjInformacionContactoOferta(){
    return $this->hasOne(InformacionContactoOferta::className(), ['idInformacionContacto' => 'idInformacionContacto']);
  }

  public function getOfertasDestino()
  {
    return $this->hasMany(OfertasLaboralesDestino::className(), ['idOfertaLaboral' => 'idOfertaLaboral']);
  }

  // CONSULTAS

  /**
  * busca las ofertas laborales segun los atributos ciudad, grupo de interes, fecha publicacion y fecha fin publicacion
  * @param userCiudad = ciudad del usuario, userGrupos = grupos de interes donde esta el usuario
  * @return resultado de la consulta
  */
  public static function getOfertasLaboralesInteres($userCiudad, $userGrupos)
  {
    $fecha = Date("Y-m-d H:i:s");
    $userGrupos = implode(',',$userGrupos);

    $todosCiudad = \Yii::$app->params['ciudad']['*'];
    $todosGrupo = \Yii::$app->params['grupo']['*'];

    $query = self::find()->joinWith(['ofertasDestino'])
    ->where("( t_OfertasLaborales.estado=:estado AND fechaPublicacion<=:fechaPublicacion AND fechaCierre>=:fechaCierre AND ( (codigoCiudad =:codigoCiudad AND idGrupoInteres IN ($userGrupos)) OR (codigoCiudad =:codigoCiudad AND idGrupoInteres=:todosGrupo) OR (codigoCiudad =:todosCiudad AND idGrupoInteres IN ($userGrupos)) OR (codigoCiudad =:todosCiudad AND idGrupoInteres =:todosGrupo) )   )")
    ->addParams([':estado' => InformacionContactoOferta::PLANTILLA_ACTIVA, ':fechaPublicacion' => $fecha,':fechaCierre'=>$fecha, ':codigoCiudad'=> $userCiudad, ':todosCiudad'=>$todosCiudad, ':todosGrupo'=> $todosGrupo]);

    //var_dump($query->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql);

    $dataProvider = new ActiveDataProvider([
      'query' => $query,
      'pagination' => [
        'pageSize' => 5,
      ],
    ]);

    return $dataProvider;
  }


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

    return ArrayHelper::map($opciones, 'NombreCargo', 'NombreCargo');
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
  * consulta todos los objetos del modelo Ciudad
  * @param
  * @return retorna todos los modelos Cargo mapeados por idCiudad y nombreCiudad
  */
  public static function getListaCiudad()
  {
    $opciones = Ciudad::find()->asArray()->all();
    return ArrayHelper::map($opciones, 'idCiudad', 'nombreCiudad');
  }

  /**
  * Se consultan las plantillas
  * @param none
  * @return array mapeado
  */
  public static function getListaPlantillas()
  {
    $opciones = InformacionContactoOferta::find()->where(['estado' => InformacionContactoOferta::PLANTILLA_ACTIVA])->asArray()->all();
    return ArrayHelper::map($opciones, 'idInformacionContacto', 'nombrePlantilla');
  }


}
