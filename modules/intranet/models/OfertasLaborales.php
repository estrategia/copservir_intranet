<?php

namespace app\modules\intranet\models;

use Yii;
use app\modules\intranet\models\ContenidoDestino;

/**
 * This is the model class for table "t_OfertasLaborales".
 *
 * @property string $idOfertaLaboral
 * @property string $cargo
 * @property string $idContenidoDestino
 * @property string $idCiudad
 * @property string $fechaPublicacion
 * @property string $fechaCierre
 * @property string $idUsuarioPublicacion
 * @property string $fechaInicioPublicacion
 * @property string $fechaFinPublicacion
 * @property string $tituloOferta
 * @property string $urlElEmpleo
 * @property integer $idCargo
 * @property integer $idArea
 * @property string $descripcionContactoOferta
 * @property string $idInformacionContacto
 */
class OfertasLaborales extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_OfertasLaborales';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idOfertaLaboral', 'cargo', 'idContenidoDestino', 'idCiudad', 'fechaPublicacion', 'fechaCierre', 'idUsuarioPublicacion', 'fechaInicioPublicacion', 'fechaFinPublicacion', 'tituloOferta', 'urlElEmpleo', 'idCargo', 'idArea', 'descripcionContactoOferta', 'idInformacionContacto'], 'required'],
            [['idOfertaLaboral', 'idContenidoDestino', 'idCiudad', 'idUsuarioPublicacion', 'idCargo', 'idArea', 'idInformacionContacto'], 'integer'],
            [['fechaPublicacion', 'fechaCierre', 'fechaInicioPublicacion', 'fechaFinPublicacion'], 'safe'],
            [['descripcionContactoOferta'], 'string'],
            [['cargo', 'tituloOferta', 'urlElEmpleo'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idOfertaLaboral' => 'Id Oferta Laboral',
            'cargo' => 'Cargo',
            'idContenidoDestino' => 'Id Contenido Destino',
            'idCiudad' => 'Id Ciudad',
            'fechaPublicacion' => 'Fecha Publicacion',
            'fechaCierre' => 'Fecha Cierre',
            'idUsuarioPublicacion' => 'Id Usuario Publicacion',
            'fechaInicioPublicacion' => 'Fecha Inicio Publicacion',
            'fechaFinPublicacion' => 'Fecha Fin Publicacion',
            'tituloOferta' => 'Titulo Oferta',
            'urlElEmpleo' => 'Url El Empleo',
            'idCargo' => 'Id Cargo',
            'idArea' => 'Id Area',
            'descripcionContactoOferta' => 'Descripcion Contacto Oferta',
            'idInformacionContacto' => 'Id Informacion Contacto',
        ];
    }

    public function getObjCargo(){
        return $this->hasOne(Cargo::className(), ['idCargo' => 'idCargo']);
    }

    public function getObjArea(){
        return $this->hasOne(Area::className(), ['idArea' => 'idArea']);
    }

    public function getObjCiudad(){
        return $this->hasOne(Ciudad::className(), ['idCiudad' => 'idCiudad']);
    }

    public function getObjInformacionContactoOferta(){
        return $this->hasOne(InformacionContactoOferta::className(), ['idInformacionContacto' => 'idInformacionContacto']);
    }

    public function getObjUsuarioPublicacion(){
        return $this->hasOne(Area::className(), ['idArea' => 'idArea']);
    }

    public function getContenidoDestino()
    {
        return $this->hasMany(ContenidoDestino::className(), ['idContenidoDestino' => 'idContenidoDestino']);
    }

    public static function getOfertasLaboralesInteres($userCiudad, $userGrupos)
    {
      $db = Yii::$app->db;
      $fecha = Date("Y-m-d h:i:s");
      $userGrupos = implode(',',$userGrupos);
      $todosCiudad = \Yii::$app->params['ciudad']['*'];
      $todosGrupos = \Yii::$app->params['grupo']['*'];

      $query = " select * from t_OfertasLaborales as ol
      inner join t_ContenidoDestino as cd on ol.idContenidoDestino = cd.idContenidoDestino
      where ol.fechaInicioPublicacion <= '".$fecha."' and ol.fechaFinPublicacion >= '".$fecha."'
      and ( (cd.idGrupoInteres IN(".$userGrupos.") and cd.codigoCiudad = ".$userCiudad.") or (cd.idGrupoInteres =".$todosGrupos." and cd.codigoCiudad =".$todosCiudad.") or (cd.idGrupoInteres IN(".$userGrupos.") and cd.codigoCiudad = ".$todosCiudad.") or (cd.idGrupoInteres =".$todosGrupos." and cd.codigoCiudad =".$userCiudad.")  );";

      $model = OfertasLaborales::findBySql($query)->with(['objCargo', 'objArea', 'objCiudad', 'objInformacionContactoOferta'])->all();

      return $model;
    }

}
