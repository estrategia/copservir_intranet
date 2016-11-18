<?php

namespace app\modules\intranet\models;

use Yii;
use yii\base\Model;

/**
* LoginForm is the model behind the login form.
*/
class DataTableForm extends Model {

  public $archivo;

  /**
  * @return array the validation rules.
  */
  public function rules() {
    return [
      // username and password are both required
      [['archivo'], 'required'],
      [['archivo'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xls, xlsx'],
    ];
  }

  public function attributeLabels() {
    return [
      'archivo' => 'Documento',
    ];
  }


}
