<?php

namespace app\modules\intranet\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class FotoForm extends Usuario {

    public $imagenPerfil;
    public $imagenFondo;
    public $crop_info;

    /**
     * @return array the validation rules.
     */
    public function rules() {

        // username and password are both required
        return [
            [ ['imagenPerfil'], 'file',
                'skipOnEmpty' => true,
                //'uploadRequired' => 'No has seleccionado ningún archivo', //Error
                'maxSize' => 1024 * 1024 * 2, //2 MB
                'tooBig' => 'El tamaño máximo permitido es 2MB', //Error
                'minSize' => 10, //10 Bytes
                'tooSmall' => 'El tamaño mínimo permitido son 10 BYTES', //Error
                'extensions' => 'jpg, png, jpeg',
                'wrongExtension' => 'El archivo {file} no contiene una extensión permitida {extensions}', //Error
                'maxFiles' => 1,
                'tooMany' => 'El máximo de archivos permitidos son {limit}', //Error
            ],
            ['crop_info', 'safe'],
        ];
    }

    public function attributeLabels() {
        return [
            'imagenPerfil' => 'Cambiar imagen perfil',
            'imagenFondo' => 'Cambiar imagen fondo',
        ];
    }

}
