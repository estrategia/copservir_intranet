<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\models;

use Yii;
use yii\web\UploadedFile;
use app\modules\intranet\models\GrupoInteres;

/**
 * This is the model class for table "m_FORCO_Curso".
 *
 * @property integer $idCurso
 * @property string $nombreCurso
 * @property string $presentacionCurso
 * @property integer $estadoCurso
 * @property string $fechaCreacion
 * @property string $fechaActualizacion
 */
class Curso extends \yii\db\ActiveRecord
{
    const ESTADO_ACTIVO = 1;
    const ESTADO_INACTIVO = 0;
    const TIPO_OBLIGATORIO = 1;
    const TIPO_OPCIONAL = 0;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'm_FORCO_Curso';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['estadoCurso', 'idCurso', 'cantidadPuntos', 'tipoCurso', 'orden'], 'integer'],
            [['fechaCreacion', 'fechaActualizacion', 'fechaInicio', 'fechaFin', 'fechaActivacion'], 'safe'],
            [['nombreCurso'], 'string', 'max' => 45],
            [['presentacionCurso'], 'string', 'max' => 250],
            [['estadoCurso', 'nombreCurso', 'presentacionCurso', 'fechaInicio', 'cantidadPuntos', 'tipoCurso'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idCurso' => 'Id Programa',
            'nombreCurso' => 'Nombre Programa',
            'presentacionCurso' => 'Presentacion Programa',
            'cantidadPuntos' => 'Cantidad Puntos',
            'estadoCurso' => 'Estado Programa',
            'fechaInicio' => 'Fecha Inicio',
            'fechaFin' => 'Fecha Fin',
            'fechaCreacion' => 'Fecha Creacion',
            'fechaActualizacion' => 'Fecha Actualizacion',
            'fechaActivacion' => 'Fecha Activacion',
            'tipoCurso' => 'Tipo Programa',
            'orden' => 'Orden'
        ];
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->fechaCreacion = date("Y-m-d H:i:s");
            } 
            return true;
        } else {
            return false;
        }
    }
    // Retorna false si no existe el registro, de lo contrario retorna el registro.
    public function leido()
    {
        $numeroDocumento = Yii::$app->user->identity->numeroDocumento;
        $connection = Yii::$app->db;
        $cursoUsuario = $connection->createCommand("SELECT * FROM t_FORCO_CursosUsuario WHERE numeroDocumento={$numeroDocumento} AND idCurso={$this->idCurso}")->queryOne();
        return $cursoUsuario;
    }

    public function calcularPromedioCalificacion()
    {
        $connection = Yii::$app->db;
        $query = "
            UPDATE m_FORCO_Curso 
                SET promedioCalificacion = (
                    SELECT AVG(calificacion.calificacion) FROM t_FORCO_ContenidoCalificacion calificacion
                    JOIN m_FORCO_Contenido contenido
                        ON calificacion.idContenido = contenido.idContenido
                    JOIN m_FORCO_Capitulo capitulo
                        ON contenido.idCapitulo = capitulo.idCapitulo
                    JOIN m_FORCO_Modulo modulo
                        ON capitulo.idModulo = modulo.idModulo
                    JOIN (SELECT idCurso FROM m_FORCO_Curso) curso
                        ON modulo.idCurso = curso.idCurso
                    WHERE curso.idCurso = {$this->idCurso}
                )
            WHERE m_FORCO_Curso.idCurso = {$this->idCurso}
        ";
        $command = $connection->createCommand($query)->execute();
    }

    public function activar()
    {
        $fechaInicioCurso = $this->fechaInicio;
        $modulos = $this->modulos;
        $fechaAcumulada = $fechaInicioCurso;
        foreach ($modulos as $key => $modulo) {
            $modulo->fechaInicio = $fechaAcumulada;
            $modulo->estadoModulo = Modulo::ESTADO_ACTIVO;
            $fechaAcumulada = date('Y-m-d H:i:s', strtotime($fechaAcumulada . "+ {$modulo->duracionDias} days"));
            $modulo->fechaFin = $fechaAcumulada;
            $modulo->save();
        }
        $this->fechaFin = $fechaAcumulada;
        $this->estadoCurso = self::ESTADO_ACTIVO;

        if ($this->save()) {
            return true;
        }
        return false;
    }

    // public function getModulosActivosUsuario()
    // {   
    //     // $numeroDocumento = Yii::$app->user->identity->numeroDocumento;
    //     $gruposInteres = (array) Yii::$app->user->identity->getGruposCodigos();   
    //     $modulos = Modulo::find()->joinWith('objGruposInteres')
    //         ->where([
    //             'estado' => Modulo::ESTADO_ACTIVO,
    //             'm_GrupoInteres.idGrupoInteres' => $gruposInteres
    //         ])
    //         ->all();
    //     return $modulos;
    // }

    public static function consultarActivosObligatorios()
    {
        return self::find()
            ->where(['tipoCurso' => self::TIPO_OBLIGATORIO])
            ->andWhere(['estadoCurso' => self::ESTADO_ACTIVO])
            ->andWhere(['<=', 'fechaInicio', date("Y-m-d H:i:s")]);
    }

    public static function consultarActivosOpcionales()
    {
        return self::find()
            ->where(['tipoCurso' => self::TIPO_OPCIONAL])
            ->andWhere(['estadoCurso' => self::ESTADO_ACTIVO])
            ->andWhere(['<=', 'fechaInicio', date("Y-m-d H:i:s")]);
    }

    public static function consultarActivosObligatoriosRecomendados()
    {
        return self::find()
            ->where(['tipoCurso' => self::TIPO_OBLIGATORIO])
            ->andWhere(['estadoCurso' => self::ESTADO_ACTIVO])
            ->andWhere(['<=', 'fechaInicio', date("Y-m-d H:i:s")])
            ->orderBy(['cantidadPuntos' => SORT_DESC]);
    }

    public static function consultarActivosOpcionalesRecomendados()
    {
        return self::find()
            ->where(['tipoCurso' => self::TIPO_OPCIONAL])
            ->andWhere(['estadoCurso' => self::ESTADO_ACTIVO])
            ->andWhere(['<=', 'fechaInicio', date("Y-m-d H:i:s")])
            ->orderBy(['cantidadPuntos' => SORT_DESC]);
    }

    public static function getContenidos($idCurso)
    {
        $contenidos = Contenido::find()
            ->joinWith('capitulo capitulo')
            ->joinWith('capitulo.modulo modulo')
            ->joinWith('capitulo.modulo.curso curso')
            ->where(['curso.idCurso' => $idCurso])
            ->all();
        return $contenidos;
    }

    public function getModulos()
    {
        return $this->hasMany(Modulo::className(), ['idCurso' => 'idCurso'])->orderBy(['orden' => SORT_ASC]);
    }

    public function getModulosActivos()
    {
        return $this->hasMany(Modulo::className(), ['idCurso' => 'idCurso'])->andWhere(['estadoModulo' => Modulo::ESTADO_ACTIVO])->all();
    }

    public function asignarPuntos()
    {
        $tipoContenido = $this->tipoContenido;
        $parametroPunto = ParametrosPuntos::find()
            // ->where(['idTipoContenido' => $tipoContenido->idTipoContenido])
            ->andWhere(['tipoParametro' => ParametrosPuntos::PARAMETRO_TIPO_CONTENIDO])
            ->andWhere(['estado' => ParametrosPuntos::ESTADO_ACTIVO])
            ->one();
        $puntos = new Puntos();
        $puntos->numeroDocumento = Yii::$app->user->identity->numeroDocumento;
        $puntos->valorPuntos = $parametroPunto->valorPuntosExtra;
        $puntos->descripcionPunto = "CURSO LEIDO";
        $puntos->idParametroPunto = $parametroPunto->idParametroPunto;
        $puntos->tipoParametro = ParametrosPuntos::PARAMETRO_TIPO_CONTENIDO;
        $puntos->idTipoContenido = $tipoContenido->idTipoContenido;
        $puntos->idCurso = $this->idCurso;
        $puntos->save();
    }

    public function preguntaCuestionario()
    {
        if ($this->leido() != false && $this->cuestionario != null) {
            return $this->cuestionario->idCuestionario;
        }
        return false;
    }

    public function getCuestionario()
    {
        return $this->hasOne(Cuestionario::className(), ['idCurso' => 'idCurso'])->andWhere("idContenido is NULL and estado = 1");
    }

    public function getContenidosLeidosUsuario()
    {
        return $this->hasMany(ContenidoLeidoUsuario::className(), ['idCurso' => 'idCurso']);
    }

    public function getCursosUsuario()
    {
        return $this->hasMany(CursosUsuario::className(), ['idCurso' => 'idCurso']);
    }

    public function porcentajeCompletado()
    {
        $numeroDocumento = Yii::$app->user->identity->numeroDocumento;
    
        $contenidosLeidosCurso = ContenidoLeidoUsuario::find()
            ->joinWith('contenido')
            ->where(['numeroDocumento' => $numeroDocumento])
            ->andWhere(['m_FORCO_Contenido.idCurso' => $this->idCurso])
            ->andWhere(['estadoContenido' => Contenido::ESTADO_ACTIVO])
            ->all();

        $contenidosAsignados = Contenido::find()
            ->joinWith('capitulo.modulo.curso')
            ->where(['m_FORCO_Curso.idCurso' => $this->idCurso])
            // ->andWhere(['estadoCurso' => Curso::ESTADO_ACTIVO])
            // ->andWhere(['m_FORCO_Modulo.idModulo' => Modulo::ESTADO_ACTIVO])
            // ->andWhere(['m_FORCO_Capitulo.idCapitulo' => Capitulo::ESTADO_ACTIVO])
            ->andWhere(['estadoContenido' => Contenido::ESTADO_ACTIVO])
            ->all();
            // ->distinct();
        // var_dump($contenidosAsignados->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql);
        // $contenidosAsignados->all();
        $cantidadTerminados = 0;
        $cantidadAsignados = 0;

        if (isset($contenidosLeidosCurso)) {
            $cantidadTerminados = count($contenidosLeidosCurso);
        }
        if (isset($contenidosAsignados)) {
            $cantidadAsignados = count($contenidosAsignados);
        }

        $porcentajeCompletado = 0;
        if ($cantidadAsignados > 0) {
            $porcentajeCompletado = $cantidadTerminados * 100 / $cantidadAsignados;
        }
        return $porcentajeCompletado;
    }
}
