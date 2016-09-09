<?php

namespace app\modules\trademarketing\models;

use Yii;

/**
 * Modelo para la tabla "m_TRMA_CalificacionVariable".
 *
 * @property string $idCalificacion
 * @property string $idVariable
 * @property string $valor
 * @property string $idAsignacion
 * @property string $IdAgrupacion
 * @property string $nombreUnidadNegocio
 *
 * @property VariableMedicion $variable
 * @property AsignacionPuntoVenta $asignacion
 */
class CalificacionVariable extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 't_trma_calificacionvariable';
    }

    public function rules()
    {
        return [
            [['idVariable', 'valor', 'idAsignacion'], 'required'],
            [['idVariable', 'valor', 'idAsignacion', 'IdAgrupacion'], 'integer'],
            [['nombreUnidadNegocio'], 'string', 'max' => 45],
            [['idVariable'], 'exist', 'skipOnError' => true, 'targetClass' => VariableMedicion::className(), 'targetAttribute' => ['idVariable' => 'idVariable']],
            [['idAsignacion'], 'exist', 'skipOnError' => true, 'targetClass' => AsignacionPuntoVenta::className(), 'targetAttribute' => ['idAsignacion' => 'idAsignacion']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'idCalificacion' => 'Id Calificacion',
            'idVariable' => 'Variable',
            'valor' => 'Valor',
            'idAsignacion' => 'Asignacion',
            'IdAgrupacion' => 'Agrupacion Unidad Negocio',
            'nombreUnidadNegocio' => 'Unidad Negocio',
        ];
    }

    public function getVariable()
    {
        return $this->hasOne(VariableMedicion::className(), ['idVariable' => 'idVariable']);
    }

    public function getAsignacion()
    {
        return $this->hasOne(AsignacionPuntoVenta::className(), ['idAsignacion' => 'idAsignacion']);
    }
}
