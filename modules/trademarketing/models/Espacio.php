<?php

namespace app\modules\trademarketing\models;

use Yii;
use yii\helpers\ArrayHelper;
use app\modules\trademarketing\models\VariableMedicion;

/**
 * Modelo para la tabla "m_TRMA_Espacio".
 *
 * @property string $idEspacio
 * @property string $idVariable
 * @property string $nombre
 * @property integer $estado
 *
 * @property Variablemedicion $Variable
 */
class Espacio extends \yii\db\ActiveRecord
{
    const ESTADO_ACTIVO = 1;
    const ESTADO_INACTIVO = 0;

    public static function tableName()
    {
        return 'm_TRMA_Espacio';
    }

    public function rules()
    {
        return [
            [['idVariable', 'nombre',  'estado'], 'required'],
            [['idVariable', 'estado'], 'integer'],
            [['nombre'], 'string', 'max' => 45],
            [['idVariable'], 'exist', 'skipOnError' => true, 'targetClass' => VariableMedicion::className(),
              'targetAttribute' => ['idVariable' => 'idVariable']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'idEspacio' => 'Id Espacio',
            'idVariable' => 'Variable',
            'nombre' => 'Nombre',
            'estado' => 'Estado',
        ];
    }

    public function getVariable()
    {
        return $this->hasOne(VariableMedicion::className(), ['idVariable' => 'idVariable']);
    }

    public function getMapListaVariables()
    {
      $opciones = VariableMedicion::find()->where(['estado' => VariableMedicion::ESTADO_ACTIVO])->asArray()->all();
      return ArrayHelper::map($opciones, 'idVariable', 'nombre');
    }
}
