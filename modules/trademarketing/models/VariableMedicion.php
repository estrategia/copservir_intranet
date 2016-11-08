<?php

namespace app\modules\trademarketing\models;

use Yii;
use yii\helpers\ArrayHelper;
use app\modules\trademarketing\models\Categoria;

/**
 * Modelo para la tabla "m_TRMA_Variablemedicion".
 *
 * @property string $idVariable
 * @property string $idCategoria
 * @property string $nombre
 * @property string $descripcion
 * @property integer $estado
 * @property integer $calificaUnidadNegocio
 *
 * @property array[Espacio] &espacios
 * @property Categoria $Categoria
 */

class VariableMedicion extends \yii\db\ActiveRecord
{
    const ESTADO_ACTIVO = 1;
    const ESTADO_INACTIVO = 0;
    const CALIFICA_UNIDAD = 1;
    const NO_CALIFICA_UNIDAD = 0;

    public static function tableName()
    {
        return 'm_TRMA_VariableMedicion';
    }

    public function rules()
    {
        return [
            [['idCategoria', 'nombre', 'calificaUnidadNegocio',  'estado'], 'required'],
            [['idCategoria', 'estado', 'calificaUnidadNegocio'], 'integer'],
            [['nombre', 'descripcion'], 'string', 'max' => 45],
            [['idCategoria'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::className(),
             'targetAttribute' => ['idCategoria' => 'idCategoria']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'idVariable' => 'Id Variable',
            'idCategoria' => 'Categoria',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripcion',
            'estado' => 'Estado',
            'calificaUnidadNegocio' => 'Califica Unidad Negocio',
        ];
    }

    // RELACIONES

    public function getEspacios()
    {
        return $this->hasMany(Espacio::className(), ['idVariable' => 'idVariable']);
    }

    public function getCategoria()
    {
        return $this->hasOne(Categoria::className(), ['idCategoria' => 'idCategoria']);
    }

    //FUNCIONES

    public function getMapListaCategorias()
    {
      $opciones = Categoria::find()->where(['estado' => Categoria::ESTADO_ACTIVO])->asArray()->all();
      return ArrayHelper::map($opciones, 'idCategoria', 'nombre');
    }
}
