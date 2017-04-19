<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\models;

use Yii;

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
            [['nombreModulo', 'descripcionModulo', 'estadoModulo', 'idCurso'], 'required'],
            [['estadoModulo', 'idCurso', 'duracionDias'], 'integer'],
            [['fechaCreacion', 'fechaActualizacion', 'fechaInicio', 'fechaFin'], 'safe'],
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
}
