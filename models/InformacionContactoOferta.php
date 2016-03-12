<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "t_InformacionContactoOferta".
 *
 * @property string $idInformacionContacto
 * @property string $plantillaContactoHtml
 * @property integer $estado
 * @property string $fechaRegistro
 * @property integer $usuarioRegistro
 */
class InformacionContactoOferta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_InformacionContactoOferta';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['plantillaContactoHtml', 'estado'], 'required'],
            [['plantillaContactoHtml'], 'string'],
            [['estado', 'usuarioRegistro'], 'integer'],
            [['fechaRegistro'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idInformacionContacto' => 'Id Informacion Contacto',
            'plantillaContactoHtml' => 'Plantilla Contacto Html',
            'estado' => 'Estado',
            'fechaRegistro' => 'Fecha Registro',
            'usuarioRegistro' => 'Usuario Registro',
        ];
    }
}
