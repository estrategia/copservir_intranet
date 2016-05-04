<?php

namespace app\modules\intranet\models;

use Yii;

/**
* This is the model class for table "m_Opcion".
*
* @property string $idOpcion
* @property string $nombrePermiso
* @property string $url
* @property integer $estado
* @property string $idMenu
*/
class Opcion extends \yii\db\ActiveRecord
{
  public static function tableName()
  {
    return 't_Opcion';
  }

  public function rules()
  {
    return [
      [[ 'url', 'idMenu'], 'required'],
      [['idMenu'], 'integer'],
      [['url'], 'string', 'max' => 255]
    ];
  }

  public function attributeLabels()
  {
    return [
      'idOpcion' => 'Id Opcion',
      'url' => 'Url',
      'idMenu' => 'Id Menu',
    ];
  }
}
