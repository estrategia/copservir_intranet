<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
/**
 * This is the model class for table "m_FORCO_Cuestionario".
 *
 * @property string $idCuestionario
 * @property string $tituloCuestionario
 * @property string $descripcionCuestionario
 * @property integer $estado
 * @property integer $porcentajeMinimo
 * @property integer $numeroPreguntas
 * @property integer $numeroIntentos
 * @property string $fechaCreacion
 * @property string $fechaActualizacion
 *
 * @property MFORCOPregunta[] $mFORCOPreguntas
 */
class Cuestionario extends \yii\db\ActiveRecord
{
	const ESTADO_ACTIVO = 1;
	const ESTADO_INACTIVO = 0;
	const CUESTIONARIO_INICIADO = 1;
	const CUESTIONARIO_CERRADO = 2;
	const DESCRIPCION_PUNTOS = "CUESTIONARIO REALIZADO";
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'm_FORCO_Cuestionario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tituloCuestionario', 'descripcionCuestionario', 'fechaCreacion', 'idCurso', 'numeroIntentos', 'tiempo'], 'required'],
            [['estado', 'idCurso', 'idContenido', 'porcentajeMinimo', 'numeroPreguntas', 'idCurso','numeroIntentos', 'tiempo'], 'integer'],
            [['fechaCreacion', 'fechaActualizacion','idContenido'], 'safe'],
            [['tituloCuestionario'], 'string', 'max' => 100],
            [['descripcionCuestionario'], 'string', 'max' => 250],
        	['porcentajeMinimo', 'compare', 'compareValue' => 100, 'operator' => '<='],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idCuestionario' => 'Id Cuestionario',
            'tituloCuestionario' => 'Titulo Cuestionario',
            'descripcionCuestionario' => 'Descripcion Cuestionario',
            'estado' => 'Estado',
        	'idCurso' => 'Programa',
        	'idContenido' => 'Curso',
        	'numeroPreguntas' => 'Numero Preguntas',
        	'numeroIntentos' => 'Numero Intentos',
        	'porcentajeMinimo' => 'Porcentaje Minimo',
            'fechaCreacion' => 'Fecha Creacion',
            'fechaActualizacion' => 'Fecha Actualizacion',
        	'tiempo' => 'Tiempo (Minutos)'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getListPreguntasExamen()
    {
        return $this->hasMany(Pregunta::className(), ['idCuestionario' => 'idCuestionario']);
    }
    
    public function getListPreguntas()
    {
    	return $this->hasMany(Pregunta::className(), ['idCuestionario' => 'idCuestionario'])->where('idPreguntaPadre IS NULL AND estado = '.Pregunta::ESTADO_ACTIVO)->orderBy(new Expression('rand()'))->limit($this->numeroPreguntas);
    }
    
    public function getListPreguntasCurso()
    {
        $gruposInteres = (array) Yii::$app->user->identity->getGruposCodigos();
        $gruposInteres[] = 999999;
        
        $subQueryModulos = Modulo::find()
            ->select('idModulo')
            ->where(['idCurso' => $this->idCurso]);

        $capitulosObligatorios = Capitulo::find()
            ->select('m_FORCO_Capitulo.idCapitulo')
            ->joinWith('objGruposInteres')
            ->where([
                'estadoCapitulo' => Modulo::ESTADO_ACTIVO,
                'idModulo' => $subQueryModulos,
                'm_GrupoInteres.idGrupoInteres' => $gruposInteres,
            ]);

        $contenidosObligatorios = Contenido::find()
            ->select('idContenido')
            ->where(['idCapitulo' => $capitulosObligatorios]);

        $cuestionarios = Cuestionario::find()
            ->select('idCuestionario')
            ->where(['idContenido' => $contenidosObligatorios]);
        
        $preguntas = Pregunta::find()
            ->joinWith('objCuestionario')
            ->where(['idPreguntaPadre' => null])
            ->andWhere(['m_FORCO_Pregunta.estado' => Pregunta::ESTADO_ACTIVO])
            ->andWhere(['m_FORCO_Cuestionario.idCuestionario' => $cuestionarios])
            ->all();

        // var_dump($preguntas->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql);

        return $preguntas;
        // $subQuery = Contenido::find()
        //     ->joinWith([])
        //     ->joinWith([])

    	// $cuestionarios = Cuestionario::findAll(['idCurso' => $this->idCurso]);
    	
    	// $arrayCuestionarios = [];
    	// foreach($cuestionarios as $cuestionario){
    	// 	$arrayCuestionarios[] = $cuestionario->idCuestionario;
    	// }
    	
    	// return Pregunta::find()->where('idPreguntaPadre IS NULL AND estado = '.Pregunta::ESTADO_ACTIVO)->andWhere("idCuestionario in (".implode(",", $arrayCuestionarios).")")->orderBy(new Expression('rand()'))->limit($this->numeroPreguntas)->all();
    }
    
    public function getObjCurso(){
    	return $this->hasOne(Curso::className(), ['idCurso' => 'idCurso']);
    }
    
    public function getObjContenido(){
    	return $this->hasOne(Contenido::className(), ['idContenido' => 'idContenido']);
    }

    public function search($params)
    {
        $query = self::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

       /* if (!$this->validate()) {
            return $dataProvider;
        }*/

        $query->andFilterWhere([
            'idCuestionario' => $this->idCuestionario,
            'idCurso' => $this->idCurso,
            'estado' => $this->estado,
        	'porcentajeMinimo' => $this->porcentajeMinimo,
        	'numeroPreguntas' => $this->numeroPreguntas,
        ]);

        $query->andFilterWhere(['like', 'tituloCuestionario', $this->tituloCuestionario])
            ->andFilterWhere(['like', 'descripcionCuestionario', $this->descripcionCuestionario])
            ->andFilterWhere(['like', 'fechaCreacion', $this->fechaCreacion])
            ->andFilterWhere(['like', 'fechaActualizacion', $this->fechaActualizacion]);

        return $dataProvider;
    }
    
    public function calificarCuestionario($opciones, $model, $idCuestionario, &$cuestionarioUsuario){
    	$puntaje = 0;
    	$preguntasCuestionario = [];
    	
    	if($cuestionarioUsuario->fechaActualizacion == ""){
    		$cuestionarioUsuario->fechaActualizacion = \Date ("Y-m-d h:i:s");
    	}
    	$numeroPreguntas = $porcentajeObtenido = 0;
    	
    	Respuestas::deleteAll('idCuestionarioUsuario = :idcuestionariousuario AND numeroDocumento = :numerodocumento',
    			[':idcuestionariousuario' => $cuestionarioUsuario->idCuestionarioUsuario, 
    			 ':numerodocumento' => Yii::$app->user->identity->numeroDocumento,
    			]);
    	
    	if($opciones != null){
	    	foreach($opciones as $idPregunta => $opcion){
		    		$pregunta = Pregunta::find()->where(['idPregunta' => $idPregunta])->one();
		    		$preguntasCuestionario[]= $idPregunta;
		    		
		    		if($pregunta->idTipoPregunta == Pregunta::PREGUNTA_SELECCION_UNICA
		    				|| $pregunta->idTipoPregunta == Pregunta::PREGUNTA_FALSO_VERDADERO){
		    					$respuesta = OpcionRespuesta::find()->where(['idPregunta' => $pregunta->idPregunta, 'esCorrecta' => 1])->one();
		    						
		    					$esCorrecta = 0;
		    					if($respuesta){
		    						if($opcion == $respuesta->idOpcionRespuesta){
		    							$puntaje++;
		    							$esCorrecta = 1;
		    						}
		    					}
		    						
		    					$respuestaUsuario = new Respuestas();
		    					$respuestaUsuario->numeroDocumento = Yii::$app->user->identity->numeroDocumento;
		    					$respuestaUsuario->idPregunta = $idPregunta;
		    					$respuestaUsuario->idOpcionRespuesta = $opcion;
		    					$respuestaUsuario->esCorrecta = $esCorrecta;
		    					$respuestaUsuario->idCuestionario = $idCuestionario;
		    					$respuestaUsuario->idCuestionarioUsuario = $cuestionarioUsuario->idCuestionarioUsuario;
		    					
		    					if(!$respuestaUsuario->save()){
		    						throw new \Exception("No se pudo guardar respuestas de seleccion &uacute;nica",501);
		    					}
		    						
		    		}else if($pregunta->idTipoPregunta == Pregunta::PREGUNTA_SELECCION_MULTIPLE){
		    			$respuesta = OpcionRespuesta::find()->where(['idPregunta' => $pregunta->idPregunta, 'esCorrecta' => 1])->all();
		    			$correctas = $incorrectas = 0;
		    			$respuestasCorrectas = $contestadas = array();
		    			foreach($respuesta as $opcionCorrecta){
		    				$respuestasCorrectas[] = $opcionCorrecta->idOpcionRespuesta;
		    			}
		    			foreach($opcion as $opcionMarcada => $estado){
		    				$contestadas [] = $opcionMarcada;
		    				$esCorrecta = 0;
		    				if(in_array($opcionMarcada, $respuestasCorrectas) ){/***********/
		    					$correctas++;
		    					$esCorrecta = 1;
		    				}else{
		    					$incorrectas++;
		    				}
		    	
		    				$respuestaUsuario = new Respuestas();
		    				$respuestaUsuario->numeroDocumento = Yii::$app->user->identity->numeroDocumento;
		    				$respuestaUsuario->idPregunta = $idPregunta;
		    				$respuestaUsuario->idOpcionRespuesta = $opcionMarcada;
		    				$respuestaUsuario->esCorrecta = $esCorrecta;
		    				$respuestaUsuario->idCuestionario = $idCuestionario;
		    				$respuestaUsuario->idCuestionarioUsuario = $cuestionarioUsuario->idCuestionarioUsuario;
		    				if(!$respuestaUsuario->save()){
		    					throw new \Exception("No se pudo guardar respuestas de seleccion m&uacute;ltiple",501);
		    				}
		    			}
		    				
		    			foreach($respuestasCorrectas as $respuestaCorrecta){
		    				if(!in_array($respuestaCorrecta, $contestadas) ){/***********/
		    					$incorrectas++;
		    				}
		    			}
		    				
		    			$puntaje+= ($correctas)/($correctas+$incorrectas);
		    		}else if($pregunta->idTipoPregunta == Pregunta::PREGUNTA_COMPLETAR){
		    			$correctas = $incorrectas = 0;
		    			foreach($pregunta->listPreguntasHijas as $subPregunta){
		    	
		    				if(isset($opcion[$subPregunta->idPregunta])){
		    					$respuesta = OpcionRespuesta::find()->where(['idPregunta' => $subPregunta->idPregunta, 'esCorrecta' => 1, 'TRIM(LOWER(respuesta))' => trim(strtolower($opcion[$subPregunta->idPregunta]))])->one();
		    					$opcionMarcada = NULL;
		    					$esCorrecta = 0;
		    					if($respuesta != null){
		    						$correctas++;
		    						$opcionMarcada = $respuesta->idOpcionRespuesta;
		    						$esCorrecta = 1;
		    					}else{
		    						$incorrectas++;
		    					}
		    						
		    					$respuestaUsuario = new Respuestas();
		    					$respuestaUsuario->numeroDocumento = Yii::$app->user->identity->numeroDocumento;
		    					$respuestaUsuario->idPregunta = $subPregunta->idPregunta;
		    					$respuestaUsuario->idOpcionRespuesta = $opcionMarcada;
		    					$respuestaUsuario->esCorrecta = $esCorrecta;
		    					$respuestaUsuario->idCuestionario = $idCuestionario;
		    					$respuestaUsuario->respuestaTextual = $opcion[$subPregunta->idPregunta];
		    					$respuestaUsuario->idCuestionarioUsuario = $cuestionarioUsuario->idCuestionarioUsuario;
		    					
		    					if(!$respuestaUsuario->save()){
		    						throw new \Exception("No se pudo guardar respuestas de completar",501);
		    					}
		    				}else{
		    					$incorrectas++;
		    				}
		    			}
		    			
		    			// $puntaje += ($correctas)/($correctas+$incorrectas);
		    			if($incorrectas == 0){
		    				$puntaje++;
		    			}
		    		}
		    		$numeroPreguntas++;
		    	}
		    	$porcentajeObtenido = $puntaje/$numeroPreguntas*100;
    		}
	    	$cuestionarioUsuario->numeroPreguntasTotal = $numeroPreguntas;
	    	$cuestionarioUsuario->numeroPreguntasRespondidas = $puntaje;
	    	$cuestionarioUsuario->porcentajeObtenido = $porcentajeObtenido;
	    	$cuestionarioUsuario->estadoCuestionario = Cuestionario::CUESTIONARIO_CERRADO;
	    	
	    	if(!$cuestionarioUsuario->save()){
	    		throw new \Exception("No se pudo actualizar el cuestionario",502);
	    	}
	    	
	    	/******************* SI GANA EL EXAMEN GANA PUNTOS PARAMETRIZADOS *************/
	    	if($cuestionarioUsuario->porcentajeObtenido >= $model->porcentajeMinimo){
                // Actualizamos el Promedio
                PromedioPonderadoUsuario::actualizar(Yii::$app->user->identity->numeroDocumento, $cuestionarioUsuario->porcentajeObtenido, $model->porcentajeMinimo);

	    		// Buscar el par�metro
	    		
	    	//	$parametroPunto = ParametrosPuntos::findOne(['idTipoContenido' => $model->objCurso->idTipoContenido, 'estado' => ParametrosPuntos::ESTADO_ACTIVO]);
	    		// Guardar los puntos
	    		$puntos = $tipoParametro =  0;
	    		if($model->idContenido != null){
	    			$puntos = $model->objContenido->cantidadPuntos;
	    			$tipoParametro = ParametrosPuntos::CUESTIONARIO_CONTENIDO;
	    			
	    			$contenidoUsuario = new ContenidoLeidoUsuario();
	    			$contenidoUsuario->idContenido = $model->idContenido ;
	    			$contenidoUsuario->idCurso = $model->idCurso ;
	    			$contenidoUsuario->numeroDocumento = $cuestionarioUsuario->numeroDocumento ;
	    			$contenidoUsuario->fechaCreacion = \Date("Y-m-d h:i:s");
	    			
	    			if(!$contenidoUsuario->save()){
	    				throw new \Exception("No se pudo marcar el contenido leido",505);
	    			}
	    		}else{
	    			$puntos = $model->objCurso->cantidadPuntos;
	    			$tipoParametro = ParametrosPuntos::CUESTIONARIO_CURSO;
	    			
	    			$contenidoUsuario = new CursosUsuario();
	    			$contenidoUsuario->numeroDocumento = $cuestionarioUsuario->numeroDocumento ;
	    			$contenidoUsuario->idCurso = $model->idCurso ;
	    			$contenidoUsuario->fechaCreacion  = \Date("Y-m-d h:i:s") ;
	    			$contenidoUsuario->fechaInicioLectura = \Date("Y-m-d h:i:s") ;
	    			
	    			if(!$contenidoUsuario->save()){
	    				throw new \Exception("No se pudo marcar el curso leido",505);
	    			}
	    		}
	    		
		    		$puntosUsuario = new Puntos();
		    		
		    		$puntosUsuario->numeroDocumento = $cuestionarioUsuario->numeroDocumento;
		    		$puntosUsuario->valorPuntos = $puntos; 
		    		$puntosUsuario->descripcionPunto = Cuestionario::DESCRIPCION_PUNTOS;
		    		$puntosUsuario->idCuestionario = $model->idCuestionario;
		    	//	$puntosUsuario->idParametroPunto = $parametroPunto->tipoParametro; /* ? */
		    		$puntosUsuario->tipoParametro = $tipoParametro;
		    		$puntosUsuario->fechaCreacion = Date("Y-m-d h:i:s");
		    		$puntosUsuario->idCurso = $model->idCurso;
		    	
                    $totales = PuntosTotales::find()->where(['numeroDocumento' => $cuestionarioUsuario->numeroDocumento])->one();

                    if ($totales == null) {
                        $puntosTotales = new PuntosTotales();
                        $puntosTotales->puntos = $puntos;
                        $puntosTotales->numeroDocumento = $cuestionarioUsuario->numeroDocumento;
                        $puntosTotales->save();
                    } else {
                        $totales->puntos += $puntos;
                        $totales->save();
                    }

		    		if(!$puntosUsuario->save()){
		    			throw new \Exception("No se pudo actualizar el cuestionario",502);
		    		}
	    		
	    	}
	    	return $preguntasCuestionario;
    }
    
    public function cuestionarioAprobado($numeroDocumento = null){
    	if(is_null($numeroDocumento)){
    		$numeroDocumento = Yii::$app->user->identity->numeroDocumento;
    	}
    	$cuestionarioUsuario = CuestionarioUsuario::find()->where(new Expression("porcentajeObtenido >= $this->porcentajeMinimo"))->andFilterWhere(['idCuestionario' => $this->idCuestionario, 'numeroDocumento' => $numeroDocumento])->one();
    
    	return $cuestionarioUsuario ? true:false;
    }
    
    public function getCalificacion($numeroDocumento){
    	return round(CuestionarioUsuario::find()->where(['idCuestionario' => $this->idCuestionario, 'numeroDocumento' => $numeroDocumento])->select('max(porcentajeObtenido)')->scalar(),2);
    }

    public function getPuntos($numeroDocumento = null)
    {
        $documento = $numeroDocumento;
        if ($documento == null) {
            $documento = Yii::$app->user->identity->numeroDocumento;
        }
        $puntos = Puntos::findOne(['numeroDocumento' => $documento, 'idCuestionario' => $this->idCuestionario]);
        return ($puntos ? $puntos->valorPuntos: 0);
    }
    
}
