<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\controllers;

use app\modules\intranet\modules\formacioncomunicaciones\models\CategoriasPremios;

class RedencionController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $categorias = CategoriasPremios::find()->where(['estado' => CategoriasPremios::ESTADO_ACTIVO, 'idCategoriaPadre' => null]) ->orderBy(['orden' => SORT_ASC])->all();
        return $this->render('index', ['categorias' => $categorias]);
    }

    public function actionPremiosCategoria($idCategoria)
    {
      $categoria = CategoriasPremios::find()->where(['idCategoria' => $idCategoria])->one();
      return $this->render('premios-categoria', ['categoria' => $categoria]);
    }

}