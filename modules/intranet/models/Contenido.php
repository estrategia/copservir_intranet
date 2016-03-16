<?php

namespace app\modules\intranet\models;

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
        return 't_Contenido';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['contenido', 'idUsuarioPublicacion', 'fechaPublicacion', 'idLineaTiempo'], 'required'],
            [['contenido'], 'string'],
            [['idUsuarioPublicacion', 'estado', 'idUsuarioAprobacion', 'idLineaTiempo'], 'integer'],
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
            'estado' => 'Estado',
            'fechaAprobacion' => 'Fecha Aprobacion',
            'idUsuarioAprobacion' => 'Id Usuario Aprobacion',
            'fechaInicioPublicacion' => 'Fecha Inicio Publicacion',
            'idLineaTiempo' => 'Id Linea Tiempo',
        ];
    }

    public static function traerNoticias($idLineaTiempo){
        return $noticias = Contenido::find()->with(['objUsuarioPublicacion', 'listComentarios', 'listAdjuntos','listMeGusta', 'listComentarios','listMeGustaUsuario', 'objDenuncioComentarioUsuario'])
                ->joinWith(['listContenidosDestinos'])->where(
                           ['and',
                                ['<=', 'fechaInicioPublicacion', 'now()'],
                                ['=', 'idLineaTiempo', $idLineaTiempo],
                                ['=', 'estado', 2],
                                ['=', 't_ContenidoDestino.codigoCiudad', Yii::$app->user->identity->getCodigoCiudad() ],
                                ['IN', 't_ContenidoDestino.idGrupoInteres',  Yii::$app->user->identity->getGruposCodigos() ]
                             ]
                            )->orderBy('fechaInicioPublicacion Desc')

                ->all();
    }
    
    public static function traerNoticiaEspecifica($idContenido){
        return $noticias = Contenido::find()->with(['objUsuarioPublicacion', 'listComentarios', 'listAdjuntos','listMeGusta', 'listComentarios','listMeGustaUsuario', 'objDenuncioComentarioUsuario'])->where(
                           ['and',
                                ['<=', 'fechaInicioPublicacion', 'now()'],
                                ['=', 'idContenido', $idContenido],
                                ['=', 'estado', 2]
                             ]
                            )->one();
    }
    
    

    public function getListComentarios()
    {
        return $this->hasMany(ContenidosComentarios::className(), ['idContenido' => 'idContenido']);
    }
    
    public function getListMeGusta()
    {
        return $this->hasMany(MeGustaContenidos::className(), ['idContenido' => 'idContenido']);
    }
    
    public function getListMeGustaUsuario()
    {
        return $this->hasMany(MeGustaContenidos::className(), ['idContenido' => 'idContenido'])->andOnCondition(['numeroDocumento' => Yii::$app->user->identity->numeroDocumento]);
    }
    
    public function getObjDenuncioComentarioUsuario()
    {
        return $this->hasOne(DenunciosContenidos::className(), ['idContenido' => 'idContenido'])->andOnCondition(['idUsuarioDenunciante' => Yii::$app->user->identity->numeroDocumento]);
    }

    public function getListAdjuntos()
    {
        return $this->hasMany(ContenidosAdjuntos::className(), ['idContenido' => 'idContenido']);
    }
    
    public function getListContenidosDestinos()
    {
        return $this->hasMany(ContenidoDestino::className(), ['idContenido' => 'idContenido']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObjUsuarioPublicacion()
    {
        return $this->hasOne(Usuario::className(), ['idUsuario' => 'idUsuarioPublicacion']);
    }
    
    public function meGusta($idUsuario){
        
    }
}
