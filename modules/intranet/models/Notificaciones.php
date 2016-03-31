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
    
    const ME_GUSTA= 1;
    const COMENTARIO = 2;
    
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
            [['idUsuarioDirige', 'idUsuarioDirigido', 'tipoNotificacion', 'estadoNotificacion', 'idContenido'], 'integer'],
            [['idUsuarioDirigido', 'descripcion', 'tipoNotificacion', 'estadoNotificacion', 'idContenido'], 'required'],
            [['descripcion', 'fechaRegistro'], 'string', 'max' => 45]
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
            'tipoNotificacion' => 'Tipo Notificacion',
            'estadoNotificacion' => 'Estado Notificacion',
            'fechaRegistro' => 'Fecha Registro',
            'idContenido' => 'Id Contenido',
        ];
    }
}
