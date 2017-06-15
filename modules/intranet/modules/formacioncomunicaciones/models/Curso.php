<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\models;

use Yii;
use yii\web\UploadedFile;

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
    const CRUD_SCENARIO = 'crud';
    const TIPO_OBLIGATORIO = 1;
    const TIPO_OPCIONAL = 0;
    public $cursoGruposInteres;
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
            [['estadoCurso', 'idCurso', 'idTipoContenido', 'tipoCurso'], 'integer'],
            [['fechaCreacion', 'fechaActualizacion', 'fechaInicio', 'fechaFin'], 'safe'],
            [['nombreCurso'], 'string', 'max' => 45],
            [['presentacionCurso'], 'string', 'max' => 250],
            [['rutaImagen'], 'string', 'max' => 100],
            [['estadoCurso', 'idTipoContenido', 'nombreCurso', 'presentacionCurso', 'fechaInicio', 'tipoCurso'], 'required'],
            [['cursoGruposInteres'], 'required', 'on' => 'crud']
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
            'estadoCurso' => 'Estado Curso',
            'cursoGruposInteres' => 'Grupos de Interes',
            'idTipoContenido' => 'Tipo Contenido',
            'fechaInicio' => 'Fecha Inicio',
            'fechaFin' => 'Fecha Fin',
            'fechaCreacion' => 'Fecha Creacion',
            'fechaActualizacion' => 'Fecha Actualizacion',
            'tipoCurso' => 'Tipo Curso'
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

    public function guardarGruposInteres($gruposInteres)
    {
        foreach ($gruposInteres as $indice => $grupoInteres) {
            $cursoGruposInteres = new CursoGruposInteres;
            $cursoGruposInteres->idCurso = $this->idCurso;
            $cursoGruposInteres->idGrupoInteres = $gruposInteres[$indice];
            // \yii\helpers\VarDumper::dump($cursoGruposInteres, 10,true);
            $cursoGruposInteres->save();
        }
    }

    public function getTipoContenido()
    {
        return $this->hasOne(TipoContenido::className(), ['idTipoContenido' => 'idTipoContenido']);
    }

    public function getModulos()
    {
        return $this->hasMany(Modulo::className(), ['idCurso' => 'idCurso']);
    }

    public function getModulosActivos()
    {
        return $this->hasMany(Modulo::className(), ['idCurso' => 'idCurso'])->andWhere(['estadoModulo' => Modulo::ESTADO_ACTIVO])->all();
    }

    public function getObjCursoGruposInteres()
    {
        return $this->hasMany(CursoGruposInteres::className(), ['idCurso' => 'idCurso']);
    }

    public function setCursoGruposInteres()
    {
        $idsGrupos = [];
        foreach ($this->objCursoGruposInteres as $grupo) {
            $idsGrupos[] = $grupo->idGrupoInteres;
        }
        $this->cursoGruposInteres = $idsGrupos;
    }

    public function actualizarGrupos($gruposSelect)
    {
        $paraCrear = [];
        $paraEliminar = [];
        $idsGrupos = [];
        $array1 = [];
        $array2 = [];
        $gruposAsignados = CursoGruposInteres::find()->where(['idCurso' => $this->idCurso])->all();
        foreach ($gruposAsignados as $grupo) {
            $idsGrupos[] = $grupo->idGrupoInteres;
        }

        if (!is_array($gruposSelect)) {
            $array1 = (array) $gruposSelect;
        } else {
            $array1 = $gruposSelect;
        }
        if (!is_array($idsGrupos)) {
            $array2 = (array) $idsGrupos;
        } else {
            $array2 = $idsGrupos;
        }
        $paraCrear = array_diff($array1, $array2);
        $paraEliminar = array_diff($array2, $array1);

        // print_r($gruposSelect);
        if (!empty($paraEliminar)) {
            CursoGruposInteres::deleteAll(['and', 'idCurso = :curso', ['in', 'idGrupoInteres', $paraEliminar]],[
                ':curso' => $this->idCurso
            ]);
        }

        foreach ($paraCrear as $idGrupo) {
            $nuevoGrupo = new CursoGruposInteres;
            $nuevoGrupo->idCurso = $this->idCurso;
            $nuevoGrupo->idGrupoInteres = $idGrupo;
            $nuevoGrupo->save();
        }
    }

    public function asignarPuntos()
    {
        $tipoContenido = $this->tipoContenido;
        $parametroPunto = ParametrosPuntos::find()
            ->where(['idTipoContenido' => $tipoContenido->idTipoContenido])
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

    public function guardarImagen($rutaAnterior)
    {
        $imagen = UploadedFile::getInstance($this, 'rutaImagen'); // si no selecciona nada pone null
        if (!is_null($imagen)) {
            $nombre = time() . '_.' . $imagen->extension;
            $imagen->saveAs(Yii::getAlias('@webroot') . Yii::$app->params['formacioncomunicaciones']['rutaImagenCursos'] . $nombre);
            $this->rutaImagen = $nombre;
        }else{
            $this->rutaImagen = $rutaAnterior;
        }
    }

    public function getCuestionario()
    {
        return $this->hasOne(Cuestionario::className(), ['idCurso' => 'idCurso']);
    }

    public function getContenidosLeidosUsuario()
    {
        return $this->hasMany(ContenidoLeidoUsuario::className(), ['idCurso' => 'idCurso']);
    }

}
