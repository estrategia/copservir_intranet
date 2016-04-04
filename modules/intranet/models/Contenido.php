<?php

namespace app\modules\intranet\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

/**
 * This is the model class for table "t_contenido".
 *
 * @property string $idContenido
 * @property string $titulo
 * @property string $contenido
 * @property string $idUsuarioPublicacion
 * @property string $fechaPublicacion
 * @property string $fechaActualizacion
 * @property integer $idEstado
 * @property string $fechaAprobacion
 * @property string $idUsuarioAprobacion
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
            [['contenido', 'idUsuarioPublicacion', 'fechaPublicacion', 'idLineaTiempo'], 'required'],
            [['contenido'], 'string'],
            [['idUsuarioPublicacion', 'estado', 'idUsuarioAprobacion', 'idLineaTiempo'], 'integer'],
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
            'idUsuarioPublicacion' => 'Id Usuario Publicacion',
            'fechaPublicacion' => 'Fecha Publicacion',
            'fechaActualizacion' => 'Fecha Actualizacion',
            'estado' => 'Estado',
            'fechaAprobacion' => 'Fecha Aprobacion',
            'idUsuarioAprobacion' => 'Id Usuario Aprobacion',
            'fechaInicioPublicacion' => 'Fecha Inicio Publicacion',
            'idLineaTiempo' => 'Id Linea Tiempo',
        ];
    }

    public static function traerNoticias($idLineaTiempo){
        return $noticias = Contenido::find()->with(['objUsuarioPublicacion', 'listComentarios', 'listAdjuntos','listMeGusta', 'listComentarios','listMeGustaUsuario', 'objDenuncioComentarioUsuario'])
                ->joinWith(['listContenidosDestinos'])->where(
//                           ['and',
//                                ['<=', 'fechaInicioPublicacion', 'now()'],
//                                ['=', 'idLineaTiempo', $idLineaTiempo],
//                                ['=', 'estado', Contenido::APROBADO],
//                                ['=', 't_ContenidoDestino.codigoCiudad', Yii::$app->user->identity->getCodigoCiudad() ],
//                                ['IN', 't_ContenidoDestino.idGrupoInteres',  Yii::$app->user->identity->getGruposCodigos() ]
//                             ]
                        " fechaInicioPublicacion<=now() AND idLineaTiempo =:idLineaTiempo AND estado=:estado AND
                            (
                                (t_ContenidoDestino.codigoCiudad =:ciudad AND t_ContenidoDestino.idGrupoInteres IN (".implode(", ",Yii::$app->user->identity->getGruposCodigos()).")) OR
                                (t_ContenidoDestino.codigoCiudad =:ciudad AND t_ContenidoDestino.idGrupoInteres=:gruposA ) OR
                                (t_ContenidoDestino.codigoCiudad =:ciudadA AND t_ContenidoDestino.idGrupoInteres=:gruposA ) OR
                                (t_ContenidoDestino.codigoCiudad =:ciudadA AND t_ContenidoDestino.idGrupoInteres IN (".implode(",",Yii::$app->user->identity->getGruposCodigos())."))
                        )"
                            )
                            ->addParams([':estado' => self::APROBADO,
                                         ':ciudad'=> Yii::$app->user->identity->getCodigoCiudad(),
                                         ':idLineaTiempo' => $idLineaTiempo,
                                         ':ciudadA'=> Yii::$app->params['ciudad']['*'],
                                         ':gruposA'=>Yii::$app->params['grupo']['*']]
                                        )
                            ->orderBy('fechaInicioPublicacion Desc')

                ->all();
    }


    public static function traerTodasNoticiasCopservir($idLineaTiempo){
          return $noticias = Contenido::find()->with(['objUsuarioPublicacion', 'listComentarios', 'listAdjuntos','listMeGusta', 'listComentarios','listMeGustaUsuario', 'objDenuncioComentarioUsuario'])
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
    * define la relacion entre los modelos Contenido y ContenidoRecomendacion a traves del aributo idContenido
    */
    public function getContenidoRecomendacion()
    {
        return $this->hasMany(ContenidoRecomendacion::className(), ['idContenido' => 'idContenido']);
    }

    /**
    * Consuta las publicaciones realizadas por el usuario y las publicaciones que le han recomendado al usuario
    * y las retorna ordenadas descendentemente
    */
    public static function traerMisPublicaciones(){

        $fecha = Date("Y-m-d H:i:s");
        $idUsuario = Yii::$app->user->identity->numeroDocumento;
        $query = self::find()->joinWith(['contenidoRecomendacion'])
              ->where("( (t_Contenido.idUsuarioPublicacion =:idUsuario and t_Contenido.estado=:estado and t_Contenido.fechaPublicacion <=:fechaPublicacion) or (t_ContenidoRecomendacion.numeroDocumentoDirigido =:idUsuario and t_ContenidoRecomendacion.fechaRegistro <=:fechaRegistro) )")
              ->addParams([':fechaPublicacion' => $fecha,':fechaRegistro'=>$fecha, ':idUsuario'=> $idUsuario, ':estado'=>self::APROBADO])
              ->orderBy('t_contenido.fechaInicioPublicacion DESC,t_contenidorecomendacion.fechaRegistro DESC');

        return $query;
    }



    public static function traerNoticiaEspecifica($idContenido){
        return $noticias = Contenido::find()->with(['objUsuarioPublicacion', 'listComentarios', 'listAdjuntos','listMeGusta', 'listComentarios','listMeGustaUsuario', 'objDenuncioComentarioUsuario'])->where(
                           ['and',
                                ['<=', 'fechaInicioPublicacion', new Expression('now()')],
                                ['=', 'idContenido', $idContenido],
                                ['=', 'estado', self::APROBADO]
                             ]
                            )->one();
    }



    /**
    * Trae todas las noticias con ese patron
    * @param busqueda = patron de busqueda
    * @return dataProvider con la consulta
    */
    public static function traerBusqueda($busqueda)
    {
      $query = Contenido::find()->andFilterWhere([
                                                  'or',
                                                      ['LIKE', 'contenido', $busqueda],
                                                      ['LIKE', 'titulo', $busqueda],
                                                    ]);
      $dataProvider = new ActiveDataProvider([
         'query' => $query,
         'pagination' => [
             'pageSize' => 5,
         ],
      ]);

     return $dataProvider;

    }


    /**
    * Trae todas las noticias en ese año con ese patron
    * @param busqueda = patron de busqueda, a = año especifico
    * @return dataProvider con la consulta
    */
    public static function traerBusquedaAnio($busqueda, $a)
    {

      $query = Contenido::find()->andFilterWhere([
                                                  'or',
                                                      ['LIKE', 'contenido', $busqueda],
                                                      ['LIKE', 'titulo', $busqueda],
                                                    ])->andWhere(
                                                      ['=', 'year(fechaPublicacion)', $a]
                                                    );
      $dataProvider = new ActiveDataProvider([
         'query' => $query,
         'pagination' => [
             'pageSize' => 5,
         ],
      ]);

     return $dataProvider;

    }

    /**
    * trae todas las noticias en ese año y mes con ese patron
    * @param busqueda = patron de busqueda,  a = año especifico, m = mes especifico
    * @return dataProvider con la consulta
    */
    public static function traerBusquedaMes($busqueda , $a, $m)
    {
      $query = Contenido::find()->andFilterWhere([
                                                  'or',
                                                      ['LIKE', 'contenido', $busqueda],
                                                      ['LIKE', 'titulo', $busqueda],
                                                    ])->andWhere(
                                                      ['=', 'year(fechaPublicacion)', $a]
                                                    )->andWhere(
                                                      ['=', 'month(fechaPublicacion)', $m]
                                                    );
      $dataProvider = new ActiveDataProvider([
         'query' => $query,
         'pagination' => [
             'pageSize' => 5,
         ],
      ]);

     return $dataProvider;

    }


    /**
    *  trae todas las noticias en ese año mes y dia con ese patron
    * @param busqueda = patron de busqueda,  a = año especifico, m = mes especifico, d = dia especifico
    * @return dataProvider con la consulta
    */
    public static function traerBusquedaDia($busqueda , $a, $m, $d)
    {
      $query = Contenido::find()->andFilterWhere([
                                                  'or',
                                                      ['LIKE', 'contenido', $busqueda],
                                                      ['LIKE', 'titulo', $busqueda],
                                                    ])->andWhere(
                                                      ['=', 'year(fechaPublicacion)', $a]
                                                    )->andWhere(
                                                      ['=', 'month(fechaPublicacion)', $m]
                                                    )->andWhere(
                                                      ['=', 'day(fechaPublicacion)', $d]
                                                    );
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
      $sql = 'select year(fechaPublicacion) etiqueta, count(idContenido) cantidad from t_contenido where (contenido like "%'.$busqueda.'%" or titulo like "%'.$busqueda.'%") group by year(fechaPublicacion) order by fechaPublicacion desc limit 5;';
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
      $sql = 'select year(fechaPublicacion) anio, month(fechaPublicacion) etiqueta, count(idContenido) cantidad from t_contenido where (contenido like "%'.$busqueda.'%" or titulo like "%'.$busqueda.'%") and year(fechaPublicacion) = '.$a.' group by month(fechaPublicacion) order by fechaPublicacion desc;';
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
      $sql = 'select year(fechaPublicacion) anio, month(fechaPublicacion) mes, day(fechaPublicacion) etiqueta, count(idContenido) cantidad from t_contenido where (contenido like "%'.$busqueda.'%" or titulo like "%'.$busqueda.'%") and year(fechaPublicacion) = '.$a.' and month(fechaPublicacion) = '.$m.' group by day(fechaPublicacion) order by fechaPublicacion desc;';
      $resultado = $db->createCommand($sql)->queryAll();
      return $resultado;
    }


    public function getListComentarios()
    {
        return $this->hasMany(ContenidosComentarios::className(), ['idContenido' => 'idContenido']);
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
        return $this->hasOne(DenunciosContenidos::className(), ['idContenido' => 'idContenido'])->andOnCondition(['idUsuarioDenunciante' => Yii::$app->user->identity->numeroDocumento]);
    }

    public function getListAdjuntos()
    {
        return $this->hasMany(ContenidosAdjuntos::className(), ['idContenido' => 'idContenido']);
    }

    public function getListContenidosDestinos()
    {
        return $this->hasMany(ContenidoDestino::className(), ['idContenido' => 'idContenido']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObjUsuarioPublicacion()
    {
        return $this->hasOne(Usuario::className(), ['numeroDocumento' => 'idUsuarioPublicacion']);
    }

    public function getObjLineaTiempo()
    {
        return $this->hasOne(LineaTiempo::className(), ['idLineaTiempo' => 'idLineaTiempo']);
    }

    public function meGusta($idUsuario){

    }
}
