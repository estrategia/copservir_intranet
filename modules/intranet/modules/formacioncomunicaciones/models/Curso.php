<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\models;

use Yii;

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
            [['estadoCurso', 'idCurso', 'idTipoContenido'], 'integer'],
            [['fechaCreacion', 'fechaActualizacion', 'fechaInicio', 'fechaFin'], 'safe'],
            [['nombreCurso'], 'string', 'max' => 45],
            [['presentacionCurso'], 'string', 'max' => 250],
            [['estadoCurso', 'idTipoContenido', 'nombreCurso', 'presentacionCurso', 'fechaInicio'], 'required'],
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
                SELECT SUM(xxxx.leido) FROM
                    (SELECT (
                        case  t_FORCO_ContenidoLeidoUsuario.numeroDocumento 
                            when {$numeroDocumento}
                            then 0 
                            else 1 
                            end) 
                    as leido
                    FROM m_FORCO_Contenido 
                    LEFT JOIN t_FORCO_ContenidoLeidoUsuario
                    ON t_FORCO_ContenidoLeidoUsuario.idContenido = m_FORCO_Contenido.idContenido
                    WHERE m_FORCO_Contenido.idCurso = $this->idCurso
                    AND t_FORCO_ContenidoLeidoUsuario.numeroDocumento = {$numeroDocumento} 
                    OR t_FORCO_ContenidoLeidoUsuario.numeroDocumento IS NULL) xxxx
            ";
            $command = $connection->createCommand($query);
            $leido = $command->queryScalar();
            if ($leido == 0) {
                $connection->createCommand()
                    ->insert('t_FORCO_CursosUsuario', [
                            'idCurso' => $this->idCurso,
                            'numeroDocumento' => $numeroDocumento,
                            'fechaCreacion' => date("Y-m-d H:i:s")
                        ])
                    ->execute();
            }
        }
    }

    public function activar()
    {
        $fechaInicioCurso = $this->fechaInicio;
        $modulos = $this->modulosActivos;
        $fechaAcumulada = $fechaInicioCurso;
        foreach ($modulos as $key => $modulo) {
            $modulo->fechaInicio = $fechaAcumulada;
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
}
