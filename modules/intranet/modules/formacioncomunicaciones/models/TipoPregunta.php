<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\models;

use Yii;

/**
 * This is the model class for table "m_FORCO_TipoPregunta".
 *
 * @property string $idTipoPregunta
 * @property string $tipoPregunta
 * @property integer $estado
 *
 * @property MFORCOPregunta[] $mFORCOPreguntas
 */
class TipoPregunta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'm_FORCO_TipoPregunta';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tipoPregunta', 'estado'], 'required'],
            [['estado'], 'integer'],
            [['tipoPregunta'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idTipoPregunta' => 'Id Tipo Pregunta',
            'tipoPregunta' => 'Tipo Pregunta',
            'estado' => 'Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getListPreguntas()
    {
        return $this->hasMany(Pregunta::className(), ['idTipoPregunta' => 'idTipoPregunta']);
    }
}
