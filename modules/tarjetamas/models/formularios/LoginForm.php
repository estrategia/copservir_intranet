<?php

namespace app\modules\tarjetamas\models\formularios;

use Yii;
use yii\base\Model;
use app\models\Usuario;
use app\modules\intranet\models\AuthAssignment;

//use app\modules\tarjetamas\models\UsuarioTarjetaMas;

class LoginForm extends Model {

    public $username;
    public $password;
    public $password2;
    public $captcha;
    public $rememberMe = true;
    private $_user = false;

    /**
     * @return array con las reglas de validación.
     */
    public function rules() {
        return [

            [['username', 'password'], 'required'],
            [['username'], 'integer'],
            [['password', 'password2'], 'string', 'min' => 6],
            ['password2', 'required', 'on' => ['recuperar']],
            ['password2', 'required', 'on' => ['cambiarClave']],
            ['password2', 'compare', 'compareAttribute' => 'password', 'message' => 'Las contraseñas deben ser iguales'],
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword', 'on' => ['login']],
        ];
    }

    public function attributeLabels() {
        return [
            'username' => 'Cédula',
            'password' => 'Contraseña',
            'password2' => 'Confirmar contraseña',
            'rememberMe' => 'Recordar',
        ];
    }

    /**
     * Valida la password segun su valor en BD
     * @param string $attribute el atributo actual a validar
     * @param array $params parametros adicionales en pares nombre-valor dados en las reglas de validacion
     */
    public function validatePassword($attribute, $params) {

        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user) {
                $this->addError($attribute, 'Usuario no existe');
            } else if (!$this->checkPassword($user->contrasena)) {
                $this->addError($attribute, 'Contraseña incorrecta por favor verifica de nuevo');
            } else if ($user->estado != 1) {
                $this->addError($attribute, 'El usuario se encuentra inactivo');
            } else if ($user->codigoPerfil != \Yii::$app->params['PerfilesUsuario']['tarjetaMas']['codigo']) {
                $this->addError($attribute, 'El usuario no tiene permiso para iniciar sesion');
            }
        }
    }

    public function checkPassword($userPassword) {
        return md5($this->password) === $userPassword;
    }

    /**
     * Encuentra un usuario por su [[username]]
     * @return User|null
     */
    public function getUser() {
        if ($this->_user === false) {
            $this->_user = Usuario::findByUsername($this->username); //UsuarioTarjetaMas::findBy($this->username);
        }

        return $this->_user;
    }

    /**
     * loguea un usuario usando una vez dados su nombre de usuario and contraseña.
     * @return boolean indicando si el usuario ha iniciado sesion correctamente
     */
    public function login() {
        if ($this->validate()) {
            $objAuthAssignment = AuthAssignment::find()
                    ->where("item_name=:rol AND user_id=:usuario", [':rol' => \Yii::$app->params['PerfilesUsuario']['tarjetaMas']['permiso'], ':usuario' => $this->username])
                    ->one();
            if ($objAuthAssignment == null) {
                $objAuthAssignment = new AuthAssignment;
                $objAuthAssignment->user_id = $this->username;
                $objAuthAssignment->item_name = \Yii::$app->params['PerfilesUsuario']['tarjetaMas']['permiso'];
                $objAuthAssignment->created_at = strtotime(date('Y-m-d H:i:s'));
                $objAuthAssignment->save();
            }
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

}
