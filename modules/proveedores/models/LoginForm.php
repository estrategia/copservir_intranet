<?php 
  namespace app\modules\proveedores\models;

  use Yii;
  use app\models\Usuario;
  use yii\base\Model;

  // use app\modules\proveedores\modules\visitamedica\models\Usuario as UsuarioProveedor
  /**
  * 
  */
  class LoginForm extends Model
  {
    public $username;
    public $password;
    private $_user = false;

    public function rules()
    {
      return [
      	[['username', 'password'], 'required'],
      	['password', 'validatePassword'],
      ];
    }

    public function attributeLabels()
    {
      return [
        'username' => 'Cédula',
        'password' => 'Contraseña',
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
        }else if($user->nombrePortal != \Yii::$app->getModule('proveedores')->id){
        	$this->addError($attribute, 'El usuario no es permitido');
        }
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