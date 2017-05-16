<?php

namespace app\modules\intranet\models;

use Yii;

/**
* This is the model class for table "t_recuperacionclave".
*
* @property string $numeroDocumento
* @property string $recuperacionCodigo
* @property string $recuperacionFecha
*/
class RecuperacionClave extends \yii\db\ActiveRecord
{
  public static function tableName()
  {
    return 't_RecuperacionClave';
  }

  public function rules()
  {
    return [
      [['numeroDocumento', 'recuperacionCodigo', 'recuperacionFecha'], 'required'],
      [['numeroDocumento'], 'integer'],
      [['recuperacionFecha'], 'safe'],
      [['recuperacionCodigo'], 'string', 'max' => 45]
    ];
  }

  public function attributeLabels()
  {
    return [
      'numeroDocumento' => 'Id Usuario',
      'recuperacionCodigo' => 'Recuperacion Codigo',
      'recuperacionFecha' => 'Recuperacion Fecha',
    ];
  }
}
