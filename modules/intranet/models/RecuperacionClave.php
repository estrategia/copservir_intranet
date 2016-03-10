<?php

namespace app\modules\intranet\models;

use Yii;

/**
 * This is the model class for table "t_recuperacionclave".
 *
 * @property string $idUsuario
 * @property string $recuperacionCodigo
 * @property string $recuperacionFecha
 */
class RecuperacionClave extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_recuperacionclave';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idUsuario', 'recuperacionCodigo', 'recuperacionFecha'], 'required'],
            [['idUsuario'], 'integer'],
            [['recuperacionFecha'], 'safe'],
            [['recuperacionCodigo'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idUsuario' => 'Id Usuario',
            'recuperacionCodigo' => 'Recuperacion Codigo',
            'recuperacionFecha' => 'Recuperacion Fecha',
        ];
    }
}
