<?php

namespace app\modules\intranet\models;

use Yii;

/**
 * This is the model class for table "t_UsuariosOpcionesFavoritos".
 *
 * @property string $idMenu
 * @property string $idUsuario
 */
class UsuariosOpcionesFavoritos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_UsuariosOpcionesFavoritos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idMenu', 'idUsuario'], 'required'],
            [['idMenu', 'idUsuario'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idMenu' => 'Id Menu',
            'idUsuario' => 'Id Usuario',
        ];
    }

     public function getObjMenu()
    {
        return $this->hasOne(Menu::className(), ['idMenu' => 'idMenu']);
    }
}
