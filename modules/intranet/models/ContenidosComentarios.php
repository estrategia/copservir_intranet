<?php

namespace app\modules\intranet\models;

use Yii;

/**
 * This is the model class for table "t_contenidoscomentarios".
 *
 * @property string $idContenidoComentario
 * @property string $titulo
 * @property string $contenido
 * @property string $idUsuarioComentario
 * @property string $fechaComentario
 * @property string $fechaActualizacion
 * @property integer $estado
 * @property string $idContenido
 */
class ContenidosComentarios extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_ContenidosComentarios';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['contenido', 'idUsuarioComentario', 'fechaComentario', 'idContenido'], 'required'],
            [['contenido'], 'string'],
            [['idUsuarioComentario', 'estado', 'idContenido'], 'integer'],
            [['fechaComentario', 'fechaActualizacion'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idContenidoComentario' => 'Id Contenido Comentario',
             'contenido' => 'Contenido',
            'idUsuarioComentario' => 'Id Usuario Comentario',
            'fechaComentario' => 'Fecha Comentario',
            'fechaActualizacion' => 'Fecha Actualizacion',
            'estado' => 'Estado',
            'idContenido' => 'Id Contenido',
        ];
    }

    public function getObjUsuarioPublicacionComentario()
    {
        return $this->hasOne(Usuario::className(), ['numeroDocumento' => 'idUsuarioComentario']);
    }
    
    public function getObjDenuncioComentarioUsuario()
    {
        return $this->hasOne(DenunciosContenidosComentarios::className(), ['idContenidoComentario' => 'idContenidoComentario'])->andOnCondition(['idUsuarioDenunciante' => Yii::$app->user->identity->numeroDocumento]);
    }
}
