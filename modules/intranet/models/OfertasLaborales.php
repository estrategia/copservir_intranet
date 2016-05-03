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
* @property string $idContenidoDestino
* @property string $idCiudad
* @property string $fechaPublicacion
* @property string $fechaCierre
* @property string $numeroDocumento
* @property string $fechaInicioPublicacion
* @property string $fechaFinPublicacion
* @property string $tituloOferta
* @property string $urlElEmpleo
* @property integer $idCargo
* @property integer $idArea
* @property string $descripcionContactoOferta
* @property string $idInformacionContacto
*/
class OfertasLaborales extends \yii\db\ActiveRecord
{
  /**
  * @inheritdoc
  */
  public static function tableName()
  {
    return 't_OfertasLaborales';
  }

  /**
  * @inheritdoc
  */
  public function rules()
  {
    return [
      [[ 'idCiudad', 'fechaPublicacion', 'fechaCierre', 'numeroDocumento', 'fechaInicioPublicacion', 'fechaFinPublicacion', 'tituloOferta', 'urlElEmpleo', 'idCargo', 'idArea', 'descripcionContactoOferta', 'idInformacionContacto'], 'required'],
      [[ 'idCiudad', 'numeroDocumento', 'idCargo', 'idArea', 'idInformacionContacto'], 'integer'],
      [['fechaPublicacion', 'fechaCierre', 'fechaInicioPublicacion', 'fechaFinPublicacion'], 'date',  'format'=>'php:Y-m-d H:i:s'],//'date',  'format'=>'php:Y-m-d H:i:s'
      [['descripcionContactoOferta'], 'string'],
      [['tituloOferta', 'urlElEmpleo'], 'string', 'max' => 45]
    ];
  }

  /**
  * @inheritdoc
  */
  public function attributeLabels()
  {
    return [
      'idOfertaLaboral' => 'Id Oferta Laboral',
      'idCiudad' => 'Ciudad',
      'fechaPublicacion' => 'Fecha Publicacion',
      'fechaCierre' => 'Fecha Cierre',
      'numeroDocumento' => 'Id Usuario Publicacion',
      'fechaInicioPublicacion' => 'Fecha Inicio Publicacion',
      'fechaFinPublicacion' => 'Fecha Fin Publicacion',
      'tituloOferta' => 'Titulo Oferta',
      'urlElEmpleo' => 'Url El Empleo',
      'idCargo' => 'Cargo',
      'idArea' => 'Area',
      'descripcionContactoOferta' => 'Descripcion Contacto Oferta',
      'idInformacionContacto' => 'Plantilla',
    ];
  }

  /*
  * RELACIONES
  */

  /**
  * define la relacion entre los modelos ofertasLaborales Y Cargo a traves del aributo idCargo
  * @return \yii\db\ActiveQuery modelo Cargo
  */
  public function getObjCargo(){
    return $this->hasOne(Cargo::className(), ['idCargo' => 'idCargo']);
  }

  /**
  * define la relacion entre los modelos ofertasLaborales Y Area a traves del aributo idArea
  * @return \yii\db\ActiveQuery modelo Area
  */
  public function getObjArea(){
    return $this->hasOne(Area::className(), ['idArea' => 'idArea']);
  }

  /**
  * define la relacion entre los modelos ofertasLaborales Y Ciudad a traves del aributo idCiudad
  * @return \yii\db\ActiveQuery modelo Ciudad
  */
  public function getObjCiudad(){
    return $this->hasOne(Ciudad::className(), ['idCiudad' => 'idCiudad']);
  }

  /**
  * define la relacion entre los modelos ofertasLaborales e InformacionContactoOferta a traves del aributo idInformacionContacto
  * @return \yii\db\ActiveQuery modelo InformacionContactoOferta
  */
  public function getObjInformacionContactoOferta(){
    return $this->hasOne(InformacionContactoOferta::className(), ['idInformacionContacto' => 'idInformacionContacto']);
  }


  public function getObjUsuarioPublicacion(){
    return $this->hasOne(Area::className(), ['idArea' => 'idArea']);
  }

  /**
  * define la relacion entre los modelos ofertasLaborales y OfertasLaboralesDestino a traves del aributo idOfertaLaboral
  * @return \yii\db\ActiveQuery modelo OfertasLaboralesDestino
  */
  public function getOfertasDestino()
  {
    return $this->hasMany(OfertasLaboralesDestino::className(), ['idOfertaLaboral' => 'idOfertaLaboral']);
  }

  /*
  * CONSULTAS
  */

  /**
  * Consulta todos los modelos ofertasLaborales
  * @param userCiudad = ciudad del usuario, userGrupos = grupos de interes donde esta el usuario
  * @return dataProvider
  */
  public function getVertodos($params)
  {
    $query = self::find()->orderby('idCiudad')->with(['objCargo', 'objArea', 'objCiudad', 'objInformacionContactoOferta']);

    $dataProvider = new ActiveDataProvider([
      'query' => $query,
      'pagination' => [
        'pageSize' => 10,
      ],
    ]);

    $this->load($params);

    return $dataProvider;
  }


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
    ->where("( fechaInicioPublicacion<=:fechaInicioPublicacion AND fechaFinPublicacion>=:fechaFinPublicacion AND ( (codigoCiudad =:codigoCiudad AND idGrupoInteres IN ($userGrupos)) OR (codigoCiudad =:codigoCiudad AND idGrupoInteres=:todosGrupo) OR (codigoCiudad =:todosCiudad AND idGrupoInteres IN ($userGrupos)) OR (codigoCiudad =:todosCiudad AND idGrupoInteres =:todosGrupo) )   )")
    ->addParams([':fechaInicioPublicacion' => $fecha,':fechaFinPublicacion'=>$fecha, ':codigoCiudad'=> $userCiudad, ':todosCiudad'=>$todosCiudad, ':todosGrupo'=> $todosGrupo]);

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
  * consulta todos los objetos del modelo Area
  * @param
  * @return retorna todos los modelos Area mapeados por idArea y nombreArea
  */
  public static function getListaArea()
  {
    $opciones = Area::find()->asArray()->all();
    return ArrayHelper::map($opciones, 'idArea', 'nombreArea');
  }

  /**
  * consulta todos los objetos del modelo Cargo
  * @param
  * @return retorna todos los modelos Cargo mapeados por idCargo y nombreCargo
  */
  public static function getListaCargo()
  {
    $opciones = Cargo::find()->asArray()->all();
    return ArrayHelper::map($opciones, 'idCargo', 'nombreCargo');
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
    $opciones = InformacionContactoOferta::find()->asArray()->all();
    return ArrayHelper::map($opciones, 'idInformacionContacto', 'nombrePlantilla');
  }


}
