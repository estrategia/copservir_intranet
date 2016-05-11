<?php

namespace app\modules\intranet\models;

use Yii;

/**
* This is the model class for table "t_lineastiempo".
*
* @property string $idLineaTiempo
* @property string $nombreLineaTiempo
* @property string $color
* @property string $descripcion
* @property string $icono
* @property integer $estado
* @property integer $autorizacionAutomatica
*/
class LineaTiempo extends \yii\db\ActiveRecord
{
  const LINEA_CON_COMENTARIOS = 0;
  const LINEA_SIN_COMENTARIOS = 1;
  const AUTORIZACION_AUTOMATICA = 1;

  const MIS_PUBLICACIONES = 2;

  public static function tableName()
  {
    return 't_LineasTiempo';
  }

  public function rules()
  {
    return [
      [['nombreLineaTiempo', 'estado'], 'required'],
      [['estado', 'autorizacionAutomatica', 'solicitarGrupoObjetivo'], 'integer'],
      [['nombreLineaTiempo', 'icono'], 'string', 'max' => 45],
      [['color'], 'string', 'max' => 7],
      [['descripcion'], 'string', 'max' => 200],
    ];
  }

  public function attributeLabels()
  {
    return [
      'idLineaTiempo' => 'Id Linea Tiempo',
      'nombreLineaTiempo' => 'Nombre Linea Tiempo',
      'estado' => 'Estado',
      'autorizacionAutomatica' => 'Autorizacion Automatica',
      'solicitarGrupoObjetivo' => "Solicitar Grupo Objetivo",
      'color' => 'Color',
      'icono' => 'Icono',
      'descripcion' => 'Descripción',
    ];
  }

  //FUNCIONES

  /**
  * verifica si una linea de tiempo tiene autorizacion automatica en sus publicaciones
  * @return boolean true || false
  */
  public function tieneAutorizacionAutomatica()
  {
    if ($this->autorizacionAutomatica == LineaTiempo::AUTORIZACION_AUTOMATICA) {
      return true;
    }else{
      return false;
    }
  }

  public static function encontrarModelo($id)
  {
    $model = self::find()->where(['idLineaTiempo' => $id])->one();

    if ( $model !== null) {
      return $model;
    } else {
      throw new NotFoundHttpException('el modelo no existe.');
    }
  }
}
