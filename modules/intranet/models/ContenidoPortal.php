<?php

namespace app\modules\intranet\models;

use Yii;

/**
* This is the model class for table "t_contenidoportal".
*
* @property string $idContenido
* @property string $idPortal
*/
class ContenidoPortal extends \yii\db\ActiveRecord
{
  public static function tableName()
  {
    return 't_ContenidoPortal';
  }

  public function rules()
  {
    return [
      [['idContenido', 'idPortal'], 'required'],
      [['idContenido', 'idPortal'], 'integer']
    ];
  }

  public function attributeLabels()
  {
    return [
      'idContenido' => 'Id Contenido',
      'idPortal' => 'Id Portal',
    ];
  }
}
