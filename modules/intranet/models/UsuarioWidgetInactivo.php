<?php

namespace app\modules\intranet\models;

use Yii;

/**
 * This is the model class for table "t_UsuarioWidgetInactivo".
 *
 * @property string $idUsuarioWidgetInactivo
 * @property string $numeroDocumento
 * @property integer $widget
 */
class UsuarioWidgetInactivo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    
    const WIDGET_BANNER_SUP = 1;
    const WIDGET_CUMPLEANOS = 2;
    const WIDGET_INDICADORES = 3;
    const WIDGET_OFERTAS = 4;
    const WIDGET_TAREAS = 5;
    const WIDGET_BANNER_INF = 6;    
    
    
    public static function tableName()
    {
        return 't_UsuarioWidgetInactivo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['numeroDocumento', 'widget'], 'required'],
            [['numeroDocumento',], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idUsuarioWidgetInactivo' => 'Id Usuario Widget Inactivo',
            'numeroDocumento' => 'Numero Documento',
            'widget' => 'Widget',
        ];
    }
    
    
}
