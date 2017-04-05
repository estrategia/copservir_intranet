<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;


/**
 * This is the model class for table "m_FORCO_Pregunta".
 *
 * @property string $idPregunta
 * @property string $tituloPregunta
 * @property integer $numeroPregunta
 * @property string $pregunta
 * @property string $idPreguntaPadre
 * @property string $idTipoPregunta
 * @property string $idCuestionario
 * @property integer $estado
 * @property string $fechaCreacion
 * @property string $fechaActualizacion
 * @property MFORCOOpcionRespuesta[] $mFORCOOpcionRespuestas
 * @property Pregunta $idPreguntaPadre0
 * @property Pregunta[] $preguntas
 * @property MFORCOTipoPregunta $idTipoPregunta0
 * @property MFORCOCuestionario $idCuestionario0
 * @property TFORCORespuestas[] $tFORCORespuestas
 */
class Pregunta extends \yii\db\ActiveRecord
{
	const ESTADO_ACTIVO = 1;
	const ESTADO_INACTIVO = 0;
	
	const PREGUNTA_SELECCION_UNICA = 1;
	const PREGUNTA_SELECCION_MULTIPLE = 2;
	const PREGUNTA_FALSO_VERDADERO = 3;
	const PREGUNTA_COMPLETAR = 4;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'm_FORCO_Pregunta';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tituloPregunta', 'idTipoPregunta', 'idCuestionario', 'estado', 'fechaCreacion'], 'required'],
            [['idPreguntaPadre', 'idTipoPregunta', 'idCuestionario', 'estado'], 'integer'],
            [['pregunta'], 'string'],
            [['fechaCreacion', 'fechaActualizacion'], 'safe'],
            [['tituloPregunta'], 'string', 'max' => 45],
            [['idPreguntaPadre'], 'exist', 'skipOnError' => true, 'targetClass' => Pregunta::className(), 'targetAttribute' => ['idPreguntaPadre' => 'idPregunta']],
            [['idTipoPregunta'], 'exist', 'skipOnError' => true, 'targetClass' => TipoPregunta::className(), 'targetAttribute' => ['idTipoPregunta' => 'idTipoPregunta']],
            [['idCuestionario'], 'exist', 'skipOnError' => true, 'targetClass' => Cuestionario::className(), 'targetAttribute' => ['idCuestionario' => 'idCuestionario']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idPregunta' => 'Id Pregunta',
            'tituloPregunta' => 'Titulo Pregunta',
            'pregunta' => 'Pregunta',
            'idPreguntaPadre' => 'Id Pregunta Padre',
            'idTipoPregunta' => 'Id Tipo Pregunta',
            'idCuestionario' => 'Id Cuestionario',
            'estado' => 'Estado',
            'fechaCreacion' => 'Fecha Creacion',
            'fechaActualizacion' => 'Fecha Actualizacion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getListOpcionRespuestas()
    {
        return $this->hasMany(OpcionRespuesta::className(), ['idPregunta' => 'idPregunta'])->orderBy(new Expression('rand()'));
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObjPreguntaPadre()
    {
        return $this->hasOne(Pregunta::className(), ['idPregunta' => 'idPreguntaPadre']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getListPreguntasHijas()
    {
        return $this->hasMany(Pregunta::className(), ['idPreguntaPadre' => 'idPregunta']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObjTipoPregunta()
    {
        return $this->hasOne(TipoPregunta::className(), ['idTipoPregunta' => 'idTipoPregunta']);
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
    public function getListRespuestas()
    {
        return $this->hasMany(Respuestas::className(), ['idPregunta' => 'idPregunta']);
    }

    public function getObjRespuestaUsuario(){
    	return $this->hasOne(Respuestas::className(), ['idPregunta' => 'idPregunta', ])->where('numeroDocumento =:documento ', [':documento' => Yii::$app->user->identity->numeroDocumento] );
    }
    
     public function search($params, $id)
    {
        $query = self::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        $query->andFilterWhere([
            'idPregunta' => $this->idPregunta,
            'estado' => $this->estado,
            'idPreguntaPadre' => $this->idPreguntaPadre,
            'idTipoPregunta' => $this->idTipoPregunta,
            'idCuestionario' => $this->idCuestionario,
            'fechaCreacion' => $this->fechaCreacion,
            'fechaActualizacion' => $this->fechaActualizacion,
            'idCuestionario' => $id
        ]);

        return $dataProvider;
    }
}
