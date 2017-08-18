<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use app\modules\intranet\modules\formacioncomunicaciones\models\CategoriasPremios;
use app\modules\intranet\modules\formacioncomunicaciones\models\PremioSearch;
use app\modules\intranet\modules\formacioncomunicaciones\models\Premio;
use app\modules\intranet\modules\formacioncomunicaciones\models\PuntosTotales;
use app\modules\intranet\modules\formacioncomunicaciones\models\UsuariosPremios;
use app\modules\intranet\modules\formacioncomunicaciones\models\UsuariosPremiosTrazabilidad;
use app\modules\intranet\modules\formacioncomunicaciones\models\RestriccionesRedencion;
use app\modules\intranet\models\PublicacionesCampanas;

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
            [
                'class' => \app\components\AccessFilter::className(),
                'redirectUri' => ['/intranet/usuario/autenticar']
            ],

            [
                'class' => \app\components\AuthItemFilter::className(),
                'only' => [
                    'index', 'crear', 'actualizar', 'detalle', 'cambiar-estado-redencion'
                ],
                'authsActions' => [
                    'index' => 'formacionComunicaciones_premios_admin',
                    'detalle' => 'formacionComunicaciones_premios_admin',
                    'crear' => 'formacionComunicaciones_premios_admin',
                    'actualizar' => 'formacionComunicaciones_premios_admin',
                    'detalle' => 'formacionComunicaciones_premios_admin',
                    'cambiar-estado-redencion' => 'formacionComunicaciones_premios_admin'
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
		$numeroDocumento = Yii::$app->user->identity->numeroDocumento;
        $userCiudad = Yii::$app->user->identity->getCiudadCodigo();
        $userGrupos = (array) Yii::$app->user->identity->getGruposCodigos();
        $banner = PublicacionesCampanas::getCampana($userCiudad, $userGrupos, PublicacionesCampanas::POSICION_TIENDA_FORCO);
		$dataProvider = new ActiveDataProvider([
				'query' => Premio::traerPremiosCategoria($idCategoria),
				'pagination' => [
						'pageSize' => 4,
				],
		]);
		$puntosUsuario = PuntosTotales::findOne(['numeroDocumento' => Yii::$app->user->identity->numeroDocumento]);
		$puntos = 0;
		if($puntosUsuario){
			$puntos = $puntosUsuario->puntos;
		}
		
		$restricciones = RestriccionesRedencion::findOne(['numeroDocumento' =>  Yii::$app->user->identity->numeroDocumento]);
		
		$restriccion = false;
		if($restricciones){
			$restriccion = true;
		}
		return $this->render('listaPremios', ['listDataProvider' => $dataProvider, 'puntos' => $puntos, 'restriccion' => $restriccion, 'banner' => $banner]);
	}
	
	
	public function actionVerificarRedimir(){
		$idPremio = Yii::$app->request->post('idPremio');
		$cantidad = Yii::$app->request->post('cantidad');
		$numeroDocumento = Yii::$app->user->identity->numeroDocumento;
		$transaction = UsuariosPremios::getDb()->beginTransaction();
		
		$puntosUsuario = PuntosTotales::findOne(['numeroDocumento' => $numeroDocumento]);
		
		$premio = Premio::findOne(['idPremio' => $idPremio]);
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		
		if(empty($premio)){
			return  ['result' => 'error', 'response' => 'Premio no existe'];
		}
		
		if($premio->tipoRedimir == Premio::TIPO_TIENDA){
			if(empty($puntosUsuario)){
				return  ['result' => 'error', 'response' => 'No tienes puntos'];
			}
			
			if($premio->cantidad < 1){
				return  ['result' => 'error', 'response' => 'Cantidad no disponible. Disponibles: '.$premio->cantidad." unidades"];
			}
			
			if($cantidad > $premio->cantidad){
				return  ['result' => 'error', 'response' => 'Cantidad no disponible. Disponibles: '.$premio->cantidad." unidades"];
			}
			
			if($puntosUsuario->puntos < $cantidad*$premio->puntosRedimir){
				return  ['result' => 'error', 'response' => 'No tienes puntos suficientes para redimir'];
			}
		}else{
			
			if($premio->cantidad < 1){
				return  ['result' => 'error', 'response' => 'Premio ya no está disponible'];
			}
			
			if($cantidad > 1){
				return  ['result' => 'error', 'response' => 'Solo se puede redimir un solo premio'];
			}
			
			// Validar si el premio ya lo ha redimido
			
			$premioRedimido = UsuariosPremios::findOne(['idPremio' => $idPremio, 'numeroDocumento' => $numeroDocumento]);
			
			if($premioRedimido){
				return  ['result' => 'error', 'response' => 'Ya redimiste este premio, solo se puede hacer una vez'];
			}
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
			$transaction->rollBack();
			return  ['result' => 'error', 'response' => 'No tienes puntos suficientes para redimir'];
		}
		
		$premio->cantidad -=  $cantidad;
		
		if(!$premio->save()){
			$transaction->rollBack();
			return  ['result' => 'error', 'response' => 'No se pueden actualizar las cantidades disponibles'];
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
			$transaction->rollBack();
			return  ['result' => 'error', 'response' => 'Error al actualizar los puntos'];
		}
		
		$transaction->commit();
		return  ['result' => 'ok', 'response' => 'Se ha redimido el premio con &eacute;xito'];
		
	}
	
	
	public function actionRedenciones($estado = UsuariosPremios::ESTADO_PENDIENTE){
		
		$numeroDocumento = Yii::$app->user->identity->numeroDocumento;
		$searchModel = new UsuariosPremios();
		$searchModel->estado = $estado;
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$params = Yii::$app->request->queryParams;
		
		$filtrosUsuario = \Yii::$app->session->set(\Yii::$app->params['formacioncomunicaciones']['session']['filtrosPremios'], $params);
		
		return $this->render('redenciones', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel, 'estado' => $estado]);
	}
	
	public function actionCambiarEstadoRedencion(){
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		
		$premios = Yii::$app->request->post('premios');
		$estado = Yii::$app->request->post('estado');
		$observacion = "";
		$fechaEntrega = null;
		if($estado ==  UsuariosPremios::ESTADO_TRAMITADO){
			$observacion = Yii::$app->request->post('observaciones');
			$fechaEntrega =  Yii::$app->request->post('fechaEntrega');
		}
		
		
		$transaction = UsuariosPremios::getDb()->beginTransaction();
		
		foreach($premios as $premio){
			$premioUsuario = UsuariosPremios::findOne(['idUsuarioPremio' => $premio]);
			$premioUsuario->estado = $estado;
			
			if($estado == UsuariosPremios::ESTADO_CANCELADO){
				// Devolverle los puntos al usuario
				$puntosUsuario = PuntosTotales::findOne(['numeroDocumento' => $premioUsuario->numeroDocumento]);
				
				if($puntosUsuario){
					$puntosUsuario->puntos += $premioUsuario->puntosRedimir;
					if(!$puntosUsuario->save()){
						$transaction->rollBack();
						return  ['result' => 'error', 'response' => 'Error al cambiar de estado en el premio '.$premio];
					}
				}
			}else{
				$premioUsuario->fechaEntrega = $fechaEntrega;
			}
		
			if(!$premioUsuario->save()){
				$transaction->rollBack();
				return  ['result' => 'error', 'response' => 'Error al actualizar el estado '.$premio];
			}
			
			$premioUsuarioTraza = new UsuariosPremiosTrazabilidad();
			$premioUsuarioTraza->idUsuarioPremio = $premioUsuario->idUsuarioPremio;
			$premioUsuarioTraza->idPremio = $premioUsuario->idPremio;
			$premioUsuarioTraza->numeroDocumento = $premioUsuario->numeroDocumento;
			$premioUsuarioTraza->numeroDocumentoTraza = Yii::$app->user->identity->numeroDocumento;
			$premioUsuarioTraza->estado = $estado;
			$premioUsuarioTraza->fechaRegistro = \Date("Y-m-d h:i:s");
			$premioUsuarioTraza->observacion = $observacion;
			
			if(!$premioUsuarioTraza->save()){
				$transaction->rollBack();
				return  ['result' => 'error', 'response' => 'Error al cambiar de estado'.$premio];
			}
		}
		
		$transaction->commit();
		return  ['result' => 'ok', 'response' => 'Estados Actualizados'];
	}
	
	public function actionExportarRedenciones(){
		$searchModel = new UsuariosPremios();
		$objPHPExcel = new \PHPExcel();
		$objPHPExcel->getProperties()->setTitle("Premios Redimidos");
	
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getSheet(0)->setTitle('Premios');
	
		$objWorksheet = $objPHPExcel->getSheet(0);
		$objWorksheet->setTitle('Premios');
	
		$col = 0;
		$objWorksheet->setCellValueByColumnAndRow($col++, 1, '#');
		$objWorksheet->setCellValueByColumnAndRow($col++, 1, '# Documento');
		$objWorksheet->setCellValueByColumnAndRow($col++, 1, 'Nombre Completo');
		$objWorksheet->setCellValueByColumnAndRow($col++, 1, 'Cargo');
		$objWorksheet->setCellValueByColumnAndRow($col++, 1, 'Cantidad');
		$objWorksheet->setCellValueByColumnAndRow($col++, 1, 'Estado');
		$objWorksheet->setCellValueByColumnAndRow($col++, 1, 'Premio');
		$objWorksheet->setCellValueByColumnAndRow($col++, 1, 'Fecha Creacion');
	
		$params = \Yii::$app->session->get(\Yii::$app->params['formacioncomunicaciones']['session']['filtrosPremios']);
		$searchModel->estado = $params['estado'];
		$dataProvider = $searchModel->search($params);
	
		// var_dump($dataProvider);
		
		foreach ($dataProvider->getModels() as $indice => $premio ) {
			$col = 0;
			$fila = $indice + 2;
				
			$objWorksheet->setCellValueByColumnAndRow($col++, $fila, $premio->idUsuarioPremio );
			$objWorksheet->setCellValueByColumnAndRow($col++, $fila, $premio->numeroDocumento );
			$objWorksheet->setCellValueByColumnAndRow($col++, $fila, $premio->objUsuario->objUsuarioIntranet->nombres." ".
					$premio->objUsuario->objUsuarioIntranet->primerApellido." ".
					$premio->objUsuario->objUsuarioIntranet->segundoApellido );
				
			$objWorksheet->setCellValueByColumnAndRow($col++, $fila, $premio->objUsuario->objUsuarioIntranet->nombreCargo);
			$objWorksheet->setCellValueByColumnAndRow($col++, $fila, $premio->cantidad );
			$objWorksheet->setCellValueByColumnAndRow($col++, $fila, \yii::$app->params['formacioncomunicaciones']['estadosPremios'][$premio->estado]);
			$objWorksheet->setCellValueByColumnAndRow($col++, $fila, $premio->objPremio->nombrePremio);
			$objWorksheet->setCellValueByColumnAndRow($col++, $fila, $premio->fechaCreacion);
		}
	
		$objPHPExcel->setActiveSheetIndex(0);
	
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="redenciones_' . date('YmdHis') . '.xls"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');
		// If you're serving to IE over SSL, then the following may be needed
		//header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
		header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header('Pragma: public'); // HTTP/1.0
	
		$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
	}
	
}
