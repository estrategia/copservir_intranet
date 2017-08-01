<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\models;

use Yii;

/**
 * This is the model class for table "t_FORCO_PromedioPonderadoUsuario".
 *
 * @property string $numeroDocumento
 * @property string $promedio
 * @property string $acumuladoNecesario
 * @property string $acumuladoPonderado
 */
class PromedioPonderadoUsuario extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_FORCO_PromedioPonderadoUsuario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['numeroDocumento'], 'required'],
            [['numeroDocumento'], 'integer'],
            [['promedio', 'acumuladoNecesario', 'acumuladoPonderado'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'numeroDocumento' => 'Numero Documento',
            'promedio' => 'Promedio',
            'acumuladoNecesario' => 'Acumulado Necesario',
            'acumuladoPonderado' => 'Acumulado Ponderado',
        ];
    }

    public static function actualizar($numeroDocumento, $porcentajeObtenido, $porcentajeMinimo)
    {
        $promedioPonderado = self::find()->where(['numeroDocumento' => $numeroDocumento])->one();
        if (!is_null($promedioPonderado)) {
            $promedioPonderado->acumuladoPonderado += $porcentajeObtenido * $porcentajeMinimo;
            $promedioPonderado->acumuladoNecesario += $porcentajeMinimo;
            $promedioPonderado->promedio = $promedioPonderado->acumuladoPonderado / $promedioPonderado->acumuladoNecesario;
        } else {
            $promedioPonderado = new PromedioPonderadoUsuario();
            $promedioPonderado->acumuladoPonderado += $porcentajeObtenido * $porcentajeMinimo;
            $promedioPonderado->acumuladoNecesario += $porcentajeMinimo;
            $promedioPonderado->promedio = $promedioPonderado->acumuladoPonderado / $promedioPonderado->acumuladoNecesario;
        }

        return $promedioPonderado->save();
    }
}
