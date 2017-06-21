<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\controllers;

use Yii;
use app\modules\intranet\models\GrupoInteres;
use app\modules\intranet\modules\formacioncomunicaciones\models\Capitulo;
use app\modules\intranet\modules\formacioncomunicaciones\models\Curso;
use app\modules\intranet\modules\formacioncomunicaciones\models\CursoGruposInteres;
use app\modules\intranet\modules\formacioncomunicaciones\models\CursoSearch;
use app\modules\intranet\modules\formacioncomunicaciones\models\Contenido;
use app\modules\intranet\modules\formacioncomunicaciones\models\Modulo;
use app\modules\intranet\modules\formacioncomunicaciones\models\TipoContenido;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\BaseUrl;
use yii\helpers\Url;

/**
 * CursoController implements the CRUD actions for Curso model.
 */
class CursoController extends Controller
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
                    'index', 'crear', 'actualizar', 'crear-modulo', 'detalle','actualizar-modulo', 'crear-capitulo', 'actualizar-capitulo', 'crear-contenido', 'visualizar-contenido', 'mis-contenidos', 'buscador'
                ],
                'authsActions' => [
                    'index' => 'formacionComunicaciones_curso_admin',
                    'detalle' => 'formacionComunicaciones_curso_admin',
                    'crear' => 'formacionComunicaciones_curso_admin',
                    'actualizar' => 'formacionComunicaciones_curso_admin',
                    'crear-modulo' => 'formacionComunicaciones_modulo_admin',
                    'actualizar-modulo' => 'formacionComunicaciones_modulo_admin',
                    'crear-capitulo' => 'formacionComunicaciones_capitulo_admin',
                    'actualizar-capitulo' => 'formacionComunicaciones_capitulo_admin',
                    'crear-contenido' => 'formacionComunicaciones_contenido_admin',
                    'visualizar-curso' => 'intranet_usuario',
                    'mis-contenidos' => 'intranet_usuario',
                    'buscador' => 'intranet_usuario'
                ],
           ],

        ];
    }

    /**
     * Lists all Curso models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CursoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Curso model.
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
     * Creates a new Curso model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCrear()
    {
        $model = new Curso();
        $model->scenario = Curso::CRUD_SCENARIO;
        $gruposInteres = ArrayHelper::Map(GrupoInteres::find()->where(['estado' => 1])->asArray()->all(), 'idGrupoInteres', 'nombreGrupo');
        $tiposContenido = ArrayHelper::Map(TipoContenido::find()->where(['estadoTipoContenido' => 1])->asArray()->all(), 'idTipoContenido', 'nombreTipoContenido');
        if ($model->load(Yii::$app->request->post())) {
            $model->guardarImagen('');
            $transaction = Curso::getDb()->beginTransaction();
            try {
              if ($model->save()) {
                if (!empty(Yii::$app->request->post()['Curso']['cursoGruposInteres'])) {
                  $model->guardarGruposInteres(Yii::$app->request->post()['Curso']['cursoGruposInteres']);
                }
                // exit();
                $transaction->commit();
                return $this->redirect(['detalle', 'id' => $model->idCurso]);
              }
            } catch (\Exception $e) {

            $transaction->rollBack();
            Yii::$app->session->setFlash('error', $e->getMessage());
            throw $e;
            }
        } else {
            return $this->render('crear', [
                'model' => $model,
                'gruposInteres' => $gruposInteres,
                'tiposContenido' => $tiposContenido,
                'objCursoGruposInteres' => new CursoGruposInteres()
            ]);
        }
    }

    /**
     * Updates an existing Curso model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionActualizar($id)
    {
        $model = $this->findModel($id);
        $model->scenario = Curso::CRUD_SCENARIO;
        $gruposInteres = ArrayHelper::Map(GrupoInteres::find()->where(['estado' => 1])->asArray()->all(), 'idGrupoInteres', 'nombreGrupo');
        $tiposContenido = ArrayHelper::Map(TipoContenido::find()->where(['estadoTipoContenido' => 1])->asArray()->all(), 'idTipoContenido', 'nombreTipoContenido');
        $rutaImagen = $model->rutaImagen;
        if ($model->load(Yii::$app->request->post())) {
            $model->guardarImagen($rutaImagen);
            if ($model->save()) {
                $model->actualizarGrupos(Yii::$app->request->post()['Curso']['cursoGruposInteres']);            
                return $this->redirect(['detalle', 'id' => $model->idCurso]);
            } else {
                return $this->redirect(['actualizar', 'id' => $model->idCurso]);
            }
        } else {
            $model->setCursoGruposInteres();
            return $this->render('actualizar', [
                'model' => $model,
                'gruposInteres' => $gruposInteres,
                'tiposContenido' => $tiposContenido,
                'objCursoGruposInteres' => new CursoGruposInteres()
            ]);
        }
    }

    public function actionRenderModalCrearModulo($idCurso)
    {
        $model = new Modulo();
        $modulos = [
            'result' => 'ok',
            'response' => $this->renderAjax('_modalModulo', ['model' => $model, 'idCurso' => $idCurso])
        ];
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $modulos;
    }

    public function actionRenderModalEditarModulo($idModulo)
    {
        $model = Modulo::find()->where(['idModulo' => $idModulo])->one();
        $modulos = [
            'result' => 'ok',
            'response' => $this->renderAjax('_modalModulo', ['model' => $model, 'idCurso' => $model->idCurso])
        ];
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $modulos;
    }

    public function actionCrearModulo($idCurso) {
        $model = new Modulo();
        $modulos = [];
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $modulos = [
                'result' => 'ok',
                'response' => $this->renderAjax('_contenidoCurso', [
                    'model' => Curso::find()->where(['idCurso' => $idCurso])->one()
                ])
            ];
        } else {
            $modulos = [
                'result' => 'error',
                'response' => $this->renderAjax('_modalModulo', ['model' => $model])
            ];
        }

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $modulos;
    }

    public function actionActivar($id)
    {
        $model = Curso::find()->where(['idCurso' => $id])->one();
        if (sizeof($model->modulos) > 0) {
            if ($model->activar()) {
                Yii::$app->session->setFlash('success', 'Se ha activado el curso correctamente');
            } else {
                Yii::$app->session->setFlash('error', 'Ha ocurrido un error al activar el curso');
            }
        } else {
            Yii::$app->session->setFlash('error', 'El curso debe contener modulos para poder ser activado');
        }
        return $this->redirect(['index']);
    }

    public function actionActualizarModulo($idModulo, $idCurso) {
        $model = Modulo::find()->where(['idModulo' => $idModulo])->one();
        $modulos = [];
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $modulos = [
                'result' => 'ok',
                'response' => $this->renderAjax('_contenidoCurso', [
                    'model' => Curso::find()->where(['idCurso' => $idCurso])->one()
                ])
            ];
        } else {
            $modulos = [
                'result' => 'error',
                'response' => $this->renderAjax('_modalModulo', ['model' => $model])
            ];
        }

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $modulos;
    }

    public function actionRenderModalCrearCapitulo($idModulo)
    {
        $model = new Capitulo();
        $capitulos = [
            'result' => 'ok',
            'response' => $this->renderAjax('_modalCapitulo', ['model' => $model, 'idModulo' => $idModulo])
        ];
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $capitulos;
    }

    public function actionRenderModalEditarCapitulo($idCapitulo)
    {
        $model = Capitulo::find()->where(['idCapitulo' => $idCapitulo])->one();
        $capitulos = [
            'result' => 'ok',
            'response' => $this->renderAjax('_modalCapitulo', ['model' => $model, 'idModulo' => $model->idModulo])
        ];
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $capitulos;
    }

    public function actionCrearCapitulo($idCurso)
    {
        $model = new Capitulo();
        $capitulos = [];
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $capitulos = [
                'result' => 'ok',
                'response' => $this->renderAjax('_contenidoCurso', [
                    'model' => Curso::find()->where(['idCurso' => $idCurso])->one()
                ])
            ];
        } else {
            $capitulos = [
                'result' => 'error',
                'response' => $this->renderAjax('_modalCapitulo', ['model' => $model])
            ];
        }

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $capitulos;   
    }

    public function actionActualizarCapitulo($idCapitulo, $idCurso)
    {
        $model = Capitulo::find()->where(['idCapitulo' => $idCapitulo])->one();
        $capitulos = [];
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $capitulos = [
                'result' => 'ok',
                'response' => $this->renderAjax('_contenidoCurso', [
                    'model' => Curso::find()->where(['idCurso' => $idCurso])->one()
                ])
            ];
        } else {
            $capitulos = [
                'result' => 'error',
                'response' => $this->renderAjax('_modalCapitulo', ['model' => $model])
            ];
        }

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $capitulos;   
    }

    public function actionRenderModalCrearContenido($idCapitulo)
    {
        $model = new Contenido();
        $contenidos = [
            'result' => 'ok',
            'response' => $this->renderAjax('_modalContenido', ['model' => $model, 'idCapitulo' => $idCapitulo])
        ];
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $contenidos;
    }

    public function actionCrearContenido($idCurso, $idCapitulo)
    {
        $model = new Contenido();
        $capitulos = [];
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $capitulos = [
                'result' => 'ok',
                'response' => $this->renderAjax('_contenidoCurso', [
                    'model' => Curso::find()->where(['idCurso' => $idCurso])->one()
                ])
            ];
        } else {
            $capitulos = [
                'result' => 'error',
                'response' => $this->renderAjax('_modalContenido', ['model' => $model, 'idCapitulo' => $idCapitulo])
            ];
        }

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $capitulos;   
    }

    public function actionBuscador()
    {
        $searchModel = new CursoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('buscador', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    // public function actionMisCursos()
    // {
    //     $searchModel = new CursoSearch();
    //     $queryParams = Yii::$app->request->queryParams;
    //     $gruposInteres = (array) Yii::$app->user->identity->getGruposCodigos();
    //     $queryParams['gruposInteresUsuario'] = $gruposInteres;
    //     $queryParams['activos'] = true;
    //     $dataProvider = $searchModel->search($queryParams);
    //     return $this->render('misCursos', [
    //         'searchModel' => $searchModel,
    //         'dataProvider' => $dataProvider
    //     ]);
    // }

    public function actionMisCursos()
    {
        $params = [];
        $cursosBanner = [];
        $cursosFormacion = [];
        $cursosComunicacion = [];
        $gruposInteres = (array) Yii::$app->user->identity->getGruposCodigos();   
        $cursosObligatorios = Curso::find()
            ->joinWith('objCursoGruposInteres')
            ->where([
                'tipoCurso' => Curso::TIPO_OBLIGATORIO,
                'estadoCurso' => Curso::ESTADO_ACTIVO,
                'idGrupoInteres' => $gruposInteres
            ])
            ->orderBy(['fechaActualizacion' => SORT_DESC])
            ->limit(7)
            ->all();
        $cursosComunicacion = Curso::find()
            ->joinWith('objCursoGruposInteres')
            ->where([
                'tipoCurso' => Curso::TIPO_OPCIONAL,
                'estadoCurso' => Curso::ESTADO_ACTIVO,
                'idGrupoInteres' => $gruposInteres
            ])
            ->orderBy(['fechaActualizacion' => SORT_DESC])
            ->limit(4)
            ->all();
        if (sizeof($cursosObligatorios >= 3)) {
            $cursosBanner = array_slice($cursosObligatorios, 0, 3);
            $cursosFormacion = array_slice($cursosObligatorios, 3, 8);
        } else {
            $cursosBanner = $cursosObligatorios;
        }
        $params = [
            'cursosBanner' => $cursosBanner,
            'cursosFormacion' => $cursosFormacion,
            'cursosComunicacion' => $cursosComunicacion,
        ];
        return $this->render('misCursos', $params);
    }

    public function actionRecomendados()
    {
        $cursosFormacion = Curso::find()
            ->where(['tipoCurso' => Curso::TIPO_OBLIGATORIO])
            ->limit(10)
            ->orderBy(['prioridad' => SORT_DESC])
            ->all();
        $cursosComunicacion = Curso::find()
            ->where(['tipoCurso' => Curso::TIPO_OPCIONAL])
            ->limit(10)
            ->orderBy(['prioridad' => SORT_DESC])
            ->all();
        return $this->render('recomendados', [
            'cursosFormacion' => $cursosFormacion,
            'cursosComunicacion' => $cursosComunicacion
        ]);
    }

    public function actionLeidos()
    {
        $numeroDocumento = Yii::$app->user->identity->numeroDocumento;
        $cursosFormacion = Curso::find()
            ->leftJoin('t_FORCO_CursosUsuario', 't_FORCO_CursosUsuario.idCurso = m_FORCO_Curso.idCurso')
            ->where([
                'tipoCurso' => Curso::TIPO_OBLIGATORIO,
                'numeroDocumento' => $numeroDocumento
            ])
            ->limit(10)
            ->orderBy(['prioridad' => SORT_DESC])
            ->all();
        $cursosComunicacion = Curso::find()
            ->leftJoin('t_FORCO_CursosUsuario', 't_FORCO_CursosUsuario.idCurso = m_FORCO_Curso.idCurso')
            ->where([
                'tipoCurso' => Curso::TIPO_OPCIONAL,
                'numeroDocumento' => $numeroDocumento
            ])
            ->limit(10)
            ->orderBy(['prioridad' => SORT_DESC])
            ->all();
         return $this->render('leidos', [
            'cursosFormacion' => $cursosFormacion,
            'cursosComunicacion' => $cursosComunicacion
        ]);
    }

    public function actionFormacion()
    {
        $gruposInteres = (array) Yii::$app->user->identity->getGruposCodigos();   

        $cursosObligatorios = Curso::find()
            ->joinWith('objCursoGruposInteres')
            ->where([
                'tipoCurso' => Curso::TIPO_OBLIGATORIO,
                'estadoCurso' => Curso::ESTADO_ACTIVO,
                'idGrupoInteres' => $gruposInteres
            ])
            ->orderBy(['fechaActualizacion' => SORT_DESC])
            ->all();
        return $this->render('cursosFormacion', ['cursosFormacion' => $cursosObligatorios]);
    }

    public function actionComunicacion()
    {
        $gruposInteres = (array) Yii::$app->user->identity->getGruposCodigos();   

        $cursosComunicacion = Curso::find()
            ->joinWith('objCursoGruposInteres')
            ->where([
                'tipoCurso' => Curso::TIPO_OPCIONAL,
                'estadoCurso' => Curso::ESTADO_ACTIVO,
                'idGrupoInteres' => $gruposInteres
            ])
            ->orderBy(['fechaActualizacion' => SORT_DESC])
            ->all();
        return $this->render('cursosComunicacion', ['cursosComunicacion' => $cursosComunicacion]);
    }

    public function actionNotificaciones()
    {
        $searchModel = new CursoSearch();
        $queryParams = Yii::$app->request->queryParams;
        $gruposInteres = (array) Yii::$app->user->identity->getGruposCodigos();
        $queryParams['gruposInteresUsuario'] = $gruposInteres;
        $queryParams['activos'] = true;
        $dataProvider = $searchModel->search($queryParams);
        $cursos = $dataProvider->getModels();
        // \yii\helpers\VarDumper::dump($cursos,10,true);
        $notificaciones = [];
        foreach ($cursos as $indice => $curso) {
            $notificaciones[] = [
                'nombreCurso' => $curso->nombreCurso,
                'urlCurso' => Url::to(['visualizar-curso', 'id' => $curso->idCurso], true)
            ];
        }
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $notificaciones;
    }

    public function actionVisualizarCurso($id)
    {
        return $this->render('visualizarCurso', [
            'model' => $this->findModel($id)
        ]);
    }
    
    /**
     * Finds the Curso model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Curso the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Curso::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}