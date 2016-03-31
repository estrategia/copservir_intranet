<?php

namespace app\modules\intranet\controllers;

use Yii;
use yii\helpers\Json;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use \app\modules\intranet\models\LineaTiempo;
use \app\modules\intranet\models\Contenido;
use \app\modules\intranet\models\MeGustaContenidos;
use \app\modules\intranet\models\ContenidosComentarios;
use \app\modules\intranet\models\DenunciosContenidos;
use app\modules\intranet\models\DenunciosContenidosComentarios;
use app\modules\intranet\models\ContenidoDestino;

class ContenidoController extends Controller {

    public function actionPublicar() {
        $request = \Yii::$app->request;
        $render = $request->post('render', false);

        if ($render) {
            $idLinea = $request->post('linea');
            $objLineaTiempo = LineaTiempo::findOne($idLinea);
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $response = [
                'result' => 'ok',
                'response' => $this->renderAjax('formContenido', ['objLineaTiempo' => $objLineaTiempo, 'objContenido' => new Contenido])
            ];
            return $response;
        } else {

        }
    }

    public function actionListadoMeGustaContenido() {
        $request = \Yii::$app->request;
        $render = $request->post('render', false);

        if ($render) {
            $idContenido = $request->post('idContenido');

            $usuariosMeGusta = MeGustaContenidos::find()->with('objUsuario')->where(['idContenido' => $idContenido])->all();

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'result' => 'ok',
                'response' => $this->renderPartial('_modalMeGusta', ['usuariosMeGusta' => $usuariosMeGusta])
            ];
        } else {

        }
    }

    public function actionListadoComentariosContenido() {
        $request = \Yii::$app->request;
        $render = $request->post('render', false);

        if ($render) {
            $idContenido = $request->post('idContenido');

            $comentariosContenido = ContenidosComentarios::find()->with('objUsuarioPublicacionComentario', 'objDenuncioComentarioUsuario')->where(['idContenido' => $idContenido])->all();

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'result' => 'ok',
                'response' => $this->renderPartial('_modalComentarios', ['comentariosContenido' => $comentariosContenido])
            ];
        } else {

        }
    }

    public function actionDenunciarContenido() {
        $request = \Yii::$app->request;
        $render = $request->post('render', false);

        if ($render) {
            $idContenido = $request->post('idContenido');
            $idLinea = $request->post('idLineaTiempo');

            $modelDenuncio = new DenunciosContenidos();
            $modelDenuncio->idContenido = $idContenido;
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'result' => 'ok',
                'response' => $this->renderPartial('_modalDenuncio', ['modelDenuncio' => $modelDenuncio, 'idLineaTiempo' => $idLinea])
            ];
        } else {

        }
    }

    public function actionGuardarDenuncioContenido() {
        $request = \Yii::$app->request;
        $render = $request->post('render', false);

        $post = $request->post('DenunciosContenidos');

        $idLineaTiempo = $request->post('idLineaTiempo');
        $modelDenuncio = new DenunciosContenidos();
        $modelDenuncio->load($request->post());
        $modelDenuncio->idUsuarioDenunciante = Yii::$app->user->identity->numeroDocumento;
        $modelDenuncio->fechaRegistro = Date("Y-m-d h:i:s");

        if ($modelDenuncio->save()) {
            $linea = LineaTiempo::find()->where(['idLineaTiempo' => $idLineaTiempo])->one();

            $noticias = Contenido::traerNoticias($idLineaTiempo);

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'result' => 'ok',
                'response' => $this->renderAjax('/sitio/_lineaTiempo', [
                    'linea' => $linea,
                    'noticias' => $noticias
                        ]
                )
            ];
        } else {

            $contenido = Contenido::find()->where(['idContenido' => $modelDenuncio->idContenido])->one();

            if (empty($contenido)) {
                $items = [
                    'result' => 'error',
                    'response' => 'El contenido ya no existe'
                ];
            } else {
                $items = [
                    'result' => 'error',
                    'response' => 'Error al guardar el comentario'
                ];
            }

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return $items;
        }
    }

    public function actionEliminarComentario() {
        $request = \Yii::$app->request;
        $idComentario = $request->post('idComentario');
        $contenido = ContenidosComentarios::find('idComentario = :idComentario', [':idComentario' => $idComentario])->one();
        $idContenido = $contenido->idContenido;
        $contenido = ContenidosComentarios::deleteAll('idContenidoComentario = :idComentario', [':idComentario' => $idComentario]);

        $comentariosContenido = ContenidosComentarios::find()->with('objUsuarioPublicacionComentario', 'objDenuncioComentarioUsuario')->where(['idContenido' => $idContenido])->all();

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'result' => 'ok',
            'response' => $this->renderPartial('_listadoComentarios', ['comentariosContenido' => $comentariosContenido])
        ];
    }

    public function actionDenunciarComentario() {
        $request = \Yii::$app->request;

        $idComentario = $request->post('idComentario');

        $modelDenuncio = new DenunciosContenidosComentarios();
        $modelDenuncio->idContenidoComentario = $idComentario;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'result' => 'ok',
            'response' => $this->renderPartial('_modalDenuncioComentario', ['modelDenuncio' => $modelDenuncio])
        ];
    }

    public function actionGuardarDenuncioComentario() {
        $request = \Yii::$app->request;
        $render = $request->post('render', false);

        $modelDenuncio = new DenunciosContenidosComentarios();
        $modelDenuncio->load($request->post());
        $modelDenuncio->idUsuarioDenunciante = Yii::$app->user->identity->numeroDocumento;
        $modelDenuncio->fechaRegistro = Date("Y-m-d h:i:s");

        if ($modelDenuncio->save()) {

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            return [
                'result' => 'ok',
                'response' => ''
            ];
        } else {

            $contenido = ContenidosComentarios::find()->where(['idContenidoComentario' => $modelDenuncio->idContenidoComentario])->one();

            if (empty($contenido)) {
                $items = [
                    'result' => 'error',
                    'response' => 'El contenido ya no existe'
                ];
            } else {
                $items = [
                    'result' => 'error',
                    'response' => 'Error al guardar el denuncio'
                ];
            }

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return $items;
        }
    }

    public function actionDetalleContenido($idNoticia, $idLineaTiempo) {
        $linea = LineaTiempo::find()->where(['idLineaTiempo' => $idLineaTiempo])->one();
        $noticia = Contenido::findOne(['idContenido' => $idNoticia]);
        return $this->render('/sitio/_contenido', ['noticia' => $noticia, 'linea' => $linea]);
    }

    public function actionAgregarDestino() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'result' => 'ok',
            'response' => $this->renderAjax('_formDestinoContenido', ['objContenidoDestino' => new ContenidoDestino])
        ];
    }

    public function actionNoticias($lineaTiempo) {


        $linea = LineaTiempo::find()->where(['idLineaTiempo' => $lineaTiempo])->one();
//      $noticias = Contenido::traerTodasNoticiasCopservir($lineaTiempo);
//      return $this->render('/sitio/_lineaTiempo', [
//                'linea' => $linea,
//                'noticias' => $noticias
//                    ]);

         $dataProvider = new ActiveDataProvider([
            'query' => Contenido::traerTodasNoticiasCopservir($lineaTiempo),
            'pagination' => [
                'pageSize' => 2,
            ],
        ]);

        $this->view->title = 'Noticias';
        return $this->render('publicaciones', ['listDataProvider' => $dataProvider,]);
    }


    public function actionMisPublicaciones(){
         $dataProvider = new ActiveDataProvider([
            'query' => Contenido::traerMisPublicaciones(),
            'pagination' => [
                'pageSize' => 4,
            ],
        ]);

        $this->view->title = 'Mis Publicaciones';
        return $this->render('publicaciones', ['listDataProvider' => $dataProvider ]);
    }

    /**
     * buscardor de noticias
     * @param post-> busqueda  | lo que el usuario escribe en la barra de busqueda
     * @return mixed | redirige a la vista donde se hara la busuqeda pasando como parametros de la url:
     * busqueda = el patron de busqueda, a = año, m = mes, d = dia
     */
    public function actionBuscadorNoticias()
    {
      $busqueda = trim(Yii::$app->request->post('busqueda',''));

      $this->redirect(['busqueda','busqueda' => $busqueda, 'a' => '', 'm' => '', 'd' => '']);
    }

    /**
     * buscardor de noticias
     * @param busqueda = el patron de busqueda, a = año, m = mes, d = dia
     * @return mixed | retorna la vista con las noticias encontradas
     */
    public function actionBusqueda($busqueda, $a, $m, $d)
    {

        $flag = '';  // indica si la url lleva año, mes y dia
        $url = ['url'=>'','urlJson'=>'']; // arreglo con la url para generar la imagen en google charts y url para devolver el json de la misma
        $resultados= ''; // noticias encontradas
        $valorGrafica = ''; // valores que tomara la grafica (etiuetas y cantidad de veces que se encuentra una noticia)

        if ( empty($a)  and empty($m) and empty($d)   ) {

            //hacer busqueda del patron
            $resultados = Contenido::traerBusqueda($busqueda);
            // grafica resultado por años
            $valorGrafica = Contenido::datosGraficaAnio($busqueda);
            $url = $this->makeUrlChart($valorGrafica, false);
            $valorGrafica = Json::encode($valorGrafica);
            $flag = 'a';

        }

        if ( !empty($a)  and empty($m) and empty($d)   ) {

            // hacer la busqueda de ese patron en ese año
            $resultados = Contenido::traerBusquedaAnio($busqueda, $a);
            // grafica resultado por mes
            $valorGrafica = Contenido::datosGraficaMes($busqueda, $a);
            $url = $this->makeUrlChart($valorGrafica, true);
            $valorGrafica = Json::encode($valorGrafica);
            $flag = 'am';

        }

        if ( !empty($a)  and !empty($m) and empty($d)   ) {
          // hacer la busqueda de ese patron en ese año y mes
          $resultados = Contenido::traerBusquedaMes($busqueda, $a, $m);
          // grafica resultado por dias
          $valorGrafica = Contenido::datosGraficaDia($busqueda, $a, $m);
          $url = $this->makeUrlChart($valorGrafica, false);
          $valorGrafica = Json::encode($valorGrafica);
          $flag = 'amd';
        }

        if ( !empty($a)  and !empty($m) and !empty($d)) {
          // hacer la busqueda de ese patron en ese año, mes y dia
          $resultados = Contenido::traerBusquedaDia($busqueda, $a, $m, $d);
          // no hacer grafica
        }

        return $this->render('busqueda', ['resultados' => $resultados, 'url'=>$url, 'flag'=>$flag, 'valorGrafica'=>$valorGrafica, 'patron'=>$busqueda ]);
    }

    /**
    * funcion auxiliar para crear la url para generar la imagen y su json para mapearla
    * @param valorGrafica = valores que tomara la grafica, flag = bandera para poner el nombe de los meses
    * @return arreglo con las dos urls
    */
    public function makeUrlChart($valorGrafica, $flag)
    {
      /*
        > chof = - para mapear => json

        > cht = tipo de gafico

        > chs = tamaño del grafico

        > chxt = que solo se manejara el eje x

        > chm = forma que se le da al valor del dato

        > chd = serie de datos para el grafico

        > chds = limites minimos y maximos de cada serie

        > chxl = etiquetas
      */


      $url = 'https://chart.googleapis.com/chart?cht=s&amp;chs=908x70&amp;chxt=x&amp;chm=o,0aa699,0,0,20.0,0&amp;';
      $urlJson = '"https://chart.googleapis.com/chart?chof=json&cht=s&chs=908x70&chxt=x&chm=o,0aa699,0,0,20.0,0&';
      $chd = 'chd=t:';
      $chxl = 'chxl=0:||';

      // se pegan las posiciones de la grafica
      for ($i=0; $i <=count($valorGrafica) ; $i++) {
        $chd .= $i . ',';
      }
      // se separa la serie
      $chd = substr($chd, 0, -1);
      $chd .= '|';


      // se pegan las posiciones en y
      for ($i=0; $i <= count($valorGrafica) ; $i++) {
        $chd .= 20 . ',';
      }

      // se separa la serie
      $chd = substr($chd, 0, -1);
      $chd .= '|0,';

      // se pegan las cantidades de veces que se repite la noticia y sus etiquetas
      $maximo = array();

      foreach ($valorGrafica as $valor) {
         $chd .= $valor['cantidad'] . ',';
         if ($flag) {
            $chxl .= \Yii::$app->params['meses'][$valor['etiqueta']]. '|';
         }else{
            $chxl .= $valor['etiqueta'] . '|';
         }

         array_push($maximo, $valor['cantidad']);

      }
      if (!empty($valorGrafica)) {
        $maximo = max($maximo);
      }else{
        $maximo = 0;
      }


      $chd = substr($chd, 0, -1);

      // se defienen los limites
      $chds = 'chds=0,'.(count($valorGrafica)+1).',0,40,0,'.$maximo;

      // se crea toda la url
      $url .= $chd.'&amp;';
      $urlJson .= $chd.'&';
      $url .= $chxl.'&amp;';
      $urlJson .= $chxl.'&';
      $url .= $chds;
      $urlJson .= $chds;
      $urlJson .= '"';

      return ['url' => $url, 'urlJson'=> $urlJson ];
    }


    /**
    * accion donde el usuario envia una publicacion a un amigo
    * @param post = los usuarios que selecciono para enviar la publicación
    * @return 
    */
    public function actionEnviarAmigo()
    {
      $amigos =  Yii::$app->request->post();
      var_dump($amigos);
    }

}
