<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\models;

use Yii;

/**
 * This is the model class for table "m_FORCO_Contenido".
 *
 * @property integer $idContenido
 * @property string $contenido
 * @property integer $estadoContenido
 * @property integer $idAreaConocimiento
 * @property integer $idModulo
 * @property integer $idCapitulo
 * @property integer $idTipoContenido
 * @property integer $idContenidoCopia
 * @property string $fechaInicio
 * @property string $fechaFin
 * @property integer $frecuenciaMes
 * @property string $fechaCreacion
 * @property string $fechaActualizacion
 *
 * @property MFORCOArea $idAreaConocimiento0
 * @property MFORCOModulo $idModulo0
 * @property MFORCOCapitulo $idCapitulo0
 * @property MFORCOTipoContenido $idTipoContenido0
 * @property Contenido $idContenidoCopia0
 * @property Contenido[] $contenidos
 */
class Contenido extends \yii\db\ActiveRecord
{
    const ESTADO_ACTIVO = 1;
    const ESTADO_INACTIVO = 0;
    const FRECUENCIA_SEMESTRAL = 1;
    const FRECUENCIA_ANUAL = 2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'm_FORCO_Contenido';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['contenido', 'idAreaConocimiento', 'tituloContenido', 'descripcionContenido', 'idModulo', 'idCapitulo', 'idTipoContenido', 'fechaInicio', 'fechaFin'], 'required'],
            [['tituloContenido', 'descripcionContenido', 'contenido'], 'string'],
            [['estadoContenido', 'idAreaConocimiento', 'idModulo', 'idCapitulo', 'idTipoContenido', 'idContenidoCopia', 'frecuenciaMes'], 'integer'],
            [['fechaInicio', 'fechaFin', 'fechaCreacion', 'fechaActualizacion'], 'safe'],
            // [['idAreaConocimiento'], 'exist', 'skipOnError' => true, 'targetClass' => Area::className(), 'targetAttribute' => ['idAreaConocimiento' => 'idAreaConocimiento']],
            // [['idModulo'], 'exist', 'skipOnError' => true, 'targetClass' => Modulo::className(), 'targetAttribute' => ['idModulo' => 'idModulo']],
            // [['idCapitulo'], 'exist', 'skipOnError' => true, 'targetClass' => Capitulo::className(), 'targetAttribute' => ['idCapitulo' => 'idCapitulo']],
            // [['idTipoContenido'], 'exist', 'skipOnError' => true, 'targetClass' => TipoContenido::className(), 'targetAttribute' => ['idTipoContenido' => 'idTipoContenido']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idContenido' => 'Id Contenido',
            'tituloContenido' => 'Título',
            'descripcionContenido' => 'Descripción',
            'contenido' => 'Contenido',
            'estadoContenido' => 'Estado',
            'idAreaConocimiento' => 'Área de Conocimiento',
            'idModulo' => 'Módulo',
            'idCapitulo' => 'Capítulo',
            'idTipoContenido' => 'Tipo Contenido',
            'idContenidoCopia' => 'Contenido Copia',
            'fechaInicio' => 'Fecha Inicio',
            'fechaFin' => 'Fecha Fin',
            'frecuenciaMes' => 'Frecuencia Mes',
            'fechaCreacion' => 'Fecha Creación',
            'fechaActualizacion' => 'Fecha Actualización',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAreaConocimiento()
    {
        return $this->hasOne(Area::className(), ['idAreaConocimiento' => 'idAreaConocimiento']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModulo()
    {
        return $this->hasOne(Modulo::className(), ['idModulo' => 'idModulo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCapitulo()
    {
        return $this->hasOne(Capitulo::className(), ['idCapitulo' => 'idCapitulo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoContenido()
    {
        return $this->hasOne(TipoContenido::className(), ['idTipoContenido' => 'idTipoContenido']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContenidoCopia()
    {
        return $this->hasOne(Contenido::className(), ['idContenido' => 'idContenidoCopia']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContenidos()
    {
        return $this->hasMany(Contenido::className(), ['idContenidoCopia' => 'idContenido']);
    }
}
