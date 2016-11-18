<?php

namespace app\modules\intranet\controllers;

use Yii;
use app\modules\intranet\models\GrupoInteres;
use app\modules\intranet\models\GrupoInteresSearch;
use app\modules\intranet\models\GrupoInteresCargo;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\db\Query;
use yii\helpers\VarDumper;
use yii\web\UploadedFile;

/**
 * GrupoInteresController implementa las acciones para el modelo GrupoInteres.
 */
class GrupoInteresController extends Controller {

    public function behaviors() {
        return [
            [
                'class' => \app\components\AccessFilter::className(),
            ],
            [
                 'class' => \app\components\AuthItemFilter::className(),
                 'only' => [
                     'admin', 'detalle', 'crear', 'actualizar', 'eliminar'
                 ],
                 'authsActions' => [
                   'admin' => 'intranet_grupo-interes_admin',
                   'detalle' => 'intranet_grupo-interes_admin',
                   'crear' => 'intranet_grupo-interes_admin',
                   'actualizar' => 'intranet_grupo-interes_admin',
                   'eliminar' => 'intranet_grupo-interes_admin',
                 ]
             ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
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
     * Lista todos los modelos Grupointeres.
     * @return mixed
     */
    public function actionAdmin() {
        $searchModel = new GrupoInteresSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('admin', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Muesrtra un solo modelo Grupointeres.
     * @param string $id
     * @return mixed
     */
    public function actionDetalle($id) {
        $grupo = $this->findModel($id);
        $modelGrupoInteresCargo = new GrupoInteresCargo;
        $grupoInteresCargo = GrupoInteresCargo::listaCargos($id);

        return $this->render('detalle', [
                    'grupo' => $grupo,
                    'modelGrupoInteresCargo' => $modelGrupoInteresCargo,
                    'grupoInteresCargo' => $grupoInteresCargo,
        ]);
    }

    /**
     * Crea un nuevo modelo GrupoInteres.
     * Si la creacion es exitosa el navegador redirige a la vista detalle.
     * @return mixed
     */
    public function actionCrear() {
        $model = new GrupoInteres();

        if ($model->load(Yii::$app->request->post()) ) { //&& $model->save()
            $model->asignarImagenGrupo();

            if ($model->save()) {
              return $this->redirect(['detalle', 'id' => $model->idGrupoInteres]);
            }

        }

        return $this->render('crear', [
                    'model' => $model,
        ]);

    }

    /**
     * Actualiza un modelo existente GrupoInteres.
     * si la actualizacion es exitosa el navegador redirige a la vista detalle.
     * @param string $id
     * @return mixed
     */
    public function actionActualizar($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
          $model->asignarImagenGrupo();
          if ($model->save()) {
            return $this->redirect(['detalle', 'id' => $model->idGrupoInteres]);
          }
        }

        return $this->render('actualizar', [
                    'model' => $model,
        ]);

    }

    /**
     * Borra un modelo existente GrupoInteres.
     * si la elimiancion es existosa el navegador redirige a la vista index (Listar).
     * @param string $id
     * @return mixed
     */
    public function actionEliminar($id) {

        $model = $this->findModel($id);
        $model->estado = GrupoInteres::ESTADO_INACTIVO;
        if ($model->save()) {
            return $this->redirect(['admin']);
        }
    }

    /**
     * Borra un registro de GrupoInteresCargo donde este ese cargo
     * si la elimiancion es existosa el navegador redirige a la vista index (Listar).
     * @param string $id
     * @return mixed
     */
    public function actionEliminarCargo() {

        $idCargo = Yii::$app->request->post('idCargo', '');
        $idGrupoInteres = Yii::$app->request->post('idGrupo', '');

        $grupoInteresCargo = GrupoInteresCargo::find()->where('( idCargo =:idCargo and idGrupoInteres =:idGrupoInteres )')
                ->addParams(['idCargo' => $idCargo, 'idGrupoInteres' => $idGrupoInteres])
                ->one();

        $respond = [
            'result' => 'error',
        ];

        if ($grupoInteresCargo->delete()) {

            $grupo = $this->findModel($idGrupoInteres);
            $grupoInteresCargo = GrupoInteresCargo::listaCargos($idGrupoInteres);
            $model = new GrupoInteresCargo;

            $respond = [
                'result' => 'ok',
                'response' => $this->renderAjax('cargosGrupoInteres', [
                  'grupo' => $grupo,
                  'modelGrupoInteresCargo' => $model,
                  'grupoInteresCargo' => $grupoInteresCargo,
                        ]
            )];

        }
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $respond;
    }

    /**
     * accion para renderizar el modal de agregar cargos
     * @param none
     * @return respond = []
     *         respond.result = indica si todo se realizo bien o mal
     *         respond.response = html para renderizar los cargos asociados a el grupo
     */
    public function actionAgregaCargo($idGrupo) {

        $model = new GrupoInteresCargo;
        $model->scenario = 'agregarCargo';
        $grupoInteresCargo = '';
        $grupo = '';
        $estado = false;

        if ($model->load(Yii::$app->request->post())) { // && $model->validate()
          /*var_dump($model->validate());
          var_dump($model->getErrors());
          exit();*/
          $grupoInteresCargo = GrupoInteresCargo::listaCargos($idGrupo);
          $grupo = $this->findModel($idGrupo);

          if (empty($model->idCargo) || empty($model->nombreCargo)) {
            $model->addError('idCargo', 'el campo no piede estar vacio');
          }else{
            foreach ($model->idCargo as $key => $cargo) {

              $existeModelo = GrupoInteresCargo::find()->where(['idCargo'=>$cargo]);
              if ($existeModelo === null) {
                $model->addError('idCargo', 'un cargo seleccionado ya fue agregado');
                break;
              }else{
                $newModel = new GrupoInteresCargo;
                $newModel->idCargo = $cargo;
                $newModel->idGrupoInteres = $model->idGrupoInteres;
                $newModel->nombreCargo = $model->nombreCargo[$key];

                if ($newModel->save()) {
                  $estado = true;
                }else{
                  $estado = false;
                  $model->addError('idCargo', 'un modelo no se pudo guardar');
                }
              }
            }
          }


          if ($estado) {
            $model = new GrupoInteresCargo;
          }
        }

        $respond = [
            'result' => 'ok',
            'response' => $this->renderAjax('cargosGrupoInteres', [
              'grupo' => $grupo,
              'modelGrupoInteresCargo' => $model,
              'grupoInteresCargo' => $grupoInteresCargo,
                    ]
        )];

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $respond;
    }

    /**
     * Encuentra un modelo GrupoInteres basado en el valor de su llave primaria.
     * @param string $id
     * Si el modelo no es encontrado se arroja una exepcion HTTP 404.
     * @return un modelo GrupoInteres
     * @throws NotFoundHttpException si el modelo no es enconrado
     */
    protected function findModel($id) {
        if (($model = GrupoInteres::findOne(['idGrupoInteres' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
