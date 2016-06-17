<?php

namespace app\modules\intranet\controllers;

use Yii;
use app\modules\intranet\models\InformacionContactoOferta;
use app\modules\intranet\models\InformacionContactoOfertaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * InformacionContactoOfertaController implements the CRUD actions for InformacionContactoOferta model.
 */
class InformacionContactoOfertaController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            [
                'class' => \app\components\AccessFilter::className(),
                'only' => [
                    'admin', 'detalle', 'crear', 'actualizar', 'eliminar', 'plantilla'
                ],
            ],
            [
                'class' => \app\components\AuthItemFilter::className(),
                'only' => [
                    'admin', 'detalle', 'crear', 'actualizar', 'plantilla'
                ],
                'authsActions' => [
                    'detalle' => 'intranet_informacion-contacto-oferta_admin',
                    'crear' => 'intranet_informacion-contacto-oferta_admin',
                    'actualizar' => 'intranet_informacion-contacto-oferta_admin',
                    'plantilla' => 'intranet_informacion-contacto-oferta_admin',
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Lista todos los modelos InformacionContactoOferta.
     * @return mixed
     */
    public function actionAdmin() {
        $searchModel = new InformacionContactoOfertaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('listar', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Muestra un solo modelo InformacionContactoOferta.
     * @param string $id
     * @return mixed
     */
    public function actionDetalle($id) {
        return $this->render('detalle', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Crea un nuevo modelo InformacionContactoOferta.
     * Si la creacion es exitosa el navegador redirige a el detalle.
     * @return mixed
     */
    public function actionCrear() {
        $model = new InformacionContactoOferta();

        if ($model->load(Yii::$app->request->post())) {
            $model->fechaRegistro = Date("Y-m-d");
            //por ahora queda quemado se debe colocar el de la persona de la oferta
            $model->numeroDocumentoContacto = 1;

            if ($model->save()) {
                return $this->redirect(['detalle', 'id' => $model->idInformacionContacto]);
            }
        } else {
            return $this->render('crear', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Actualiza un modelo existente InformacionContactoOferta.
     * Si la actualizacion es exitosa el navegador redirige al detalle.
     * @param string $id
     * @return mixed
     */
    public function actionActualizar($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            //por ahora queda quemado se debe colocar el de la persona de la oferta
            $model->numeroDocumentoContacto = 1;

            if ($model->save()) {
                return $this->redirect(['detalle', 'id' => $model->idInformacionContacto]);
            }
        } else {
            return $this->render('actualizar', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Elimina un modelo existente InformacionContactoOferta model.
     * Si la eliminacion es exitosa el navegador redirige al index.
     * @param string $id
     * @return mixed
     */
    public function actionEliminar($id) {

        $model = $this->findModel($id);
        $model->estado = InformacionContactoOferta::PLANTILLA_INACTIVA;
        if ($model->save()) {
            return $this->redirect(['admin']);
        }
    }

    /**
     * Busca un modelo InformacionContactoOferta segun su id y retorna un textArea
     * con el contenido de la platilla
     * @param string $id
     * @return mixed
     */
    public function actionPlantilla($id) {

        $model = $this->findModel($id);
        $respond = [];

        // consultar la informacion del contacto
        $respond = [
            'result' => 'ok',
            'response' => $this->renderAjax('_plantillaOferta', [
                'plantilla' => $model,
                'contacto' => '' // mandar la informacion de contacto
                    ]
            )
        ];

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $respond;
    }

    /**
     * Encuentra un modelo InformacionContactoOferta basado es el valor de su llave primaria.
     * Si el modelo no existe retorna una excepcion 404 HTTP exception.
     * @param string $id
     * @return InformacionContactoOferta el modelo cargado
     * @throws NotFoundHttpException si el modelo no fue encontrado s
     */
    protected function findModel($id) {
        if (($model = InformacionContactoOferta::findOne(['idInformacionContacto' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('no existe.');
        }
    }

}
