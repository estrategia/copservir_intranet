<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "t_contenido".
 *
 * @property string $idContenido
 * @property string $titulo
 * @property string $contenido
 * @property string $idUsuarioPublicacion
 * @property string $fechaPublicacion
 * @property string $fechaActualizacion
 * @property integer $idEstado
 * @property string $fechaAprobacion
 * @property string $idUsuarioAprobacion
 * @property string $fechaInicioPublicacion
 * @property string $idLineaTiempo
 */
class Contenido extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_contenido';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['contenido', 'idUsuarioPublicacion', 'fechaPublicacion', 'idLineaTiempo'], 'required'],
            [['contenido'], 'string'],
            [['idUsuarioPublicacion', 'idEstado', 'idUsuarioAprobacion', 'idLineaTiempo'], 'integer'],
            [['fechaPublicacion', 'fechaActualizacion', 'fechaAprobacion', 'fechaInicioPublicacion'], 'safe'],
            [['titulo'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idContenido' => 'Id Contenido',
            'titulo' => 'Titulo',
            'contenido' => 'Contenido',
            'idUsuarioPublicacion' => 'Id Usuario Publicacion',
            'fechaPublicacion' => 'Fecha Publicacion',
            'fechaActualizacion' => 'Fecha Actualizacion',
            'idEstado' => 'Id Estado',
            'fechaAprobacion' => 'Fecha Aprobacion',
            'idUsuarioAprobacion' => 'Id Usuario Aprobacion',
            'fechaInicioPublicacion' => 'Fecha Inicio Publicacion',
            'idLineaTiempo' => 'Id Linea Tiempo',
        ];
    }
    
    public static function traerNoticias($idLineaTiempo){
        return $noticias = Contenido::find()->where(
                           ['and', 
                                ['<=', 'fechaInicioPublicacion', 'now()'],
                                ['=', 'idLineaTiempo', $idLineaTiempo],
                                ['=', 'idEstado', 2]
                             ]
                            )->orderBy('fechaInicioPublicacion Desc')
                            
                ->all();
    }
}
