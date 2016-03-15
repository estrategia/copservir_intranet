<?php

namespace app\modules\intranet\controllers;

use Yii;
use yii\web\Controller;
use \app\modules\intranet\models\LineaTiempo;
use \app\modules\intranet\models\Contenido;
use \app\modules\intranet\models\MeGustaContenidos;
use \app\modules\intranet\models\ContenidosComentarios;
use \app\modules\intranet\models\DenunciosContenidos;

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

            $comentariosContenido = ContenidosComentarios::find()->with('objUsuarioPublicacionComentario')->where(['idContenido' => $idContenido])->all();

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

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            return [
                'result' => 'error',
                'response' => 'Error al guardar el denuncio'
            ];
        }
    }


    public function actionDetalleContenido($idNoticia, $idLineaTiempo)
    {
      $linea = LineaTiempo::find()->where(['idLineaTiempo' => $idLineaTiempo])->one();
      $noticia = Contenido::findOne(['idContenido' => $idNoticia]);
      return $this->render('/sitio/_contenido', ['noticia' => $noticia, 'linea' => $linea]);
    }

}
