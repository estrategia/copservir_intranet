<?php

namespace app\modules\intranet\models;

use Yii;

/**
 * This is the model class for table "t_logdocumento".
 *
 * @property string $idLogDocumento
 * @property string $idDocumento
 * @property string $descripcion
 * @property string $fechaCreacion
 *
 * @property MDocumento $idDocumento0
 */
class LogDocumento extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_logdocumento';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idLogDocumento', 'idDocumento', 'descripcion', 'fechaCreacion'], 'required'],
            [['idLogDocumento', 'idDocumento'], 'integer'],
            [['descripcion'], 'string'],
            [['fechaCreacion'], 'safe'],
            [['idDocumento'], 'exist', 'skipOnError' => true, 'targetClass' => MDocumento::className(), 'targetAttribute' => ['idDocumento' => 'idDocumento']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idLogDocumento' => 'Id Log Documento',
            'idDocumento' => 'Id Documento',
            'descripcion' => 'Descripcion',
            'fechaCreacion' => 'Fecha Creacion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdDocumento0()
    {
        return $this->hasOne(MDocumento::className(), ['idDocumento' => 'idDocumento']);
    }
}
