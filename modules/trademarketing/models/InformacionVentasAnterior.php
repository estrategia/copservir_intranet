<?php

namespace app\modules\trademarketing\models;

use Yii;

/**
 * Modelo para la tabla "t_TRMA_InformacionVentasAnterior".
 *
 * @property string $idInformacionVentasAnterior
 * @property string $idComercial
 * @property string $idAgrupacion
 * @property string $mes
 * @property string $valor
 */
class InformacionVentasAnterior extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 't_TRMA_InformacionVentasAnterior';
    }

    public function rules()
    {
        return [
            [['idComercial', 'idAgrupacion', 'mes', 'valor'], 'required'],
            [['idAgrupacion', 'mes', 'valor'], 'integer'],
            [['idComercial'], 'string', 'max' => 10],
        ];
    }

    public function attributeLabels()
    {
        return [
            'idInformacionVentasAnterior' => 'Id Informacion Ventas Anterior',
            'idComercial' => 'Id Comercial',
            'idAgrupacion' => 'Id Agrupacion',
            'mes' => 'Mes',
            'valor' => 'Valor',
        ];
    }
}
