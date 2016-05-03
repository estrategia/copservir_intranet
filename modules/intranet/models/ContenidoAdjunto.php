<?php

namespace app\modules\intranet\models;

use Yii;

/**
* This is the model class for table "t_contenidoadjunto".
*
* @property string $idContenidoAdjunto
* @property string $rutaArchivo
* @property integer $tipo
* @property string $idContenido
*
* @property TContenido $idContenido0
*/
class ContenidoAdjunto extends \yii\db\ActiveRecord
{
  /**
  * @inheritdoc
  */
  public static function tableName()
  {
    return 't_ContenidoAdjunto';
  }

  /**
  * @inheritdoc
  */
  public function rules()
  {
    return [
      [['rutaArchivo', 'tipo', 'idContenido'], 'required'],
      [['tipo', 'idContenido'], 'integer'],
      [['rutaArchivo'], 'string', 'max' => 100],
      [['idContenido'], 'exist', 'skipOnError' => true, 'targetClass' => Contenido::className(), 'targetAttribute' => ['idContenido' => 'idContenido']],
    ];
  }

  /**
  * @inheritdoc
  */
  public function attributeLabels()
  {
    return [
      'idContenidoAdjunto' => 'Id Contenido Adjunto',
      'rutaArchivo' => 'Ruta Archivo',
      'tipo' => 'Tipo',
      'idContenido' => 'Id Contenido',
    ];
  }

  /*
  RELACIONES
  */

  /**
  * Se define la relacion entre los modelos ContenidoAdjunto y Contenido
  * @return \yii\db\ActiveQuery
  */
  public function getObjContenido()
  {
    return $this->hasOne(Contenido::className(), ['idContenido' => 'idContenido']);
  }

}
