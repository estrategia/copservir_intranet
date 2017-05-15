<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\models;

use Yii;

/**
 * This is the model class for table "m_FORCO_ContactoCategoria".
 *
 * @property integer $idCategoriaPremio
 * @property string $numeroDocumento
 *
 * @property MUsuario $numeroDocumento0
 * @property MFORCOCategoriasPremios $idCategoriaPremio0
 */
class ContactoCategoria extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'm_FORCO_ContactoCategoria';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idCategoriaPremio', 'numeroDocumento'], 'required'],
            [['idCategoriaPremio', 'numeroDocumento'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idCategoriaPremio' => 'Id Categoria Premio',
            'numeroDocumento' => 'Numero Documento',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(\app\modules\intranet\models\UsuarioIntranet::className(), ['numeroDocumento' => 'numeroDocumento']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategorias()
    {
        return $this->hasOne(CategoriasPremios::className(), ['idCategoria' => 'idCategoriaPremio']);
    }
}
