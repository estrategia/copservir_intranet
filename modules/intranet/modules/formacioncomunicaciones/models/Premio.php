<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\models;

use Yii;
use yii\web\UploadedFile;

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
class Premio extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'm_FORCO_Premio';
    }

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
            [['idCategoria'], 'exist', 'skipOnError' => true, 'targetClass' => CategoriasPremios::className(), 'targetAttribute' => ['idCategoria' => 'idCategoria']],
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObjCategoria()
    {
        return $this->hasOne(CategoriasPremios::className(), ['idCategoria' => 'idCategoria']);
    }
    
    public function guardarImagen($rutaAnterior)
    {
    	$imagen = UploadedFile::getInstance($this, 'rutaImagen'); // si no selecciona nada pone null
    	if (!is_null($imagen)) {
    		$nombre = time() . '_.' . $imagen->extension;
    		$imagen->saveAs('img/formacioncomunicaciones/premios/'. $nombre);
    		$this->rutaImagen = $nombre;
    	}else{
    		$this->rutaImagen = $rutaAnterior;
    	}
    }
}
