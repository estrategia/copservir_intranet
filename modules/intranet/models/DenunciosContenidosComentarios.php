<?php

namespace app\modules\intranet\models;

use Yii;
use app\models\Usuario;
/**
* This is the model class for table "t_DenunciosContenidosComentarios".
*
* @property string $idDenuncioComentario
* @property string $idContenidoComentario
* @property string $descripcionDenuncio
* @property string $numeroDocumento
* @property string $fechaRegistro
*/
class DenunciosContenidosComentarios extends \yii\db\ActiveRecord
{

  // estados
  const PENDIENTE_APROBACION = 1;
  const APROBADO = 2;
  const ELIMINADO = 3;

  public static function tableName()
  {
    return 't_DenunciosContenidosComentarios';
  }

  public function rules()
  {
    return [
      [['idContenidoComentario', 'descripcionDenuncio', 'numeroDocumento', 'fechaRegistro'], 'required'],
      [['idContenidoComentario', 'estado', 'numeroDocumento'], 'integer'],
      [['descripcionDenuncio'], 'string'],
      [['fechaRegistro', 'fechaActualizacion'], 'safe']
    ];
  }

  public function attributeLabels()
  {
    return [
      'idDenuncioComentario' => 'Id Denuncio Comentario',
      'idContenidoComentario' => 'Id Contenido Comentario',
      'descripcionDenuncio' => 'Descripcion Denuncio',
      'numeroDocumento' => 'Usuario Denunciante',
      'fechaRegistro' => 'Fecha Registro',
    ];
  }

  // RELACIONES

  public function getObjContenido()
  {
    return $this->hasOne(Contenido::className(), ['idContenido' => 'idContenidoComentario']);
  }

  public function getObjUsuario()
  {
    return $this->hasOne(Usuario::className(), ['numeroDocumento' => 'numeroDocumento']);
  }

}
