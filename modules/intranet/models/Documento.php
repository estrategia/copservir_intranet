<?php

namespace app\modules\intranet\models;

use Yii;

/**
 * This is the model class for table "m_documento".
 *
 * @property string $idDocumento
 * @property string $titulo
 * @property string $descripcion
 * @property string $rutaDocumento
 * @property string $estado
 * @property string $fechaCreacion
 * @property string $fechaActualizacion
 *
 * @property MCategoriadocumentodetalle[] $mCategoriadocumentodetalles
 * @property TLogdocumento[] $tLogdocumentos
 */
class Documento extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'm_documento';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['titulo', 'descripcion', 'rutaDocumento', 'estado', 'fechaCreacion', 'fechaActualizacion'], 'required'],
            [['fechaCreacion', 'fechaActualizacion'], 'safe'],
            [['titulo', 'rutaDocumento'], 'string', 'max' => 100],
            [['descripcion'], 'string', 'max' => 250],
            [['estado'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idDocumento' => 'Id Documento',
            'titulo' => 'Titulo',
            'descripcion' => 'Descripcion',
            'rutaDocumento' => 'Ruta Documento',
            'estado' => 'Estado',
            'fechaCreacion' => 'Fecha Creacion',
            'fechaActualizacion' => 'Fecha Actualizacion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMCategoriadocumentodetalles()
    {
        return $this->hasMany(MCategoriadocumentodetalle::className(), ['idDocumento' => 'idDocumento']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTLogdocumentos()
    {
        return $this->hasMany(TLogdocumento::className(), ['idDocumento' => 'idDocumento']);
    }
}
