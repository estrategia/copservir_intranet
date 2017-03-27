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
 * @property array[Variablemedicion] $variablesMedicion
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

    // RELACIONES

    public function getVariablesMedicion()
    {
        return $this->hasMany(VariableMedicion::className(), ['idCategoria' => 'idCategoria'])->andWhere([VariableMedicion::tablename().'.estado' => VariableMedicion::ESTADO_ACTIVO]);
    }

    // CONSULTAS
    public static function getCategorias()
    {
        return self::find()->where(['estado' => self::ESTADO_ACTIVO])->all();
    }

    // FUNCIONES
    
    // extra campos para solicitar las relaciones en la peticion rest
    public function extraFields()
    {
      return ['variablesMedicion'];
    }
}
