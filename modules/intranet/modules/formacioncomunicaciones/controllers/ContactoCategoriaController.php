<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\controllers;

use \yii\helpers\ArrayHelper;

use \app\modules\intranet\modules\formacioncomunicaciones\models\CategoriasPremios;
use \app\modules\intranet\modules\formacioncomunicaciones\models\ContactoCategoria;

class ContactoCategoriaController extends \yii\web\Controller
{
    public function actionCrear()
    {
      $response = [];
      if (\Yii::$app->request->isPost) {
        $idCategoria = \Yii::$app->request->post()['idCategoria'];
        $numeroDocumento = \Yii::$app->request->post()['numeroDocumento'];
        if (!is_null($idCategoria) && !is_null($numeroDocumento)) {
          $modelCategoria = CategoriasPremios::find()->where(['idCategoria' => $idCategoria])->one();
          $model = new ContactoCategoria();
          $model->idCategoriaPremio = $idCategoria;
          $model->numeroDocumento = $numeroDocumento;
          if ($model->save()) {
            $response = [
              'result' => 'ok', 
              'response' => $this->renderAjax('_lista-contactos-categoria', ['model'=> $modelCategoria])
            ];
          }
        }
      }
      \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;  
      return $response;
    }

    public function actionRenderModalAgregarContacto()
    {
      $usuarios = ArrayHelper::map(\app\modules\intranet\models\UsuarioIntranet::find()->all(), 'numeroDocumento', 'nombres');
      $response = ['result' => 'ok', 'response' => $this->renderAjax('_modalCrearContacto', ['usuarios' => $usuarios])];
      \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;  
      return $response;
    }

    public function actionEliminar()
    {
      $response = [];
      if (\Yii::$app->request->isPost) {
        $idCategoria = \Yii::$app->request->post()['idCategoria'];
        $numeroDocumento = \Yii::$app->request->post()['numeroDocumento'];
        $contacto = ContactoCategoria::find()->where(['idCategoriaPremio' => $idCategoria, 'numeroDocumento' => $numeroDocumento])->one();
        $modelCategoria = CategoriasPremios::find()->where(['idCategoria' => $idCategoria])->one();
        if (is_null($contacto)) {
          $response = ['result' => 'error', 'response' => 'No se encuentra el contacto'];
        } elseif ($contacto->delete()) {
          $response = [
            'result' => 'ok', 
            'response' => $this->renderAjax('_lista-contactos-categoria', ['model'=> $modelCategoria])
          ];
        }
      }
      \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;  
      return $response;
    }

}
