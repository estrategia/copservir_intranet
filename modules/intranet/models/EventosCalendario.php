<?php

namespace app\modules\intranet\models;

use Yii;
use yii\db\Expression;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\modules\intranet\models\Portal;
use app\models\Usuario;

/**
 * This is the model class for table "t_EventosCalendario".
 *
 * @property integer $idEventoCalendario
 * @property string $tituloEvento
 * @property string $url
 * @property integer $numeroDocumento
 * @property string $fechaRegistro
 * @property string $fechaInicioEvento
 * @property string $horaInicioEvento
 * @property string $fechaFinEvento
 * @property string $horaFinEvento
 * @property string $fechaInicioVisible
 * @property integer $estado
 */
class EventosCalendario extends \yii\db\ActiveRecord {

  const ACTIVO = 1;
  const INACTIVO = 0;
  const ENLACE_INTERNO = 1;
  const ENLACE_EXTERNO = 2;
  public $gruposInteres;
  public $portales;

    public static function tableName() {
        return 't_EventosCalendario';
    }

    public function rules() {
        return [
            [[ 'numeroDocumento', 'estado'], 'integer'],
            [['tituloEvento', 'numeroDocumento', 'fechaRegistro', 'fechaInicioEvento', 'fechaFinEvento', 'fechaInicioVisible', 'portales'], 'required'],
            [['fechaRegistro', 'fechaInicioEvento', 'horaInicioEvento', 'fechaFinEvento', 'horaFinEvento', 'fechaInicioVisible'], 'safe'],
            [['tituloEvento'], 'string', 'max' => 45],
            [['url'], 'string', 'max' => 200]
        ];
    }

    public function attributeLabels() {
        return [
            'idEventoCalendario' => 'Id Evento',
            'tituloEvento' => 'Título Evento',
            'url' => 'Url',
            'numeroDocumento' => 'Número Documento',
            'fechaRegistro' => 'Fecha Registro',
            'fechaInicioEvento' => 'Fecha Inicio Evento',
            'horaInicioEvento' => 'Hora Inicio Evento',
            'fechaFinEvento' => 'Fecha Fin Evento',
            'horaFinEvento' => 'Hora Fin Evento',
            'fechaInicioVisible' => 'Fecha Inicio Visible',
            'estado' => 'Estado',
            'portales' => 'Portales'
            // 'idPortal' => 'Portal',
        ];
    }

    public static function consultarEventos($inicio, $fin, $portal, $destino, $resumen = false) {
        //$fechaInicio = "t.fechaInicioVisible";
        //$fechaFin = "t.fechaFinVisible";
        $fechaInicio = "t.fechaInicioEvento";
        $fechaFin = "t.fechaFinEvento";
        /*if ($resumen) {
            $fechaInicio = "t.fechaInicioEvento";
            $fechaFin = "t.fechaFinEvento";
        }*/

        $query = array();

        if (empty($destino)) {
            $query = self::find()
                    ->alias('t')
                    ->joinWith(['objPortal as objPortal'])->where("( ($fechaInicio<=:inicio AND $fechaFin>:inicio) OR ($fechaInicio<:fin AND $fechaFin>=:fin) OR ($fechaInicio>=:inicio AND $fechaFin<=:fin) ) AND t.estado=:estado AND objPortal.nombrePortal=:portal")
                    ->orderBy('fechaInicioEvento ASC')
                    ->addParams([':inicio' => $inicio, ':fin' => $fin, ':estado' => 1, ':portal' => $portal])
                    ->all();
            return $query;
        } else {
            $query = self::find()
                    ->alias('t')
                    ->joinWith(['listEventosDestinos as destinos', 'objPortal as objPortal'])->where("( ($fechaInicio<=:inicio AND $fechaFin>:inicio) OR ($fechaInicio<:fin AND $fechaFin>=:fin) OR ($fechaInicio>=:inicio AND $fechaFin<=:fin) ) AND t.estado=:estado AND objPortal.nombrePortal=:portal AND ( (destinos.codigoCiudad=:ciudad AND destinos.idGrupoInteres IN (" . $destino['grupos'] . ")) OR (destinos.codigoCiudad=:ciudadA AND destinos.idGrupoInteres IN (" . $destino['grupos'] . ")) OR (destinos.codigoCiudad=:ciudad AND destinos.idGrupoInteres=:gruposA) OR (destinos.codigoCiudad=:ciudadA AND destinos.idGrupoInteres=:gruposA) )")
                    ->orderBy('fechaInicioEvento ASC')
                    ->addParams([':inicio' => $inicio, ':fin' => $fin, ':estado' => 1, ':portal' => $portal, ':ciudad' => $destino['ciudad'], ':ciudadA' => Yii::$app->params['ciudad']['*'], ':gruposA' => Yii::$app->params['grupo']['*']])
                    ->all();
            return $query;
        }

        //var_dump($query->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql);
        //exit();
    }

    public function convertirEvento($portal) {
        $evento = [
            'id' => $this->idEventoCalendario,
            'title' => $this->tituloEvento,
            'start' => $this->fechaInicioEvento,
            'end' => $this->fechaFinEvento,
            'color' => null,
            'href' => null,
            'allDay' => true
        ];

        if (!empty($this->url)) {
            if ($portal == "intranet") {
                $evento['href'] = $this->url;
            } else {
                $evento['href'] = $this->url;
            }
        }

        if ($this->horaInicioEvento != null && $this->horaFinEvento != null) {
            $evento['start'] .= "T$this->horaInicioEvento";
            $evento['end'] .= "T$this->horaFinEvento";
            $evento['allDay'] = false;
        }

        return $evento;
    }

    public function actualizarPortales($portalesForm)
    {
        $portalesAsignados = $this->eventosPortalesDestino;
        $idPortalesAsignados = ArrayHelper::getColumn($portalesAsignados, 'idPortal');
        $paraInsertar = array_diff($portalesForm, $idPortalesAsignados);
        $paraEliminar = array_diff($idPortalesAsignados, $portalesForm);
        if (!empty($paraInsertar)) {
            $this->guardarEventosPortalesDestino($paraInsertar);
        }
        if (!empty($paraEliminar)) {
            $connection = Yii::$app->getDb();
            $connection
            ->createCommand()
            ->delete('t_EventosCalendarioPortalesDestino', ['idPortal' => $paraEliminar])
            ->execute();
        }
    }

    public function guardarEventosPortalesDestino($portales)
    {
        $nombresPortales = $this->getListaPortales();
        foreach ($portales as $key => $portal) {
            $portalEvento = new EventosCalendarioPortalesDestino;
            $portalEvento->idEventoCalendario = $this->idEventoCalendario;
            $portalEvento->nombrePortal = $nombresPortales[$portal];
            $portalEvento->idPortal = $portal;
            $portalEvento->save();
        }
    }

    public function getListEventosDestinos() {
        return $this->hasMany(EventosCalendarioDestino::className(), ['idEventoCalendario' => 'idEventoCalendario']);
    }

    public function getObjPortal() {
        return $this->hasOne(Portal::className(), ['idPortal' => 'idPortal']);
    }

    public function getObjUsuario() {
        return $this->hasOne(Usuario::className(), ['numeroDocumento' => 'numeroDocumento']);
    }

    public function getEventosPortalesDestino() {
        return $this->hasMany(EventosCalendarioPortalesDestino::className(), ['idEventoCalendario' => 'idEventoCalendario']);
    }

    /**
     * @return array con modelos Portal mapeados por idPortal y nombrePortal
     */
    public function getListaPortales() {
        $opciones = Portal::find()->asArray()->all();
        return ArrayHelper::map($opciones, 'idPortal', 'nombrePortal');
    }
}
