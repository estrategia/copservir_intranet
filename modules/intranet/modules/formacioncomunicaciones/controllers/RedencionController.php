<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\controllers;

use app\modules\intranet\modules\formacioncomunicaciones\models\CategoriasPremios;
use app\modules\intranet\modules\formacioncomunicaciones\models\UsuariosPremios;
use app\modules\intranet\modules\formacioncomunicaciones\models\UsuariosPremiosSearch;

class RedencionController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $categorias = CategoriasPremios::find()->where(['estado' => CategoriasPremios::ESTADO_ACTIVO, 'idCategoriaPadre' => null]) ->orderBy(['orden' => SORT_ASC])->all();
        return $this->render('index', ['categorias' => $categorias]);
    }

    public function actionSubcategorias($idCategoria)
    {
        $categoria = CategoriasPremios::find()->where(['idCategoria' => $idCategoria])->one();
        return $this->render('subcategorias', ['categoria' => $categoria]);
    }

    public function actionPremiosCategoria($idCategoria)
    {
        $categoria = CategoriasPremios::find()->where(['idCategoria' => $idCategoria])->one();
        return $this->render('premios-categoria', ['categoria' => $categoria]);
    }

    public function actionMisRedenciones()
    {
        $searchModel = new UsuariosPremiosSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('mis-redenciones', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDetalle($id)
    {
        $model = UsuariosPremios::find()->where(['idUsuarioPremio' => $id])->one();

        return $this->render('detalle-redencion', [
            'model' => $model
        ]);
    }

    public function actionRenderModalTraza($idRedencion)
    {
        $redenciones = (new \yii\db\Query())
            ->select('traza.fechaRegistro, traza.estado, premio.nombrePremio')
            ->from('t_FORCO_UsuariosPremiosTrazabilidad as traza')
            ->join('JOIN', 'm_FORCO_Premio as premio', 'traza.idPremio = premio.idPremio')
            ->where(['idUsuarioPremio' => $idRedencion])
            // ->limit(10)
            ->all();
        // $redenciones = UsuariosPremios::find()->where(['idUsuarioPremio' => $idRedencion])->all();
        $response = [
            'result' => 'ok',
            'response' => $this->renderAjax('_modal-traza', ['redenciones' => $redenciones])
        ];
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $response;
    }

    public function actionHistorial()
    {
        $searchModel = new UsuariosPremiosSearch();
        $params = \Yii::$app->request->queryParams;
        $params['historial'] = true;
        $dataProvider = $searchModel->search($params);

        return $this->render('historial', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


}
