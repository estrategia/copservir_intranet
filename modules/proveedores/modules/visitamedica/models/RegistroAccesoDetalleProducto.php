<?php 
namespace app\modules\proveedores\modules\visitamedica\models;

/**
* 
*/
class RegistroAccesoDetalleProducto extends \yii\db\ActiveRecord
{
  
  public static function tableName()
  {
      return 't_VIMED_RegistroAccesoDetalleProducto';
  }


   public function rules()
  {
    return [
      [['codigoProducto', 'descripcionProducto', 'presentacionProducto', 'codigoCiudad', 'codigoSector', 'ip' ], 'required'],
      [['codigoProducto'], 'integer'],
      [['fechaConsulta'], 'safe'],
      [['ip'], 'string', 'max' => 45]
    ];
  }

  public function attributeLabels()
  {
    return [
      'codigoProducto' => 'Codigo producto',
      'descripcionProducto' => 'Descripcion producto',
      'presentacionProducto' => 'Presentacion producto',
      'codigoCidudad' => 'Codigo ciudad',
      'codigoSector' => 'Codigo sector',
      'fechaConsulta' => 'Fecha Consulta',
      'ip' => 'Ip',
    ];
  }

  public function getRealIp()
  {
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
  }
}
?>