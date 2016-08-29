<?php

namespace app\modules\trademarketing\models;

use Yii;

/**
 * Modelo para la tabla "m_TRMA_RangoCalificaciones".
 *
 * @property integer $idRangoCalificacion
 * @property string $nombre
 * @property string $valor
 * @property integer $estado
 */
class RangoCalificaciones extends \yii\db\ActiveRecord
{
    const ESTADO_ACTIVO = 1;
    const ESTADO_INACTIVO = 0;

    public static function tableName()
    {
        return 'm_TRMA_RangoCalificaciones';
    }

    public function rules()
    {
        return [
            [['nombre', 'valor'], 'required'],
            [['idRangoCalificacion', 'valor', 'estado'], 'integer'],
            [['nombre'], 'string', 'max' => 45],
        ];
    }

    public function attributeLabels()
    {
        return [
            'idRangoCalificacion' => 'Id Rango Calificacion',
            'nombre' => 'Nombre',
            'valor' => 'Valor',
            'estado' => 'Estado',
        ];
    }
}
