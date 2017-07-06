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
            [['estadoCurso', 'idCurso', 'cantidadPuntos', 'idTercero'], 'integer'],
            [['fechaCreacion', 'fechaActualizacion', 'fechaInicio', 'fechaFin', 'fechaActivacion'], 'safe'],
            [['nombreCurso'], 'string', 'max' => 45],
            [['presentacionCurso'], 'string', 'max' => 250],
            [['estadoCurso', 'nombreCurso', 'presentacionCurso', 'fechaInicio', 'cantidadPuntos'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idCurso' => 'Id Curso',
            'nombreCurso' => 'Nombre Curso',
            'presentacionCurso' => 'Presentacion Curso',
            'cantidadPuntos' => 'Cantidad Puntos',
            'idTercero' => 'Proveedor',
            'estadoCurso' => 'Estado Curso',
            'fechaInicio' => 'Fecha Inicio',
            'fechaFin' => 'Fecha Fin',
            'fechaCreacion' => 'Fecha Creacion',
            'fechaActualizacion' => 'Fecha Actualizacion',
            'fechaActivacion' => 'Fecha Activacion',
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

    public function marcarLeido()
    {
        if ($this->leido() == false) {
            $numeroDocumento = Yii::$app->user->identity->numeroDocumento;
            $connection = Yii::$app->db;
            $query = "
                SELECT SUM(xxxx.leido) as porLeer FROM
                    (SELECT (
                        CASE  t_FORCO_ContenidoLeidoUsuario.numeroDocumento 
                            WHEN {$numeroDocumento}
                            THEN 0 
                            ELSE 1 
                            END) 
                    AS leido
                    FROM m_FORCO_Contenido 
                    LEFT JOIN t_FORCO_ContenidoLeidoUsuario
                    ON t_FORCO_ContenidoLeidoUsuario.idContenido = m_FORCO_Contenido.idContenido
                    WHERE m_FORCO_Contenido.idCurso = $this->idCurso
                    AND (t_FORCO_ContenidoLeidoUsuario.numeroDocumento = {$numeroDocumento} 
                    OR t_FORCO_ContenidoLeidoUsuario.numeroDocumento IS NULL)) xxxx
            ";
            $command = $connection->createCommand($query);
            $leido = $command->queryOne()['porLeer'];
            if ($leido == '0') {
                $fechaInicioLectura = ContenidoLeidoUsuario::find()
                    ->where(['numeroDocumento' => $numeroDocumento, 'idCurso' => $this->idCurso])
                    ->orderBy("fechaCreacion ASC")
                    ->one()->fechaCreacion;
                $connection->createCommand()
                    ->insert('t_FORCO_CursosUsuario', [
                            'idCurso' => $this->idCurso,
                            'numeroDocumento' => $numeroDocumento,
                            'fechaCreacion' => date("Y-m-d H:i:s"),
                            'fechaInicioLectura' => $fechaInicioLectura
                        ])
                    ->execute();
                $this->asignarPuntos();
            }
            return $leido;
        }
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
        // $this->validate();
        // \yii\helpers\VarDumper::dump($this->errors,10,true);
        if ($this->save()) {
            return true;
        }
        return false;
    }

    public function getModulosActivosUsuario()
    {   
        // $numeroDocumento = Yii::$app->user->identity->numeroDocumento;
        $gruposInteres = (array) Yii::$app->user->identity->getGruposCodigos();   
        $modulos = Modulo::find()->joinWith('objGruposInteres')
            ->where([
                'estado' => Modulo::ESTADO_ACTIVO,
                'm_GrupoInteres.idGrupoInteres' => $gruposInteres
            ])
            ->all();
        return $modulos;
    }

    public function getModulos()
    {
        return $this->hasMany(Modulo::className(), ['idCurso' => 'idCurso']);
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
        return $this->hasOne(Cuestionario::className(), ['idCurso' => 'idCurso']);
    }

    public function getContenidosLeidosUsuario()
    {
        return $this->hasMany(ContenidoLeidoUsuario::className(), ['idCurso' => 'idCurso']);
    }

    public function getCursosUsuario()
    {
        return $this->hasMany(CursosUsuario::className(), ['idCurso' => 'idCurso']);
    }

}
