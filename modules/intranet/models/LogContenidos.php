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
 * @property string $numeroDocumento
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
            [['idContenido', 'estado', 'fechaRegistro', 'numeroDocumento'], 'required'],
            [['idContenido', 'estado', 'numeroDocumento'], 'integer'],
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
            'numeroDocumento' => 'Usuario Registro',
        ];
    }
}
