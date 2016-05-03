<?php

namespace app\modules\intranet\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

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
*/
class Contenido extends \yii\db\ActiveRecord
{
  /**
  * @inheritdoc
  */

  const PENDIENTE_APROBACION = 1;
  const APROBADO = 2;
  const ELIMINADO = 3;
  const ELIMINADO_DENUNCIO = 4;

  public $anexos;

  public static function tableName()
  {
    return 't_Contenido';
  }

  /**
  * @inheritdoc
  */
  public function rules()
  {
    return [
      [['contenido', 'numeroDocumentoPublicacion', 'fechaPublicacion', 'idLineaTiempo'], 'required'],
      [['contenido'], 'string'],
      [['numeroDocumentoPublicacion', 'estado', 'numeroDocumentoAprobacion', 'idLineaTiempo'], 'integer'],
      [['fechaPublicacion', 'fechaActualizacion', 'fechaAprobacion', 'fechaInicioPublicacion'], 'safe'],
      [['titulo'], 'string', 'max' => 45]
    ];
  }

  /**
  * @inheritdoc
  */
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

  /*
  * RELACIONES
  */

  /**
  * define la relacion entre los modelos Contenido y ContenidoRecomendacion a traves del aributo idContenido
  */
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

  /**
  * se define la relacion entre los modelos Contenido y Usuario
  * @return \yii\db\ActiveQuery
  */
  public function getObjUsuarioPublicacion()
  {
    return $this->hasOne(Usuario::className(), ['numeroDocumento' => 'numeroDocumentoPublicacion']);
  }

  public function getObjLineaTiempo()
  {
    return $this->hasOne(LineaTiempo::className(), ['idLineaTiempo' => 'idLineaTiempo']);
  }

  public function meGusta($idUsuario){

  }

  /**
  * Define la relacion relacion entre los modelos Contenido y DenunciosContenidos
  * @param none
  * @return modelo DenunciosContenidos
  */
  public function getObjDenunciosContenidos(){
    return $this->hasOne(DenunciosContenidos::className(), ['idContenido' => 'idContenido']);
  }

  /**
  * Se define la relacion entre los modelos Contenido y ContenidoAdjunto
  * @return \yii\db\ActiveQuery
  */
  public function getObjContenidoAdjuntoImagenes()
  {
    return $this->hasMany(ContenidoAdjunto::className(), ['idContenido' => 'idContenido'])->from(ContenidoAdjunto::tableName().' ContenidoAdjuntoImagenes')->andOnCondition(['ContenidoAdjuntoImagenes.tipo' => 2]);
  }

  /**
  * Se define la relacion entre los modelos Contenido y ContenidoAdjunto
  * @return \yii\db\ActiveQuery
  */
  public function getObjContenidoAdjuntoDocumentos()
  {
    return $this->hasMany(ContenidoAdjunto::className(), ['idContenido' => 'idContenido'])->from(ContenidoAdjunto::tableName().' ContenidoAdjuntoDocumentos')->andOnCondition(['ContenidoAdjuntoDocumentos.tipo' => 1]);
  }

  /*
  * CONSULTAS
  */

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
  )->orderBy('fechaInicioPublicacion Desc')

  ;
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
          $sql = 'select year(fechaInicioPublicacion) etiqueta, count(idContenido) cantidad from t_Contenido where (contenido like "%'.$busqueda.'%" or titulo like "%'.$busqueda.'%") group by year(fechaInicioPublicacion) order by fechaInicioPublicacion desc limit ' . Yii::$app->params['contenido']['aniosBusqueda'] ;
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
          $sql = 'select year(fechaInicioPublicacion) anio, month(fechaInicioPublicacion) etiqueta, count(idContenido) cantidad from t_Contenido where (contenido like "%'.$busqueda.'%" or titulo like "%'.$busqueda.'%") and year(fechaInicioPublicacion) = '.$a.' group by month(fechaInicioPublicacion) order by fechaInicioPublicacion desc';
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
          $sql = 'select year(fechaInicioPublicacion) anio, month(fechaInicioPublicacion) mes, day(fechaInicioPublicacion) etiqueta, count(idContenido) cantidad from t_Contenido where (contenido like "%'.$busqueda.'%" or titulo like "%'.$busqueda.'%") and year(fechaInicioPublicacion) = '.$a.' and month(fechaInicioPublicacion) = '.$m.' group by day(fechaInicioPublicacion) order by fechaInicioPublicacion desc';
          $resultado = $db->createCommand($sql)->queryAll();
          return $resultado;
        }

        /**
        * Consulta todos los modelos Contenido con estado = 1 (pendiente)
        * @param none
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
        * @param none
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
        }
