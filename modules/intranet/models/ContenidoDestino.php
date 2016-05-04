<?php

namespace app\modules\intranet\models;

use Yii;

/**
* This is the model class for table "t_ContenidoDestino".
*
* @property string $idContenidoDestino
* @property string $idGrupoInteres
* @property integer $codigoCiudad
*/
class ContenidoDestino extends \yii\db\ActiveRecord
{
  public static function tableName()
  {
    return 't_ContenidoDestino';
  }

  public function rules()
  {
    return [
      [['idGrupoInteres', 'codigoCiudad', 'idContenido'], 'required'],
      [['idGrupoInteres', 'codigoCiudad', 'idContenido'], 'integer']
    ];
  }

  public function attributeLabels()
  {
    return [
      'idContenido' => 'Contenido',
      'idGrupoInteres' => 'Grupo Interes',
      'codigoCiudad' => 'Ciudad',
    ];
  }
}
