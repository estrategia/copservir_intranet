<?php

namespace app\modules\intranet\models;

use Yii;

/**
* This is the model class for table "m_AreasOrganigrama".
*
* @property string $idArea
* @property string $idOrganigrama
*/
class AreasOrganigrama extends \yii\db\ActiveRecord
{
  /**
  * @inheritdoc
  */
  public static function tableName()
  {
    return 'm_AreasOrganigrama';
  }

  /**
  * @inheritdoc
  */
  public function rules()
  {
    return [
      [['idArea', 'idOrganigrama'], 'required'],
      [['idArea', 'idOrganigrama'], 'integer']
    ];
  }

  /**
  * @inheritdoc
  */
  public function attributeLabels()
  {
    return [
      'idArea' => 'Id Area',
      'idOrganigrama' => 'Id Organigrama',
    ];
  }
}
