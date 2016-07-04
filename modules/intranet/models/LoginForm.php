<?php

namespace app\modules\intranet\models;

use Yii;
use yii\base\Model;
//use models\User;
use app\models\Usuario;
/**
* LoginForm is the model behind the login form.
*/
class LoginForm extends Model {

  public $username;
  public $password;
  public $password2;
  public $captcha;
  public $form;
  public $rememberMe = true;
  private $_user = false;

  /**
  * @return array the validation rules.
  */
  public function rules() {
    return [
      ['captcha', 'captcha','captchaAction'=>'intranet/usuario/captcha',  'on' => ['recuperar']],
      ['captcha', 'captcha','captchaAction'=>'intranet/usuario/captcha',  'on' => ['cambiarClave']],
      // username and password are both required
      [['username', 'password'], 'required'],
      //   [["captcha",],"required", "when" => $this->form == 'recuperar'],
      [['password','password2'], 'string', 'min' =>6],
      ['password2', 'required', 'on' =>  ['recuperar']],
      ['password2', 'required', 'on' =>  ['cambiarClave']],
      //['captcha', 'captcha', 'on' => ['recuperar','cambiarClave']],
      ['password2', 'compare', 'compareAttribute'=>'password', 'message'=>'Las contraseñas deben ser iguales'],
      // rememberMe must be a boolean value
      ['rememberMe', 'boolean'],
      // password is validated by validatePassword()
      ['password', 'validatePassword', 'on' => ['login']],
      //['password', 'validatePassword', 'on' => ['cambiarClave']],
      // valida que el usuario exista
      ['password', 'validateUser', 'on' => ['login']],
      //['password', 'validateUser', 'on' => ['cambiarClave']],
    ];
  }

  public function attributeLabels() {
    return [
      'username' => 'Usuario',
      'captcha' => 'Captcha',
      'password' => 'Contraseña',
      'password2' => 'Confirmar contraseña',
      'rememberMe' => 'Recordar',
    ];
  }

  /**
  * Valida el username y el password llamando a un web service
  * @param string $attribute el atributo actual a validar
  * @param array $params parametros adicionales en pares nombre-valor dados en las reglas de validacion
  */
  public function validatePassword($attribute, $params) {
    $resultWebServicesLogin = self::callWSLogin($this->username, $this->password);

    if ($resultWebServicesLogin['result'] == 3) {
      //$user = $this->getUser();
    }else if ($resultWebServicesLogin['result'] == 0) {
        $this->addError($attribute, 'Usuario no existe');
    }else if ($resultWebServicesLogin['result'] == 1) {
        $this->addError($attribute, 'El usuario se encuentra inactivo');
    }else if ($resultWebServicesLogin['result'] == 2) {
        $this->addError($attribute, 'Contraseña incorrecta por favor verifica de nuevo');
    }

    /*
    if (!$this->hasErrors()) {
      $user = $this->getUser();

      if (!$user) {
        $this->addError($attribute, 'Usuario no existe');
      } else if (!$user->validatePassword($this->password)) {
        $this->addError($attribute, 'Contraseña incorrecta por favor verifica de nuevo');
      }/* else if($user->estado != 1){
        $this->addError($attribute, 'El usuario se encuentra inactivo');
      } /
    }*/
  }

/**
* Funcion para consumir el web services de login
* @param string $username, string password
* @return array['result'],
*/
  public static function callWSLogin($username, $password)
  {
    $client = new \SoapClient(\Yii::$app->params['webServices']['persona'], array(
        "trace" => 1,
        "exceptions" => 0,
        'connection_timeout' => 5,
        'cache_wsdl' => WSDL_CACHE_NONE
    ));

    try {

        $result = $client->getLogin($username, sha1($password));
        return $result;

    } catch (SoapFault $exc) {
      $this->addError('password', 'ha ocurrido un error');
    } catch (Exception $exc) {
      $this->addError('password', 'ha ocurrido un error');
    }
  }

  /**
  * Valida si un usuario existe o no tanto en la BD como a traves del WS
  * @param $attribute,  $params
  */
  public function validateUser($attribute, $params)
  {
    $user = $this->getUser();

    if (!$user) {
      $this->asignarDatosNuevoUsuario();
    }

    $generoDatos = $this->_user->generarDatos();

    if (!$generoDatos) {
      $this->addError($attribute, 'El usuario no existe');
    }else{

      if ($this->_user->isNewRecord) {
          $this->asignarAliasUsuario();
          $this->_user->save();
      }else{
        if ($user->codigoPerfil != \Yii::$app->params['PerfilesUsuario']['intranet']['codigo']) {
          $this->addError($attribute, 'El usuario no tiene permiso para iniciar sesion');
        }
      }

    }

  }

  /**
  * Finds user by [[username]]
  *
  * @return User|null
  */
  public function getUser() {
    if ($this->_user === false) {
      $this->_user = Usuario::findByUsername($this->username);
    }

    return $this->_user;
  }

  /**
  * Crea un nuevo ususario si no hay uno en la BD
  */
  private function asignarDatosNuevoUsuario()
  {
    $this->_user = new Usuario;
    $this->_user->numeroDocumento = $this->username;
    $this->_user->alias = $this->username;
    $this->_user->estado = Usuario::ESTADO_ACTIVO;
    $this->_user->codigoPerfil = \Yii::$app->params['PerfilesUsuario']['intranet']['codigo'];
  }

  /*
  * Asigna un alias al usuario si el usuario no se encuentra en BD pero genero datos
  * a traves del WS
  */
  private function asignarAliasUsuario()
  {
    $nombres = $this->_user->getNombres();
    $primerApellido =  $this->_user->getPrimerApellido();
    $segundoApellido2 =  $this->_user->getSegundoApellido();

    $alias = '';
    $nombres = explode(" ", $nombres);

    foreach($nombres as $n){
      $alias .= $n[0];
    }

    $alias .= $primerApellido;
    if(!empty($segundoApellido)){
     $alias .= $segundoApellido[0];
    }
    $this->_user->alias = $alias;
  }

  /**
  * Logs in a user using the provided username and password.
  * @return boolean whether the user is logged in successfully
  */
  public function login() {

    if ($this->validate()) {
      return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
    } else {
      return false;
    }
  }
}
