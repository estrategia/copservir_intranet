<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\models;

use Yii;

use yii\helpers\ArrayHelper;
use app\modules\intranet\models\GrupoInteres;

/**
 * This is the model class for table "t_FORCO_ContenidoGruposInteres".
 *
 * @property integer $idGrupoInteres
 * @property integer $idModulo
 *
 */
class CapituloGruposInteres extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_FORCO_CapituloGruposInteres';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idGrupoInteres', 'idCapitulo'], 'required'],
            [['idGrupoInteres', 'idCapitulo'], 'integer'],
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
            'idCapitulo' => 'Id modulo',
        ];
    }
    
    public function getListaGrupoInteres() 
    {
        $opciones = GrupoInteres::find()->where(['estado'=>1])->orderBy('nombreGrupo')->asArray()->all();
        return ArrayHelper::map($opciones, 'idGrupoInteres', 'nombreGrupo');
    }

    public function getDatosSelectGruposInteres()
    {
        $data = [];
        $options = [];
        $padres = GrupoInteres::find()->where(['estado'=>1])->andWhere(['idGrupoInteresPadre' => NULL])->orderBy('nombreGrupo')->all();
        $grupos = $this->getDataSelectGrupos($padres);
        $data = ArrayHelper::map($grupos, 'idGrupoInteres', 'nombreGrupo');
        $options = $this->getEstilosSelectGrupos($grupos);
        return ['data' => $data, 'options' => $options];
    }

    private function getEstilosSelectGrupos($grupos)
    {
        $options = [];
        foreach ($grupos as $indice => $grupo) {
          if ($grupo->idGrupoInteresPadre == '') {
            $options[$grupo->idGrupoInteres] = ['style' => 'font-weight: bold;font-style: italic;'];
          } else {
            $options[$grupo->idGrupoInteres] = ['style' => 'padding-left: 15px;'];
          }
        }
        return $options;
    }

    private function getDataSelectGrupos($padres)
    {
        $data = [];
        $hijos = [];
        foreach ($padres as $indice => $padre) {
          $data[] = $padre;
          $hijos = $padre->gruposHijos;
          if (!empty($hijos)) {
            foreach ($hijos as $hijo) {
              $data[] = $hijo;
            }
          }
        }
        return $data;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCapitulo()
    {
        return $this->hasOne(Capitulo::className(), ['idCapitulo' => 'idCapitulo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrupoInteres()
    {
        return $this->hasOne(GrupoInteres::className(), ['idGrupoInteres' => 'idGrupoInteres']);
    }
}
