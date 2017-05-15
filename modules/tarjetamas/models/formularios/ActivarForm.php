<?php

namespace app\modules\tarjetamas\models\formularios;

use Yii;
use yii\base\Model;
use app\models\Usuario;


class ActivarForm extends Model {

  public $numeroTarjeta;

  /**
  * @return array con las reglas de validación.
  */
  public function rules() {
    return [
      [['numeroTarjeta'], 'required'],
      [['numeroTarjeta'], 'integer'],
    ];
  }

  public function attributeLabels() {
    return [
      'numeroTarjeta' => 'Digite la tarjeta',
    ];
  }

}
