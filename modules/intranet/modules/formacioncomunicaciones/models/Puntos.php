<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\models;

use Yii;
use app\models\Usuario;

/**
 * This is the model class for table "t_FORCO_Puntos".
 *
 * @property string $idPunto
 * @property string $numeroDocumento
 * @property string $valorPuntos
 * @property string $descripcionPunto
 * @property string $idCuestionario
 * @property string $idParametroPunto
 * @property integer $tipoParametro
 * @property string $idTipoContenido
 * @property string $condicion
 * @property string $fechaCreacion
 * @property string $idPuntoSincronizado
 *
 * @property MFORCOCuestionario $idCuestionario0
 * @property MFORCOParametrosPuntos $idParametroPunto0
 * @property MUsuario $numeroDocumento0
 */
class Puntos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_FORCO_Puntos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['numeroDocumento', 'valorPuntos', 'descripcionPunto'], 'required'],
            [['numeroDocumento', 'valorPuntos', 'idCuestionario', 'idParametroPunto', 'tipoParametro', 'idTipoContenido', 'condicion', 'idPuntoSincronizado'], 'integer'],
            [['fechaCreacion'], 'safe'],
            [['descripcionPunto'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idPunto' => 'Id Punto',
            'numeroDocumento' => 'Numero Documento',
            'valorPuntos' => 'Valor Puntos',
            'descripcionPunto' => 'Descripcion Punto',
            'idCuestionario' => 'Id Cuestionario',
            'idParametroPunto' => 'Id Parametro Punto',
            'tipoParametro' => 'Tipo Parametro',
            'idTipoContenido' => 'Id Tipo Contenido',
            'condicion' => 'Condicion',
            'fechaCreacion' => 'Fecha Creacion',
            'idPuntoSincronizado' => 'Id Punto Sincronizado',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObjCuestionario()
    {
        return $this->hasOne(Cuestionario::className(), ['idCuestionario' => 'idCuestionario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObjParametrosPuntos()
    {
        return $this->hasOne(ParametrosPuntos::className(), ['idParametroPunto' => 'idParametroPunto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObjUsuario()
    {
        return $this->hasOne(Usuario::className(), ['numeroDocumento' => 'numeroDocumento']);
    }
}
