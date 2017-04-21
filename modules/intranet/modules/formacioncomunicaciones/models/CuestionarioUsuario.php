<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\models;

use Yii;
use app\models\Usuario;

/**
 * This is the model class for table "t_FORCO_CuestionarioUsuario".
 *
 * @property string $idCuestionario
 * @property string $numeroDocumento
 * @property double $numeroPreguntasTotal
 * @property integer $numeroPreguntasRespondidas
 * @property integer $estadoCuestionario
 * @property string $fechaCreacion
 * @property string $fechaActualizacion
 *
 * @property MFORCOCuestionario $idCuestionario0
 * @property MUsuario $numeroDocumento0
 */
class CuestionarioUsuario extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_FORCO_CuestionarioUsuario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idCuestionario', 'numeroDocumento', 'estadoCuestionario', 'fechaCreacion'], 'required'],
            [['idCuestionario', 'numeroDocumento', 'estadoCuestionario'], 'integer'],
            [['numeroPreguntasTotal'], 'number'],
            [['fechaCreacion', 'fechaActualizacion'], 'safe'],
            [['idCuestionario'], 'exist', 'skipOnError' => true, 'targetClass' => Cuestionario::className(), 'targetAttribute' => ['idCuestionario' => 'idCuestionario']],
            [['numeroDocumento'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['numeroDocumento' => 'numeroDocumento']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idCuestionario' => 'Id Cuestionario',
            'numeroDocumento' => 'Numero Documento',
            'numeroPreguntasTotal' => 'Numero Preguntas Total',
            'numeroPreguntasRespondidas' => 'Numero Preguntas Respondidas',
            'estadoCuestionario' => 'Estado Cuestionario',
            'fechaCreacion' => 'Fecha Creacion',
            'fechaActualizacion' => 'Fecha Actualizacion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObjCuestionario()
    {
        return $this->hasOne(Cuestionario::className(), ['idCuestionario' => 'idCuestionario']);
    }
    
	public function cuestionarioAprobado(){
    	$cuestionario = $this->objCuestionario;
    
    	return ($this->porcentajeObtenido >= $cuestionario->porcentajeMinimo) ? true:false;
    }

    public function getPuntosObtenidos(){
    	
    	if($this->cuestionarioAprobado()){
    		$puntos = Puntos::findOne(['numeroDocumento' => $this->numeroDocumento, 'idCuestionario' => $this->idCuestionario]);
    		return ($puntos ? $puntos->valorPuntos: 0);
    	}else{
    		return 0;
    	}
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNumeroDocumento0()
    {
        return $this->hasOne(MUsuario::className(), ['numeroDocumento' => 'numeroDocumento']);
    }
    
    public function getTiempoEmpleado(){
    	$fecha1 = new \DateTime($this->fechaCreacion);
    	$fecha2 = new \DateTime($this->fechaActualizacion);
    	
    	$diff = $fecha1->diff($fecha2);
    	
    	return $diff->format("%h horas %I minutos %s segundos");
    }
}
