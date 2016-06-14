<?php

namespace app\modules\intranet\models;

use Yii;

/**
 * This is the model class for table "m_parametros".
 *
 * @property string $idParametro
 * @property string $valorParametro
 * @property string $descripcion
 */
class Parametros extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'm_Parametros';
    }

    public function rules()
    {
        return [
            [['idParametro', 'valorParametro'], 'required'],
            [['idParametro'], 'string', 'max' => 45],
            [['descripcion'], 'string', 'max' => 100],
            ['valorParametro',  'integer', 'when' => function($model) {
              return $model->idParametro == 'contenido_maxFileCount';
            }],
            ['valorParametro',  'integer', 'when' => function($model) {
              return $model->idParametro == 'contenido_maxFileSize';
            }]
        ];
    }

    public function attributeLabels()
    {
        return [
            'idParametro' => 'Nombre Parametro',
            'valorParametro' => 'Valor Parametro',
            'descripcion' => 'Descripcion',
        ];
    }

    public static function obtenerValorParametro($idParametro)
    {
      $query = self::find()->select(['valorParametro'])
              ->where('( idParametro=:idParametro )')
              ->addParams([':idParametro' => $idParametro])
              ->one();

      return $query->valorParametro;
    }
}
