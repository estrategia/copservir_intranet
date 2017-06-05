<?php 
    /**
    * 
    */
namespace app\modules\intranet\controllers;

use Yii;
use app\modules\intranet\models\ConexionesUsuarios;
use app\modules\intranet\models\LoginForm;


class LoginController extends \yii\web\Controller
{

    public function actionIndex() {
        $this->layout = 'loginLayout2';

        /*if (!\Yii::$app->user->isGuest) {
            return $this->redirect(['sitio/index']);

        }*/

        $model = new LoginForm();
        $model->scenario = 'login';

        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            // se guarda el registro de la conexion
            $objConexionesUsuario = new ConexionesUsuarios();
            $objConexionesUsuario->numeroDocumento = $model->username;
            $objConexionesUsuario->fechaConexion = date('YmdHis');
            $objConexionesUsuario->ip = $objConexionesUsuario->getRealIp(); //Yii::$app->getRequest()->getUserIP() ;
            $objConexionesUsuario->save();


          return $this->redirect(['sitio/index']);
        }

        return $this->render('autenticar', [
                    'model' => $model,
        ]);
    }
}
?>