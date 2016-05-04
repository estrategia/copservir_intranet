<?php

namespace app\modules\intranet\models;

use Yii;

/**
* This is the model class for table "t_denuncioscontenidos".
*
* @property string $idDenuncioContenido
* @property string $idContenido
* @property string $descripcionDenuncio
* @property string $numeroDocumento
* @property string $fechaRegistro
* @property integer $estado
* @property string $fechaActualizacion
*
* @property TContenido $idContenido0
* @property MUsuario $numeroDocumento0
*/
class DenunciosContenidos extends \yii\db\ActiveRecord
{
  // estados
  const PENDIENTE_APROBACION = 1;
  const APROBADO = 2;
  const ELIMINADO = 3;

  public static function tableName()
  {
    return 't_DenunciosContenidos';
  }

  public function rules()
  {
    return [
      [['idContenido', 'descripcionDenuncio', 'numeroDocumento', 'fechaRegistro', 'estado', 'fechaActualizacion'], 'required'],
      [['idContenido', 'numeroDocumento', 'estado'], 'integer'],
      [['descripcionDenuncio'], 'string'],
      [['fechaRegistro', 'fechaActualizacion'], 'safe'],
      [['idContenido'], 'exist', 'skipOnError' => true, 'targetClass' => Contenido::className(), 'targetAttribute' => ['idContenido' => 'idContenido']],
      [['numeroDocumento'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['numeroDocumento' => 'numeroDocumento']],
    ];
  }

  public function attributeLabels()
  {
    return [
      'idDenuncioContenido' => 'Id Denuncio Contenido',
      'idContenido' => 'Id Contenido',
      'descripcionDenuncio' => 'Descripcion Denuncio',
      'numeroDocumento' => 'Numero Documento',
      'fechaRegistro' => 'Fecha Registro',
      'estado' => 'Estado',
      'fechaActualizacion' => 'Fecha Actualizacion',
    ];
  }


  //RELACIONES

  public function getObjUsuario()
  {
    return $this->hasOne(Usuario::className(), ['numeroDocumento' => 'numeroDocumento']);
  }
}
