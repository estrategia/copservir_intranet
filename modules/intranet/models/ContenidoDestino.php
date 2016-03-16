<?php

namespace app\modules\intranet\models;

use Yii;

/**
 * This is the model class for table "t_ContenidoDestino".
 *
 * @property string $idContenidoDestino
 * @property string $idGrupoInteres
 * @property integer $codigoCiudad
 */
class ContenidoDestino extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_ContenidoDestino';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idGrupoInteres', 'codigoCiudad', 'idContenido'], 'required'],
            [['idGrupoInteres', 'codigoCiudad', 'idContenido'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idContenidoDestino' => 'Id Contenido Destino',
            'idContenido' => 'Contenido',
            'idGrupoInteres' => 'Grupo Interes',
            'codigoCiudad' => 'Ciudad',
        ];
    }
}
