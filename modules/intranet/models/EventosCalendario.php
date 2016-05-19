<?php

namespace app\modules\intranet\models;

use Yii;
use yii\db\Expression;
use yii\helpers\Url;

/**
 * This is the model class for table "t_EventosCalendario".
 *
 * @property integer $idEventoCalendario
 * @property integer $idContenido
 * @property string $tituloEvento
 * @property string $descripcionEvento
 * @property integer $numeroDocumento
 * @property string $fechaRegistro
 * @property string $fechaInicioEvento
 * @property string $horaInicioEvento
 * @property string $fechaFinEvento
 * @property string $horaFinEvento
 * @property string $fechaInicioVisible
 * @property string $fechaFinVisible
 * @property integer $estado
 */
class EventosCalendario extends \yii\db\ActiveRecord {

    public static function tableName() {
        return 't_EventosCalendario';
    }

    public function rules() {
        return [
            [['idContenido', 'numeroDocumento', 'estado'], 'integer'],
            [['tituloEvento', 'descripcionEvento', 'numeroDocumento', 'fechaRegistro', 'fechaInicioEvento', 'fechaFinEvento', 'fechaInicioVisible', 'fechaFinVisible'], 'required'],
            [['fechaRegistro', 'fechaInicioEvento', 'horaInicioEvento', 'fechaFinEvento', 'horaFinEvento', 'fechaInicioVisible', 'fechaFinVisible'], 'safe'],
            [['tituloEvento'], 'string', 'max' => 45],
            [['descripcionEvento'], 'string', 'max' => 200]
        ];
    }

    public function attributeLabels() {
        return [
            'idEventoCalendario' => 'Id Evento',
            'idContenido' => 'Contenido',
            'tituloEvento' => 'T&iacute;tulo Evento',
            'descripcionEvento' => 'Descripci&oacute;n Evento',
            'numeroDocumento' => 'N&uacute;mero Documento',
            'fechaRegistro' => 'Fecha Registro',
            'fechaInicioEvento' => 'Fecha Inicio Evento',
            'horaInicioEvento' => 'Hora Inicio Evento',
            'fechaFinEvento' => 'Fecha Fin Evento',
            'horaFinEvento' => 'Hora Fin Evento',
            'fechaInicioVisible' => 'Fecha Inicio Visible',
            'fechaFinVisible' => 'Fecha Fin Visible',
            'estado' => 'Estado',
        ];
    }

    public static function consultarEventos($inicio, $fin, $portal, $destino, $resumen = false) {
        $fechaInicio = "t_EventosCalendario.fechaInicioVisible";
        $fechaFin = "t_EventosCalendario.fechaFinVisible";

        if ($resumen) {
            $fechaInicio = "t_EventosCalendario.fechaInicioEvento";
            $fechaFin = "t_EventosCalendario.fechaFinEvento";
        }

        $query = array();

        if (empty($destino)) {
            $query = self::find()->with(['objContenido'])
                    ->joinWith(['listEventosPortales.objPortal'])->where("( ($fechaInicio<=:inicio AND $fechaFin>:inicio) OR ($fechaInicio<:fin AND $fechaFin>=:fin) OR ($fechaInicio>=:inicio AND $fechaFin<=:fin) ) AND t_EventosCalendario.estado=:estado AND m_Portal.nombrePortal=:portal")
                    ->orderBy('fechaInicioEvento ASC')
                    ->addParams([':inicio' => $inicio, ':fin' => $fin, ':estado' => 1, ':portal' => $portal])
                    ->all();
            return $query;
        } else {
            $query = self::find()->with(['objContenido'])
                    ->joinWith(['listEventosDestinos', 'listEventosPortales.objPortal'])->where("( ($fechaInicio<=:inicio AND $fechaFin>:inicio) OR ($fechaInicio<:fin AND $fechaFin>=:fin) OR ($fechaInicio>=:inicio AND $fechaFin<=:fin) ) AND t_EventosCalendario.estado=:estado AND m_Portal.nombrePortal=:portal AND ( (t_EventosCalendarioDestino.codigoCiudad=:ciudad AND t_EventosCalendarioDestino.idGrupoInteres IN (" . $destino['grupos'] . ")) OR (t_EventosCalendarioDestino.codigoCiudad=:ciudadA AND t_EventosCalendarioDestino.idGrupoInteres IN (" . $destino['grupos'] . ")) OR (t_EventosCalendarioDestino.codigoCiudad=:ciudad AND t_EventosCalendarioDestino.idGrupoInteres=:gruposA) OR (t_EventosCalendarioDestino.codigoCiudad=:ciudadA AND t_EventosCalendarioDestino.idGrupoInteres=:gruposA) )")
                    ->orderBy('fechaInicioEvento ASC')
                    ->addParams([':inicio' => $inicio, ':fin' => $fin, ':estado' => 1, ':portal' => $portal, ':ciudad' => $destino['ciudad'], ':ciudadA' => Yii::$app->params['ciudad']['*'], ':gruposA' => Yii::$app->params['grupo']['*']])
                    ->all();
            return $query;
        }

        var_dump($query->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql);
        exit();
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

        if ($this->objContenido != null) {
            if ($portal == "intranet") {
                $evento['href'] = Url::to(['/intranet/contenido/detalle-contenido', 'idNoticia' => $this->idContenido]);
            } else {
                $evento['href'] = Url::to(["/$portal/sitio/detalle-noticia", 'idNoticia' => $this->idContenido]);
            }
        }

        if ($this->horaInicioEvento != null && $this->horaFinEvento != null) {
            $evento['start'] .= "T$this->horaInicioEvento";
            $evento['end'] .= "T$this->horaFinEvento";
            $evento['allDay'] = false;
        }

        return $evento;
    }

    public function getListEventosDestinos() {
        return $this->hasMany(EventosCalendarioDestino::className(), ['idEventoCalendario' => 'idEventoCalendario']);
    }

    public function getListEventosPortales() {
        return $this->hasMany(EventosCalendarioPortal::className(), ['idEventoCalendario' => 'idEventoCalendario']);
    }

    public function getObjContenido() {
        return $this->hasOne(Contenido::className(), ['idContenido' => 'idContenido']);
    }

    public function getObjUsuario() {
        return $this->hasOne(Usuario::className(), ['numeroDocumento' => 'numeroDocumento']);
    }

}
