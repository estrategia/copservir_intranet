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
            [['estadoCurso', 'idTipoContenido', 'nombreCurso', 'presentacionCurso', 'cursoGruposInteres', 'fechaInicio'], 'required']
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

    public function activarCurso()
    {
        $modulos = $this->modulos;
        foreach ($modulos as $key => $modulo) {
            # code...
        }
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
