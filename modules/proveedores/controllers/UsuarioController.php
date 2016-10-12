<?php 
namespace app\modules\proveedores\controllers;

use Yii;
use yii\web\Controller;
use app\modules\proveedores\models\LoginForm;
use app\modules\intranet\models\ConexionesUsuarios;

/**
* 
*/
class UsuarioController extends Controller
{
 public function actionAutenticar() {

    $model = new LoginForm();
    // $model->scenario = 'login';

    if ($model->load(Yii::$app->request->post()) && $model->login()) {
      $objConexionesUsuario = new ConexionesUsuarios();
      $objConexionesUsuario->numeroDocumento = $model->username;
      $objConexionesUsuario->fechaConexion = date('YmdHis');
      $objConexionesUsuario->ip = $objConexionesUsuario->getRealIp(); //Yii::$app->getRequest()->getUserIP() ;
      $objConexionesUsuario->save();
      return $this->redirect(['/proveedores/visitamedica/productos/buscar']);
    }

    return $this->render('/sitio/login', [
      'model' => $model,
    ]);
  }
}
  
?>