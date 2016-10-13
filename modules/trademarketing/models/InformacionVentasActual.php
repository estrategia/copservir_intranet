<?php

namespace app\modules\trademarketing\models;

use Yii;

/**
 * Modelo para la tabla "t_TRMA_InformacionVentasActual".
 *
 * @property string $idInformacionVentasActual
 * @property string $idComercial
 * @property string $idAgrupacion
 * @property string $mes
 * @property string $valor
 */
class InformacionVentasActual extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 't_TRMA_InformacionVentasActual';
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
            'idInformacionVentasActual' => 'Id Informacion Ventas Actual',
            'idComercial' => 'Id Comercial',
            'idAgrupacion' => 'Id Agrupacion',
            'mes' => 'Mes',
            'valor' => 'Valor',
        ];
    }
}
