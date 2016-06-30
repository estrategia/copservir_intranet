<?php

namespace app\modules\tarjetamas\models\formularios;

use Yii;
use yii\base\Model;
use app\models\Usuario;


class RegistroForm extends Model {

  public $username;
  private $_user = false;

  /**
  * @return array con las reglas de validación.
  */
  public function rules() {
    return [
      [['username'], 'required'],
      [['username'], 'integer'],
      ['username', 'validateUser'],
    ];
  }

  public function attributeLabels() {
    return [
      'username' => 'Digite la cedula',
    ];
  }

  /**
  * Valida si el usuario y esta registrado
  */
  public function validateUser($attribute, $params) {
    if (!$this->hasErrors()) {
      $user = $this->getUser();

      if ($user) {
        $this->addError($attribute, 'El Usuario ya se encuentra registrado');
      }
    }
  }

  /**
  * Encuentra un usuario por su [[username]]
  * @return User|null
  */
  public function getUser() {
    if ($this->_user === false) {
      $this->_user = Usuario::findByUsername($this->username);
    }

    return $this->_user;
  }

}
