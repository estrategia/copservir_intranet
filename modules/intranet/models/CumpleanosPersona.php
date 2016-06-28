<?php

namespace app\modules\intranet\models;

use Yii;

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
            [['numeroDocumento', 'nombre', 'idCargo', 'fecha', 'codigoCiudad'], 'required'],
            [['numeroDocumento', 'codigoCiudad'], 'integer'],
            [['fecha'], 'safe'],
            [['nombre', 'idCargo'], 'string', 'max' => 255],
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
     * @param $userCiudad = ciudad donde se encuentra el usuario, $userGrupos = grupos de interes del usuario
     * @return array modelo CumpleanosLaboral
     */
    public static function getCumpleanosIndex($userCiudad, $userGrupos) {
        $fecha = new \DateTime;
        $fecha->modify('-5 days');
        $userGrupos = implode(',', $userGrupos);

        $todosCiudad = \Yii::$app->params['ciudad']['*'];
        $todosGrupo = \Yii::$app->params['grupo']['*'];

        $query =  self::find()->joinWith(['objGrupoInteresCargo', 'objUsuario'])->with(['objUsuario'])
                        ->where("( m_Usuario.imagenPerfil is not null AND t_CumpleanosPersona.fecha>=:fecha AND ( (t_CumpleanosPersona.codigoCiudad =:codigoCiudad AND m_GrupoInteresCargo.idGrupoInteres IN ($userGrupos)) OR (t_CumpleanosPersona.codigoCiudad =:codigoCiudad AND m_GrupoInteresCargo.idCargo=:todosGrupo) OR (t_CumpleanosPersona.codigoCiudad =:todosCiudad AND m_GrupoInteresCargo.idGrupoInteres IN ($userGrupos)) OR (t_CumpleanosPersona.codigoCiudad =:todosCiudad AND m_GrupoInteresCargo.idCargo =:todosGrupo) )   )")
                        ->addParams([':fecha' => $fecha->format('Y-m-d H:i:s'), ':codigoCiudad' => $userCiudad, ':todosCiudad' => $todosCiudad, ':todosGrupo' => $todosGrupo])
                        ->orderBy('t_CumpleanosPersona.fecha asc')
                        ->all();
                        
        return $query;

    }

    /**
     * consulta todos los modelos CumpleanosPersona a partir de 5 dias atras de la fecha actual
     * @return array modelo CumpleanosLaboral
     */
    public static function getCumpleanosVerTodos() {

        $fecha = new \DateTime;
        $fecha->modify('-5 days');
        return self::find()->joinWith(['objGrupoInteresCargo'])->with(['objUsuario'])
                        ->where("( t_CumpleanosPersona.fecha>=:fecha  )")
                        ->addParams([':fecha' => $fecha->format('Y-m-d H:i:s')])
                        ->orderBy('t_CumpleanosPersona.fecha asc')
                        ->all();
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

}
