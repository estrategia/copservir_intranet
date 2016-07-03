<?php

namespace app\modules\intranet\models;

use Yii;

/**
* This is the model class for table "t_Indicadores".
*
* @property string $idIndicador
* @property string $colorFondo
* @property string $descripcion
* @property string $valor
* @property string $textoComplementario
*/
class Indicadores extends \yii\db\ActiveRecord
{
  const ESTADO_ACTIVO = 1;
  const ESTADO_INACTIVO = 0;
  
  public static function tableName()
  {
    return 't_Indicadores';
  }

  public function rules()
  {
    return [
      [['estado', 'colorFondo', 'descripcion', 'valor', 'textoComplementario'], 'required'],
      [['colorFondo'], 'string', 'max' => 8],
      [['descripcion'], 'string', 'max' => 60],
      [['valor'], 'string', 'max' => 100],
      [['estado'], 'integer'],
      [['textoComplementario'], 'string', 'max' => 255]
    ];
  }

  public function attributeLabels()
  {
    return [
      'idIndicador' => 'Id Indicador',
      'colorFondo' => 'Color Fondo',
      'descripcion' => 'Descripcion',
      'valor' => 'Valor',
      'textoComplementario' => 'Texto Complementario',
    ];
  }
}
