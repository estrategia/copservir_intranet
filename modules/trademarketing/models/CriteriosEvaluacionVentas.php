<?php

namespace app\modules\trademarketing\models;

use Yii;

/**
* Modelo para la tabla "m_TRMA_CriteriosEvaluacionVentas".
 *
 * @property integer $idCriterio
 * @property string $descripcion
 * @property string $valor
 * @property integer $estado
 */
 
class CriteriosEvaluacionVentas extends \yii\db\ActiveRecord
{
    const ESTADO_ACTIVO = 1;
    const ESTADO_INACTIVO = 0;

    public static function tableName()
    {
        return 'm_TRMA_CriteriosEvaluacionVentas';
    }

    public function rules()
    {
        return [
            [['valor', 'estado', 'descripcion'], 'required'],
            [['idCriterio', 'valor', 'estado'], 'integer'],
            [['descripcion'], 'string', 'max' => 200],
        ];
    }

    public function attributeLabels()
    {
        return [
            'idCriterio' => 'Id Criterio',
            'descripcion' => 'Descripcion',
            'valor' => 'Valor',
            'estado' => 'Estado',
        ];
    }
}
