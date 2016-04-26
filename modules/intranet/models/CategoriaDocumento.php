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
    /**
     * @inheritdoc
     */

    // estados del documento
    const ESTADO_ACTIVO = 1;
    const ESTADO_INACTIVO = 0;

    public static function tableName()
    {
        return 'm_CategoriaDocumento';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idCategoriaPadre', 'estado'], 'integer'],
            [['nombre', 'fechaCreacion'], 'required'],
            [['fechaCreacion'], 'safe'],
            [['nombre'], 'string', 'max' => 100],
            [['idCategoriaPadre'], 'exist', 'skipOnError' => true, 'targetClass' => CategoriaDocumento::className(), 'targetAttribute' => ['idCategoriaPadre' => 'idCategoriaDocumento']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idCategoriaDocumento' => 'Id Categoria Documento',
            'idCategoriaPadre' => 'Id Categoria Padre',
            'nombre' => 'Nombre',
            'estado' => 'Estado',
            'fechaCreacion' => 'Fecha Creacion',
        ];
    }

    /*
    * RELACIONES
    */

    /**
     * se define la relacion entre los modelos CategoriaDocumento y CategoriaDocumento para obtener el padre
     * @return \yii\db\ActiveQuery modelo CategoriaDocumento
     */
    public function getIdCategoriaPadre0()
    {
        return $this->hasOne(CategoriaDocumento::className(), ['idCategoriaDocumento' => 'idCategoriaPadre']);
    }

    /**
     * se define la relacion entre los modelos CategoriaDocumento y CategoriaDocumento para obtener los hijos s
     * @return \yii\db\ActiveQuery modelos CategoriaDocumento
     */
    public function getCategoriaDocumentos()
    {
        return $this->hasMany(CategoriaDocumento::className(), ['idCategoriaPadre' => 'idCategoriaDocumento']);
    }


    /**
     * se define la relacion entre los modelos CategoriaDocumento y CategoriaDocumentoDetalle
     * @return \yii\db\ActiveQuery modelos CategoriaDocumentoDetalle
     */
    public function getCategoriaDocumentosDetalle()
    {
        return $this->hasOne(CategoriaDocumentoDetalle::className(), ['idCategoriaDocumento' => 'idCategoriaDocumento']);
    }

    /*
    * CONSULLTAS
    */

    /**
     * Consulta para obtener los padres del menu
     * @return \yii\db\ActiveQuery modelos CategoriaDocumento
     */
     public static function getPadres()
     {
        return self::find()->where('idCategoriaPadre is null')->andWhere(['=', 'estado', 1])->with(['categoriaDocumentosDetalle'])->all();
     }

     /**
      * Consulta para obtener los padres del menu
      * @return \yii\db\ActiveQuery modelos CategoriaDocumento
      */
      public static function getHijos($idCategoriaDocumento)
      {
        $query = self::find()
        ->where("( idCategoriaPadre =:idCategoria and estado=:estado )")
        ->addParams([':idCategoria'=> $idCategoriaDocumento, ':estado'=> self::ESTADO_ACTIVO])->with(['categoriaDocumentosDetalle'])->all();

        return $query;
      }

}
