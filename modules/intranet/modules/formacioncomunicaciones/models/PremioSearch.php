<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "m_FORCO_Premio".
 *
 * @property string $idPremio
 * @property string $nombrePremio
 * @property string $descripcionPremio
 * @property string $idCategoria
 * @property string $puntosRedimir
 * @property integer $estado
 * @property string $cantidad
 * @property string $rutaImagen
 * @property string $fechaInicioVigencia
 * @property string $fechaFinVigencia
 * @property string $fechaCreacion
 * @property string $fechaActualizacion
 *
 * @property MFORCOCategoriasPremios $idCategoria0
 */
class PremioSearch extends Premio
{
    

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descripcionPremio'], 'string'],
            [['idCategoria', 'puntosRedimir', 'estado', 'cantidad'], 'integer'],
            [['fechaInicioVigencia', 'fechaFinVigencia', 'fechaCreacion', 'fechaActualizacion'], 'safe'],
            [['nombrePremio', 'rutaImagen'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idPremio' => 'Id Premio',
            'nombrePremio' => 'Nombre Premio',
            'descripcionPremio' => 'Descripcion Premio',
            'idCategoria' => 'Id Categoria',
            'puntosRedimir' => 'Puntos Redimir',
            'estado' => 'Estado',
            'cantidad' => 'Cantidad',
            'rutaImagen' => 'Ruta Imagen',
            'fechaInicioVigencia' => 'Fecha Inicio Vigencia',
            'fechaFinVigencia' => 'Fecha Fin Vigencia',
            'fechaCreacion' => 'Fecha Creacion',
            'fechaActualizacion' => 'Fecha Actualizacion',
        ];
    }

 
    
    public function search($params){
    	$query = Premio::find();
    	
    	// add conditions that should always apply here
    	
    	$dataProvider = new ActiveDataProvider([
    			'query' => $query,
    	]);
    	
    	$this->load($params);
    	
    	if (!$this->validate()) {
    		// uncomment the following line if you do not want to return any records when validation fails
    		// $query->where('0=1');
    		return $dataProvider;
    	}
    	
    	// grid filtering conditions
    	$query->andFilterWhere([
    			'idPremio' => $this->idPremio,
    			'idCategoria' => $this->idCategoria,
    			'puntosRedimir' => $this->puntosRedimir,
    			'estado' => $this->estado,
    			'cantidad' => $this->cantidad,
    			'fechaInicioVigencia' => $this->fechaInicioVigencia,
    			'fechaFinVigencia' => $this->fechaFinVigencia,
    	]);
    	
    	$query->andFilterWhere(['like', 'nombrePremio', $this->nombrePremio])
    	->andFilterWhere(['like', 'descripcionPremio', $this->descripcionPremio]);
    	
    	return $dataProvider;
    }
}
