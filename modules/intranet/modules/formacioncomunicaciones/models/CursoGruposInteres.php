<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\models;

use Yii;

/**
 * This is the model class for table "t_FORCO_ContenidoGruposInteres".
 *
 * @property integer $idGrupoInteres
 * @property integer $idContenido
 *
 * @property MFORCOContenido $idContenido0
 * @property MGrupoInteres $idGrupoInteres0
 */
class CursoGruposInteres extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_FORCO_CursoGruposInteres';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idGrupoInteres', 'idCurso'], 'required'],
            [['idGrupoInteres', 'idCurso'], 'integer'],
            // [['idContenido'], 'exist', 'skipOnError' => true, 'targetClass' => MFORCOContenido::className(), 'targetAttribute' => ['idContenido' => 'idContenido']],
            // [['idGrupoInteres'], 'exist', 'skipOnError' => true, 'targetClass' => MGrupoInteres::className(), 'targetAttribute' => ['idGrupoInteres' => 'idGrupoInteres']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idGrupoInteres' => 'Id Grupo Interes',
            'idCurso' => 'Id Contenido',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurso()
    {
        return $this->hasOne(Curso::className(), ['idCurso' => 'idCurso']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrupoInteres()
    {
        return $this->hasOne(GrupoInteres::className(), ['idGrupoInteres' => 'idGrupoInteres']);
    }
}
