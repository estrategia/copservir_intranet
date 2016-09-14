<?php

namespace app\modules\trademarketing\models;

use Yii;
use app\models\Usuario;
use \app\modules\intranet\models\Ciudad;


/**
 * Modelo para la tabla "t_TRMA_AsignacionPuntoVenta".
 *
 * @property string $idAsignacion
 * @property string $idComercial
 * @property string $NombrePuntoDeVenta
 * @property string $nombreTipoNegocio
 * @property string $idCiudad
 * @property string $idZona
 * @property string $nombreZona
 * @property string $idSede
 * @property string $nombreSede
 * @property string $numeroDocumento
 * @property string $numeroDocumentoAdministradorPuntoVenta
 * @property string $numeroDocumentosubAdministradorpuntoVenta
 * @property integer $estado
 * @property string $fechaAsignacion
 *
 * @property Usuario $usuario
 * @property array[CalificacionVariable] $calificaciones
 * @property Usuario $usuarioAdministrador
 * @property Usuario $usuarioSubAminidtrador
 * @property array[Observaciones] $observaciones
 * @property array[PorcentajeUnidad] porcentajeUnidad
 * @property Ciudad ciudad
 */
 
class AsignacionPuntoVenta extends \yii\db\ActiveRecord
{
    const ESTADO_INACTIVO = 0;
    const ESTADO_PENDIENTE = 1;
    const ESTADO_CALIFICADO = 2;

    const ACTION_GUARDAR = 0;
    const ACTION_FINALIZAR = 1;

    public static function tableName()
    {
        return 't_TRMA_AsignacionPuntoVenta';
    }

    public function rules()
    {
        return [
            [['idComercial', 'NombrePuntoDeVenta', 'nombreTipoNegocio', 'idCiudad', 'idZona', 'nombreZona', 'idSede',
              'nombreSede', 'numeroDocumento', 'numeroDocumentoAdministradorPuntoVenta', 'numeroDocumentosubAdministradorpuntoVenta',
               'estado', 'fechaAsignacion'], 'required'],
            [['idCiudad', 'idZona', 'idSede', 'numeroDocumento', 'numeroDocumentoAdministradorPuntoVenta',
              'numeroDocumentosubAdministradorpuntoVenta', 'estado'], 'integer'],
            [['fechaAsignacion'], 'safe'],
            [['idComercial'], 'string', 'max' => 10],
            [['NombrePuntoDeVenta', 'nombreSede'], 'string', 'max' => 100],
            [['nombreTipoNegocio'], 'string', 'max' => 45],
            [['nombreZona'], 'string', 'max' => 80],
        ];
    }

    public function attributeLabels()
    {
        return [
            'idAsignacion' => 'Id Asignacion',
            'idComercial' => 'Punto de Venta',
            'NombrePuntoDeVenta' => 'Punto De Venta',
            'nombreTipoNegocio' => 'Tipo de Negocio',
            'idCiudad' => 'Ciudad',
            'idZona' => 'Id Zona',
            'nombreZona' => 'Zona',
            'idSede' => 'Id Sede',
            'nombreSede' => 'Sede',
            'numeroDocumento' => 'Numero Documento',
            'numeroDocumentoAdministradorPuntoVenta' => 'Administrador Punto Venta',
            'numeroDocumentosubAdministradorpuntoVenta' => 'SubAdministrador Punto Venta',
            'estado' => 'Estado',
            'fechaAsignacion' => 'Fecha Asignacion',
        ];
    }

    // RELACIONES

    public function getCalificaciones()
    {
        return $this->hasMany(CalificacionVariable::className(), ['idAsignacion' => 'idAsignacion']);
    }

    public function getObservaciones()
    {
        return $this->hasMany(Observaciones::className(), ['idAsignacion' => 'idAsignacion']);
    }

    public function getPorcentajeUnidad()
    {
        return $this->hasMany(PorcentajeUnidad::className(), ['idAsignacion' => 'idAsignacion']);
    }

    public function getCiudad() {
        return $this->hasOne(Ciudad::className(), ['idCiudad' => 'idCiudad']);
    }

    public function getUsuario() {
        return $this->hasOne(Usuario::className(), ['numeroDocumento' => 'numeroDocumento']);
    }

    public function getUsuarioAdministrador() {
        return $this->hasOne(Usuario::className(), ['numeroDocumento' => 'numeroDocumentoAdministradorPuntoVenta']);
    }

    public function getUsuarioSubAminidtrador() {
        return $this->hasOne(Usuario::className(), ['numeroDocumento' => 'numeroDocumentosubAdministradorpuntoVenta']);
    }

    // FUNCIONES

    public function setEstadoPendiente()
    {
      $this->estado = self::ESTADO_PENDIENTE;
    }

    public function setEstadoFinalizado()
    {
      $this->estado = self::ESTADO_CALIFICADO;
    }


    // extra campos para solicitar las relaciones en la peticion rest
    public function extraFields()
    {
      return ['calificaciones', 'observaciones', 'porcentajeUnidad'];
    }
}
