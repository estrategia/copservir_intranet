<?php

namespace app\modules\intranet\models;

use Yii;

/**
* This is the model class for table "m_categoriadocumentodetalle".
*
* @property string $idCategoriaDocumento
* @property string $contenido
* @property string $idDocumento
*
* @property MCategoriadocumento $idCategoriaDocumento0
* @property MDocumento $idDocumento0
*/
class CategoriaDocumentoDetalle extends \yii\db\ActiveRecord
{
  public static function tableName()
  {
    return 'm_CategoriaDocumentoDetalle';
  }

  public function rules()
  {
    return [
      [['idCategoriaDocumento', 'contenido', 'idDocumento'], 'required'],
      [['idCategoriaDocumento', 'idDocumento'], 'integer'],
      [['contenido'], 'string'],
      [['idCategoriaDocumento'], 'exist', 'skipOnError' => true, 'targetClass' => Categoriadocumento::className(), 'targetAttribute' => ['idCategoriaDocumento' => 'idCategoriaDocumento']],
      [['idDocumento'], 'exist', 'skipOnError' => true, 'targetClass' => Documento::className(), 'targetAttribute' => ['idDocumento' => 'idDocumento']],
    ];
  }

  public function attributeLabels()
  {
    return [
      'idCategoriaDocumento' => 'Id Categoria Documento',
      'contenido' => 'Contenido',
      'idDocumento' => 'Id Documento',
    ];
  }


  // RELACIONES

  public function getObjCategoriaDocumento()
  {
    return $this->hasOne(CategoriaDocumento::className(), ['idCategoriaDocumento' => 'idCategoriaDocumento']);
  }

  public function getObjDocumento()
  {
    return $this->hasOne(Documento::className(), ['idDocumento' => 'idDocumento']);
  }

  // CONSULTAS

  /**
  * consulta un modelo CategoriaDocumentoDetalle por el atributo idCategoriaDocumento
  * @param idCategoriaDocumento = categoria
  * @return modelo Documento
  */
  public static function getCategoriaDocumentoDetalle($idCategoriaDocumento)
  {
    return self::find()
    ->where("( idCategoriaDocumento =:idCategoriaDocumento )")
    ->addParams([':idCategoriaDocumento'=> $idCategoriaDocumento])->one();
  }

  /**
  * consulta un modelo CategoriaDocumentoDetalle por los atributos idCategoriaDocumento y idDocumento
  * @param idCategoriaDocumento = categoria, idDocumento = documento
  * @return modelo Documento
  */
  public static function getRelacionCategoriaDocumento($idCategoriaDocumento, $idDocumento)
  {
    return self::find()
    ->where("( idCategoriaDocumento =:idCategoriaDocumento and idDocumento =:idDocumento )")
    ->addParams([':idCategoriaDocumento'=> $idCategoriaDocumento, ':idDocumento' => $idDocumento])->one();
  }
}
