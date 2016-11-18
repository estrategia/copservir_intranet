<?php

namespace app\modules\intranet\models;

use Yii;
use yii\helpers\ArrayHelper;
use app\modules\intranet\models\GrupoInteres;
use app\modules\intranet\models\Ciudad;

/**
* This is the model class for table "t_ContenidoDestino".
*
* @property string $idContenidoDestino
* @property string $idGrupoInteres
* @property integer $codigoCiudad
*/
class ContenidoDestino extends \yii\db\ActiveRecord
{
  public static function tableName()
  {
    return 't_ContenidoDestino';
  }

  public function rules()
  {
    return [
      [['idGrupoInteres', 'codigoCiudad', 'idContenido'], 'required'],
      [['idGrupoInteres', 'codigoCiudad', 'idContenido'], 'integer']
    ];
  }

  public function attributeLabels()
  {
    return [
      'idContenido' => 'Contenido',
      'idGrupoInteres' => 'Grupo Interes',
      'codigoCiudad' => 'Ciudad',
    ];
  }

  /**
   * @return array con modelos Portal mapeados por idPortal y nombrePortal
   */
  public function getListaGrupoInteres($bandera) {

    if ($bandera) {

      $opciones = GrupoInteres::find()->where(['estado'=>1])->orderBy('nombreGrupo')->asArray()->all();

      return ArrayHelper::map($opciones, 'idGrupoInteres', 'nombreGrupo');

    }else{

      $userGrupos = Yii::$app->user->identity->getGruposCodigos();
      $userGrupos = implode(',',$userGrupos);

      $opciones = GrupoInteres::find()->where(" ( idGrupoInteres IN ($userGrupos)) AND estado = 1")
      ->orderBy('nombreGrupo')
      ->asArray()
      ->all();

      return ArrayHelper::map($opciones, 'idGrupoInteres', 'nombreGrupo');
    }

  }

  /**
   * @return array con modelos Portal mapeados por idPortal y nombrePortal
   */
  public function getListaCiudades($bandera) {

    if ($bandera) {

      $opciones = Ciudad::find()->orderBy('nombreCiudad')->asArray()->all();

      return ArrayHelper::map($opciones, 'codigoCiudad', 'nombreCiudad');

    }else{

      $opciones = Ciudad::find()->where(' ( codigoCiudad=:codigoCiudad)')
      ->orderBy('nombreCiudad')
      ->addParams([':codigoCiudad' => Yii::$app->user->identity->getCiudadCodigo()])
      ->asArray()
      ->all();

      return ArrayHelper::map($opciones, 'codigoCiudad', 'nombreCiudad');
    }

  }
}
