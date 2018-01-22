<?php

namespace app\modules\intranet\modules\servicop\modules\creditos\controllers;

use Yii;
//use vova07\imperavi\Widget;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\modules\intranet\models\LoginForm;
use app\modules\intranet\models\PersonaForm;
use app\models\Usuario; 
use app\modules\intranet\models\UsuarioIntranet;
use app\modules\intranet\models\ConexionesUsuarios;
use app\modules\intranet\models\RecuperacionClave;
use app\modules\intranet\models\FotoForm;
use app\modules\intranet\models\Contenido;
use yii\web\UploadedFile;
use app\modules\intranet\models\UsuarioWidgetInactivo;
use app\modules\intranet\models\MeGustaContenidos;
use app\modules\intranet\models\GrupoInteres;
use app\modules\intranet\models\Ciudad;
use yii\imagine\Image;
use yii\helpers\Json;
use yii\helpers\VarDumper;
use Imagine\Image\Box;
use Imagine\Image\Point;


class UsuarioController extends \yii\web\Controller {

    public function actionBuscarAjax($q = null, $id = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $response = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $usuarios = \app\modules\intranet\models\UsuarioIntranet::find()
                ->where(['like', 'numeroDocumento', $q])
                ->orWhere(['like', 'nombres', $q])
                ->orWhere(['like', 'primerApellido', $q])
                ->orWhere(['like', 'segundoApellido', $q])
                ->andWhere(['!=', 'numeroDocumento', Yii::$app->user->identity->numeroDocumento])
                ->limit(10)
                ->all();
            foreach ($usuarios as $key => $usuario) {
                $response = [];
                $response['results'][] = [
                    'id' => $usuario->numeroDocumento, 
                    'text' => $usuario->nombres . ' ' . $usuario->primerApellido . ' ' . $usuario->segundoApellido . ' - ' . $usuario->numeroDocumento
                ];
            }
        }
        elseif ($id > 0){
            $usuario = \app\modules\intranet\models\UsuarioIntranet::find()
                ->where(['numeroDocumento' => $id])
                ->one();
            $response['results'][] = [
                    'id' => $usuario->numeroDocumento, 
                    'text' => $usuario->nombres . ' ' . $usuario->primerApellido . ' ' . $usuario->segundoApellido . ' - ' . $usuario->numeroDocumento
            ];
        }
        // $jsonUsuarios = \yii\helpers\ArrayHelper::map($usuarios, 'numeroDocumento', 'nombres');
        return $response;
    }

}
