<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\controllers;

use Yii;
use yii\web\Controller;
use app\modules\intranet\modules\formacioncomunicaciones\models\Cuestionario;
use app\modules\intranet\modules\formacioncomunicaciones\models\Pregunta;
use app\modules\intranet\modules\formacioncomunicaciones\models\TipoPregunta;
use app\modules\intranet\modules\formacioncomunicaciones\models\OpcionRespuesta;
use app\modules\intranet\models\OpcionesUsuario;
use app\modules\intranet\modules\formacioncomunicaciones\models\Respuestas;
use app\modules\intranet\modules\formacioncomunicaciones\models\CuestionarioUsuario;
use yii\base\Model;
use yii\db\Expression;
use app\models\Usuario;
use app\modules\intranet\models\CuestionarioUsuarioForm;
use yii\helpers\ArrayHelper;

class CuestionarioController extends Controller{ 

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
								'index', 'crear', 'actualizar', 'crear-modulo', 'detalle','actualizar-modulo', 'crear-capitulo', 'actualizar-capitulo', 'crear-contenido', 'visualizar-contenido', 'mis-contenidos', 'buscador'
						],
						'authsActions' => [
								'index' => 'formacionComunicaciones_cuestionario_admin',
								'detalle' => 'formacionComunicaciones_cuestionario_admin',
								'crear' => 'formacionComunicaciones_cuestionario_admin',
								'actualizar' => 'formacionComunicaciones_cuestionario_admin',
								'crear-modulo' => 'formacionComunicaciones_modulo_admin',
								
								'visualizar-cuestionario' => 'intranet_usuario',
								
						],
				],
	
		];
	}
	
	public function actionIndex(){
		$searchModel = new Cuestionario();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
	}

	public function actionCrear(){
		$model = new Cuestionario();
		$model->fechaCreacion = \Date("Y-m-d h:i:s");
		$model->fechaActualizacion = \Date("Y-m-d h:i:s");
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        	
            return $this->redirect(['detalle', 'id' => $model->idCuestionario]);
        } else {
            return $this->render('crear', [
                        'model' => $model,
            ]);
        }
	}
	
	public function actionActualizar($id){
		$model = $this->findModel($id);
		
		if ($model->load(Yii::$app->request->post()) ) {
			$model->fechaActualizacion = \Date("Y-m-d h:i:s");
			
			if($model->save()){
				return $this->redirect(['detalle', 'id' => $model->idCuestionario]);
			}
		}
		
		$params= [  'model' => $model,
				'view' => 'crear'
		];
			return $this->render('detalle',['params' => $params]);
		
	}


	public function actionDetalle($id){
		 $params= [  'model' => $this->findModel($id),
		 			'view' => 'detallePregunta'
		 ];
		 
		  return $this->render('detalle',['params' => $params]);
	}

	public function actionPreguntas($id){
		$modelCuestionario =  $this->findModel($id);

		$searchModel = new Pregunta();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$id,true);
        $tipoPreguntas = TipoPregunta::find()->where('estado = 1')->all();
        
        $params= [
        			'model' => $this->findModel($id),
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'modelCuestionario' => $modelCuestionario,
                    'tipoPreguntas' => $tipoPreguntas,
        			'view' => 'resumenPreguntas'
        ];
        
        return $this->render('detalle', ['params' => $params]);
	}


	public function actionCrearPregunta($idCuestionario = null){
		$model = new Pregunta();
		$modelCuestionario = $this->findModel($idCuestionario);
		$tipoPreguntas = TipoPregunta::find()->where('estado = 1')->all();
		$model->fechaCreacion = \Date("Y-m-d h:i:s");
		$model->fechaActualizacion = \Date("Y-m-d h:i:s");
		$params = [ 'model' => $model,
                    'modelCuestionario' => $modelCuestionario,
                    'tipoPreguntas' => $tipoPreguntas,
            		'view' => '_formPregunta'];
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
		    return $this->redirect(['contenido-pregunta', 'idPregunta' => $model->idPregunta, 'opcion' => 'enunciado']);
        } else {
        	return $this->render('_crearPregunta', ['params' => $params]);
        }
	}
	
	public function actionActualizarPregunta($id = null){
		$model = Pregunta::findOne(['idPregunta' => $id]);
		$modelCuestionario = $this->findModel($model->idCuestionario);
		$tipoPreguntas = TipoPregunta::find()->where('estado = 1')->all();
		
		$model->fechaCreacion = \Date("Y-m-d h:i:s");
		$model->fechaActualizacion = \Date("Y-m-d h:i:s");
		
		$params = [ 'model' => $model,
				'modelCuestionario' => $modelCuestionario,
				'tipoPreguntas' => $tipoPreguntas,
				'view' => '_formPregunta'];
		
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['contenido-pregunta', 'idPregunta' => $model->idPregunta, ]);
		} else {
			return $this->render('_crearPregunta', ['params' => $params]);
		}
	}
	
	
	public function actionContenidoPregunta($idPregunta){
		$model = Pregunta::find()->where(['idPregunta' => $idPregunta])->one();
		if ($model->load(Yii::$app->request->post())) {
			$model->fechaActualizacion = \Date("Y-m-d h:i:s");
			if($model->save()){
				return $this->redirect(['opciones-respuesta', 'idPregunta' => $model->idPregunta]);
			}
		}
		
		$params = [	'model' => $model,
					'view' => '_contenidoPregunta' ];
		
		return $this->render('_crearPregunta',['params' => $params]);
	}
	
	
	public function actionOpcionesRespuesta($idPregunta){
		$model = Pregunta::find()->where(['idPregunta' => $idPregunta])->one();
		$modelOpcionRespuesta = new OpcionRespuesta();
		
		$searchModel = new OpcionRespuesta;
		$searchModel->idPregunta = $idPregunta;
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
		$params = [	'model' => $model,
					'searchModel' => $searchModel, 
                    'modelOpcionRespuesta' => $modelOpcionRespuesta,
                    'dataProvider' => $dataProvider,
            		'view' => '_formOpcionesPregunta' ];
		
		return $this->render('_crearPregunta',['params' => $params]);
	}
	
	
	public function actionPreguntaCompletar($idPregunta){
		$model = Pregunta::find()->where(['idPregunta' => $idPregunta])->one();
		$modelPreguntaHija = new Pregunta();
	
		$searchModel = new Pregunta();
		$searchModel->idPreguntaPadre = $idPregunta;
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams, null, false);
	
		$params = [	'model' => $model,
				'searchModel' => $searchModel,
				'modelPreguntaHija' => $modelPreguntaHija,
				'dataProvider' => $dataProvider,
				'view' => '_formOpcionesPregunta' ];
	
		return $this->render('_crearPregunta',['params' => $params]);
	}
	
	public function actionGuardarOpcionRespuesta(){
		$model = new OpcionRespuesta();
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
	
		if ($model->load(Yii::$app->request->post())) {
			$pregunta = Pregunta::findOne(['idPregunta' => $model->idPregunta]);
			
			if($pregunta->idTipoPregunta == Pregunta::PREGUNTA_SELECCION_UNICA || $pregunta->idTipoPregunta == Pregunta::PREGUNTA_SELECCION_MULTIPLE){
				if($model->esCorrecta == 1){
					if($pregunta->idTipoPregunta == Pregunta::PREGUNTA_SELECCION_UNICA){
						$respuestas = OpcionRespuesta::find()->where(['idPregunta' => $model->idPregunta, 'esCorrecta' => 1])->one();
						if($respuestas){
							return ['result' => 'error', 'response' => 'Ya hay una respuesta correcta agregada'];
							exit();
						}
					}
				}
				if($model->save()){
					return ['result' => 'ok', 'response' => 'Opci&oacute;n agregada'];
					exit();
				}
				else{
					return ['result' => 'error', 'response' => 'Opci&oacute;n no pudo ser agregada'];
					exit();
				}
			}else if($pregunta->idTipoPregunta == Pregunta::PREGUNTA_FALSO_VERDADERO){
				foreach(Yii::$app->params['formacioncomunicaciones']['cuestionario']['opcionesverdaderofalso'] as $index => $value){
					$opcionRespuesta = new OpcionRespuesta();
					$opcionRespuesta->respuesta = $value;
					$opcionRespuesta->esCorrecta = $model->respuesta == $index;
					$opcionRespuesta->idPregunta = $model->idPregunta;
					
					if($opcionRespuesta->esCorrecta != 1){
						$opcionRespuesta->esCorrecta = 0;
					}
					
					if(!$opcionRespuesta->save()){
						return ['result' => 'error', 'response' => 'Opci&oacute;n no pudo ser agregada'];
						exit();
					}
				}
				return ['result' => 'ok', 'response' => 'Opci&oacute;n agregada'];
				exit();
			}
		}
		return ['result' => 'error', 'response' => 'Opci&oacute;n no pudo ser agregada'];
		exit();
	}
	
	public function actionAgregarOpcionesCompletar(){
		
		$opcionesAgregadas = OpcionRespuesta::find()->where(['idPregunta' => Yii::$app->request->post('idPregunta')])->all();
		
		$modelOpciones = new OpcionRespuesta();
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		return ['result' => 'ok', 'response' => $this->renderPartial('_modalOpcionesCompletar',[
				'opcionesAgregadas' => $opcionesAgregadas,
				'modelOpciones' => $modelOpciones,
				'idPregunta' => Yii::$app->request->post('idPregunta'),
			 ])];
	}
	
	public function actionGuardarOpcionCompletar(){
		$modelOpciones = new OpcionRespuesta();
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		if($modelOpciones->load(Yii::$app->request->post()) && $modelOpciones->save()){
			$opcionesAgregadas = OpcionRespuesta::find()->where(['idPregunta' => $modelOpciones->idPregunta])->all();
			return ['result' => 'ok', 'response' => $this->renderPartial('_tablaOpcionesCompletar',[
					'opcionesAgregadas' => $opcionesAgregadas,
			])];
			exit();
		}else{
			print_r($modelOpciones->getErrors());exit();
			return ['result' => 'error', 
					'response' => 'Error al guardar la opci&oacute;n' 
			];
			exit();
		}
	}
	
	public function actionEditarOpcionModal(){
		$opcion = OpcionRespuesta::find()->where(['idOpcionRespuesta' => Yii::$app->request->post('idOpcionRespuesta')])->one();
		
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		return ['result' => 'ok', 'response' => $this->renderPartial('_modalEditarOpcion',[
				'modelOpcion' => $opcion,
				])];
	}
	
	public function actionGuardarOpcionEditar(){
		$opcion =  Yii::$app->request->post('OpcionRespuesta')['idOpcionRespuesta'];
		$opcionRespuesta = OpcionRespuesta::find()->where(['idOpcionRespuesta' => $opcion ])->one();
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		if ($opcionRespuesta->load(Yii::$app->request->post())) {
			$pregunta = Pregunta::findOne(['idPregunta' => $opcionRespuesta->idPregunta]);
				
			if($pregunta->idTipoPregunta == Pregunta::PREGUNTA_SELECCION_UNICA || $pregunta->idTipoPregunta == Pregunta::PREGUNTA_SELECCION_MULTIPLE){
				if($opcionRespuesta->esCorrecta == 1){
					if($pregunta->idTipoPregunta == Pregunta::PREGUNTA_SELECCION_UNICA){
						$respuestas = OpcionRespuesta::find()->where("idOpcionRespuesta != $opcion")->andFilterWhere(['idPregunta' => $opcionRespuesta->idPregunta, 'esCorrecta' => 1])->one();
						if($respuestas){
							return ['result' => 'error', 'response' => 'Ya hay una respuesta correcta agregada'];
							exit();
						}
					}
				}
				if($opcionRespuesta->save()){
					return ['result' => 'ok', 'response' => 'Opci&oacute;n agregada'];
					exit();
				}
				else{
					return ['result' => 'error', 'response' => 'Opci&oacute;n no pudo ser agregada'];
					exit();
				}
			}
		}
		
	}
	
	public function actionEliminarOpcion(){
		$id = Yii::$app->request->post('idOpcionRespuesta',true);
		OpcionRespuesta::deleteAll('idOpcionRespuesta = :id',[':id' => $id]);
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		return ['result' => 'ok', 'response' => 'Opci&oacute;n eliminada'];
		exit();
	}
	
	public function actionEliminarPregunta($id){
		$pregunta = Pregunta::findOne(['idPregunta' => $id]);
		$pregunta->estado = Pregunta::ESTADO_INACTIVO;
		$pregunta->save();
		return $this->redirect(['preguntas', 'id' => $pregunta->idCuestionario, ]);
	}
	
	public function actionVisualizarPreguntaDemo(){
		$id = Yii::$app->request->post('idPregunta',true);
		$pregunta = Pregunta::findOne(['idPregunta' => $id]);
		
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		return ['result' => 'ok', 'response' => $this->renderPartial('_modalVisualizacionPregunta',[
				'pregunta' => $pregunta,
		])];
	}
	
	public function actionGuardarPreguntaCompletar(){
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$model = new Pregunta();
		
		if($model->load(Yii::$app->request->post())){
			$model->fechaCreacion = \Date("Y-m-d h:i:s");
			$model->fechaActualizacion = \Date("Y-m-d h:i:s");
			$model->idTipoPregunta = Pregunta::PREGUNTA_COMPLETAR;
			
			if($model->save()){
				return ['result' => 'ok', 'response' => 'Opci&oacute;n agregada'];
				exit();
			}else{
				print_r($model->getErrors());
				return ['result' => 'error', 'response' => 'Error al a&ntilde;adir subpregunta'];
				exit();
			}
		}
	}
	
	
	public function actionAplicarCuestionario($id){
		
		$cuestionariosPrevios = CuestionarioUsuario::findAll(['idCuestionario' => $id, 'numeroDocumento' => Yii::$app->user->identity->numeroDocumento]);
		$modelCuestionario = Cuestionario::find()->where('m_FORCO_Cuestionario.idCuestionario = '. $id)->one();
		return $this->render('resumenIntentos',[
				'cuestionariosPrevios' => $cuestionariosPrevios,
				'modelCuestionario' => $modelCuestionario,
				'resumen' => false,
		]);
	}
	
	public function actionVisualizarCuestionario($id){
		$params =[];
		$transaction = Cuestionario::getDb()->beginTransaction();
		
		try{
			$cuestionariosPrevios = CuestionarioUsuario::findAll(['idCuestionario' => $id, 'numeroDocumento' => Yii::$app->user->identity->numeroDocumento]);
			
			$model = Cuestionario::find()->where('m_FORCO_Cuestionario.idCuestionario = '. $id)->one();
			
			if($model == null){
				// El cuestionario no existe
				exit();
			}
			
			if(Yii::$app->request->post()){
				$idCuestionarioUsuario = Yii::$app->request->post('idCuestionarioUsuario');
				$cuestionarioUsuario = CuestionarioUsuario::find()->where(['idCuestionario' => $id, 'idCuestionarioUsuario' => $idCuestionarioUsuario, 'numeroDocumento' => Yii::$app->user->identity->numeroDocumento])->orderBy(new Expression("idCuestionarioUsuario DESC "))->one();
				$opciones = Yii::$app->request->post('opcionRespuesta');
				$objCuestionario = new Cuestionario();
				$preguntas = $objCuestionario->calificarCuestionario($opciones, $model,$id, $cuestionarioUsuario, $idCuestionarioUsuario);
				$params['preguntas'] = Pregunta::find()->where('idPregunta in ('.implode(",",$preguntas).")")->all();
				$params['cuestionarioUsuario'] = $cuestionarioUsuario;
				$params['respuestasUsuario'] =  Yii::$app->request->post('opcionRespuesta');
			}else{
				if(($model->numeroIntentos != 0 && count($cuestionariosPrevios) >= $model->numeroIntentos) || 
						$model->cuestionarioAprobado(Yii::$app->user->identity->numeroDocumento) || !$model->objCurso->leido()){
					// numero de intentos por encima
					return $this->redirect(['aplicar-cuestionario' , 'id' => $id]);
					exit();
				}
				
				$model = Cuestionario::find()->where('m_FORCO_Cuestionario.idCuestionario = '. $id)->one();
				$cuestionarioUsuario = new CuestionarioUsuario();
				$cuestionarioUsuario->idCuestionario = $id;
				$cuestionarioUsuario->estadoCuestionario = Cuestionario::CUESTIONARIO_INICIADO;
				$cuestionarioUsuario->numeroDocumento = Yii::$app->user->identity->numeroDocumento;
				$cuestionarioUsuario->fechaCreacion = \Date("Y-m-d h:i:s");
				if(!$cuestionarioUsuario->save()){
					throw new \Exception("No se pudo guardar el inicio del intento",502);;
				}
				$params['preguntas'] = $model->listPreguntas;
				$params['cuestionarioUsuario'] = $cuestionarioUsuario;
			}
			$params['model'] = $model;
			
			$transaction->commit();
			 
		}catch(\Exception $e){
			$transaction->rollBack();
			Yii::$app->session->setFlash('error', $e->getMessage());
			throw  $e;
		}
		return $this->render('visualizarCuestionario', $params);
	}

	 /**
     * Encuentra un modelo LineaTiempo basado en su llave primaria.
     * @param string $id
     * @return LineaTiempo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Cuestionario::findOne(['idCuestionario' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    
    public function actionCuestionarioUsuarios(){
    	$model = new CuestionarioUsuarioForm();
    	$usuario= [];
    	$usuarios = [];
    	$client = new \SoapClient(\Yii::$app->params['webServices']['persona'], array(
    			"trace" => 1,
    			"exceptions" => 0,
    			'connection_timeout' => 5,
    			'cache_wsdl' => WSDL_CACHE_NONE
    	));
    	
    	try {
    	
    		$result = $client->getPersonas(null,false);
    		
    		foreach($result as $persona){
    			$usuarios[$persona['NumeroDocumento']] =$persona['NumeroDocumento']." - ". $persona['PrimerApellido']." ".$persona['SegundoApellido']." ".$persona['Nombres'];
    		}
    		
    		
    	} catch (SoapFault $ex) {
    		$usuarios = ArrayHelper::map(Usuario::findAll(['estado' => Usuario::ESTADO_ACTIVO]), 'numeroDocumento',function($user){return $user->numeroDocumento." - ".$user->alias;});
    	} 
    	
    	$cuestionarios = [];
    	if($model->load(Yii::$app->request->post())){
    		$cuestionarios= CuestionarioUsuario::find()->where(['numeroDocumento' => $model->numeroDocumento])->select(['distinct(idCuestionario)','numeroDocumento'])->all();
    		$usuario = Usuario::findOne(['numeroDocumento' => $model->numeroDocumento]);
    	}
    	return $this->render('estadoCuestionariousuario',[
    			'model' => $model,
    			'usuarios' => $usuarios,
    			'cuestionarios' => $cuestionarios,
    			'usuario' => $usuario,
    	]);
    }
    
    public function actionDetalleCuestionario($numeroDocumento, $idCuestionario){
    	$cuestionariosPrevios = CuestionarioUsuario::findAll(['idCuestionario' => $idCuestionario, 'numeroDocumento' => $numeroDocumento]);
    	$modelCuestionario = Cuestionario::find()->where('m_FORCO_Cuestionario.idCuestionario = '. $idCuestionario)->one();
    	return $this->render('resumenIntentos',[
    			'cuestionariosPrevios' => $cuestionariosPrevios,
    			'modelCuestionario' => $modelCuestionario,
    			'resumen' => true
    	]);
    }
    
}