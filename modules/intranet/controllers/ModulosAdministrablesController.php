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
use app\modules\intranet\models\DataTableForm;
use yii\web\UploadedFile;

class ModulosAdministrablesController extends Controller {

    public $defaultAction = "admin";

    function actionAdmin() {
        $modelo = ModuloContenido::find();
        $searchModel = new ModuloContenido();

        if ($searchModel->load(Yii::$app->request->get())) {

            $modelo->andWhere("titulo like '%" . $searchModel->titulo . "%'");
            $modelo->andWhere("descripcion like '%" . $searchModel->descripcion . "%'");
            
            if (!empty($searchModel->tipo)) {
                $modelo->andWhere("tipo = '" . $searchModel->tipo . "'");
            }
        }else{
            $modelo->orderBy(['fechaRegistro' => SORT_DESC]);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $modelo,
        ]);
        return $this->render('admin', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel
        ]);
    }

    function actionVerContenido() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $this->renderPartial('visualizarContenidoModal', [
                    'contenido' => Yii::$app->request->post('contenido')
        ]);
    }

    function actionCrear() {
        $model = new ModuloContenido();

        $model->fechaRegistro = Date("Y-m-d H:i:s");
        $model->fechaActualizacion = Date("Y-m-d H:i:s");
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['actualizar', 'id' => $model->idModulo]);
        }

        return $this->render('crear', [
                    'model' => $model
        ]);
    }

    function actionActualizar($id = null) {

        if ($id != null) {
            $model = ModuloContenido::find()->where(['idModulo' => $id])->one();

            $model->fechaActualizacion = Date("Y-m-d H:i:s");
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['actualizar', 'id' => $model->idModulo]);
            }
            $params['vista'] = '_form';
            $params['opcion'] = 'editar';

            $params['model'] = $model;
            return $this->render('actualizar', [
                        'params' => $params,
            ]);
        }
    }

    function actionContenido($id = null) {

        if ($id != null) {
            $model = ModuloContenido::find()->where(['idModulo' => $id])->one();

            $modelExisten = ModuloContenido::find()->joinWith(['listGruposModulos'])
                    ->where("t_GruposModulos.idGruposModulos =:grupo");

            $params = [];
            if ($model->tipo == ModuloContenido::TIPO_HTML) {
                $params['vista'] = '_contenido';
                $params['opcion'] = 'contenido';
                
                if ($model->load(Yii::$app->request->post())) {
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', "HTML guardado con &eacute;xito");
                    } else {
                        Yii::$app->session->setFlash('error', "Error al guardar HTML." . \yii\helpers\Json::encode($model->getErrors()));
                    }
                }
            } else if ($model->tipo == ModuloContenido::TIPO_DATATABLE) {
                $params['opcion'] = 'contenido';
                $params['vista'] = '_dataTable';

                $modelForm = new DataTableForm;

                if ($modelForm->load(Yii::$app->request->post())) {
                    $archivo = UploadedFile::getInstance($modelForm, 'archivo');

                    if (!is_null($archivo)) {
                        $rutaDirectorio = Yii::$app->params['documentos']['rutaDataTables'];
                        $rutaDocumento = Yii::$app->user->identity->numeroDocumento . "_" . date('YmdHis') . '.' . $archivo->extension;
                        $archivo->saveAs($rutaDirectorio . $rutaDocumento);


                        $extension['xlsx'] = '\PHPExcel_Reader_Excel2007';
                        $extension['xls'] = '\PHPExcel_Reader_Excel5';
                        $objReader = new $extension[$archivo->extension];
                        $objPHPExcel = $objReader->load($rutaDirectorio . $rutaDocumento);

                        $nHojas = $objPHPExcel->getSheetCount();
                        $hojas = $objPHPExcel->getSheetNames();

                        $dataTableHTML = $this->renderPartial(
                                'datatable_read', [
                            'objPHPExcel' => $objPHPExcel,
                            'nHojas' => $nHojas,
                            'hojas' => $hojas,
                            'idModulo' => $model->idModulo
                        ]);
                        $model->contenido = $dataTableHTML;
                        if ($model->save()) {
                            Yii::$app->session->setFlash('success', "Tabla generada con &eacute;xito");
                        } else {
                            Yii::$app->session->setFlash('error', "Error al generar tabla");
                        }
                    }
                }

                $params['modelForm'] = $modelForm;
            } else if ($model->tipo == ModuloContenido::TIPO_GROUP_MODULES) {
                $params['searchModelAgregar'] = new ModuloContenido();

                $modelExisten->orderBy('t_GruposModulos.orden ASC')
                        ->addParams([':grupo' => $id]);

                $params['dataProviderAgregados'] = new ActiveDataProvider([
                    'query' => $modelExisten,
                ]);

                $modelNoExisten = ModuloContenido::find()->where('tipo <> ' . ModuloContenido::TIPO_GROUP_MODULES);

                if ($params['searchModelAgregar']->load(Yii::$app->request->get())) {

                    $modelNoExisten->andWhere("titulo like '%" . $params['searchModelAgregar']->titulo . "%'");
                    $modelNoExisten->andWhere("descripcion like '%" . $params['searchModelAgregar']->descripcion . "%'");

                    if (!empty($params['searchModelAgregar']->tipo)) {
                        $modelNoExisten->andWhere("tipo = '" . $params['searchModelAgregar']->tipo . "'");
                    }
                }
                $params['dataProviderNoAgregados'] = new ActiveDataProvider([
                    'query' => $modelNoExisten,
                ]);

                $params['vista'] = '_gruposModulos';
                $params['opcion'] = 'contenido';
            }



            $params['model'] = $model;
            return $this->render('actualizar', [
                        'params' => $params,
            ]);
        }
    }

    function actionEliminar($id = null) {

        if ($id != null) {

            if (ModuloContenido::deleteAll(['idModulo' => $id])) {
                return $this->redirect(['admin']);
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
        } else {
            return [
                'result' => 'error',
            ];
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
