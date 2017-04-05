<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\models;

use Yii;
use app\models\Usuario;

/**
 * This is the model class for table "t_FORCO_Respuestas".
 *
 * @property string $idRespuesta
 * @property string $numeroDocumento
 * @property string $idPregunta
 * @property string $idOpcionRespuesta
 *
 * @property MFORCOOpcionRespuesta $idOpcionRespuesta0
 * @property MFORCOPregunta $idPregunta0
 * @property MUsuario $numeroDocumento0
 */
class Respuestas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_FORCO_Respuestas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['numeroDocumento', 'idPregunta','idCuestionario','esCorrecta'], 'required'],
            [['numeroDocumento', 'idPregunta','idCuestionario', 'idOpcionRespuesta'], 'integer'],
            [['idOpcionRespuesta'], 'exist', 'skipOnError' => true, 'targetClass' => OpcionRespuesta::className(), 'targetAttribute' => ['idOpcionRespuesta' => 'idOpcionRespuesta']],
            [['idPregunta'], 'exist', 'skipOnError' => true, 'targetClass' => Pregunta::className(), 'targetAttribute' => ['idPregunta' => 'idPregunta']],
            [['numeroDocumento'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['numeroDocumento' => 'numeroDocumento']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idRespuesta' => 'Id Respuesta',
            'numeroDocumento' => 'Numero Documento',
            'idPregunta' => 'Id Pregunta',
        	'idCuestionario' => 'Id Cuestionario',
            'idOpcionRespuesta' => 'Id Opcion Respuesta',
        	'esCorrecta' => 'Correcta',
        	'respuestaTextual' => 'Respuesta',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObjOpcionRespuesta()
    {
        return $this->hasOne(OpcionRespuesta::className(), ['idOpcionRespuesta' => 'idOpcionRespuesta']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObjPregunta()
    {
        return $this->hasOne(Pregunta::className(), ['idPregunta' => 'idPregunta']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNumeroDocumento0()
    {
        return $this->hasOne(Usuario::className(), ['numeroDocumento' => 'numeroDocumento']);
    }
}
