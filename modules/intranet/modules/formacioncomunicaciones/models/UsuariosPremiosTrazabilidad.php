<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\models;

use Yii;
use app\models\Usuario;
/**
 * This is the model class for table "t_FORCO_UsuariosPremiosTrazabilidad".
 *
 * @property string $idTrazabilidad
 * @property string $idUsuarioPremio
 * @property string $idPremio
 * @property string $numeroDocumento
 * @property integer $estado
 * @property string $numeroDocumentoTraza
 * @property string $fechaRegistro
 *
 * @property MUsuario $numeroDocumento0
 * @property MFORCOPremio $idPremio0
 * @property TFORCOUsuariosPremios $idUsuarioPremio0
 */
class UsuariosPremiosTrazabilidad extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_FORCO_UsuariosPremiosTrazabilidad';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idUsuarioPremio', 'idPremio', 'numeroDocumento', 'estado', 'numeroDocumentoTraza'], 'required'],
            [['idUsuarioPremio', 'idPremio', 'numeroDocumento', 'estado', 'numeroDocumentoTraza'], 'integer'],
            [['fechaRegistro'], 'safe'],
            [['numeroDocumento'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['numeroDocumento' => 'numeroDocumento']],
            [['idPremio'], 'exist', 'skipOnError' => true, 'targetClass' => Premio::className(), 'targetAttribute' => ['idPremio' => 'idPremio']],
            [['idUsuarioPremio'], 'exist', 'skipOnError' => true, 'targetClass' => UsuariosPremios::className(), 'targetAttribute' => ['idUsuarioPremio' => 'idUsuarioPremio']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idTrazabilidad' => 'Id Trazabilidad',
            'idUsuarioPremio' => 'Id Usuario Premio',
            'idPremio' => 'Id Premio',
            'numeroDocumento' => 'Numero Documento',
            'estado' => 'Estado',
            'numeroDocumentoTraza' => 'Numero Documento Traza',
            'fechaRegistro' => 'Fecha Registro',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObjUsuario()
    {
        return $this->hasOne(Usuario::className(), ['numeroDocumento' => 'numeroDocumento']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObjPremio()
    {
        return $this->hasOne(Premio::className(), ['idPremio' => 'idPremio']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObjUsuarioPremio()
    {
        return $this->hasOne(UsuariosPremios::className(), ['idUsuarioPremio' => 'idUsuarioPremio']);
    }
}
