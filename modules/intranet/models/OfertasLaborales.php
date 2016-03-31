<?php

namespace app\modules\intranet\models;

use Yii;
use app\modules\intranet\models\ContenidoDestino;
use app\modules\intranet\models\Ciudad;
use app\modules\intranet\models\Area;
use app\modules\intranet\models\Cargo;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
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
            'idCiudad' => 'Ciudad',
            'fechaPublicacion' => 'Fecha Publicacion',
            'fechaCierre' => 'Fecha Cierre',
            'idUsuarioPublicacion' => 'Id Usuario Publicacion',
            'fechaInicioPublicacion' => 'Fecha Inicio Publicacion',
            'fechaFinPublicacion' => 'Fecha Fin Publicacion',
            'tituloOferta' => 'Titulo Oferta',
            'urlElEmpleo' => 'Url El Empleo',
            'idCargo' => 'Cargo',
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

    public function getVertodos($params)
    {
      $query = OfertasLaborales::find()->orderby('idCiudad')->with(['objCargo', 'objArea', 'objCiudad', 'objInformacionContactoOferta']);

      $dataProvider = new ActiveDataProvider([
           'query' => $query,
           'pagination' => [
               'pageSize' => 10,
           ],
       ]);

       $this->load($params);

       return $dataProvider;
    }
    public static function getOfertasLaboralesInteres($userCiudad, $userGrupos)
    {
      //$db = Yii::$app->db;
      $fecha = Date("Y-m-d h:i:s");
      $userGrupos = implode(',',$userGrupos);

      $query = OfertasLaborales::find()->with(['objCargo', 'objArea', 'objCiudad', 'objInformacionContactoOferta'])
        ->joinWith(['contenidoDestino'])->where(
            ['and',
                ['<=','fechaInicioPublicacion', $fecha],
                ['>=','fechaFinPublicacion', $fecha],
                ['=','codigoCiudad', $userCiudad],
                ['IN','idGrupoInteres', $userGrupos],
            ]
        );

        $dataProvider = new ActiveDataProvider([
             'query' => $query,
             'pagination' => [
                 'pageSize' => 5,
             ],
         ]);

         return $dataProvider;
      /*
      $todosCiudad = \Yii::$app->params['ciudad']['*'];
      $todosGrupos = \Yii::$app->params['grupo']['*'];

      $query = " select * from t_OfertasLaborales as ol
      inner join t_ContenidoDestino as cd on ol.idContenidoDestino = cd.idContenidoDestino
      where ol.fechaInicioPublicacion <= '".$fecha."' and ol.fechaFinPublicacion >= '".$fecha."'
      and ( (cd.idGrupoInteres IN(".$userGrupos.") and cd.codigoCiudad = ".$userCiudad.") or (cd.idGrupoInteres =".$todosGrupos." and cd.codigoCiudad =".$todosCiudad.") or (cd.idGrupoInteres IN(".$userGrupos.") and cd.codigoCiudad = ".$todosCiudad.") or (cd.idGrupoInteres =".$todosGrupos." and cd.codigoCiudad =".$userCiudad.")  );";

      $model = OfertasLaborales::findBySql($query)->with(['objCargo', 'objArea', 'objCiudad', 'objInformacionContactoOferta'])->all();

      $count = count($model);
      $pages = new Pagination(
        ['totalCount' => $count, 'pageSize'=>1]
      );*/
    }

    public static function getListaArea()
    {
        $opciones = Area::find()->asArray()->all();
        return ArrayHelper::map($opciones, 'idArea', 'nombreArea');
    }

    public static function getListaCargo()
    {
        $opciones = Cargo::find()->asArray()->all();
        return ArrayHelper::map($opciones, 'idCargo', 'nombreCargo');
    }

    public static function getListaCiudad()
    {
        $opciones = Ciudad::find()->asArray()->all();
        return ArrayHelper::map($opciones, 'idCiudad', 'nombreCiudad');
    }

}
