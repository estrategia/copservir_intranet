<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\controllers;

use Yii;
use app\modules\intranet\models\GrupoInteres;
use app\modules\intranet\modules\formacioncomunicaciones\models\Capitulo;
use app\modules\intranet\modules\formacioncomunicaciones\models\Curso;
use app\modules\intranet\modules\formacioncomunicaciones\models\CursoSearch;
use app\modules\intranet\modules\formacioncomunicaciones\models\Contenido;
use app\modules\intranet\modules\formacioncomunicaciones\models\Modulo;
use app\modules\intranet\modules\formacioncomunicaciones\models\TipoContenido;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\BaseUrl;

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
                    'index', 'create', 'update', 'crear-modulo', 'view','actualizar-modulo', 'crear-capitulo', 'actualizar-capitulo', 'crear-contenido', 'visualizar-contenido', 'mis-contenidos', 'buscador'
                ],
                'authsActions' => [
                    'index' => 'formacionComunicaciones_curso_admin',
                    'view' => 'formacionComunicaciones_curso_admin',
                    'create' => 'formacionComunicaciones_curso_admin',
                    'update' => 'formacionComunicaciones_curso_admin',
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
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Curso model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Curso();
        $gruposInteres = ArrayHelper::Map(GrupoInteres::find()->where(['estado' => 1])->asArray()->all(), 'idGrupoInteres', 'nombreGrupo');
        $tiposContenido = ArrayHelper::Map(TipoContenido::find()->where(['estadoTipoContenido' => 1])->asArray()->all(), 'idTipoContenido', 'nombreTipoContenido');
        if ($model->load(Yii::$app->request->post())) {
            // $model->validate()
            // return $this->redirect(['detalle', 'id' => $model->idContenido]);
            $transaction = Curso::getDb()->beginTransaction();
            try {
              if ($model->save()) {
                if (!empty(Yii::$app->request->post()['Curso']['cursoGruposInteres'])) {
                  $model->guardarGruposInteres(Yii::$app->request->post()['Curso']['cursoGruposInteres']);
                }
                // exit();
                $transaction->commit();
                return $this->redirect(['view', 'id' => $model->idCurso]);
              }
            } catch (\Exception $e) {

            $transaction->rollBack();
            Yii::$app->session->setFlash('error', $e->getMessage());
            throw $e;
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'gruposInteres' => $gruposInteres,
                'tiposContenido' => $tiposContenido
            ]);
        }
    }

    /**
     * Updates an existing Curso model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $gruposInteres = ArrayHelper::Map(GrupoInteres::find()->where(['estado' => 1])->asArray()->all(), 'idGrupoInteres', 'nombreGrupo');
        $tiposContenido = ArrayHelper::Map(TipoContenido::find()->where(['estadoTipoContenido' => 1])->asArray()->all(), 'idTipoContenido', 'nombreTipoContenido');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->actualizarGrupos(Yii::$app->request->post()['Curso']['cursoGruposInteres']);            
            return $this->redirect(['view', 'id' => $model->idCurso]);
        } else {
            $model->setCursoGruposInteres();
            return $this->render('update', [
                'model' => $model,
                'gruposInteres' => $gruposInteres,
                'tiposContenido' => $tiposContenido
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

    public function actionMisCursos()
    {
        $searchModel = new CursoSearch();
        $queryParams = Yii::$app->request->queryParams;
        $gruposInteres = (array) Yii::$app->user->identity->getGruposCodigos();
        $queryParams['gruposInteresUsuario'] = $gruposInteres;
        $dataProvider = $searchModel->search($queryParams);
        return $this->render('misCursos', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
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
