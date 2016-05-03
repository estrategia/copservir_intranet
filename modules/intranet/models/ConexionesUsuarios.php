<?php

namespace app\modules\intranet\models;

use Yii;

/**
* This is the model class for table "t_conexionesusuarios".
*
* @property string $idConexion
* @property string $numeroDocumento
* @property string $fechaConexion
* @property string $ip
*/
class ConexionesUsuarios extends \yii\db\ActiveRecord
{
  /**
  * @inheritdoc
  */
  public static function tableName()
  {
    return 't_ConexionesUsuarios';
  }

  /**
  * @inheritdoc
  */
  public function rules()
  {
    return [
      [['numeroDocumento', 'fechaConexion', 'ip'], 'required'],
      [['numeroDocumento'], 'integer'],
      [['fechaConexion'], 'safe'],
      [['ip'], 'string', 'max' => 45]
    ];
  }

  /**
  * @inheritdoc
  */
  public function attributeLabels()
  {
    return [
      'idConexion' => 'Id Conexion',
      'numeroDocumento' => 'Id Usuario',
      'fechaConexion' => 'Fecha Conexion',
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
