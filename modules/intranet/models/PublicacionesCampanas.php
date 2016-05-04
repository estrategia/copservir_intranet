<?php

namespace app\modules\intranet\models;

use Yii;

/**
* This is the model class for table "t_publicacionescampanas".
*
* @property string $idImagenCampana
* @property string $nombreImagen
* @property string $rutaImagen
* @property string $numeroDocumento
* @property string $urlEnlaceNoticia
* @property string $fechaInicio
* @property integer $estado
* @property integer $posicion
* @property string $fechaFin
*
* @property TPublicacioncampanasportales[] $tPublicacioncampanasportales
*/
class PublicacionesCampanas extends \yii\db\ActiveRecord
{
  // posicion en el home
  const POSICION_ARRIBA = 0;
  const POSICION_ABAJO = 1;
  const POSICION_DERECHA = 2;

  // estados
  const ESTADO_ACTIVO = 1;

  public static function tableName()
  {
    return 't_PublicacionesCampanas';
  }

  public function rules()
  {
    return [
      [['nombreImagen', 'rutaImagen', 'numeroDocumento', 'fechaInicio', 'estado', 'posicion', 'fechaFin'], 'required'],
      [['numeroDocumento', 'estado', 'posicion'], 'integer'],
      [['fechaInicio', 'fechaFin'], 'safe'],
      [['nombreImagen', 'rutaImagen'], 'string', 'max' => 60],
      [['urlEnlaceNoticia'], 'string', 'max' => 45],
    ];
  }

  public function attributeLabels()
  {
    return [
      'idImagenCampana' => 'Id Imagen Campana',
      'nombreImagen' => 'Nombre Imagen',
      'rutaImagen' => 'Ruta Imagen',
      'numeroDocumento' => 'Numero Documento',
      'urlEnlaceNoticia' => 'Url Enlace Noticia',
      'fechaInicio' => 'Fecha Inicio',
      'estado' => 'Estado',
      'posicion' => 'Posicion',
      'fechaFin' => 'Fecha Fin',
    ];
  }

  // RELACIONES

  public function getObjPublicacionCampanasPortales()
  {
    return $this->hasMany(PublicacionCampanasPortales::className(), ['idImagenCampana' => 'idImagenCampana']);
  }

  // CONSULTAS
  
  /**
  * consulta las campañas dependiendo de la ciudad, grupos de interes e indicando la posicion donde se ubica en el home
  * @param userCiudad = ciudad donde se encuentra el usuario, userGrupos = grupos de interes del usuario,
  * posicion = indicando la posicion donde se ubica en el home
  * @return array modelos Campana
  */
  public static function getCampana($userCiudad, $userGrupos, $posicion)
  {
    $db = Yii::$app->db;
    $campana = $db->createCommand('select distinct pc.idImagenCampana, pc.rutaImagen, pc.urlEnlaceNoticia
    from t_CampanasDestino as pcc, t_PublicacionesCampanas as pc
    where (pcc.idImagenCampana = pc.idImagenCampana and pc.fechaInicio<=:fecha and pc.fechaFin >=:fecha and pc.estado=:estado and pc.posicion =:posicion
    and (( pcc.idGrupoInteres IN(:userGrupos) and pcc.codigoCiudad =:userCiudad) or ( pcc.idGrupoInteres =:todosGrupos and pcc.codigoCiudad =:todosCiudad) or (pcc.idGrupoInteres IN(:userGrupos) and pcc.codigoCiudad =:todosCiudad) or (pcc.idGrupoInteres =:todosGrupos and pcc.codigoCiudad =:userCiudad)  )  )
    order by rand()')
    ->bindValue(':userCiudad', $userCiudad)
    ->bindValue(':userGrupos', implode(',', $userGrupos))
    ->bindValue(':estado', self::ESTADO_ACTIVO)
    ->bindValue(':posicion', $posicion)
    ->bindValue(':fecha', date('Y-m-d H:i:s'))
    ->bindValue('todosCiudad', \Yii::$app->params['ciudad']['*'])
    ->bindValue('todosGrupos', \Yii::$app->params['grupo']['*'])
    ->queryAll();

    return $campana;
  }

}
