<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\models;

use Yii;
use app\modules\intranet\models\GrupoInteres;

/**
 * This is the model class for table "m_FORCO_Capitulo".
 *
 * @property integer $idCapitulo
 * @property string $nombreCapitulo
 * @property string $descripcionCapitulo
 * @property integer $estadoCapitulo
 * @property string $fechaCreacion
 * @property string $fechaActualizacion
 */
class Capitulo extends \yii\db\ActiveRecord
{
    const ESTADO_ACTIVO = 1;
    const ESTADO_INACTIVO = 0;
    public $capituloGruposInteres;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'm_FORCO_Capitulo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombreCapitulo', 'descripcionCapitulo', 'estadoCapitulo', 'idModulo'], 'required'],
            [['estadoCapitulo', 'idCapitulo'], 'integer'],
            [['fechaCreacion', 'fechaActualizacion', 'capituloGruposInteres'], 'safe'],
            [['nombreCapitulo'], 'string', 'max' => 45],
            [['descripcionCapitulo'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idCapitulo' => 'Id Capítulo',
            'nombreCapitulo' => 'Nombre',
            'descripcionCapitulo' => 'Descripción',
            'estadoCapitulo' => 'Estado',
            'fechaCreacion' => 'Fecha Creación',
            'fechaActualizacion' => 'Fecha Actualización',
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

    public function getModulo()
    {
        return $this->hasOne(Modulo::className(), ['idCapitulo' => 'idCapitulo']);
    }

    public function getContenidos()
    {
        return $this->hasMany(Contenido::className(), ['idCapitulo' => 'idCapitulo']);
    }

    public function getContenidosActivos()
    {
        return $this->hasMany(Contenido::className(), ['idCapitulo' => 'idCapitulo'])->andWhere(['estadoContenido' => Contenido::ESTADO_ACTIVO])->all();
    }

    public function guardarGruposInteres($gruposInteres)
    {
        foreach ($gruposInteres as $indice => $grupoInteres) {
            $moduloGruposInteres = new CapituloGruposInteres;
            $moduloGruposInteres->idCapitulo = $this->idCapitulo;
            $moduloGruposInteres->idGrupoInteres = $gruposInteres[$indice];
            // \yii\helpers\VarDumper::dump($moduloGruposInteres, 10,true);
            $moduloGruposInteres->save();
        }
    }

    public function setCapituloGruposInteres()
    {
        $idsGrupos = [];
        foreach ($this->objCapituloGruposInteres as $grupo) {
            $idsGrupos[] = $grupo->idGrupoInteres;
        }
        $this->capituloGruposInteres = $idsGrupos;
    }

    public function actualizarGrupos($gruposSelect)
    {
        $paraCrear = [];
        $paraEliminar = [];
        $idsGrupos = [];
        $array1 = [];
        $array2 = [];
        $gruposAsignados = CapituloGruposInteres::find()->where(['idCapitulo' => $this->idCapitulo])->all();
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
            CapituloGruposInteres::deleteAll(['and', 'idCapitulo = :capitulo', ['in', 'idGrupoInteres', $paraEliminar]],[
                ':capitulo' => $this->idCapitulo
            ]);
        }

        foreach ($paraCrear as $idGrupo) {
            $nuevoGrupo = new CapituloGruposInteres;
            $nuevoGrupo->idCapitulo = $this->idCapitulo;
            $nuevoGrupo->idGrupoInteres = $idGrupo;
            $nuevoGrupo->save();
        }
    }

    public function getObjCapituloGruposInteres()
    {
        return $this->hasMany(CapituloGruposInteres::className(), ['idCapitulo' => 'idCapitulo']);
    }

    public function getObjGruposInteres()
    {
        return $this->hasMany(GrupoInteres::className(), ['idGrupoInteres' => 'idGrupoInteres'])->via('objModuloGruposInteres');
    }
}
