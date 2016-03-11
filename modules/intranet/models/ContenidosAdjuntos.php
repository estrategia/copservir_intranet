<?php

namespace app\modules\intranet\models;

use Yii;

/**
 * This is the model class for table "t_contenidosadjuntos".
 *
 * @property string $idContenidoAdjunto
 * @property string $nombreAdjunto
 * @property string $rutaAdjunto
 * @property string $idContenido
 * @property string $fechaPublicacion
 * @property string $idTipo
 */
class ContenidosAdjuntos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_ContenidosAdjuntos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombreAdjunto', 'rutaAdjunto', 'idContenido', 'fechaPublicacion'], 'required'],
            [['idContenido', 'idTipo'], 'integer'],
            [['fechaPublicacion'], 'safe'],
            [['nombreAdjunto', 'rutaAdjunto'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idContenidoAdjunto' => 'Id Contenido Adjunto',
            'nombreAdjunto' => 'Nombre Adjunto',
            'rutaAdjunto' => 'Ruta Adjunto',
            'idContenido' => 'Id Contenido',
            'fechaPublicacion' => 'Fecha Publicacion',
            'idTipo' => 'Id Tipo',
        ];
    }
}
