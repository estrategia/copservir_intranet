<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\intranet\controllers;

use Yii;
use yii\web\Controller;
use \app\modules\intranet\models\ModuloContenido;
use \yii\data\ActiveDataProvider;
use app\modules\intranet\models\GruposModulos;

class ModulosAdministrablesController extends Controller {

    function actionIndex() {
        $modelo = ModuloContenido::find();
        $searchModel = new ModuloContenido();

//
//        if ($searchModel->load(\Yii::$app->request->get())) {
//            $modelo->andWhere("DescripcionPQRS like '%$searchModel->DescripcionPQRS%'");
//            
//            if(!empty($searchModel->IdOrigenCaso)){
//                $modelo->andWhere("IdOrigenCaso = '$searchModel->IdOrigenCaso'");
//            }
//        }
        $dataProvider = new ActiveDataProvider([
            'query' => $modelo,
        ]);
        return $this->render('index', [
                    'dataProvider' => $dataProvider
        ]);
    }

    function actionVerContenido() {
       \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $this->renderPartial('visualizarContenidoModal', [
                    'contenido' => Yii::$app->request->post('contenido')
        ]);
    }
    
    function actionCreate() {
        $model = new ModuloContenido();

        $model->fechaRegistro = Date("Y-m-d H:i:s");
        $model->fechaActualizacion = Date("Y-m-d H:i:s");
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update' ,'id' => $model->idModulo]);
        }

        return $this->render('create', [
                    'model' => $model
        ]);
    }

    function actionUpdate($id = null) {

        if ($id != null) {
            $model = ModuloContenido::find()->where(['idModulo' => $id])->one();

            $model->fechaActualizacion = Date("Y-m-d H:i:s");
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['update', 'id' => $model->idModulo]);
            }
            $params['vista'] = '_form';
            $params['opcion'] = 'editar';

            $params['model'] = $model;
            return $this->render('update', [
                        'params' => $params,
            ]);
        }
    }
    
    function actionContenido($id = null) {

        if ($id != null) {
            $model = ModuloContenido::find()->where(['idModulo' => $id])->one();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['index']);
            }
            
            $modelExisten = ModuloContenido::find()->joinWith(['listGruposModulos'])
                    ->where("t_GruposModulos.idGruposModulos =:grupo")
                    ->orderBy('t_GruposModulos.orden ASC')
                    ->addParams([':grupo' => $id]);

            $params = [];
            $params['dataProviderAgregados'] = new ActiveDataProvider([
                'query' => $modelExisten,
            ]);

            $modelNoExisten = ModuloContenido::find()->where('tipo <> ' . ModuloContenido::TIPO_GROUP_MODULES);
            $params['dataProviderNoAgregados'] = new ActiveDataProvider([
                'query' => $modelNoExisten,
            ]);

            $params['vista'] = '_contenido';
            $params['opcion'] = 'contenido';

            $params['model'] = $model;
            return $this->render('update', [
                        'params' => $params,
            ]);
        }
    }    

    function actionDelete($id = null) {

        if ($id != null) {

            if (ModuloContenido::deleteAll(['idModulo' => $id])) {
                return $this->redirect(['index']);
            }
        }
    }

    function actionAgregarModulo() {
        $post = Yii::$app->request->post();
        $model = GruposModulos::find()->where(['and', ['idGruposModulos' => $post['idGrupo']], ['idModulo' => $post['idModulo']]])->one();

        if ($model == null) {

            $model = new GruposModulos();
            $model->idGruposModulos = $post['idGrupo'];
            $model->idModulo = $post['idModulo'];
            $model->orden = 0;
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if ($model->save()) {
                return [
                    'result' => 'ok',
                ];
            } else {
                return [
                    'result' => 'error',
                ];
            }
        }
    }

    function actionEliminarModulo() {
        $post = Yii::$app->request->post();
        $model = GruposModulos::deleteAll('idGruposModulos = ' . $post['idGrupo'] . ' AND idModulo = ' . $post['idModulo']);
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'result' => 'ok',
        ];
    }

    function actionEditarModulo() {
        $post = Yii::$app->request->post();
        $model = GruposModulos::find()->where('idGruposModulos = ' . $post['idGrupo'] . ' AND idModulo = ' . $post['idModulo'])->one();

        $model->orden = $post['orden'];

        if ($model->save()) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'result' => 'ok',
            ];
        } else {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'result' => 'error',
            ];
        }
    }

}
