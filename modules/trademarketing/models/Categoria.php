<?php

namespace app\modules\trademarketing\models;

use Yii;

/**
 * Modelo para la tabla "m_TRMA_Categoria".
 *
 * @property string $idCategoria
 * @property string $nombre
 * @property string $descripcion
 * @property integer $estado
 *
 * @property Variablemedicion[] $Variablesmedicion
 */
class Categoria extends \yii\db\ActiveRecord
{
    const ESTADO_ACTIVO = 1;
    const ESTADO_INACTIVO = 0;

    public static function tableName()
    {
        return 'm_TRMA_Categoria';
    }

    public function rules()
    {
        return [
            [['nombre', 'estado'], 'required'],
            [['estado'], 'integer'],
            [['nombre', 'descripcion'], 'string', 'max' => 45],
        ];
    }

    public function attributeLabels()
    {
        return [
            'idCategoria' => 'Id Categoria',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripcion',
            'estado' => 'Estado',
        ];
    }

    public function getVariablesmedicion()
    {
        return $this->hasMany(Variablemedicion::className(), ['idCategoria' => 'idCategoria']);
    }
}
