<?php

namespace app\modules\intranet\models;

use Yii;
use yii\web\IdentityInterface;
use yii\base\NotSupportedException;
use yii\base\Event;
use yii\web\ForbiddenHttpException;
use yii\data\ActiveDataProvider;

/**
* This is the model class for table "m_usuario".
*
* @property string $idUsuario
* @property string $numeroDocumento
* @property string $alias
* @property integer $estado
* @property string $llaveAutenticacion
*/
class Usuario extends \yii\db\ActiveRecord implements IdentityInterface {

  private $data = [
    'sesionRestaurada' => false,
    'personal' => [
      'celular' => null,
      'residencia' => null,
      'ciudad' => [
        'codigo' => null,
        'nombre' => null
      ],
      'fechaCumpleanhos' => null
    ],
    'academica' => [
      'profesion' => null,
      'estudiosSuperiores' => null
    ],
    'laboral' => [
      'cargo' => [
        'codigo' => null,
        'nombre' => null
      ],
      'area' => [
        'codigo' => null,
        'nombre' => null
      ],
      'fechaVinculacion' => null,
      'jefeInmediato' => [
        'numeroIdentificacion' => null,
        'nombre' => null
      ],
      'extension' => null,
      'correoElectronico' => null,
    ],
    'gruposInteres' => []
  ];

  public static function tableName() {
    return 'm_Usuario';
  }

  public function init() {
    Event::on(\yii\web\User::className(), \yii\web\User::EVENT_AFTER_LOGIN, function ($event) {
      $this->generarDatos();
    });
  }

  private function restaurarSesion() {
    $userdata = \Yii::$app->session->get('user.data');
    if (empty($userdata)) {
      $this->generarDatos();
    } else {
      $this->data = \Yii::$app->session->get('user.data');
    }
  }

  private function generarDatos() {
    if (!$this->data['sesionRestaurada']) {
      try {
        $this->data['personal']['celular'] = "314 598 2002";
        $this->data['personal']['residencia'] = "Calle 16 25 - 23";
        $this->data['personal']['ciudad']['nombre'] = "Cali";
        $this->data['personal']['ciudad']['codigo'] = "76001";
        $this->data['personal']['fechaCumpleanhos'] = "2015-01-20";

        $this->data['academica']['profesion'] = "Ingeniero de sistemas y ciencias de la computación";
        $this->data['academica']['estudiosSuperiores'] = "Universidad del valle sede Melendez";

        $this->data['laboral']['cargo']['codigo'] = "81";
        $this->data['laboral']['cargo']['nombre'] = "COORDINADOR DE TECNOLOGIA";
        $this->data['laboral']['area']['nombre'] = "TECNOLOGIA";
        $this->data['laboral']['fechaVinculacion'] = "2014-01-17";
        $this->data['laboral']['jefeInmediato']['numeroIdentificacion'] = "123456";
        $this->data['laboral']['jefeInmediato']['nombre'] = "Andres Tabares";
        $this->data['laboral']['extension'] = "35689";
        $this->data['laboral']['correoElectronico'] = "miguel.sanchez@eiso.com.co";

        $this->data['sesionRestaurada'] = true;

        $listGrupoInteresCargo = GrupoInteresCargo::find()->where("idCargo=:cargo", [':cargo'=>  $this->data['laboral']['cargo']['codigo']])->all();
        $this->data['gruposInteres'] = [];

        foreach ($listGrupoInteresCargo as $objGrupoInteresCargo) {
          $this->data['gruposInteres'][] = $objGrupoInteresCargo->idGrupoInteres;
        }

        \Yii::$app->session->set('user.data', $this->data);
      } catch (Exception $ex) {

      }
    }
  }

  public function rules() {
    return [
      [['numeroDocumento', 'estado'], 'required'],
      [['numeroDocumento', 'estado'], 'integer'],
      [['alias'], 'string', 'max' => 60],
      [['numeroDocumento'], 'unique'],
      [['llaveAutenticacion'], 'safe'],
    ];
  }

  public function attributeLabels() {
    return [
      'idUsuario' => 'Id Usuario',
      'numeroDocumento' => 'Numero Documento',
      'alias' => 'Alias',
      'estado' => 'Estado',
      'imagenPerfil' => 'Imagen Perfil',
      'imagenFondo' => 'Imagen Fondo',
      'llaveAutenticacion' => 'Llave autenticaci&oacute;n'
    ];
  }

  public function beforeSave($insert) {
    if (parent::beforeSave($insert)) {
      if ($this->isNewRecord) {
        $this->generateAuthKey();
      }
      return true;
    }
    return false;
  }

  //CONSULTAS

  /**
  * Consulta una lista de usuarios que sera cargada en el selector de enviar a un amigo
  */
  public static function listaUsuariosEnviarAmigo($idContenido) {
    //Usuario::find()->where([ 'estado' => 1])->andWhere(['<>', 'numeroDocumento', Yii::$app->user->identity->numeroDocumento])->all();
    $idUsuario = Yii::$app->user->identity->numeroDocumento;
    $fecha = Date("Y-m-d H:i:s");

    $query = self::find()
    ->where("(
    estado=:estado
    and numeroDocumento not in (select numeroDocumentoDirigido from `t_ContenidoRecomendacion`
    where (`fechaRegistro` <=:fechaRegistro) and (`idContenido`=:idContenido))
    and numeroDocumento !=:idUsuario )")
    ->addParams([':estado' => 1, ':idUsuario' => $idUsuario, ':fechaRegistro' => $fecha, ':idContenido' => $idContenido])->all();

    return $query;
  }

  public static function findIdentity($id) {
    return static::findOne(['idUsuario' => $id, 'estado' => 1]);
  }

  public static function findIdentityByAccessToken($token, $type = null) {
    throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
  }

  /**
  * Finds user by username
  *
  * @param string $username
  * @return static|null
  */
  public static function findByUsername($username) {
    return static::find()->where(['AND', ['=', 'numeroDocumento', $username], ['=', 'estado', 1], ['!=', 'numeroDocumento', 0]])->one();
  }

  public static function dataProviderFindAllUsers() {

    $query = static::find()->where(['AND', ['=', 'estado', 1]]);

    $dataProvider = new ActiveDataProvider([
      'query' => $query,
      'pagination' => [
        'pageSize' => 10,
      ],
    ]);

    return $dataProvider;

  }

  public function getId() {
    return $this->getPrimaryKey();
  }

  public function getAuthKey() {
    return $this->llaveAutenticacion;
  }

  public function validateAuthKey($llaveAutenticacion) {
    return $this->llaveAutenticacion = $llaveAutenticacion;
  }

  /**
  * Validates password
  *
  * @param string $password password to validate
  * @return boolean if password provided is valid for current user
  */
  public function validatePassword($password) {
    return true;
  }

  /**
  * Generates password hash from password and sets it to the model
  *
  * @param string $password
  */
  public function setPassword($password) {
    $this->password_hash = Yii::$app->security->generatePasswordHash($password);
  }

  /**
  * Generates "remember me" authentication key
  */
  public function generateAuthKey() {
    $this->llaveAutenticacion = Yii::$app->security->generateRandomString();
  }

  //datos personales

  public function getCelular() {
    $this->restaurarSesion();
    return $this->data['personal']['celular'];
  }

  public function getResidencia() {
    $this->restaurarSesion();
    return $this->data['personal']['residencia'];
  }

  public function getCiudadNombre() {
    $this->restaurarSesion();
    return $this->data['personal']['ciudad']['nombre'];
  }

  public function getCiudadCodigo() {
    $this->restaurarSesion();
    return $this->data['personal']['ciudad']['codigo'];
  }

  public function getCumpleanhos() {
    $this->restaurarSesion();
    if (empty($this->data['personal']['fechaCumpleanhos']))
    return null;

    setlocale(LC_ALL, "es_ES");
    return strftime("%B %d", strtotime($this->data['personal']['fechaCumpleanhos']));
  }

  //datos academicos

  public function getProfesion() {
    $this->restaurarSesion();
    return $this->data['academica']['profesion'];
  }

  public function getEstudiosSuperiores() {
    $this->restaurarSesion();
    return $this->data['academica']['estudiosSuperiores'];
  }

  //datos laborales
  public function getCargoCodigo() {
    $this->restaurarSesion();
    return $this->data['laboral']['cargo']['codigo'];
  }

  public function getCargoNombre() {
    $this->restaurarSesion();
    return $this->data['laboral']['cargo']['nombre'];
  }

  public function getAreaNombre() {
    $this->restaurarSesion();
    return $this->data['laboral']['area']['nombre'];
  }

  public function getVinculacion() {
    $this->restaurarSesion();
    return strtotime($this->data['laboral']['fechaVinculacion']);
  }

  public function getJefeInmediatoNombre() {
    $this->restaurarSesion();
    return $this->data['laboral']['jefeInmediato']['numeroIdentificacion'];
  }

  public function getExtension() {
    $this->restaurarSesion();
    return $this->data['laboral']['extension'];
  }

  public function getEmail() {
    $this->restaurarSesion();
    return $this->data['laboral']['correoElectronico'];
  }

  public function getAntiguedad() {
    $this->restaurarSesion();

    if (empty($this->data['laboral']['fechaVinculacion'])) {
      return null;
    }

    $datetime1 = date_create(date('Y-m-d'));
    $datetime2 = date_create($this->data['laboral']['fechaVinculacion']);
    $interval = date_diff($datetime1, $datetime2);
    $anhos = $meses = "";

    if ($interval->format('%y') > 1) {
      $anhos = $interval->format('%y') . " años ";
    } else if ($interval->format('%y') == 1) {
      $anhos = $interval->format('%y') . " año ";
    }

    if ($interval->format('%m') > 1) {
      $meses = $interval->format('%m') . " meses";
    } else if ($interval->format('%m') == 1) {
      $meses = $interval->format('%m') . " mes";
    }
    return $anhos . $meses;
  }

  public function getGruposCodigos() {
    $this->restaurarSesion();
    if(empty($this->data['gruposInteres'])){
      return [Yii::$app->params['grupo']['*']];
    }
    return $this->data['gruposInteres'];
  }

  public function getOcultosDashboard() {
    $opciones = UsuarioWidgetInactivo::find()->where(['numeroDocumento' => $this->numeroDocumento])->all();
    $opcionesOcultas = [];
    foreach ($opciones as $opcion) {
      $opcionesOcultas[] = $opcion->widget;
    }

    return $opcionesOcultas;
  }

  public function tienePermiso($nombrePermiso)
  {
    if (Yii::$app->authManager->checkAccess(Yii::$app->user->identity->numeroDocumento, $nombrePermiso)) {
      return true;
    }else{
        //throw new ForbiddenHttpException('no tienes permiso para acceder');
        return false;
    }
  }
}
