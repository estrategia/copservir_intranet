<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\models;

use Yii;
use app\modules\intranet\models\GrupoInteres;

/**
 * This is the model class for table "m_FORCO_Modulo".
 *
 * @property integer $idModulo
 * @property string $nombreModulo
 * @property string $descripcionModulo
 * @property integer $estadoModulo
 * @property string $fechaCreacion
 * @property string $fechaActualizacion
 */
class Modulo extends \yii\db\ActiveRecord
{
    const ESTADO_ACTIVO = 1;
    const ESTADO_INACTIVO = 0;
    public $moduloGruposInteres;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'm_FORCO_Modulo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombreModulo', 'descripcionModulo', 'estadoModulo', 'idCurso', 'moduloGruposInteres'], 'required'],
            [['estadoModulo', 'idCurso', 'duracionDias'], 'integer'],
            [['fechaCreacion', 'fechaActualizacion', 'fechaInicio', 'fechaFin', 'descripcionModulo'], 'safe'],
            [['nombreModulo'], 'string', 'max' => 45],
            [['descripcionModulo'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idModulo' => 'Id Módulo',
            'idCurso' => 'Id Curso',
            'nombreModulo' => 'Nombre',
            'descripcionModulo' => 'Descripción',
            'estadoModulo' => 'Estado',
            'fechaCreacion' => 'Fecha Creación',
            'fechaActualizacion' => 'Fecha Actualización',
            'duracionDias' => 'Dias de duracion',
            'fechaInicio' => 'Fecha Inicio',
            'fechaFin' => 'Fecha Fin'
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

    public function guardarGruposInteres($gruposInteres)
    {
        foreach ($gruposInteres as $indice => $grupoInteres) {
            $moduloGruposInteres = new ModuloGruposInteres;
            $moduloGruposInteres->idModulo = $this->idModulo;
            $moduloGruposInteres->idGrupoInteres = $gruposInteres[$indice];
            // \yii\helpers\VarDumper::dump($moduloGruposInteres, 10,true);
            $moduloGruposInteres->save();
        }
    }

    public function setModuloGruposInteres()
    {
        $idsGrupos = [];
        foreach ($this->objModuloGruposInteres as $grupo) {
            $idsGrupos[] = $grupo->idGrupoInteres;
        }
        $this->moduloGruposInteres = $idsGrupos;
    }

    public function actualizarGrupos($gruposSelect)
    {
        $paraCrear = [];
        $paraEliminar = [];
        $idsGrupos = [];
        $array1 = [];
        $array2 = [];
        $gruposAsignados = ModuloGruposInteres::find()->where(['idModulo' => $this->idModulo])->all();
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
            ModuloGruposInteres::deleteAll(['and', 'idModulo = :modulo', ['in', 'idGrupoInteres', $paraEliminar]],[
                ':modulo' => $this->idModulo
            ]);
        }

        foreach ($paraCrear as $idGrupo) {
            $nuevoGrupo = new ModuloGruposInteres;
            $nuevoGrupo->idModulo = $this->idModulo;
            $nuevoGrupo->idGrupoInteres = $idGrupo;
            $nuevoGrupo->save();
        }
    }

    public function getCurso()
    {
        return $this->hasOne(Curso::className(), ['idCurso' => 'idCurso']);
    }

    public function getCapitulos()
    {
        return $this->hasMany(Capitulo::className(), ['idModulo' => 'idModulo']);
    }

    public function getCapitulosActivos()
    {
        return $this->hasMany(Capitulo::className(), ['idModulo' => 'idModulo'])->andWhere(['estadoCapitulo' => Capitulo::ESTADO_ACTIVO])->all();
    }

    public function getObjModuloGruposInteres()
    {
        return $this->hasMany(ModuloGruposInteres::className(), ['idModulo' => 'idModulo']);
    }

    public function getObjGruposInteres()
    {
        return $this->hasMany(GrupoInteres::className(), ['idGrupoInteres' => 'idGrupoInteres'])->via('objModuloGruposInteres');
    }
}
