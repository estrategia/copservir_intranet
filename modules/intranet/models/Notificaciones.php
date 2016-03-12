<?php

namespace app\modules\intranet\models;

use Yii;

/**
 * This is the model class for table "t_Notificaciones".
 *
 * @property string $idNotificacion
 * @property string $idUsuarioDirige
 * @property string $idUsuarioDirigido
 * @property string $descripcion
 * @property string $idTipoNotificacion
 * @property integer $estadoNotificacion
 * @property string $fechaVisto
 */
class Notificaciones extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_Notificaciones';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idUsuarioDirige', 'idUsuarioDirigido', 'idTipoNotificacion', 'estadoNotificacion'], 'integer'],
            [['idUsuarioDirigido', 'descripcion', 'idTipoNotificacion', 'estadoNotificacion'], 'required'],
            [['descripcion', 'fechaVisto'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idNotificacion' => 'Id Notificacion',
            'idUsuarioDirige' => 'Id Usuario Dirige',
            'idUsuarioDirigido' => 'Id Usuario Dirigido',
            'descripcion' => 'Descripcion',
            'idTipoNotificacion' => 'Id Tipo Notificacion',
            'estadoNotificacion' => 'Estado Notificacion',
            'fechaVisto' => 'Fecha Visto',
        ];
    }
}
