<?php

namespace app\modules\intranet\models;

use Yii;

/**
 * This is the model class for table "t_DenunciosContenidosComentarios".
 *
 * @property string $idDenuncioComentario
 * @property string $idContenidoComentario
 * @property string $descripcionDenuncio
 * @property string $numeroDocumento
 * @property string $fechaRegistro
 */
class DenunciosContenidosComentarios extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_DenunciosContenidosComentarios';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idContenidoComentario', 'descripcionDenuncio', 'numeroDocumento', 'fechaRegistro'], 'required'],
            [['idContenidoComentario', 'numeroDocumento'], 'integer'],
            [['descripcionDenuncio'], 'string'],
            [['fechaRegistro'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idDenuncioComentario' => 'Id Denuncio Comentario',
            'idContenidoComentario' => 'Id Contenido Comentario',
            'descripcionDenuncio' => 'Descripcion Denuncio',
            'numeroDocumento' => 'Usuario Denunciante',
            'fechaRegistro' => 'Fecha Registro',
        ];
    }
}
