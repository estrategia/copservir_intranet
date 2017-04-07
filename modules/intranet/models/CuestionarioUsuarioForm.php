<?php

namespace app\modules\intranet\models;

use Yii;
use yii\base\Model;
//use models\User;
use app\models\Usuario;

/**
 * LoginForm is the model behind the login form.
 */
class CuestionarioUsuarioForm extends Model {

    public $numeroDocumento;

    /**
     * @return array the validation rules.
     */
    public function rules() {
        return [
            [['numeroDocumento',], 'required'],
        ];
    }

    public function attributeLabels() {
        return [
            'numeroDocumento' => 'Usuario',
        ];
    }

}
