<?php

namespace app\modules\intranet\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class DatosForm extends Model {

    public $email;
    public $celular;
    public $residencia;

    /**
     * @return array the validation rules.
     */
    public function rules() {
        return [
            // username and password are both required
            [['email', 'celular','residencia'], 'required'],
            [['email'], 'email'],
            ['celular', 'integer' ],
            [['celular'], 'integer', 'min' =>10],
            [['residencia'], 'string', 'min' =>8],
        ];
    }

    public function attributeLabels() {
        return [
            'email' => 'Email',
            'celular' => 'Celular',
            'residencia' => 'Residencia',
        ];
    }


}
