<?php

namespace app\modules\intranet\models;

use Yii;
use app\models\Usuario;
/**
 * This is the model class for table "t_cumpleanospersona".
 *
 * @property integer $idCumpleanosPersona
 * @property integer $numeroDocumento
 * @property string $nombre
 * @property string $idCargo
 * @property string $fecha
 * @property integer $codigoCiudad
 */
class CumpleanosPersona extends \yii\db\ActiveRecord {

    public static function tableName() {
        return 't_CumpleanosPersona';
    }

    public function rules() {
        return [
            [['numeroDocumento', 'nombre', 'idCargo', 'fecha', 'codigoCiudad', 'fechaIngreso'], 'required'],
            [['numeroDocumento', 'codigoCiudad'], 'integer'],
            [['fecha', 'fechaIngreso'], 'safe'],
            [['nombre', 'idCargo'], 'string', 'max' => 255],
            [['ubicacion',], 'string', 'max' => 200],
        ];
    }

    public function attributeLabels() {
        return [
            'idCumpleanosPersona' => 'Id Cumpleanos Persona',
            'numeroDocumento' => 'Numero Documento',
            'nombre' => 'Nombre',
            'idCargo' => 'Id Cargo',
            'fecha' => 'Fecha',
            'codigoCiudad' => 'Id Ciudad',
            'fechaIngreso' => 'Fecha de Ingreso',
            'ubicacion' => 'Ubicacion'
        ];
    }

    // RELACIONES

    public function getObjUsuario() {
        return $this->hasOne(Usuario::className(), ['numeroDocumento' => 'numeroDocumento']);
    }

    public function getObjGrupoInteresCargo() {
        return $this->hasMany(GrupoInteresCargo::className(), ['idCargo' => 'idCargo']);
    }

    // CONSULTAS

    /**
     * Consulta los cumpleaños segun el mes actual
     * @return array modelo CumpleanosLaboral
     */
    public static function getCumpleanosMes()
    {
        $query = self::find()->where('(  month(t_CumpleanosPersona.fecha) =:mes )')
        ->addParams([':mes' => date("m")])
        ->all();

        return $query;
    }

    /**
     * @param $userCiudad = ciudad donde se encuentra el usuario, $userGrupos = grupos de interes del usuario
     * @return array modelo CumpleanosLaboral
     */
    public static function getCumpleanosIndex() {
        $fecha = new \DateTime;
        $query =  self::find()->joinWith(['objUsuario'])
                        ->where("m_Usuario.imagenPerfil IS NOT NULL AND t_CumpleanosPersona.fecha=:fecha")
                        ->addParams([':fecha' => $fecha->format('Y-m-d')])
                        ->orderBy('t_CumpleanosPersona.fecha asc');

        //return $query->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql;
        return $query->all();
    }

    /**
     * consulta todos los modelos CumpleanosPersona a partir de 5 dias atras de la fecha actual
     * @return array modelo CumpleanosLaboral
     */
    public static function getCumpleanosVerTodos() {

        $fecha = new \DateTime;
        $fecha->modify('-5 days');

        $fecha2 = new \DateTime;
        $fecha2->modify('+5 days');

        $query = self::find()->joinWith(['objUsuario'])
                        ->where("m_Usuario.imagenPerfil IS NOT NULL AND  t_CumpleanosPersona.fecha>=:fecha")
                        ->addParams([':fecha' => $fecha->format('Y-m-d')])
                        ->orderBy('t_CumpleanosPersona.fecha asc');

        return $query->all();
    }

    public static function encontrarModelo($id) {
        $model = self::find()->with(['objUsuario'])->where(['idCumpleanosPersona' => $id])->one();

        if ($model !== null) {
            return $model;
        } else {
            throw new \Exception('el modelo no existe.');
        }
    }

    public function obtenerDestinos($contenidoDestino = false) {
        $listGrupoInteres = GrupoInteresCargo::find()
                ->where("idCargo=:cargo", [':cargo' => $this->idCargo])
                ->all();

        $arrDestinos = array();

        foreach ($listGrupoInteres as $indice => $objGrupoInteres) {
            if ($contenidoDestino) {
                $arrDestinos['idGrupoInteres'][$indice] = $objGrupoInteres->idGrupoInteres;
                $arrDestinos['codigoCiudad'][$indice] = $this->codigoCiudad;
            } else {
                $arrDestinos[$indice]['idGrupoInteres'] = $objGrupoInteres->idGrupoInteres;
                $arrDestinos[$indice]['codigoCiudad'] = $this->codigoCiudad;
            }
        }

        return $arrDestinos;
    }

    public static function callWSGetCumpleanos($cedulas) {
        $client = new \SoapClient(\Yii::$app->params['webServices']['persona'], array(
            "trace" => 1,
            "exceptions" => 0,
            'connection_timeout' => 5,
            //'cache_wsdl' => WSDL_CACHE_NONE
        ));

        try {

            $result = $client->getCumpleanos(date("m"), $cedulas);
            return $result;
        } catch (SoapFault $ex) {
            Yii::error($ex->getMessage());
        } catch (Exception $ex) {
            Yii::error($ex->getMessage());
        }
    }

}
