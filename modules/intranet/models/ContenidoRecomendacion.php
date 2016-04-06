<?php

namespace app\modules\intranet\models;

use Yii;

/**
 * This is the model class for table "t_contenidorecomendacion".
 *
 * @property integer $idContenido
 * @property integer $numeroDocumentoDirige
 * @property integer $numeroDocumentoDirigido
 * @property string $fechaRegistro
 */
class ContenidoRecomendacion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_ContenidoRecomendacion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idContenido', 'numeroDocumentoDirige', 'numeroDocumentoDirigido', 'fechaRegistro'], 'required'],
            [['idContenido', 'numeroDocumentoDirige', 'numeroDocumentoDirigido'], 'integer'],
            [['fechaRegistro'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idContenido' => 'Id Contenido',
            'numeroDocumentoDirige' => 'Numero Documento Dirige',
            'numeroDocumentoDirigido' => 'Numero Documento Dirigido',
            'fechaRegistro' => 'Fecha Registro',
        ];
    }
}
