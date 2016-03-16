<?php

namespace app\modules\intranet\controllers;

use Yii;
use yii\web\Controller;
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
            'response' => $this->renderPartial('_formDestinoContenido',['objContenidoDestino' => new ContenidoDestino])
        ];
    }

}
