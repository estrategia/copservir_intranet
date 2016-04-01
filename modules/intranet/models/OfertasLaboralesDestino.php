<?php

namespace app\modules\intranet\models;

use Yii;

/**
 * This is the model class for table "t_ofertaslaboralesdestino".
 *
 * @property integer $idOfertaLaboral
 * @property integer $idGrupoInteres
 * @property integer $idContenido
 * @property integer $codigoCiudad
 */
class OfertasLaboralesDestino extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_ofertaslaboralesdestino';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idOfertaLaboral', 'idGrupoInteres', 'idContenido', 'codigoCiudad'], 'required'],
            [['idOfertaLaboral', 'idGrupoInteres', 'idContenido', 'codigoCiudad'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idOfertaLaboral' => 'Id Oferta Laboral',
            'idGrupoInteres' => 'Id Grupo Interes',
            'idContenido' => 'Id Contenido',
            'codigoCiudad' => 'Codigo Ciudad',
        ];
    }
}
