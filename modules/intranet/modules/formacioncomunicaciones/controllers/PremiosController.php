<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\controllers;

use Yii;
use app\modules\intranet\modules\formacioncomunicaciones\models\CategoriasPremios;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\intranet\modules\formacioncomunicaciones\models\PremioSearch;
use app\modules\intranet\modules\formacioncomunicaciones\models\Premio;
use yii\data\ActiveDataProvider;
use app\modules\intranet\modules\formacioncomunicaciones\models\PuntosTotales;
use app\modules\intranet\modules\formacioncomunicaciones\models\UsuariosPremios;
use app\modules\intranet\modules\formacioncomunicaciones\models\UsuariosPremiosTrazabilidad;

/**
 * CategoriasPremiosController implements the CRUD actions for CategoriasPremios model.
 */
class PremiosController extends Controller
{
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
				'verbs' => [
						'class' => VerbFilter::className(),
						'actions' => [
								'delete' => ['POST'],
						],
				],
		];
	}

	/**
	 * Lists all CategoriasPremios models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new PremioSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		return $this->render('index', [
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays a single CategoriasPremios model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDetalle($id)
	{
		return $this->render('detalle', [
				'model' => $this->findModel($id),
		]);
	}

	/**
	 * Creates a new CategoriasPremios model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCrear()
	{
		$model = new Premio();

		if ($model->load(Yii::$app->request->post())) {
			$model->guardarImagen('');
			$model->fechaCreacion = \Date("Y-m-d h:i:s");
			if ($model->save()) {
				return $this->redirect(['detalle', 'id' => $model->idPremio]);
			} else {
				return $this->render('crear', [
						'model' => $model,
				]);
			}
		} else {
			return $this->render('crear', [
					'model' => $model,
			]);
		}
	}

	/**
	 * Updates an existing CategoriasPremios model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionActualizar($id)
	{
		$model = $this->findModel($id);
		$atributoIcono = $model->rutaImagen;
		if ($model->load(Yii::$app->request->post())) {
			$model->guardarImagen($atributoIcono);
			if ($model->save()) {
				return $this->redirect(['detalle', 'id' => $model->idPremio]);
			}
		} else {
			return $this->render('actualizar', [
					'model' => $model,
			]);
		}
	}

	public function actionRenderModalAsignarPadre()
	{
		if (Yii::$app->request->isAjax) {
			$categorias = CategoriasPremios::find()->where(['estado' => CategoriasPremios::ESTADO_ACTIVO, 'idCategoriaPadre' => null])->all();
			$respond = [
					'result' => 'ok',
					'response' => $this->renderAjax('_modalCategoriaPadre', [
							'categorias' => $categorias,
					])];
			Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return $respond;
		}
	}

	/**
	 * Finds the CategoriasPremios model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return CategoriasPremios the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Premio::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
	
	
	public function actionVerPremios($idCategoria){
		$dataProvider = new ActiveDataProvider([
				'query' => Premio::traerPremiosCategoria($idCategoria),
				'pagination' => [
						'pageSize' => 4,
				],
		]);
		
		return $this->render('listaPremios', ['listDataProvider' => $dataProvider]);
	}
	
	
	public function actionVerificarRedimir(){
		$idPremio = Yii::$app->request->post('idPremio');
		$cantidad = Yii::$app->request->post('cantidad');
		$numeroDocumento = Yii::$app->user->identity->numeroDocumento;
		
		$puntosUsuario = PuntosTotales::findOne(['numeroDocumento' => $numeroDocumento]);
		$premio = Premio::findOne(['idPremio' => $idPremio]);
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		
		if(empty($premio)){
			return  ['result' => 'error', 'response' => 'Premio no existe'];
		}
		
		if(empty($puntosUsuario)){
			return  ['result' => 'error', 'response' => 'No tienes puntos'];
		}
		
		if($cantidad > $premio->cantidad){
			return  ['result' => 'error', 'response' => 'Cantidad no disponible. Disponibles: '.$premio->cantidad." unidades"];
		}
		
		if($cantidad > $premio->cantidad){
			return  ['result' => 'error', 'response' => 'Cantidad no disponible. Disponibles: '.$premio->cantidad." unidades"];
		}
		
		if($puntosUsuario->puntos < $cantidad*$premio->puntosRedimir){
			return  ['result' => 'error', 'response' => 'No tienes puntos suficientes para redimir'];
		}
		
		// Se puede redimir el articulo por tanto se le crea el registro de redimir
		
		$premioUsuario = new UsuariosPremios();
		$premioUsuario->idPremio = $idPremio;
		$premioUsuario->numeroDocumento = $numeroDocumento;
		$premioUsuario->cantidad= $cantidad;
		$premioUsuario->estado = UsuariosPremios::ESTADO_PENDIENTE;
		$premioUsuario->puntosRedimir = $cantidad*$premio->puntosRedimir;
		$premioUsuario->fechaCreacion = \Date("Y-m-d h:i:s");
		
		if(!$premioUsuario->save()){
			return  ['result' => 'error', 'response' => 'No tienes puntos suficientes para redimir'];
		}
		
		// Guardar la traza
		
		$premioUsuarioTraza = new UsuariosPremiosTrazabilidad();
		$premioUsuarioTraza->idUsuarioPremio = $premioUsuario->idUsuarioPremio;
		$premioUsuarioTraza->idPremio = $idPremio;
		$premioUsuarioTraza->numeroDocumento = $numeroDocumento;
		$premioUsuarioTraza->numeroDocumentoTraza = $numeroDocumento;
		$premioUsuarioTraza->estado = UsuariosPremios::ESTADO_PENDIENTE;
		$premioUsuarioTraza->fechaRegistro = \Date("Y-m-d h:i:s");
		
		if(!$premioUsuarioTraza->save()){
			return  ['result' => 'error', 'response' => 'No tienes puntos suficientes para redimir'];
		}
		
		$puntosUsuario->puntos -= $premioUsuario->puntosRedimir;
		
		if(!$puntosUsuario->save()){
			return  ['result' => 'error', 'response' => 'Error al actualizar los puntos'];
		}
		
	}
}
