<?php

namespace app\modules\intranet\modules\sascop\controllers;

use yii\web\Controller;

/**
 * Default controller for the `sascop` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
