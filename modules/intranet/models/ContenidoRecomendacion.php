<?php

namespace app\modules\intranet\models;

use Yii;

/**
* This is the model class for table "t_contenidorecomendacion".
*
* @property integer $idContenido
* @property integer $numeroDocumentoDirige
* @property integer $numeroDocumentoDirigido
* @property string $fechaRegistro
*/
class ContenidoRecomendacion extends \yii\db\ActiveRecord
{
  public static function tableName()
  {
    return 't_ContenidoRecomendacion';
  }

  public function rules()
  {
    return [
      [['idContenido', 'numeroDocumentoDirige', 'numeroDocumentoDirigido', 'fechaRegistro'], 'required'],
      [['idContenido', 'numeroDocumentoDirige', 'numeroDocumentoDirigido'], 'integer'],
      [['fechaRegistro'], 'safe']
    ];
  }

  public function attributeLabels()
  {
    return [
      'idContenido' => 'Id Contenido',
      'numeroDocumentoDirige' => 'Numero Documento Dirige',
      'numeroDocumentoDirigido' => 'Numero Documento Dirigido',
      'fechaRegistro' => 'Fecha Registro',
    ];
  }

  public function guardarContenidoRecomendacion($idContenido,$idUsuarioDirigido)
  {
    $this->idContenido = $idContenido;
    $this->numeroDocumentoDirige = Yii::$app->user->identity->numeroDocumento;
    $this->numeroDocumentoDirigido = $idUsuarioDirigido;
    $this->fechaRegistro = Date("Y-m-d H:i:s");

    if (!$this->save()) {

      throw new \Exception("Error al guardar el contenido recomendacion:".json_encode($this->getErrors()), 100);
    }
  }
}
