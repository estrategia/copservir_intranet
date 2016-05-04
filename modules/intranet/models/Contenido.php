<?php

namespace app\modules\intranet\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use app\modules\intranet\models\ContenidoDestino;

/**
* This is the model class for table "t_Contenido".
*
* @property string $idContenido
* @property string $titulo
* @property string $contenido
* @property string $numeroDocumentoPublicacion
* @property string $fechaPublicacion
* @property string $fechaActualizacion
* @property integer $idEstado
* @property string $fechaAprobacion
* @property string $numeroDocumentoAprobacion
* @property string $fechaInicioPublicacion
* @property string $idLineaTiempo
* @property array $imagenes
*/
class Contenido extends \yii\db\ActiveRecord
{
  const PENDIENTE_APROBACION = 1;
  const APROBADO = 2;
  const ELIMINADO = 3;
  const ELIMINADO_DENUNCIO = 4;

  public $anexos;
  public $imagenes = [];

  public static function tableName()
  {
    return 't_Contenido';
  }

  public function rules()
  {
    return [
      [['contenido', 'numeroDocumentoPublicacion', 'fechaPublicacion', 'idLineaTiempo'], 'required'],
      [['contenido'], 'string'],
      [['numeroDocumentoPublicacion', 'estado', 'numeroDocumentoAprobacion', 'idLineaTiempo'], 'integer'],
      [['fechaPublicacion', 'fechaActualizacion', 'fechaAprobacion', 'fechaInicioPublicacion'], 'safe'],
      [['titulo'], 'string', 'max' => 45],
      [['imagenes'], 'safe'],
    ];
  }

  public function attributeLabels()
  {
    return [
      'idContenido' => 'Id Contenido',
      'titulo' => 'Titulo',
      'contenido' => 'Contenido',
      'numeroDocumentoPublicacion' => 'Usuario Publicacion',
      'fechaPublicacion' => 'Fecha Publicacion',
      'fechaActualizacion' => 'Fecha Actualizacion',
      'estado' => 'Estado',
      'fechaAprobacion' => 'Fecha Aprobacion',
      'numeroDocumentoAprobacion' => 'Usuario Aprobacion',
      'fechaInicioPublicacion' => 'Fecha Inicio Publicacion',
      'idLineaTiempo' => 'Id Linea Tiempo',
    ];
  }


  //RELACIONES

  public function getContenidoRecomendacion()
  {
    return $this->hasMany(ContenidoRecomendacion::className(), ['idContenido' => 'idContenido']);
  }

  public function getListComentarios()
  {
    return $this->hasMany(ContenidosComentarios::className(), ['idContenido' => 'idContenido'])->andOnCondition(['estado' => ContenidosComentarios::ESTADO_ACTIVO]);
  }

  public function getListMeGusta()
  {
    return $this->hasMany(MeGustaContenidos::className(), ['idContenido' => 'idContenido']);
  }

  public function getListMeGustaUsuario()
  {
    return $this->hasMany(MeGustaContenidos::className(), ['idContenido' => 'idContenido'])->andOnCondition(['numeroDocumento' => Yii::$app->user->identity->numeroDocumento]);
  }

  public function getObjDenuncioComentarioUsuario()
  {
    return $this->hasOne(DenunciosContenidos::className(), ['idContenido' => 'idContenido'])->andOnCondition(['numeroDocumento' => Yii::$app->user->identity->numeroDocumento]);
  }

  public function getListContenidosDestinos()
  {
    return $this->hasMany(ContenidoDestino::className(), ['idContenido' => 'idContenido']);
  }

  public function getObjUsuarioPublicacion()
  {
    return $this->hasOne(Usuario::className(), ['numeroDocumento' => 'numeroDocumentoPublicacion']);
  }

  public function getObjLineaTiempo()
  {
    return $this->hasOne(LineaTiempo::className(), ['idLineaTiempo' => 'idLineaTiempo']);
  }

  public function getObjDenunciosContenidos(){
    return $this->hasOne(DenunciosContenidos::className(), ['idContenido' => 'idContenido']);
  }

  public function getObjContenidoAdjuntoImagenes()
  {
    return $this->hasMany(ContenidoAdjunto::className(), ['idContenido' => 'idContenido'])->from(ContenidoAdjunto::tableName().' ContenidoAdjuntoImagenes')->andOnCondition(['ContenidoAdjuntoImagenes.tipo' => 2]);
  }

  public function getObjContenidoAdjuntoDocumentos()
  {
    return $this->hasMany(ContenidoAdjunto::className(), ['idContenido' => 'idContenido'])->from(ContenidoAdjunto::tableName().' ContenidoAdjuntoDocumentos')->andOnCondition(['ContenidoAdjuntoDocumentos.tipo' => 1]);
  }

  //CONSULTAS

  public static function traerNoticias($idLineaTiempo){
    return $noticias = self::find()->with(['objUsuarioPublicacion', 'listComentarios', 'listMeGusta', 'listComentarios','listMeGustaUsuario', 'objDenuncioComentarioUsuario'])
    ->joinWith(['listContenidosDestinos'])->where(
    " fechaInicioPublicacion<=now() AND idLineaTiempo =:idLineaTiempo AND estado=:estado AND
    (
    (t_ContenidoDestino.codigoCiudad =:ciudad AND t_ContenidoDestino.idGrupoInteres IN (".implode(", ",Yii::$app->user->identity->getGruposCodigos()).")) OR
    (t_ContenidoDestino.codigoCiudad =:ciudad AND t_ContenidoDestino.idGrupoInteres=:gruposA ) OR
    (t_ContenidoDestino.codigoCiudad =:ciudadA AND t_ContenidoDestino.idGrupoInteres=:gruposA ) OR
    (t_ContenidoDestino.codigoCiudad =:ciudadA AND t_ContenidoDestino.idGrupoInteres IN (".implode(",",Yii::$app->user->identity->getGruposCodigos())."))
    )"
    )
    ->addParams([':estado' => self::APROBADO,
    ':ciudad'=> Yii::$app->user->identity->getCiudadCodigo(),
    ':idLineaTiempo' => $idLineaTiempo,
    ':ciudadA'=> Yii::$app->params['ciudad']['*'],
    ':gruposA'=>Yii::$app->params['grupo']['*']]
    )
    ->orderBy('fechaInicioPublicacion Desc')

    ->all();
  }


  public static function traerTodasNoticiasCopservir($idLineaTiempo){
    return $noticias = self::find()->with(['objUsuarioPublicacion', 'listComentarios', 'listMeGusta', 'listComentarios','listMeGustaUsuario', 'objDenuncioComentarioUsuario'])
    ->where(
      ['and',
        ['<=', 'fechaInicioPublicacion', new Expression('now()')],
        ['=', 'idLineaTiempo', $idLineaTiempo],
        ['=', 'estado', self::APROBADO],
      ]
    )->orderBy('fechaInicioPublicacion Desc');
  }

  /**
  * Consuta las publicaciones realizadas por el usuario y las publicaciones que le han recomendado al usuario
  * y las retorna ordenadas descendentemente
  */
  public static function traerMisPublicaciones(){

    $fecha = Date("Y-m-d H:i:s");
    $idUsuario = Yii::$app->user->identity->numeroDocumento;
    $query = self::find()->joinWith(['contenidoRecomendacion'])
    ->where("( (t_Contenido.numeroDocumentoPublicacion =:idUsuario and t_Contenido.estado=:estado and t_Contenido.fechaInicioPublicacion <=:fechaPublicacion) or (t_ContenidoRecomendacion.numeroDocumentoDirigido =:idUsuario and t_ContenidoRecomendacion.fechaRegistro <=:fechaRegistro) )")
    ->addParams([':fechaPublicacion' => $fecha,':fechaRegistro'=>$fecha, ':idUsuario'=> $idUsuario, ':estado'=>self::APROBADO])
    ->orderBy('t_Contenido.fechaInicioPublicacion DESC,t_ContenidoRecomendacion.fechaRegistro DESC');

    return $query;
  }


  public static function traerNoticiaEspecifica($idContenido){
      return $noticias = self::find()->with(['objUsuarioPublicacion', 'listComentarios', 'listMeGusta', 'listComentarios','listMeGustaUsuario', 'objDenuncioComentarioUsuario'])->where(
      ['and',
        ['<=', 'fechaInicioPublicacion', new Expression('now()')],
        ['=', 'idContenido', $idContenido],
        ['=', 'estado', self::APROBADO]
      ]
    )->one();
  }

  /**
  * consulta todas las noticias con ese patron
  * @param busqueda = patron de busqueda
  * @return dataProvider con la consulta
  */
  public static function traerBusqueda($busqueda)
  {
    $query = self::find()->andFilterWhere([
      'or',
      ['LIKE', 'contenido', $busqueda],
      ['LIKE', 'titulo', $busqueda],
      ])->andWhere(
      ['estado' => self::APROBADO]
      )->orderBy('fechaInicioPublicacion DESC');
      $dataProvider = new ActiveDataProvider([
        'query' => $query,
        'pagination' => [
          'pageSize' => 5,
        ],
      ]);

      return $dataProvider;
  }


  /**
  * consulta todas las noticias en ese año con ese patron
  * @param busqueda = patron de busqueda, a = año especifico
  * @return dataProvider con la consulta
  */
  public static function traerBusquedaAnio($busqueda, $a)
  {
    $query = self::find()->andFilterWhere([
      'or',
        ['LIKE', 'contenido', $busqueda],
        ['LIKE', 'titulo', $busqueda],
        ])->andWhere(
          ['=', 'year(fechaInicioPublicacion)', $a]
          )->andWhere(
          ['estado' => self::APROBADO]
          )->orderBy('fechaInicioPublicacion DESC');

    $dataProvider = new ActiveDataProvider([
      'query' => $query,
      'pagination' => [
        'pageSize' => 5,
      ],
    ]);

    return $dataProvider;
  }

  /**
  * consulta todas las noticias en ese año y mes con ese patron
  * @param busqueda = patron de busqueda,  a = año especifico, m = mes especifico
  * @return dataProvider con la consulta
  */
  public static function traerBusquedaMes($busqueda , $a, $m)
  {
    $query = self::find()->andFilterWhere([
      'or',
      ['LIKE', 'contenido', $busqueda],
      ['LIKE', 'titulo', $busqueda],
      ])->andWhere(
      ['=', 'year(fechaInicioPublicacion)', $a]
      )->andWhere(
      ['=', 'month(fechaInicioPublicacion)', $m]
      )->andWhere(
      ['estado' => self::APROBADO]
      )->orderBy('fechaInicioPublicacion DESC');
      $dataProvider = new ActiveDataProvider([
        'query' => $query,
        'pagination' => [
          'pageSize' => 5,
        ],
      ]);

      return $dataProvider;
    }

  /**
  *  consulta todas las noticias en ese año mes y dia con ese patron
  * @param busqueda = patron de busqueda,  a = año especifico, m = mes especifico, d = dia especifico
  * @return dataProvider con la consulta
  */
  public static function traerBusquedaDia($busqueda , $a, $m, $d)
  {
    $query = self::find()->andFilterWhere([
      'or',
      ['LIKE', 'contenido', $busqueda],
      ['LIKE', 'titulo', $busqueda],
      ])->andWhere(
      ['=', 'year(fechaInicioPublicacion)', $a]
      )->andWhere(
      ['=', 'month(fechaInicioPublicacion)', $m]
      )->andWhere(
      ['=', 'day(fechaInicioPublicacion)', $d]
      )->andWhere(
      ['estado' => self::APROBADO]
      )->orderBy('fechaInicioPublicacion DESC');
      $dataProvider = new ActiveDataProvider([
        'query' => $query,
        'pagination' => [
          'pageSize' => 5,
        ],
      ]);

      return $dataProvider;
    }


  /**
  * cuenta cuantas noticias hay agrupadas por años para crear la grafica
  * @param busqueda = patron de busqueda
  * @return resultado de la consulta
  */
  public static function datosGraficaAnio($busqueda)
  {
    $db = Yii::$app->db;
    $sql = 'select year(fechaInicioPublicacion) etiqueta, count(idContenido) cantidad
      from t_Contenido
        where (contenido like "%'.$busqueda.'%" or titulo like "%'.$busqueda.'%") group by year(fechaInicioPublicacion)
          order by fechaInicioPublicacion desc limit ' . Yii::$app->params['contenido']['aniosBusqueda'] ;
    $resultado = $db->createCommand($sql)->queryAll();
    return $resultado;
  }


  /**
  *  cuenta cuantas noticias hay agrupadas por meses para crear la grafica
  * @param busqueda = patron de busqueda,  a = año especifico
  * @return dataProvider con la consulta
  */
  public static function datosGraficaMes($busqueda, $a)
  {
    $db = Yii::$app->db;
    $sql = 'select year(fechaInicioPublicacion) anio, month(fechaInicioPublicacion) etiqueta, count(idContenido) cantidad
      from t_Contenido
        where (contenido like "%'.$busqueda.'%" or titulo like "%'.$busqueda.'%")
          and year(fechaInicioPublicacion) = '.$a.' group by month(fechaInicioPublicacion) order by fechaInicioPublicacion desc';
    $resultado = $db->createCommand($sql)->queryAll();
    return $resultado;
  }

  /**
  * cuenta cuantas noticias hay agrupadas por dias para crear la grafica
  * @param busqueda = patron de busqueda,  a = año especifico,  m = mes especifico
  * @return dataProvider con la consulta
  */
  public static function datosGraficaDia($busqueda, $a, $m)
  {
    $db = Yii::$app->db;
    $sql = 'select year(fechaInicioPublicacion) anio, month(fechaInicioPublicacion) mes, day(fechaInicioPublicacion) etiqueta,
     count(idContenido) cantidad
      from t_Contenido
        where (contenido like "%'.$busqueda.'%" or titulo like "%'.$busqueda.'%")
          and year(fechaInicioPublicacion) = '.$a.' and month(fechaInicioPublicacion) = '.$m.'
            group by day(fechaInicioPublicacion) order by fechaInicioPublicacion desc';
    $resultado = $db->createCommand($sql)->queryAll();
    return $resultado;
  }

  /**
  * Consulta todos los modelos Contenido con estado PENDIENTE_APROBACION
  * @return array modelo Contenido
  */
  public static function getContenidosPendientesAprobacion()
  {
    $query = self::find()->with(['objUsuarioPublicacion', 'objLineaTiempo'])->where('( estado =:estado )')->orderBy('fechaPublicacion asc')
    ->addParams(['estado'=>self::PENDIENTE_APROBACION]);

    $dataProvider = new ActiveDataProvider([
      'query' => $query,
      'pagination' => [
        'pageSize' => 10,
      ],
    ]);

    return $dataProvider;
  }

  /**
  * Consulta un modelo Contenido por llave primaria, junto con las relaciones: usuario y linea de tiempo
  * @param $id = identificador del contenido
  * @return modelo Contenido
  */
  public static function getContenidoDetalleAprobacion($id)
  {
    return self::find()->where(['idContenido' => $id])->with(['objUsuarioPublicacion', 'objLineaTiempo'])->one();
  }

  /**
  * Consulta todos los modelos Contenido que han sido denunciados
  * @return array modelo Contenido
  */
  public static function getContenidosDenunciados()
  {

    $query = self::find()->joinWith(['objDenunciosContenidos'])
    ->where("(   t_DenunciosContenidos.estado =:estado )")
    ->orderBy('fechaRegistro asc')
    ->addParams([':estado' => DenunciosContenidos::PENDIENTE_APROBACION ])->with(['objUsuarioPublicacion', 'objLineaTiempo' ]);

    $dataProvider = new ActiveDataProvider([
      'query' => $query,
      'pagination' => [
        'pageSize' => 10,
      ],
    ]);

    return $dataProvider;
  }

  /**
  * Consulta un modelo Contenido por llave primaria, junto con las relaciones: usuario, linea de tiempo y contenidoDenunciado
  * @param $id = identificador del contenido
  * @return modelo Contenido
  */
  public static function getContenidoDetalleDenuncio($id)
  {
    $query = self::find()->joinWith(['objDenunciosContenidos'])
    ->where("(   t_DenunciosContenidos.estado =:estado and t_Contenido.idContenido =:id )")
    ->addParams([':estado' => DenunciosContenidos::PENDIENTE_APROBACION, ':id' => $id ])->with([
      'objDenunciosContenidos' => function($q) {
        $q->with('objUsuario');
      }, 'objUsuarioPublicacion', 'objLineaTiempo' ])->one();

      return $query;
  }

  // FUNCIONES

  /**
  * funcion para crear un modelo LogContenidos
  * si el modelo no se crea devuelve una excepcion
  * @throws excepcion 101 el modelo no guardo su log
  */
  public function afterSave($inser, $changedAttributes)
  {
    $logContenido = new LogContenidos();
    $logContenido->idContenido = $this->idContenido;
    $logContenido->estado = $this->estado;
    $logContenido->fechaRegistro = $this->fechaPublicacion;
    $logContenido->numeroDocumento = $this->numeroDocumentoPublicacion;
    if (!$logContenido->save()) {
      //error al guardar el log
      throw new Exception("Error al guardar el logContenido:".yii\helpers\Json::enconde($logContenido->getErrors()), 101);
    }
    return parent::afterSave($inser, $changedAttributes);
  }

  /**
  * verifica si la linea de tiempo tiene autorizacion automatica y dependiendo de esto
  * procede a aprobar o no el contenido
  */
  public function setEstadoDependiendoAprovacion($lineaTiempo)
  {
    if ($lineaTiempo->tieneAutorizacionAutomatica()) {
      $this->aprobarPublicacion();
    } else {
      $this->publicacionPendienteAprobar();
    }
  }

  /**
  * Asigna los atributos estado, fechaAprobacion, fechaInicioPublicacion para que el contenido sea aprobado
  */
  public function aprobarPublicacion()
  {
    $this->estado = Contenido::APROBADO;
    $this->fechaAprobacion = date("Y-m-d H:i:s");
    $this->fechaInicioPublicacion = date("Y-m-d H:i:s");
  }

  /**
  * Asigna el atributo estado para que el contenido quede pendiente de aprovacion
  */
  public function publicacionPendienteAprobar()
  {
    $this->estado = Contenido::PENDIENTE_APROBACION;
  }

  public function guardarContenidoDestino($contenidodestino)
  {
    $ciudades = $contenidodestino['codigoCiudad'];
    $gruposInteres = $contenidodestino['idGrupoInteres'];

    for ($i = 0; $i < count($gruposInteres); $i++) {
      $contenidodestino = new ContenidoDestino();
      $contenidodestino->idGrupoInteres = $gruposInteres[$i];
      $contenidodestino->codigoCiudad = $ciudades[$i];
      $contenidodestino->idContenido = $this->idContenido;

      if (!$contenidodestino->save()) {
        throw new Exception("Error al guardar el destino:".yii\helpers\Json::enconde($contenidodestino->getErrors()), 102);
      }
    }
  }

  public function guardarContenidoDestinoTodos(){
    $contenidodestino = new ContenidoDestino();
    $contenidodestino->idGrupoInteres = Yii::$app->params['grupo']['*'];
    $contenidodestino->codigoCiudad = Yii::$app->params['ciudad']['*'];
    $contenidodestino->idContenido = $this->idContenido;

    if (!$contenidodestino->save()) {
      throw new Exception("Error al guardar el destino:".yii\helpers\Json::enconde($contenidodestino->getErrors()), 102);
    }
  }

  public function saveEstadoEliminado()
  {
    $this->estado = Contenido::ELIMINADO_DENUNCIO;
    $this->fechaActualizacion = Date("Y-m-d H:i:s");

    if (!$this->save()) {
      throw new Exception("Error al guardar el logTarea:".yii\helpers\Json::enconde($logTarea->getErrors()), 101);
    }
  }
}
