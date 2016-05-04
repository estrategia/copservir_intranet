<?php

namespace app\modules\intranet\models;

use Yii;

/**
* This is the model class for table "t_MeGustaContenidos".
*
* @property string $idMeGusta
* @property string $idContenido
* @property string $idUsuario
* @property string $fechaRegistro
*/
class MeGustaContenidos extends \yii\db\ActiveRecord
{
  public static function tableName()
  {
    return 't_MeGustaContenidos';
  }

  public function rules()
  {
    return [
      [['idContenido', 'numeroDocumento', 'fechaRegistro'], 'required'],
      [['idContenido', 'numeroDocumento'], 'integer'],
      [['fechaRegistro'], 'safe']
    ];
  }

  public function attributeLabels()
  {
    return [
      'idContenido' => 'Id Contenido',
      'numeroDocumento' => 'Id Usuario',
      'fechaRegistro' => 'Fecha Registro',
    ];
  }

  // RELACIONES

  public function getObjUsuario(){
    return $this->hasOne(Usuario::className(), ['numeroDocumento' => 'numeroDocumento']);
  }
}
