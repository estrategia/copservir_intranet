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
  const TIPO_IMAGEN = 1;

  public static function tableName()
  {
    return 't_ContenidoAdjunto';
  }

  public function rules()
  {
    return [
      [['rutaArchivo', 'tipo', 'idContenido'], 'required'],
      [['tipo', 'idContenido'], 'integer'],
      [['rutaArchivo'], 'string', 'max' => 100],
      [['idContenido'], 'exist', 'skipOnError' => true, 'targetClass' => Contenido::className(), 'targetAttribute' => ['idContenido' => 'idContenido']],
    ];
  }

  public function attributeLabels()
  {
    return [
      'idContenidoAdjunto' => 'Id Contenido Adjunto',
      'rutaArchivo' => 'Ruta Archivo',
      'tipo' => 'Tipo',
      'idContenido' => 'Id Contenido',
    ];
  }


  //RELACIONES

  public function getObjContenido()
  {
    return $this->hasOne(Contenido::className(), ['idContenido' => 'idContenido']);
  }

}
