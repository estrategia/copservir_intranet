<?php

namespace app\modules\trademarketing\models;

use Yii;

/**
 * Modelo para la tabla "t_TRMA_Observaciones".
 *
 * @property string $idObservacion
 * @property string $descripcion
 * @property string $idAsignacion
 * @property string $idVariable
 *
 * @property VariableMedicion $variable
 */

class Observaciones extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 't_TRMA_Observaciones';
    }

    public function rules()
    {
        return [
            [['idAsignacion', 'idVariable', 'numeroDocumento'], 'required'],
            [['idAsignacion', 'idVariable', 'numeroDocumento'], 'integer'],
            [['descripcion'], 'string', 'max' => 200],
            [['idVariable'], 'exist', 'skipOnError' => true, 'targetClass' => VariableMedicion::className(), 'targetAttribute' => ['idVariable' => 'idVariable']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'idObservacion' => 'Id Observacion',
            'descripcion' => 'Descripcion',
            'idAsignacion' => 'Id Asignacion',
            'idVariable' => 'Id Variable',
            'numeroDocumento' => 'Realizado por',
        ];
    }

    // RELACIONES

    public function getVariable()
    {
        return $this->hasOne(VariableMedicion::className(), ['idVariable' => 'idVariable']);
    }
}
