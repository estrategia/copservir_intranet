<?php

namespace app\modules\intranet\models;

use Yii;

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
  /**
  * @inheritdoc
  */

  // estados
  const PENDIENTE_APROBACION = 1;
  const APROBADO = 2;
  const ELIMINADO = 3;

  public static function tableName()
  {
    return 't_DenunciosContenidosComentarios';
  }

  /**
  * @inheritdoc
  */
  public function rules()
  {
    return [
      [['idContenidoComentario', 'descripcionDenuncio', 'numeroDocumento', 'fechaRegistro'], 'required'],
      [['idContenidoComentario', 'estado', 'numeroDocumento'], 'integer'],
      [['descripcionDenuncio'], 'string'],
      [['fechaRegistro', 'fechaActualizacion'], 'safe']
    ];
  }

  /**
  * @inheritdoc
  */
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

  /*
  * RELACIONES
  */

  /**
  * Se define la relacion entre los modelos DenunciosContenidos y Contenido
  * @return \yii\db\ActiveQuery modelo Contenido
  */
  public function getObjContenido()
  {
    return $this->hasOne(Contenido::className(), ['idContenido' => 'idContenidoComentario']);
  }

  /**
  * Se define la relacion entre los modelos DenunciosContenidos y Usuario
  * @return \yii\db\ActiveQuery modelo Usuarios
  */
  public function getObjUsuario()
  {
    return $this->hasOne(Usuario::className(), ['numeroDocumento' => 'numeroDocumento']);
  }

}
