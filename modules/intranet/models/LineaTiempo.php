<?php

namespace app\modules\intranet\models;

use Yii;

/**
 * This is the model class for table "t_lineastiempo".
 *
 * @property string $idLineaTiempo
 * @property string $nombreLineaTiempo
 * @property integer $estado
 * @property integer $autorizacionAutomatica
 */
class LineaTiempo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_lineastiempo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombreLineaTiempo', 'estado'], 'required'],
            [['estado', 'autorizacionAutomatica'], 'integer'],
            [['nombreLineaTiempo'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idLineaTiempo' => 'Id Linea Tiempo',
            'nombreLineaTiempo' => 'Nombre Linea Tiempo',
            'estado' => 'Estado',
            'autorizacionAutomatica' => 'Autorizacion Automatica',
        ];
    }
}
