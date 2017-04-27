<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\models;

use Yii;
use app\models\Usuario;
use yii\data\ActiveDataProvider;
/**
 * This is the model class for table "t_FORCO_UsuariosPremios".
 *
 * @property string $idUsuarioPremio
 * @property string $idPremio
 * @property string $numeroDocumento
 * @property string $cantidad
 * @property string $puntosRedimir
 * @property integer $estado
 * @property string $fechaCreacion
 * @property string $fechaActualizacion
 *
 * @property MUsuario $numeroDocumento0
 * @property MFORCOPremio $idPremio0
 * @property TFORCOUsuariosPremiosTrazabilidad[] $tFORCOUsuariosPremiosTrazabilidads
 */
class UsuariosPremios extends \yii\db\ActiveRecord
{
	const ESTADO_PENDIENTE = 1;
    const ESTADO_TRAMITADO = 2;
	const ESTADO_CANCELADO = 3;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_FORCO_UsuariosPremios';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idPremio', 'numeroDocumento', 'cantidad', 'puntosRedimir', 'estado'], 'required'],
            [['idPremio', 'numeroDocumento', 'cantidad', 'puntosRedimir', 'estado'], 'integer'],
            [['fechaCreacion', 'fechaActualizacion'], 'safe'],
            [['numeroDocumento'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['numeroDocumento' => 'numeroDocumento']],
            [['idPremio'], 'exist', 'skipOnError' => true, 'targetClass' => Premio::className(), 'targetAttribute' => ['idPremio' => 'idPremio']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idUsuarioPremio' => 'Id Usuario Premio',
            'idPremio' => 'Id Premio',
            'numeroDocumento' => 'Numero Documento',
            'cantidad' => 'Cantidad',
            'puntosRedimir' => 'Puntos Redimir',
            'estado' => 'Estado',
            'fechaCreacion' => 'Fecha Creacion',
            'fechaActualizacion' => 'Fecha Actualizacion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObjUsuario()
    {
        return $this->hasOne(Usuario::className(), ['numeroDocumento' => 'numeroDocumento']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObjPremio()
    {
        return $this->hasOne(Premio::className(), ['idPremio' => 'idPremio']);
    }
    
    public function search($params){
    	$query = UsuariosPremios::find();
    	 
    	// add conditions that should always apply here
    	 
    	$dataProvider = new ActiveDataProvider([
    			'query' => $query,
    	]);
    	 
    	$this->load($params);
    	 
    	// grid filtering conditions
    	$query->andFilterWhere([
    			'idUsuarioPremio' => $this->idUsuarioPremio,
    			'idPremio' => $this->idPremio,
    			'numeroDocumento' => $this->numeroDocumento,
    			'cantidad' => $this->cantidad,
    			'puntosRedimir' => $this->puntosRedimir,
    			'estado' => $this->estado,
    			'fechaCreacion' => $this->fechaCreacion,
    	]);
    	 
    	return $dataProvider;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getListUsuariosPremiosTrazabilidads()
    {
        return $this->hasMany(UsuariosPremiosTrazabilidad::className(), ['idUsuarioPremio' => 'idUsuarioPremio']);
    }
    
    public function traerRedenciones($estado){
    	return self::find()->where(['estado' => $estado]) ;
    }
}
