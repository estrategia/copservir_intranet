<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "m_FORCO_CategoriasPremios".
 *
 * @property integer $idCategoria
 * @property string $nombreCategoria
 * @property integer $orden
 * @property string $rutaIcono
 * @property integer $estado
 * @property integer $idCategoriaPadre
 * @property string $fechaCreacion
 * @property string $fechaActualizacion
 *
 * @property CategoriasPremios $idCategoriaPadre0
 * @property CategoriasPremios[] $categoriasPremios
 */
class CategoriasPremios extends \yii\db\ActiveRecord
{
    const ESTADO_ACTIVO = 1;
    const ESTADO_INACTIVO = 0;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'm_FORCO_CategoriasPremios';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombreCategoria', 'orden', 'estado', 'rutaIcono'], 'required'],
            [['orden', 'estado', 'idCategoriaPadre'], 'integer'],
            [['fechaCreacion', 'fechaActualizacion', 'rutaIcono'], 'safe'],
            [['nombreCategoria'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idCategoria' => 'Id Categoria',
            'nombreCategoria' => 'Nombre Categoria',
            'orden' => 'Orden',
            'rutaIcono' => 'Icono',
            'estado' => 'Estado',
            'idCategoriaPadre' => 'Categoria Padre',
            'fechaCreacion' => 'Fecha Creacion',
            'fechaActualizacion' => 'Fecha Actualizacion',
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

    public function guardarImagen($rutaAnterior)
    {
        $numeroDocumento = Yii::$app->user->identity->numeroDocumento;
        $imagen = UploadedFile::getInstance($this, 'rutaIcono'); // si no selecciona nada pone null
        if (!is_null($imagen)) {
            $nombre = time() . '_.' . $imagen->extension;
            $imagen->saveAs('img/formacioncomunicaciones/categorias/'. $nombre);
            $this->rutaIcono = $nombre;
        }else{
            $this->rutaIcono = $rutaAnterior;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoriaPadre()
    {
        return $this->hasOne(CategoriasPremios::className(), ['idCategoria' => 'idCategoriaPadre']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoriasPremios()
    {
        return $this->hasMany(CategoriasPremios::className(), ['idCategoriaPadre' => 'idCategoria']);
    }

    public function getContactos()
    {
        return $this->hasMany(ContactoCategoria::className(), ['idCategoriaPremio' => 'idCategoria']);
    }
}
