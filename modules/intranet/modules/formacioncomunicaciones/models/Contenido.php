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
    const ESTADO_LEIDO = 1;
    const ESTADO_NO_LEIDO = 0;
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
            [['tituloContenido', 'descripcionContenido', 'idCapitulo', 'tiempoRequerido', 'idTercero', 'cantidadPuntos'], 'required'],
            [['contenido'], 'required', 'on' => 'contenido'],
            [['tituloContenido', 'descripcionContenido', 'contenido'], 'string'],
            [['estadoContenido', 'idCapitulo', 'idContenidoCopia', 'frecuenciaMes', 'idCurso', 'tiempoRequerido', 'orden'], 'integer'],
            [['fechaCreacion', 'fechaActualizacion', 'nombreProveedor'], 'safe'],
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
            'idCapitulo' => 'Capítulo',
            'idContenidoCopia' => 'Contenido Copia',
            'frecuenciaMes' => 'Frecuencia Mes',
            'fechaCreacion' => 'Fecha Creación',
            'fechaActualizacion' => 'Fecha Actualización',
            'idCurso' => 'Id Curso',
            'tiempoRequerido' => 'Tiempo requerido (minutos)',
            'idTercero' => 'Proveedor',
            'cantidadPuntos' => 'Cantidad Puntos',
            'orden' => 'Orden'
        ];
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->fechaCreacion = date("Y-m-d H:i:s");
                $this->idCurso = $this->capitulo->modulo->curso->idCurso;
            } 
            return true;
        } else {
            return false;
        }
    }

    // public function getModulo()
    // {
    //     return $this->hasOne(Modulo::className(), ['idContenido' => 'idContenido']);
    // }

    public function getContenidoLeidoUsuario()
    {
        $numeroDocumento = Yii::$app->user->identity->numeroDocumento;
        return $this->hasOne(ContenidoLeidoUsuario::className(), ['idContenido' => 'idContenido'])->andWhere(['numeroDocumento' => $numeroDocumento])->one();
    }

    public function getContenidosLeidosUsuario()
    {
        return $this->hasMany(ContenidoLeidoUsuario::className(), ['idContenido' => 'idContenido']);
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
    public function getContenidoCopia()
    {
        return $this->hasOne(Contenido::className(), ['idContenido' => 'idContenidoCopia']);
    }

    public function getContenidoCalificaciones()
    {
        return $this->hasMany(ContenidoCalificacion::className(), ['idContenido' => 'idContenido']);
    }
    
    public function getCuestionario()
    {
    	return $this->hasOne(Cuestionario::className(), ['idContenido' => 'idContenido'])->andWhere("estado = 1");
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContenidos()
    {
        return $this->hasMany(Contenido::className(), ['idContenidoCopia' => 'idContenido']);
    }

    public function resumenCalificaciones()
    {
        $datos = [
            '1' => '', 
            '2' => '', 
            '3' => '', 
            '4' => '', 
            '5' => '', 
            'total' => '', 
            'promedio' => '',
            'cantidad' => ''
        ];
        $total = 0;
        $suma = 0;
        $cantidad = 0;
        $calificaciones = $this->contenidoCalificaciones;
        foreach ($calificaciones as $calificacion) {
            switch ($calificacion->calificacion) {
                case 1:
                    $datos['1'] ++;
                    break;
                case 2:
                    $datos['2'] ++;
                    break;
                case 3:
                    $datos['3'] ++;
                    break;
                case 4:
                    $datos['4'] ++;
                    break;
                case 5:
                    $datos['5'] ++;
                    break;
            }
            $suma += $calificacion->calificacion;
            $total ++;
        }
        $cantidad = 0;
        if ($total == 0) {
            $promedio = 0;
            $datos['total'] = 1;
        } else {
            $promedio = $suma / $total;
            $datos['total'] = $total;
        }

        $datos['cantidad'] = $cantidad;
        $datos['promedio'] = $promedio;
        return $datos;
    }

    public function cargarPaquete()
    {
        return $_FILES;
    }

    public static function consultarContenidosPendientesUsuario()
    {
        $gruposInteres = (array) Yii::$app->user->identity->getGruposCodigos();
        $gruposInteres[] = 999999;
        $numeroDocumento = Yii::$app->user->identity->numeroDocumento;
        $subQueryModulos = Modulo::find()
            ->select('idModulo')
            ->joinWith('curso')
            ->where(['estadoModulo' => Modulo::ESTADO_ACTIVO])
            ->andWhere(['estadoCurso' => Curso::ESTADO_ACTIVO]);

        $capitulosObligatorios = Capitulo::find()
            ->select('m_FORCO_Capitulo.idCapitulo')
            ->joinWith('objGruposInteres')
            ->where([
                'estadoCapitulo' => Capitulo::ESTADO_ACTIVO,
                'idModulo' => $subQueryModulos,
                'm_GrupoInteres.idGrupoInteres' => $gruposInteres,
            ]);

        $contenidosLeidos = ContenidoLeidoUsuario::find()
            ->joinWith('contenido')
            ->where(['numeroDocumento' => $numeroDocumento])
            ->andWhere(['estadoContenido' => Contenido::ESTADO_ACTIVO])
            ->all();
        
        $idsTerminados = \yii\helpers\ArrayHelper::getColumn($contenidosLeidos, 'idContenido');

        $contenidosPendientes = Contenido::find()
            // ->select('idContenido')
            ->where(['idCapitulo' => $capitulosObligatorios])
            ->andWhere(['NOT IN', 'idContenido', $idsTerminados])
            ->andWhere(['estadoContenido' => Contenido::ESTADO_ACTIVO]);
            // ->count();

        return $contenidosPendientes;
    }

}
