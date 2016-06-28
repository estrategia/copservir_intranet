<?php

namespace app\modules\intranet\models;

use Yii;
use app\modules\intranet\models\CategoriaDocumentoDetalle;

/**
* This is the model class for table "m_categoriadocumento".
*
* @property string $idCategoriaDocumento
* @property string $idCategoriaPadre
* @property string $nombre
* @property integer $estado
* @property string $fechaCreacion
*
* @property CategoriaDocumento $idCategoriaPadre0
* @property CategoriaDocumento[] $categoriaDocumentos
*/
class CategoriaDocumento extends \yii\db\ActiveRecord
{
  const ESTADO_ACTIVO = 1;
  const ESTADO_INACTIVO = 0;

  public static function tableName()
  {
    return 'm_CategoriaDocumento';
  }

  public function rules()
  {
    return [
      [['idCategoriaPadre', 'estado', 'orden'], 'integer'],
      [['nombre', 'fechaCreacion', 'orden'], 'required'],
      [['fechaCreacion'], 'safe'],

      [['nombre'], 'string', 'max' => 100],
      [['idCategoriaPadre'], 'exist', 'skipOnError' => true, 'targetClass' => CategoriaDocumento::className(), 'targetAttribute' => ['idCategoriaPadre' => 'idCategoriaDocumento']],
    ];
  }

  public function attributeLabels()
  {
    return [
      'idCategoriaDocumento' => 'Id Categoria Documento',
      'idCategoriaPadre' => 'Id Categoria Padre',
      'nombre' => 'Nombre',
      'estado' => 'Estado',
      'fechaCreacion' => 'Fecha Creacion',
      'orden' => 'Orden'
    ];
  }


  // RELACIONES

  public function getIdCategoriaPadre0()
  {
    return $this->hasOne(CategoriaDocumento::className(), ['idCategoriaDocumento' => 'idCategoriaPadre']);
  }

  public function getCategoriaDocumentos()
  {
    return $this->hasMany(CategoriaDocumento::className(), ['idCategoriaPadre' => 'idCategoriaDocumento']);
  }

  public function getCategoriaDocumentosDetalle()
  {
    return $this->hasOne(CategoriaDocumentoDetalle::className(), ['idCategoriaDocumento' => 'idCategoriaDocumento']);
  }

  // CONSULLTAS


  /**
  * Consulta para obtener los padres del menu
  * @return modelos CategoriaDocumento
  */
  public static function getPadres()
  {
    return self::find()->where('idCategoriaPadre is null')->andWhere(['=', 'estado', self::ESTADO_ACTIVO])->with(['categoriaDocumentosDetalle'])->orderBy('orden')->all();
  }

  /**
  * Consulta para obtener los hijos del un modelo Menu
  * @return modelos CategoriaDocumento
  */
  public static function getHijos($idCategoriaDocumento)
  {
    $query = self::find()
    ->where("( idCategoriaPadre =:idCategoria and estado=:estado )")
    ->addParams([':idCategoria'=> $idCategoriaDocumento, ':estado'=> self::ESTADO_ACTIVO])->with(['categoriaDocumentosDetalle'])->orderBy('orden')->all();

    return $query;
  }

}
