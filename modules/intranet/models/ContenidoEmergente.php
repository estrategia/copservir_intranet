<?php

namespace app\modules\intranet\models;

use Yii;

/**
 * This is the model class for table "m_contenidoemergente".
 *
 * @property string $idContenidoEmergente
 * @property string $contenido
 * @property string $fechaInicio
 * @property string $fechaFin
 * @property integer $estado
 * @property string $fechaRegistro
 */
class ContenidoEmergente extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'm_contenidoemergente';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['contenido', 'fechaInicio', 'fechaFin', 'fechaRegistro'], 'required'],
            [['contenido'], 'string'],
            [['fechaInicio', 'fechaFin', 'fechaRegistro'], 'safe'],
            [['estado'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idContenidoEmergente' => 'Id Contenido Emergente',
            'contenido' => 'Contenido',
            'fechaInicio' => 'Fecha Inicio',
            'fechaFin' => 'Fecha Fin',
            'estado' => 'Estado',
            'fechaRegistro' => 'Fecha Registro',
        ];
    }
}
