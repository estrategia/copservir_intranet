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
use yii\web\UploadedFile;
use yii\db\Query;
/**
 * GrupoInteresController implementa las acciones para el modelo GrupoInteres.
 */
class GrupoInteresController extends Controller {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lista todos los modelos Grupointeres.
     * @return mixed
     */
    public function actionListar() {
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
        $grupo =$this->findModel($id);
        $grupoInteresCargo = GrupoInteresCargo::listaCargos($id);

        return $this->render('detalle', [
                    'grupo' => $grupo,
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
            $model->imagenGrupo = UploadedFile::getInstances($model, 'imagenGrupo');


            if ($model->imagenGrupo) {
                foreach ($model->imagenGrupo as $file) {
                    $file->saveAs('img/gruposInteres/' . $file->baseName . '.' . $file->extension);
                }
                $model->imagenGrupo = $file->baseName . '.' . $file->extension;

                $model->save();
            }
            return $this->render('crear', [
                        'model' => $model,
            ]);
          //  return $this->redirect(['detalle', 'id' => $model->idGrupoInteres]);
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
            $model->imagenGrupo = UploadedFile::getInstances($model, 'imagenGrupo');

            if ($model->imagenGrupo) {
                foreach ($model->imagenGrupo as $file) {
                    $file->saveAs('img/gruposInteres/' . $file->baseName . '.' . $file->extension);
                }
                $model->imagenGrupo = $file->baseName . '.' . $file->extension;

                $model->save();
            }

          //  return $this->redirect(['detalle', 'id' => $model->idGrupoInteres]);
             return $this->render('crear', [
                        'model' => $model,
            ]);
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

        return $this->redirect(['listar']);
    }

    /**
     * Borra un registro de GrupoInteresCargo donde este ese cargo
     * si la elimiancion es existosa el navegador redirige a la vista index (Listar).
     * @param string $id
     * @return mixed
     */
    public function actionEliminarCargo() {

        $idCargo = Yii::$app->request->post('idCargo','');
        $idGrupoInteres = Yii::$app->request->post('idGrupo','');

        $grupoInteresCargo = GrupoInteresCargo::find()->where('( idCargo =:idCargo and idGrupoInteres =:idGrupoInteres )')
        ->addParams(['idCargo'=>$idCargo,'idGrupoInteres'=>$idGrupoInteres])
        ->one();

        ;

        $items = [
        'result' => 'error',
        ];

        if ($grupoInteresCargo->delete()) {


          $grupoInteresCargo = GrupoInteresCargo::listaCargos($idGrupoInteres);

          $items = [
              'result' => 'ok',
              'response' => $this->renderPartial('cargosGrupoInteres', [
                'grupoInteresCargo' => $grupoInteresCargo,
              ])
            ];
        }
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $items;
    }

    /**
     * accion para renderizar el modal de agregar cargos
     * @param none
     * @return items = []
     *         items.result = indica si todo se realizo bien o mal
     *         items.response = html para renderizar los cargos asociados a el grupo
     */
     public function actionAgregaCargo($idGrupo)
     {
        $model = new GrupoInteresCargo();
        $items = [
        'result' => 'error',
        ];

        $model->idCargo = Yii::$app->request->post('agregaCargos');
        $model->idGrupoInteres = $idGrupo;

        if ($model->save()) {
          
        $grupoInteresCargo = GrupoInteresCargo::listaCargos($idGrupo);

        $items = [
            'result' => 'ok',
            'response' => $this->renderPartial('cargosGrupoInteres', [
                'grupoInteresCargo' => $grupoInteresCargo,
             ]
        )];
        }
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $items;
     }

     /**
      * consulta la lista de cargos a agregar en un grupo de interes
      * @param none
      * @return out = []
      *         out.id = indica el identificador del cargo
      *         out.text = nombre del cargo
      */

      public function actionListaCargos($search = null, $id = null)
      {
        $out = ['results' => [ 'id' => '', 'text' => '']];

        if (!is_null($search)) {
            // consulta cuando empieza a escribir
            $query = new Query;
            $query->select('idCargo as id, nombreCargo AS text')
                ->from('m_Cargo')
                ->where('nombreCargo LIKE "%' . $search .'%" and idCargo not in (select idCargo from m_GrupoInteresCargo)')
                ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }
        elseif ($id > 0) {

            // consulta cuando selecciona una opcion del a lista
            $out['results'] = ['id' => $id, 'text' => Cargo::findOne($id)->nombreCargo];
        }
        else {

            //consulta cuando da click en el campo
            $query = new Query;
            $query->select('idCargo as id, nombreCargo AS text')
                ->from('m_Cargo')
                ->where('nombreCargo LIKE "%' . $search .'%" and idCargo not in (select idCargo from m_GrupoInteresCargo)')
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
