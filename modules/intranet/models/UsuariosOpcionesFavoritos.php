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
  public static function tableName()
  {
    return 't_UsuariosOpcionesFavoritos';
  }

  public function rules()
  {
    return [
      [['idMenu', 'numeroDocumento'], 'required'],
      [['idMenu', 'numeroDocumento'], 'integer']
    ];
  }

  public function attributeLabels()
  {
    return [
      'idMenu' => 'Id Menu',
      'numeroDocumento' => 'Usuario',
    ];
  }

  //RELACIONES
  
  public function getObjMenu()
  {
    return $this->hasOne(Menu::className(), ['idMenu' => 'idMenu']);
  }
}
