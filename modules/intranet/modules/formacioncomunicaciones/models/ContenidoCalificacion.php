<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\models;

use Yii;
use app\models\Usuario;

/**
 * This is the model class for table "t_FORCO_ContenidoCalificacion".
 *
 * @property string $numeroDocumento
 * @property integer $idContenido
 * @property string $titulo
 * @property string $comentatio
 * @property integer $calificacion
 * @property string $fecha
 */
class ContenidoCalificacion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_FORCO_ContenidoCalificacion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['numeroDocumento', 'idContenido', 'comentario', 'calificacion'], 'required'],
            [['numeroDocumento', 'idContenido', 'calificacion'], 'integer'],
            [['calificacion'], 'integer', 'min' => 1],
            [['fecha'], 'safe'],
            [['comentario'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'numeroDocumento' => 'Numero Documento',
            'idContenido' => 'Id Contenido',
            'comentatio' => 'Comentatio',
            'calificacion' => 'Calificacion',
            'fecha' => 'Fecha',
        ];
    }

    public function getUsuarioPublicador()
    {
        return $this->hasOne(Usuario::classname(), ['numeroDocumento' => 'numeroDocumento']);
    }
}
