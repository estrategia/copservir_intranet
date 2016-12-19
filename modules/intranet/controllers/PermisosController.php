<?php

namespace app\modules\intranet\controllers;

use Yii;
use yii\web\Controller;
use app\models\Usuario;//use app\modules\intranet\models\Usuario;
use app\modules\intranet\models\AuthAssignment;
use app\modules\intranet\models\UsuarioSearch;
use app\modules\intranet\models\Funciones;

class PermisosController extends Controller {
  public $defaultAction = 'admin';

  public function behaviors() {
    return [
      [
        'class' => \app\components\AccessFilter::className(),
        'only' => [
          'admin', 'usuario', 'render-lista', 'eliminar-rol',
        ],
      ],
      [
           'class' => \app\components\AuthItemFilter::className(),
           'only' => [
               'admin', 'usuario', 'elimina-rol'
           ],
           'authsActions' => [
             'admin' => 'intranet_permisos_admin',
             'usuario' => 'intranet_permisos_admin',
             'eliminar-rol' => 'intranet_permisos_admin',
           ]
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

  public function actionAdmin() {
    if (Yii::$app->user->identity->tienePermiso('intranet_admin-proveedores')) {
      throw new \yii\web\ForbiddenHttpException('Acceso no permitido.', 403);
    } else {
      $searchModel = new UsuarioSearch();
      $dataProviderUsuarios = $searchModel->search(Yii::$app->request->queryParams);

      return $this->render('lista-usuarios', [
        'dataProviderUsuarios' => $dataProviderUsuarios,
        'searchModel' => $searchModel
      ]);
    }
  }

  public function actionUsuario($id) {
    $autAssignment = new AuthAssignment;
    $usuario = Usuario::findByUsername($id);
    if (Yii::$app->user->identity->tienePermiso('intranet_permisos_admin')) {
      $roles = Yii::$app->authManager->getRolesByUser($id);

      if ($autAssignment->load(Yii::$app->request->post()) && $autAssignment->save()) {
        return $this->redirect(['usuario', 'id' => $id]);
      }

      return $this->render('permisos-usuario', [
        'autAssignment' => $autAssignment,
        'usuario' => $usuario,
        'roles' => $roles,
      ]);
    }

    if (Yii::$app->user->identity->tienePermiso('intranet_admin-proveedores')) {
      if ($usuario->nombrePortal != 'proveedores' || !(Funciones::esSubModulo($usuario->nombrePortal, 'proveedores'))) {
        throw new \yii\web\ForbiddenHttpException('Acceso no permitido.', 403);
      } else {
        $roles = Yii::$app->authManager->getRolesByUser($id);

        if ($autAssignment->load(Yii::$app->request->post()) && $autAssignment->save()) {
          return $this->redirect(['usuario', 'id' => $id]);
        }

        return $this->render('permisos-usuario', [
          'autAssignment' => $autAssignment,
          'usuario' => $usuario,
          'roles' => $roles,
        ]);
      }
    }
  }

  public function actionRenderLista($nombreRol) {
    $roles = [];
    if (isset($nombreRol)) {
      array_push($roles, Yii::$app->authManager->getRole($nombreRol));
    }

    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    $respond = [
      'result' => 'ok',
      'response' => $this->renderAjax('_listaPermisos', [
        'roles' => $roles,
      ]
      )];
      return $respond;
  }

  public function actionEliminarRol($nombreRol, $numeroDocumento) {
      $this->findModelAuthAssignment($nombreRol, $numeroDocumento)->delete();
      return $this->redirect(['usuario', 'id' => $numeroDocumento]);
  }

  protected function findModelAuthAssignment($nombreRol, $numeroDocumento) {
      if (($model = AuthAssignment::findOne([$nombreRol, $numeroDocumento])) !== null) {
        return $model;
      } else {
        throw new NotFoundHttpException('Rol no asignado a usuario.');
      }
  }

}
