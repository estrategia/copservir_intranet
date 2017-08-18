<?php

namespace app\modules\intranet\controllers;
use Yii;
use yii\base\Controller;
use yii\httpclient\Client;
use yii\data\ArrayDataProvider;


class PqrsController extends Controller
{
	
	public function actionConsultarCasosExterno(){
		
		$cedula = Yii::$app->user->identity->numeroDocumento;
		$url = Yii::$app->params['webServices']['pqrs'] . 'pqrsexterno/sweb/consultar-casos?cedula=38602460';
		$url = str_replace(' ', '%20', $url);
		$client = new Client();
		$response = $client->createRequest()
		->setMethod('get')
		->setUrl($url)
		->setData([''])
		->setOptions([
				'timeout' => 30, // set timeout to 5 seconds for the case server is not responding
		])
		->send();
	//	print_r($response->content);exit();
	//	\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$datos = json_decode( preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $response->content), true );
		
		$provider = new ArrayDataProvider([
				'allModels' => $datos,
				'pagination' => [
						'pageSize' => 10,
				],
		]);
		return $this->render('listadoPQRS', [
				'dataProvider' => $provider
		]);
		
	}
	
	public function actionConsultarCasosInterno(){
		
		$cedula = Yii::$app->user->identity->numeroDocumento;
		$url = Yii::$app->params['webServices']['pqrs'] . 'pqrsinterno/sweb/consultar-casos?cedula=38602460';
		$url = str_replace(' ', '%20', $url);
		$client = new Client();
		$response = $client->createRequest()
		->setMethod('get')
		->setUrl($url)
		->setData([''])
		->setOptions([
				'timeout' => 30, // set timeout to 5 seconds for the case server is not responding
		])
		->send();
		//	print_r($response->content);exit();
		//	\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$datos = json_decode( preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $response->content), true );
		
		$provider = new ArrayDataProvider([
				'allModels' => $datos,
				'pagination' => [
						'pageSize' => 10,
				],
		]);
		return $this->render('listadoPQRS', [
				'dataProvider' => $provider
		]);
		
	}
	
}












