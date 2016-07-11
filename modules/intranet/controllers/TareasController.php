<?php

namespace app\modules\intranet\controllers;

use Yii;
use app\modules\intranet\models\Tareas;
use app\modules\intranet\models\LogTareas;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TareasController implements the CRUD actions for Tareas model.
 */
class TareasController extends Controller {

    public $layout = 'main';

    public function behaviors() {
        return [
            [
                'class' => \app\components\AccessFilter::className(),
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * accion para renderizar la vista tareas
     * @param none
     * @return mixed
     */
    public function actionListarTareas() {
        $numeroDocumento = Yii::$app->user->identity->numeroDocumento;
        $tareasUsuario = Tareas::getTareasListar($numeroDocumento);
        return $this->render('listarTareas', ['tareasUsuario' => $tareasUsuario]);
    }

    /**
     * crea una nueva tarea y guarda un log de la tarea
     * Si una tarea se crea con exito redirige a la lista de tareas
     * @param none
     * @return mixed
     */
    public function actionCrear() {
        $modelTarea = new Tareas();
        if ($modelTarea->load(Yii::$app->request->post())) {
            if ($modelTarea->validate()) {
                $transaction = Tareas::getDb()->beginTransaction();
                try {
                    if ($modelTarea->save()) {
                        $transaction->commit();
                        return $this->redirect('listar-tareas');
                    }
                } catch (\Exception $e) {

                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', $e->getMessage());
                    throw $e;
                }
            }
        }
        return $this->render('crear', [
                    'model' => $modelTarea,
        ]);
    }

    /**
     * actualiza una tarea existente y guarda un log de la tarea
     * Si una tarea se crea con exito redirige a la lista de tareas
     * @param string $id
     * @return mixed
     */
    public function actionActualizar($id) {

        $modelTarea = $this->encontrarModelo($id);

        if ($modelTarea->load(Yii::$app->request->post())) {
            if ($modelTarea->validate()) {
                $transaction = Tareas::getDb()->beginTransaction();
                try {
                    if ($modelTarea->save()) {
                        //ejecuta la transaccion
                        $transaction->commit();
                        return $this->redirect('listar-tareas');
                    };
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', $e->getMessage());
                    throw $e;
                }
            }
        }

        return $this->render('actualizar', [
                    'model' => $modelTarea,
        ]);
    }

    /**
     * cambia el estado de una tarea existente a inactivo o  dependiendo del lugar de la peticion
     * @param POST => idtarea, location = indica de donde se esta enviando la peticion - 1 indica que viene del home
     * @return mixed
     */
    public function actionEliminar() {

        $idTarea = Yii::$app->request->post('idTarea', '');
        $location = Yii::$app->request->post('location', '');
        $modelTarea = $this->encontrarModelo($idTarea);
        $viewRenderTarea = '';
        $respond = [];

        $transaction = Tareas::getDb()->beginTransaction();
        try {

            $modelTarea->setEstadoDependingLocation($location);
            $viewRenderTarea = $modelTarea->getRenderViewDependingLocation($location);

            if ($modelTarea->save()) {

                $transaction->commit();
                $tareasUsuario = $modelTarea->getTareasDependingLocation($location);
                $respond = [
                    'result' => 'ok',
                    'location' => $location,
                    'response' => $this->renderAjax($viewRenderTarea, [
                        'tareasUsuario' => $tareasUsuario,
                    ])
                ];
            }
        } catch (\Exception $e) {

            $transaction->rollBack();
            $tareasUsuario = $modelTarea->getTareasDependingLocation($location);
            $respond = [
                'result' => 'error',
                'error' => 'la tarea no se pudo eliminar',
                'location' => $location,
                'response' => $this->renderAjax($viewRenderTarea, [
                    'tareasUsuario' => $tareasUsuario,
                ])
            ];
            throw $e;
        }
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $respond;
    }

    /**
     * actualizar el progreso de una tarea cuando mueven el slider en la lista de tareas
     *  o checkea una tarea en el home, guarda un log de la tarea
     * @param POST => idtarea
     * @return mixed
     */
    public function actionActualizarProgreso() {
        $flagHome = Yii::$app->request->post('flagHome', '');
        $idTarea = Yii::$app->request->post('idTarea', '');
        $progresoTarea = Yii::$app->request->post('progresoTarea', '');
        $modelTarea = $this->encontrarModelo($idTarea);
        $respond = [];

        $transaction = Tareas::getDb()->beginTransaction();
        try {
            $modelTarea->progreso = $progresoTarea;
            $modelTarea->setEstadoDependingProgress();
            if ($modelTarea->save()) {

                $transaction->commit();
                $numeroDocumento = Yii::$app->user->identity->numeroDocumento;
                if ($flagHome == 'true') {
                    $tareasUsuario = Tareas::getTareasIndex($numeroDocumento);
                    $respond = [
                        'result' => 'ok',
                        'response' => $this->renderAjax('_tareasHome', [
                            'tareasUsuario' => $tareasUsuario,
                                ]
                    )];
                } else {
                    $respond = [
                        'result' => 'ok',
                    ];
                }
            }
        } catch (\Exception $e) {

            //devuelve los cambios
            $transaction->rollBack();
            //devuelve mensajes de error
            $respond = [
                'result' => 'error',
                'error' => 'no se pudo actualizar el progreso'
            ];
            throw $e;
        }

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $respond;
    }

    /**
     * devuelve la tarea a su ultimo estado segun el log y guarda un log del nuevo estado de la tarea
     * @param POST => idtarea
     * @return mixed
     * @throws
     */
    public function actionUncheckHome() {
        $idTarea = Yii::$app->request->post('idTarea');
        $numeroDocumento = Yii::$app->user->identity->numeroDocumento;
        $modelTarea = $this->encontrarModelo($idTarea);

        $transaction = Tareas::getDb()->beginTransaction();
        try {
            $modelTarea->volverUltimaInstanciaTarea();
            if ($modelTarea->save()) {
                $transaction->commit();
                $tareasUsuario = Tareas::getTareasIndex($numeroDocumento);
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                $respond = [
                    'result' => 'ok',
                    'response' => $this->renderAjax('_tareasHome', [
                        'tareasUsuario' => $tareasUsuario,
                            ]
                )];
            }
        } catch (\Exception $e) {

            $transaction->rollBack();
            $tareasUsuario = Tareas::getTareasIndex($numeroDocumento);
            $respond = [
                'result' => 'error',
                'error' => 'no se pudo devolver la tarea a su estado anterior',
                'response' => $this->renderAjax('_tareasHome', [
                    'tareasUsuario' => $tareasUsuario,
                        ]
            )];
            throw $e;
        }
        return $respond;
    }

    /**
     * encuentra una tarea por su llave primaria
     * si el modelo no existe manda un 404
     * @param string $id
     * @return Tareas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function encontrarModelo($id) {
        if (($model = Tareas::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
