<?php

namespace app\modules\intranet\models;

use Yii;
use app\models\Usuario;
/**
 * This is the model class for table "t_cumpleanoslaboral".
 *
 * @property integer $idCumpleanosLaboral
 * @property integer $numeroDocumento
 * @property string $nombre
 * @property string $idCargo
 * @property string $fecha
 * @property integer $codigoCiudad
 */
class CumpleanosLaboral extends \yii\db\ActiveRecord {

    public static function tableName() {
        return 't_CumpleanosLaboral';
    }

    public function rules() {
        return [
            [['numeroDocumento', 'nombre', 'idCargo', 'fecha', 'codigoCiudad'], 'required'],
            [['numeroDocumento', 'codigoCiudad'], 'integer'],
            [['fecha'], 'safe'],
            [['nombre', 'idCargo'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels() {
        return [
            'idCumpleanosLaboral' => 'Id Cumpleanos Laboral',
            'numeroDocumento' => 'Numero Documento',
            'nombre' => 'Nombre',
            'idCargo' => 'Id Cargo',
            'fecha' => 'Fecha',
            'codigoCiudad' => 'Id Ciudad',
        ];
    }

    //RELACIONES

    public function getObjUsuario() {
        return $this->hasOne(Usuario::className(), ['numeroDocumento' => 'numeroDocumento']);
    }

    public function getObjGrupoInteresCargo() {
        return $this->hasMany(GrupoInteresCargo::className(), ['idCargo' => 'idCargo']);
    }

    // CONSULTAS

    /**
     * Consulta los aniversarios segun el mes actual
     * @return array modelo CumpleanosLaboral
     */
    public static function getAniversariosMes()
    {
        $query = self::find()->where('(  month(t_CumpleanosLaboral.fecha) =:mes )')
        ->addParams([':mes' => date("m")])
        ->all()
        ;
        
        return $query;
    }

    /**
     * 
     * @return array modelo CumpleanosLaboral
     */
    public static function getAniversariosIndex() {
        $fecha = new \DateTime;

        $query = self::find()->joinWith(['objUsuario'])
                ->where("m_Usuario.imagenPerfil IS NOT NULL AND  t_CumpleanosLaboral.fecha=:fecha")
                ->addParams([':fecha' => $fecha->format('Y-m-d')])
                ->orderBy('t_CumpleanosLaboral.fecha asc');

        //return $query->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql;
        return $query->all();
    }

    /**
     * consulta todos los modelos CumpleanosLaboral a partir de 5 dias atras de la fecha actual
     * @return array modelo CumpleanosLaboral
     */
    public static function getAniversariosVerTodos() {

        $fecha = new \DateTime;
        $fecha->modify('-3 days');

        $fecha2 = new \DateTime;
        //$fecha2->modify('+5 days');

        $query = self::find()->joinWith(['objUsuario'])
                        ->where("m_Usuario.imagenPerfil IS NOT NULL AND t_CumpleanosLaboral.fecha>=:fecha")
                        ->addParams([':fecha' => $fecha->format('Y-m-d')])
                        ->orderBy('t_CumpleanosLaboral.fecha asc');
        
        return $query->all();
    }

    public static function encontrarModelo($id) {
        $model = self::find()->with(['objUsuario'])->where(['idCumpleanosLaboral' => $id])->one();

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
    
    public static function callWSGetAniversarios($cedulas) {
        $client = new \SoapClient(\Yii::$app->params['webServices']['persona'], array(
            "trace" => 1,
            "exceptions" => 0,
            'connection_timeout' => 5,
            'cache_wsdl' => WSDL_CACHE_NONE
        ));

        try {

            $result = $client->getAniversarios(date("m"), $cedulas);
            return $result;
        } catch (SoapFault $ex) {
            Yii::error($ex->getMessage());
        } catch (Exception $ex) {
            Yii::error($ex->getMessage());
        }
    }

}
