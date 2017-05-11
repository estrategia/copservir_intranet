<?php

namespace app\modules\intranet\models;

use Yii;

/**
 * This is the model class for table "t_UsuariosMenuInactivo".
 *
 * @property integer $idMenu
 * @property integer $numeroDocumento
 *
 * @property Usuario $objUsuario
 * @property Menu $objMenu
 */
class UsuariosMenuInactivo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_UsuariosMenuInactivo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idMenu', 'numeroDocumento'], 'required'],
            [['idMenu', 'numeroDocumento'], 'integer'],
            //[['numeroDocumento'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['numeroDocumento' => 'numeroDocumento']],
            //[['idMenu'], 'exist', 'skipOnError' => true, 'targetClass' => Menu::className(), 'targetAttribute' => ['idMenu' => 'idMenu']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idMenu' => 'Id Menu',
            'numeroDocumento' => 'Numero Documento',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObjUsuario()
    {
        return $this->hasOne(Usuario::className(), ['numeroDocumento' => 'numeroDocumento']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObjMenu()
    {
        return $this->hasOne(Menu::className(), ['idMenu' => 'idMenu']);
    }
}
