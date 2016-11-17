<?php

namespace app\modules\intranet\models;

use Yii;

/**
* This is the model class for table "t_logdocumento".
*
* @property string $idLogDocumento
* @property string $idDocumento
* @property string $descripcion
* @property string $fechaCreacion
*
* @property MDocumento $idDocumento0
*/
class LogDocumento extends \yii\db\ActiveRecord
{
  public static function tableName()
  {
    return 't_LogDocumento';
  }

  public function rules()
  {
    return [
      [['idDocumento', 'descripcion', 'fechaCreacion'], 'required'],
      [['idDocumento'], 'integer'],
      [['descripcion'], 'string'],
      [['fechaCreacion'], 'safe'],
      //[['idDocumento'], 'exist', 'skipOnError' => true, 'targetClass' => Documento::className(), 'targetAttribute' => ['idDocumento' => 'idDocumento']],
    ];
  }

  public function attributeLabels()
  {
    return [
      'idLogDocumento' => 'Id Log Documento',
      'idDocumento' => 'Id Documento',
      'descripcion' => 'Descripcion',
      'fechaCreacion' => 'Fecha Creacion',
    ];
  }


  // RELACIONES

  public function getObjDocumento()
  {
    return $this->hasOne(Documento::className(), ['idDocumento' => 'idDocumento']);
  }
}
