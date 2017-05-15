<?php

namespace app\modules\trademarketing\models;

use Yii;

/**
 * This is the model class for table "t_trma_porcentajeunidad".
 *
 * @property string $porcentaje
 * @property string $idAsignacion
 * @property string $idAgrupacion
 *
 * @property AsignacionPuntoVenta $asignacion
 */

class PorcentajeUnidad extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 't_TRMA_PorcentajeUnidad';
    }

    public function rules()
    {
        return [
            [['porcentaje', 'idAsignacion', 'idAgrupacion'], 'required'],
            [['porcentaje', 'idAsignacion', 'idAgrupacion'], 'integer'],
            [['idAsignacion'], 'exist', 'skipOnError' => true, 'targetClass' => AsignacionPuntoVenta::className(), 'targetAttribute' => ['idAsignacion' => 'idAsignacion']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'porcentaje' => 'Porcentaje',
            'idAsignacion' => 'Id Asignacion',
            'idAgrupacion' => 'Id Agrupacion',
        ];
    }

    // RELACIONES

    public function getAsignacion()
    {
        return $this->hasOne(AsignacionPuntoVenta::className(), ['idAsignacion' => 'idAsignacion']);
    }
}
