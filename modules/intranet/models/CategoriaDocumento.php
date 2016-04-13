<?php

namespace app\modules\intranet\models;

use Yii;

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
    public static function tableName()
    {
        return 'm_categoriadocumento';
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
}
