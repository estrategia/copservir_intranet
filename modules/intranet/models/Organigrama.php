<?php

namespace app\models;

use Yii;

/**
* This is the model class for table "m_Organigrama".
*
* @property string $idOrganigrama
* @property string $idCargo
* @property string $numeroDocumento
* @property string $idOrganigramaPadre
*/
class Organigrama extends \yii\db\ActiveRecord
{
  public static function tableName()
  {
    return 'm_Organigrama';
  }

  public function rules()
  {
    return [
      [['idCargo', 'numeroDocumento'], 'required'],
      [['idCargo', 'numeroDocumento', 'idOrganigramaPadre'], 'integer']
    ];
  }

  public function attributeLabels()
  {
    return [
      'idOrganigrama' => 'Id Organigrama',
      'idCargo' => 'Id Cargo',
      'numeroDocumento' => 'Numero Documento',
      'idOrganigramaPadre' => 'Id Organigrama Padre',
    ];
  }


}
