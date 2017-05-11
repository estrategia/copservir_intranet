<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "m_FORCO_OpcionRespuesta".
 *
 * @property string $idOpcionRespuesta
 * @property string $idPregunta
 * @property string $respuesta
 * @property integer $esCorrecta
 *
 * @property MFORCOPregunta $idPregunta0
 * @property TFORCORespuestas[] $tFORCORespuestas
 */
class OpcionRespuesta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	
    public static function tableName()
    {
        return 'm_FORCO_OpcionRespuesta';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idPregunta', 'respuesta'], 'required'],
            [['idPregunta', 'esCorrecta'], 'integer'],
            [['respuesta'], 'string', 'max' => 250],
            [['idPregunta'], 'exist', 'skipOnError' => true, 'targetClass' => Pregunta::className(), 'targetAttribute' => ['idPregunta' => 'idPregunta']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idOpcionRespuesta' => 'Id Opcion Respuesta',
            'idPregunta' => 'Id Pregunta',
            'respuesta' => 'Respuesta',
            'esCorrecta' => 'Es Correcta',
        ];
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
    public function getListRespuestas()
    {
        return $this->hasMany(Respuestas::className(), ['idOpcionRespuesta' => 'idOpcionRespuesta']);
    }
    
    public function getObjRespuestaUsuario(){
    	return $this->hasOne(Respuestas::className(), ['idOpcionRespuesta' => 'idOpcionRespuesta', ])->where('numeroDocumento =:documento AND idCuestionario =:cuestionario', 
    			[':documento' => Yii::$app->user->identity->numeroDocumento, ':cuestionario' => ''] );
    }
    
    
    public function search($params){ 
    	$query = self::find();
    	
    	$dataProvider = new ActiveDataProvider([
    			'query' => $query,
    	]);
    	
    	$this->load($params);
    	$query->andFilterWhere([
    			'idOpcionRespuesta' => $this->idOpcionRespuesta,
    			'idPregunta' => $this->idPregunta,
    			'respuesta' => $this->respuesta,
    			'esCorrecta' => $this->esCorrecta,
    	]);
    	
    	return $dataProvider;
    }
    
    
    
    
}
