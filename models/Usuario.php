<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;
use yii\base\NotSupportedException;
use yii\base\Event;
use yii\web\ForbiddenHttpException;
use yii\data\ActiveDataProvider;
use app\modules\intranet\models\GrupoInteresCargo;
use app\modules\intranet\models\UsuarioWidgetInactivo;
use app\modules\tarjetamas\models\UsuarioTarjetaMas;

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

    const ESTADO_ACTIVO = 1;
    const ESTADO_INACTIVO = 2;

    private $data = [
        'sesionRestaurada' => false,
        'personal' => [
            'nombres' => null,
            'primerApellido' => null,
            'segundoApellido' => null,
            'correoPersonal' => null,
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

    /*
      public function init() {
      Event::on(\yii\web\User::className(), \yii\web\User::EVENT_AFTER_LOGIN, function ($event) {
      $this->generarDatos();
      });
      }
     */

    private function restaurarSesion() {
        $userdata = \Yii::$app->session->get('user.data');
        if (empty($userdata)) {
            $this->generarDatos();
        } else {
            $this->data = \Yii::$app->session->get('user.data');
        }
    }

    public function generarDatos($forzar = false) {
        if (!$this->data['sesionRestaurada'] || $forzar) {
            try {
                $infoPersona = self::callWSInfoPersona($this->numeroDocumento);

                if (empty($infoPersona)) {
                    return false;
                } else {
                    $this->data['personal']['nombres'] = $infoPersona['Nombres'];
                    $this->data['personal']['primerApellido'] = $infoPersona['PrimerApellido'];
                    $this->data['personal']['segundoApellido'] = $infoPersona['SegundoApellido'];
                    $this->data['personal']['correoPersonal'] = $infoPersona['CorreoPersonal'];

                    foreach ($infoPersona['NumeroTelefono'] as $key => $value) {
                        $this->data['personal']['celular'] .= $value . ", ";
                    }
                    $this->data['personal']['residencia'] = $infoPersona['Direccion'];
                    $this->data['personal']['ciudad']['nombre'] = $infoPersona['Ciudad'];
                    $this->data['personal']['ciudad']['codigo'] = $infoPersona['Codigo'];
                    $this->data['personal']['fechaCumpleanhos'] = $infoPersona['FechaNacimiento'];

                    //$this->data['academica']['profesion'] = "Ingeniero de sistemas y ciencias de la computación";
                    //$this->data['academica']['estudiosSuperiores'] = "Universidad del valle sede Melendez";
                    $this->data['academica']['profesion'] = "";
                    $this->data['academica']['estudiosSuperiores'] = "";

                    $this->data['laboral']['cargo']['codigo'] = $infoPersona['CodigoCargo'];
                    $this->data['laboral']['cargo']['nombre'] = $infoPersona['Cargo'];
                    $this->data['laboral']['area']['nombre'] = "";
                    $this->data['laboral']['fechaVinculacion'] = $infoPersona['FechaVinculacion'];
                    $this->data['laboral']['jefeInmediato']['numeroIdentificacion'] = "";
                    $this->data['laboral']['jefeInmediato']['nombre'] = "";
                    $this->data['laboral']['extension'] = "";
                    $this->data['laboral']['correoElectronico'] = $infoPersona['Email'];

                    $this->data['sesionRestaurada'] = true;

                    $listGrupoInteresCargo = GrupoInteresCargo::find()->where("idCargo=:cargo", [':cargo' => $this->data['laboral']['cargo']['codigo']])->all();
                    $this->data['gruposInteres'] = [];

                    foreach ($listGrupoInteresCargo as $objGrupoInteresCargo) {
                        $this->data['gruposInteres'][] = $objGrupoInteresCargo->idGrupoInteres;
                    }

                    \Yii::$app->session->set('user.data', $this->data);
                    return true;
                }
            } catch (SoapFault $exc) {

                Yii::error($exc->getMessage());
                return false;
            } catch (Exception $ex) {

                Yii::error($ex->getMessage());
                return false;
            }
        }
    }

    /**
     * Funcion para consumir un web services para traer la informacion de un usuario s
     * @param string $numeroDocumento
     * @return array
     */
    public static function callWSInfoPersona($numeroDocumento) {
        $client = new \SoapClient(\Yii::$app->params['webServices']['persona'], array(
            "trace" => 1,
            "exceptions" => 0,
            'connection_timeout' => 5,
            'cache_wsdl' => WSDL_CACHE_NONE
        ));

        $result = $client->getPersonaWithModel($numeroDocumento, true, null);
        return $result;
    }

    public function rules() {
        return [
            [['numeroDocumento', 'estado', 'codigoPerfil'], 'required'],
            [['numeroDocumento', 'estado', 'codigoPerfil'], 'integer'],
            [['alias'], 'string', 'max' => 60],
            [['contrasena'], 'string', 'max' => 32],
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

        $query = self::find()->where("(estado=:estado
        and numeroDocumento not in (select numeroDocumentoDirigido from `t_ContenidoRecomendacion`
        where (`fechaRegistro` <=:fechaRegistro) and (`idContenido`=:idContenido))
        and numeroDocumento !=:idUsuario )")->addParams([':estado' => 1, ':idUsuario' => $idUsuario, ':fechaRegistro' => $fecha, ':idContenido' => $idContenido])->all();

        return $query;
    }

    public function getObjUsuarioTarjetaMas() {
        return $this->hasOne(UsuarioTarjetaMas::className(), ['numeroDocumento' => 'numeroDocumento']);
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

    /*
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
     */

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

    public function getFechaNacimiento() {
        $this->restaurarSesion();
        return $this->data['personal']['fechaCumpleanhos'];
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
        return $this->data['laboral']['fechaVinculacion'];
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

    public function getEmailPersonal() {
        $this->restaurarSesion();
        return $this->data['personal']['correoPersonal'];
    }

    public function getNombres() {
        $this->restaurarSesion();
        return $this->data['personal']['nombres'];
    }

    public function getPrimerApellido() {
        $this->restaurarSesion();
        return $this->data['personal']['primerApellido'];
    }

    public function getSegundoApellido() {
        $this->restaurarSesion();
        return $this->data['personal']['segundoApellido'];
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
        if (empty($this->data['gruposInteres'])) {
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

    public function tienePermiso($nombrePermiso) {

        if ($this->codigoPerfil == \Yii::$app->params['PerfilesUsuario']['intranet']['codigo']) {
            \Yii::$app->authManager->defaultRoles = [\Yii::$app->params['PerfilesUsuario']['intranet']['permiso']];
        } elseif ($this->codigoPerfil == \Yii::$app->params['PerfilesUsuario']['tarjetaMas']['codigo']) {
            \Yii::$app->authManager->defaultRoles = [\Yii::$app->params['PerfilesUsuario']['tarjetaMas']['permiso']];
        }


        return Yii::$app->authManager->checkAccess($this->numeroDocumento, $nombrePermiso);
    }

    public function getRoles() {
        return Yii::$app->authManager->getRolesByUser($this->numeroDocumento);
    }

    public function generarCodigoRecuperacion() {
        $fecha = new \DateTime();
        $fecha->modify('+ 1 day');
        $codigoRecuperacion = md5($this->numeroDocumento . '~' . $fecha->format('YmdHis'));

        return $codigoRecuperacion;
    }

}
