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
    }

    /**
     * @param $userCiudad = ciudad donde se encuentra el usuario, $userGrupos = grupos de interes del usuario
     * @return array modelo CumpleanosLaboral
     */
    public static function getAniversariosIndex($userCiudad, $userGrupos) {
        //$fecha = Date("Y-m-d H:i:s");
        $fecha = new \DateTime;
        $fecha->modify('-5 days');

        $fecha2 = new \DateTime;
        $fecha2->modify('+5 days');

        $userGrupos = implode(',', $userGrupos);
        $todosCiudad = \Yii::$app->params['ciudad']['*'];
        $todosGrupo = \Yii::$app->params['grupo']['*'];

        $query = self::find()->joinWith(['objGrupoInteresCargo'])->with(['objUsuario'])
                ->where("( t_CumpleanosLaboral.fecha>=:fecha AND t_CumpleanosLaboral.fecha<=:fechaFin AND ( (t_CumpleanosLaboral.codigoCiudad =:codigoCiudad AND m_GrupoInteresCargo.idGrupoInteres IN ($userGrupos)) OR (t_CumpleanosLaboral.codigoCiudad =:codigoCiudad AND m_GrupoInteresCargo.idCargo=:todosGrupo) OR (t_CumpleanosLaboral.codigoCiudad =:todosCiudad AND m_GrupoInteresCargo.idGrupoInteres IN ($userGrupos)) OR (t_CumpleanosLaboral.codigoCiudad =:todosCiudad AND m_GrupoInteresCargo.idCargo =:todosGrupo) )   )")
                ->addParams([':fecha' => $fecha->format('Y-m-d H:i:s'), ':fechaFin' => $fecha2->format('Y-m-d H:i:s' ), ':codigoCiudad' => $userCiudad,
                 ':todosCiudad' => $todosCiudad, ':todosGrupo' => $todosGrupo])
                ->orderBy('t_CumpleanosLaboral.fecha asc')
                ->all();

        //var_dump($query->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql);
        return $query;
    }

    /**
     * consulta todos los modelos CumpleanosLaboral a partir de 5 dias atras de la fecha actual
     * @return array modelo CumpleanosLaboral
     */
    public static function getAniversariosVerTodos() {

        $fecha = new \DateTime;
        $fecha->modify('-5 days');

        $fecha2 = new \DateTime;
        $fecha2->modify('+5 days');

        return self::find()->joinWith(['objGrupoInteresCargo'])->with(['objUsuario'])
                        ->where("( t_CumpleanosLaboral.fecha>=:fecha and t_CumpleanosLaboral.fecha<=:fechaFin )")
                        ->addParams([':fecha' => $fecha->format('Y-m-d H:i:s'), ':fechaFin' => $fecha2->format('Y-m-d H:i:s' )])
                        ->orderBy('t_CumpleanosLaboral.fecha asc')
                        ->all();
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

}
