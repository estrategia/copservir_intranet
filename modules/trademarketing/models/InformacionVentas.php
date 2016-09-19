<?php

namespace app\modules\trademarketing\models;

use Yii;

/**
 * Modelo para la tabla "t_TRMA_AsignacionPuntoVenta".
 *
 * @property string $idComercial
 * @property integer $idAgrupacion
 * @property integer $valor
 * @property integer $mes
 * @property string $anio
 *
 */
 
class InformacionVentas extends \yii\db\ActiveRecord
{


    public static function tableName()
    {
        return 't_TRMA_InformacionVentas';
    }

    public function rules()
    {
        return [
            [['idComercial', 'idAgrupacion', 'valor', 'anio', 'mes'], 'required'],
            [['idAgrupacion', 'valor', 'mes'], 'integer'],
            [['anio'], 'safe'],
            [['idComercial'], 'string', 'max' => 10],
        ];
    }

    public function attributeLabels()
    {
        return [
            'idComercial' => 'Punto de Venta',
            'idAgrupacion' => 'Unidad de negocio',
            'valor' => 'Valor',
            'anio' => 'Año',
            'Mes' => 'Mes',
        ];
    }
}
