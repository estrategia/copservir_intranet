<?php

namespace app\modules\intranet\models;

use Yii;
use yii\web\UploadedFile;

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
  const POSICION_ARRIBA = 0;
  const POSICION_ABAJO = 1;
  const POSICION_DERECHA = 2;
  const POSICION_TIENDA_FORCO = 3;
  const POSICION_PROGRAMAS_FORCO = 4;


  const ESTADO_ACTIVO = 1;
  const ESTADO_INACTIVO = 0;

  const SCENARIO_CREAR = 'crear';


  public static function tableName()
  {
    return 't_PublicacionesCampanas';
  }

  public function rules()
  {
    return [
      [['nombreImagen', 'numeroDocumento', 'fechaInicio', 'estado', 'posicion', 'fechaFin'], 'required'],
      [['numeroDocumento', 'estado', 'posicion'], 'integer'],
      [['fechaInicio', 'fechaFin'], 'safe'],
      [['nombreImagen'], 'string', 'max' => 60],
      [['urlEnlaceNoticia'], 'string', 'max' => 45],
      [['rutaImagen', 'rutaImagenResponsive'], 'safe'],
      [['rutaImagen'], 'required', 'on' => self::SCENARIO_CREAR ],
      [['rutaImagenResponsive'], 'required', 'on' => self::SCENARIO_CREAR ],
    ];
  }

  public function attributeLabels()
  {
    return [
      'idImagenCampana' => 'Id Imagen Campana',
      'nombreImagen' => 'Nombre Imagen',
      'rutaImagen' => 'Ruta Imagen',
      'rutaImagenResponsive' => 'Ruta Imagen Responsive',
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
    $campana = $db->createCommand('select distinct pc.idImagenCampana, pc.rutaImagen, pc.rutaImagenResponsive, pc.urlEnlaceNoticia
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

  // FUNCIONES
  public function guardarImagen($rutaAnterior)
  {
    $numeroDocumento = Yii::$app->user->identity->numeroDocumento;
      $imagen = UploadedFile::getInstance($this, 'rutaImagen'); // si no selecciona nada pone null
      if (!is_null($imagen)) {
        $nombre = time().'_'.$numeroDocumento.'.' . $imagen->extension;
        $imagen->saveAs('img/campanas/'. $nombre);
        $this->rutaImagen = $nombre;
      }else{
        $this->rutaImagen = $rutaAnterior;
      }

      $imagenResponsive = UploadedFile::getInstance($this, 'rutaImagenResponsive'); // si no selecciona nada pone null
      // var_dump($imagenResponsive); exit();
      if (!is_null($imagenResponsive)) {
        $nombre = time().'_'.$numeroDocumento.' . responsive .' . $imagenResponsive->extension;
        $imagenResponsive->saveAs('img/campanas/'. $nombre);
        $this->rutaImagenResponsive = $nombre;
      }else{
        $this->rutaImagenResponsive = $rutaAnterior;
      }
  }
}
