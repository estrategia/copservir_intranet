<?php

namespace app\modules\intranet\models;

use Yii;

/**
 * This is the model class for table "t_Indicadores".
 *
 * @property string $idIndicador
 * @property string $colorFondo
 * @property string $descripcion
 * @property string $valor
 * @property string $textoComplementario
 */
class Indicadores extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_Indicadores';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['colorFondo', 'descripcion', 'valor', 'textoComplementario'], 'required'],
            [['colorFondo'], 'string', 'max' => 8],
            [['descripcion'], 'string', 'max' => 60],
            [['valor'], 'string', 'max' => 100],
            [['textoComplementario'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idIndicador' => 'Id Indicador',
            'colorFondo' => 'Color Fondo',
            'descripcion' => 'Descripcion',
            'valor' => 'Valor',
            'textoComplementario' => 'Texto Complementario',
        ];
    }
}
