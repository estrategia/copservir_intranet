<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\base\DynamicModel;
use yii\helpers\VarDumper;
use app\modules\intranet\models\Area;
use app\modules\intranet\models\Ciudad;

class TestController extends Controller {
	
	public function actionTest(){
		$model = new Ciudad();
		
		VarDumper::dump($model, 10, true);
	}
	
	
	public function actionModel() {
		
		$model = new \yii\base\DynamicModel([
				'name', 'email', 'address'
		]);
		
		$model->addRule(['name','email'], 'required')
		->addRule(['email'], 'email')
		->addRule('address', 'string',['max'=>32]);
		
		//VarDumper::dump($model, 10, true);
		
		
		/*if($model->load(Yii::$app->request->post())){
			// do somenthing with model
			return $this->redirect(['view']);
		}*/
		
		//return $this->render('form', ['model'=>$model]);
	    
	    $model2 = new DynamicModel(['name', 'email']);
	    $model2->addRule(['name', 'email'], 'string', ['max' => 128])
	    	->addRule('email', 'email')
	    	->validate();
	    
	    	VarDumper::dump($model2, 10, true);
    
	}
}
