<?php

namespace app\modules\intranet\models;

use Yii;
use app\models\Usuario;
/**
 * This is the model class for table "t_contenidoemergentevisto".
 *
 * @property string $numeroDocumento
 * @property string $idContenidoEmergente
 *
 * @property MUsuario $numeroDocumento0
 * @property MContenidoemergente $idContenidoEmergente0
 */
class ContenidoEmergenteVisto extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 't_ContenidoEmergenteVisto';
    }

    public function rules()
    {
        return [
            [['numeroDocumento', 'idContenidoEmergente'], 'required'],
            [['numeroDocumento', 'idContenidoEmergente'], 'integer'],
            [['numeroDocumento'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['numeroDocumento' => 'numeroDocumento']],
            [['idContenidoEmergente'], 'exist', 'skipOnError' => true, 'targetClass' => ContenidoEmergente::className(), 'targetAttribute' => ['idContenidoEmergente' => 'idContenidoEmergente']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'numeroDocumento' => 'Numero Documento',
            'idContenidoEmergente' => 'Id Contenido Emergente',
        ];
    }

    //RELACIONES
    
    public function getObjUsuario()
    {
        return $this->hasOne(Usuario::className(), ['numeroDocumento' => 'numeroDocumento']);
    }

    public function getObjContenidoEmergente()
    {
        return $this->hasOne(Contenidoemergente::className(), ['idContenidoEmergente' => 'idContenidoEmergente']);
    }
}
