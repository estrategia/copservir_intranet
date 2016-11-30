<?php 
  namespace app\modules\proveedores\models;

  use Yii;
  use app\models\Usuario;
  use yii\base\Model;
  use app\modules\intranet\models\Funciones;

  // use app\modules\proveedores\modules\visitamedica\models\Usuario as UsuarioProveedor
  /**
  * 
  */
  class LoginForm extends Model
  {
    public $username;
    public $password;
    public $password2;
    public $captcha;
    private $_user = false;

    public function rules()
    {
      return [
        ['captcha', 'captcha', 'captchaAction' => 'proveedores/usuario/captcha', 'on' => ['recuperar']],
        ['captcha', 'captcha', 'captchaAction' => 'proveedores/usuario/captcha', 'on' => ['cambiarClave']],
      	[['username', 'password'], 'required'],
        ['password2', 'required', 'on' => ['recuperar']],
        ['password2', 'required', 'on' => ['cambiarClave']],
        //['captcha', 'captcha', 'on' => ['recuperar','cambiarClave']],
        ['password2', 'compare', 'compareAttribute' => 'password', 'message' => 'Las contraseñas deben ser iguales'],
        ['password', 'validatePassword', 'on' => ['login']],
        // ['password', 'validateUser', 'on' => ['login']],

      ];
    }

    public function attributeLabels()
    {
      return [
        'username' => 'Cédula',
        'captcha' => 'Captcha',
        'password' => 'Contraseña',
        'password2' => 'Confirmar contraseña',
      ];
    }

    public function validatePassword($attribute, $params) {
      if (!$this->hasErrors()) {
        $user = $this->getUser();
        
        if (!$user) {
            $this->addError($attribute, 'Usuario no existe');
        } else if (!$this->checkPassword($user->contrasena)) {
            $this->addError($attribute, 'Contraseña incorrecta por favor verifica de nuevo');
        } else if ($user->estado != 1) {
            $this->addError($attribute, 'El usuario se encuentra inactivo');

        }else if(($user->nombrePortal != \Yii::$app->controller->module->id) && (!Funciones::esSubModulo($user->nombrePortal))){
          $this->addError($attribute, 'El usuario no es permitido');
        }
        // }else if($user->nombrePortal != \Yii::$app->getModule('proveedores')->id){
        // 	$this->addError($attribute, 'El usuario no es permitido');
        // }
        // else if ($user->codigoPerfil != \Yii::$app->params['PerfilesUsuario']['tarjetaMas']['codigo']) {
        //     $this->addError($attribute, 'El usuario no tiene permiso para iniciar sesion');
        // }
      }
    }

    public function checkPassword($userPassword) {
      return md5($this->password) === $userPassword;
    }

    public function getUser()
    {
      if ($this->_user === false) {
        $this->_user = Usuario::find()->where('numeroDocumento=:documento', [':documento' => $this->username])->with('objUsuarioProveedor')->one(); //UsuarioTarjetaMas::findBy($this->username);
      }
      return $this->_user;
    }

    public function login()
    {
      if ($this->validate()) {
        return Yii::$app->user->login($this->getUser(), 0);
      } else {
        return false;
      }
    }
  }
?>