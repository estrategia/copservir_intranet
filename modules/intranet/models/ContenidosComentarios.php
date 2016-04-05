<?php

namespace app\modules\intranet\models;

use Yii;

/**
 * This is the model class for table "t_contenidoscomentarios".
 *
 * @property string $idContenidoComentario
 * @property string $titulo
 * @property string $contenido
 * @property string $numeroDocumento
 * @property string $fechaComentario
 * @property string $fechaActualizacion
 * @property integer $estado
 * @property string $idContenido
 */
class ContenidosComentarios extends \yii\db\ActiveRecord
{
    
    const ESTADO_ACTIVO = 1;
    const ESTADO_DENUNCIADO = 2;
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
            [['contenido', 'numeroDocumento', 'fechaComentario', 'idContenido'], 'required'],
            [['contenido'], 'string'],
            [['numeroDocumento', 'estado', 'idContenido'], 'integer'],
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
            'numeroDocumento' => 'Usuario Comentario',
            'fechaComentario' => 'Fecha Comentario',
            'fechaActualizacion' => 'Fecha Actualizacion',
            'estado' => 'Estado',
            'idContenido' => 'Id Contenido',
        ];
    }

    public function getObjUsuarioPublicacionComentario()
    {
        return $this->hasOne(Usuario::className(), ['numeroDocumento' => 'numeroDocumento']);
    }
    
    public function getObjDenuncioComentarioUsuario()
    {
        return $this->hasOne(DenunciosContenidosComentarios::className(), ['idContenidoComentario' => 'idContenidoComentario'])->andOnCondition(['numeroDocumento' => Yii::$app->user->identity->numeroDocumento]);
    }
}
