<?php

namespace app\modules\trademarketing\controllers\rest;

use yii\rest\ActiveController;

class RestCategoriaController extends ActiveController
{
    public $modelClass = 'app\modules\trademarketing\models\Categoria';

    public function actions()
    {
        $actions = parent::actions();

        // disable the "delete" and "create" actions
        unset($actions['delete'], $actions['create'], $actions['update'], $actions['options'], $actions['view']);

        return $actions;
    }
}
