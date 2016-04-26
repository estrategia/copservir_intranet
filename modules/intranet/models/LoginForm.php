<?php

namespace app\modules\intranet\models;

use Yii;
use yii\base\Model;
//use models\User;

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
            ['captcha', 'captcha','captchaAction'=>'intranet/usuario/captcha',  'on' => ['recuperar','cambiarClave']],
            // username and password are both required
            [['username', 'password'], 'required'],
         //   [["captcha",],"required", "when" => $this->form == 'recuperar'],
            [['password','password2'], 'string', 'min' =>6],
            ['password2', 'required', 'on' => ['cambiarClave']],
            //['captcha', 'captcha', 'on' => ['recuperar','cambiarClave']],
            ['password2', 'compare', 'compareAttribute'=>'password', 'message'=>'Las contraseñas deben ser iguales'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
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
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params) {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user) {
                $this->addError($attribute, 'Usuario no existe');
            } else if (!$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Contraseña incorrecta por favor verifica de nuevo');
            }/* else if($user->estado != 1){
              $this->addError($attribute, 'El usuario se encuentra inactivo');
              } */
        }
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

}
