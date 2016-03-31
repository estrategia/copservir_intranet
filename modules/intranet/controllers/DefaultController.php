<?php

namespace app\modules\intranet\controllers;

use yii\web\Controller;
use yii\web\Session;
use app\modules\intranet\models\EventosCalendario;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        echo \Yii::$app->params['grupo']['*'];
        //return $this->render('index');
    }
    
    public function actionSession()
    {
        //var_dump(\Yii::$app->user->identity);
        //return $this->render('index');
        
        //$session = new Session;
        //$session->open();
        $session = \Yii::$app->session;
        
        //$value1 = $session['name1'];  // get session variable 'name1'
        //$value2 = $session['name2'];  // get session variable 'name2'
        //foreach ($session as $name => $value) // traverse all session variables
        var_dump($session['prueba']); 
    }
    
    public function actionEventos(){
        //$models = EventosCalendario::consultarEventos();
        $inicio = '2016-03-01';
        $fin = '2016-03-31';
        
        
        $listEventos = EventosCalendario::consultarEventos($inicio, $fin, true);
        
        \yii\helpers\VarDumper::dump($listEventos, 5, true);
    }
}
