<?php

namespace app\modules\intranet\models;

use Yii;

/**
 * This is the model class for table "t_LogContenidos".
 *
 * @property string $idLogContenidos
 * @property string $idContenido
 * @property integer $estado
 * @property string $fechaRegistro
 * @property string $idUsuarioRegistro
 */
class LogContenidos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_LogContenidos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idContenido', 'estado', 'fechaRegistro', 'idUsuarioRegistro'], 'required'],
            [['idContenido', 'estado', 'idUsuarioRegistro'], 'integer'],
            [['fechaRegistro'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idLogContenidos' => 'Id Log Contenidos',
            'idContenido' => 'Id Contenido',
            'estado' => 'Estado',
            'fechaRegistro' => 'Fecha Registro',
            'idUsuarioRegistro' => 'Id Usuario Registro',
        ];
    }
}
