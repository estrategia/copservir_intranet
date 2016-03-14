<?php

namespace app\modules\intranet\controllers;

use yii\web\Controller;
use \app\modules\intranet\models\LineaTiempo;
use \app\modules\intranet\models\Contenido;

class ContenidoController extends Controller {

    public function actionPublicar() {
        $request = \Yii::$app->request;
        $render = $request->post('render', false);

        if ($render) {
            $idLinea = $request->post('linea');
            $objLineaTiempo = LineaTiempo::findOne($idLinea);
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'result' => 'ok',
                'response' => $this->render('formContenido', ['objLineaTiempo' => $objLineaTiempo, 'objContenido' => new Contenido])
            ];
        } else {
            
        }
    }

}
