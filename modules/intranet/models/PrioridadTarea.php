<?php

namespace app\modules\intranet\models;

use Yii;

/**
* This is the model class for table "m_prioridadtarea".
*
* @property integer $idPrioridadTarea
* @property string $nombre
*/
class PrioridadTarea extends \yii\db\ActiveRecord
{
  const ESTADO_ACTIVO = 1;
  const ESTADO_INACTIVO = 0;
  
  public static function tableName()
  {
    return 'm_PrioridadTarea';
  }

  public function rules()
  {
    return [
      [['nombre', 'estado'], 'required'],
      [['idPrioridadTarea', 'estado'], 'integer'],
      [['nombre'], 'string', 'max' => 45]
    ];
  }

  public function attributeLabels()
  {
    return [
      'idPrioridadTarea' => 'Id Prioridad Tarea',
      'nombre' => 'Nombre',
      'Estado' => 'Estado'
    ];
  }
}
