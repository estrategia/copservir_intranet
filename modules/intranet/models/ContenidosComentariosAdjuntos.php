<?php

namespace app\modules\intranet\models;

use Yii;

/**
 * This is the model class for table "t_contenidoscomentariosadjuntos".
 *
 * @property string $idContenidoAdjunto
 * @property string $nombreAdjunto
 * @property string $rutaAdjunto
 * @property string $idContenidoComentario
 * @property string $numeroDocumento
 * @property string $fechaPublicacion
 * @property string $idTipo
 */
class ContenidosComentariosAdjuntos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_ContenidosComentariosAdjuntos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombreAdjunto', 'rutaAdjunto', 'idContenidoComentario', 'numeroDocumento', 'fechaPublicacion', 'idTipo'], 'required'],
            [['idContenidoComentario', 'idTipo'], 'integer'],
            [['nombreAdjunto', 'rutaAdjunto', 'numeroDocumento', 'fechaPublicacion'], 'string', 'max' => 45]
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
            'idContenidoComentario' => 'Id Contenido Comentario',
            'numeroDocumento' => 'Usuario Publicacion',
            'fechaPublicacion' => 'Fecha Publicacion',
            'idTipo' => 'Id Tipo',
        ];
    }
}
