<?php

namespace app\modules\intranet\controllers;

use Yii;
use app\modules\intranet\models\GrupoInteres;
use app\modules\intranet\models\GrupoInteresSearch;
use app\modules\intranet\models\GrupoInteresCargo;
use app\modules\intranet\models\Cargo;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\db\Query;

/**
 * GrupoInteresController implementa las acciones para el modelo GrupoInteres.
 */
class GrupoInteresController extends Controller {

    public function behaviors() {
        return [
            [
                'class' => \app\components\AccessFilter::className(),
                'only' => [
                    'admin', 'detalle', 'crear', 'actualizar', 'eliminar',
                    'eliminar-cargo', 'agrega-cargo', 'lista-cargos'
                ],
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

        return $this->render('index', [
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->asignarImagenGrupo();
            $model->save();

            return $this->redirect(['detalle', 'id' => $model->idGrupoInteres]);

        } else {
            return $this->render('crear', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Actualiza un modelo existente GrupoInteres.
     * si la actualizacion es exitosa el navegador redirige a la vista detalle.
     * @param string $id
     * @return mixed
     */
    public function actionActualizar($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $model->asignarImagenGrupo();
            $model->save();
            return $this->redirect(['detalle', 'id' => $model->idGrupoInteres]);

        } else {
            return $this->render('actualizar', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Borra un modelo existente GrupoInteres.
     * si la elimiancion es existosa el navegador redirige a la vista index (Listar).
     * @param string $id
     * @return mixed
     */
    public function actionEliminar($id) {
        $this->findModel($id)->delete();
        return $this->redirect(['admin']);
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
        $grupoInteresCargo = '';
        $grupo = '';

        if ($model->load(Yii::$app->request->post())) {

          $grupoInteresCargo = GrupoInteresCargo::listaCargos($idGrupo);
          $grupo = $this->findModel($idGrupo);


          if ($model->save()) {
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
     * consulta la lista de cargos a agregar en un grupo de interes
     * @param none
     * @return out = []
     *         out.id = indica el identificador del cargo
     *         out.text = nombre del cargo
     */
    public function actionListaCargos($search = null, $id = null) {
        $out = ['results' => [ 'id' => '', 'text' => '']];

        if (!is_null($search)) {
            // consulta cuando empieza a escribir
            $query = new Query;
            $query->select('idCargo as id, nombreCargo AS text')
                    ->from('m_Cargo')
                    ->where('nombreCargo LIKE "%' . $search . '%" and idCargo not in (select idCargo from m_GrupoInteresCargo)')
                    ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        } elseif ($id > 0) {

            // consulta cuando selecciona una opcion del a lista
            $out['results'] = ['id' => $id, 'text' => Cargo::findOne($id)->nombreCargo];
        } else {

            //consulta cuando da click en el campo
            $query = new Query;
            $query->select('idCargo as id, nombreCargo AS text')
                    ->from('m_Cargo')
                    ->where('nombreCargo LIKE "%' . $search . '%" and idCargo not in (select idCargo from m_GrupoInteresCargo)')
                    ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $out;
    }

    /**
     * Encuentra un modelo GrupoInteres basado en el valor de su llave primaria.
     * @param string $id
     * Si el modelo no es encontrado se arroja una exepcion HTTP 404.
     * @return un modelo GrupoInteres
     * @throws NotFoundHttpException si el modelo no es enconrado
     */
    protected function findModel($id) {
        if (($model = GrupoInteres::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
