<?php

class WsMultiportalController extends CController {

    public function actions() {
        return array(
            'persona' => array(
                'class' => 'CWebServiceAction',
            ),
        );
    }

    /**
     * @param int
     * @param boolean
     * @param string
     * @return array 
     * @soap
     */
    public function getPersona($cedula = null, $opcion = true, $idComercial = null) {

        try {

            $parametro = "";

            if (isset($cedula)) {
                $parametro .= " AND e.NumeroDocumento = " . $cedula;
            }
            if (isset($idComercial)) {
                $parametro .= " AND e.IdCentroCostos = " . $idComercial;
            }

            $sql = "SELECT p.NumeroDocumento,p.PrimerApellido,p.SegundoApellido,
						   p.Nombres,p.Direccion,b.NombreBarrio as 'Barrio',c.IdCiudad as 'Codigo',c.NombreCiudad as 'ExpedidaEn',
						   p.FechaNacimiento,td.TipoDocumento,p.Email, /* d.NombreDepartamento as 'Departamento', */
						   ci.NombreCiudad as 'Ciudad',car.NombreCargo as 'Cargo', e.IdCentroCostos ,cent.NombreCentroCostos as 'CentroCosto'
						   FROM m_Empleado e
						   LEFT JOIN m_Persona p ON p.NumeroDocumento = e.NumeroDocumento
						   LEFT OUTER JOIN m_Barrio b ON b.IdBarrio = p.IdBarrio
						   LEFT JOIN m_Ciudad c ON c.IdCiudad = p.ExpedidaEn
						   LEFT JOIN m_TipoDocumento td ON td.IdTipoDocumento = p.IdTipoDocumento
						   RIGHT JOIN m_Departamento d ON d.IdDepartamento = p.IdDepartamento
						   RIGHT JOIN m_Ciudad ci ON ci.IdCiudad = p.IdCiudad
						   RIGHT JOIN m_Cargo car ON car.IdCargo = e.IdCargo
						   RIGHT JOIN m_CentroCostos cent ON cent.IdCentroCostos = e.IdCentroCostos
						   WHERE e.IdEstado = 1 " . $parametro;

            $data = Yii::app()->getDb()->createCommand($sql)->queryAll();

            if ($opcion) {
                if (!empty($data)) {
                    foreach ($data as $clave => $array) {
                        break;
                    }
                    return $array;
                } else {
                    return array();
                }
            } else {
                if (!empty($data) || empty($data)) {
                    return $data;
                }
            }
        } catch (Exception $exc) {
            Yii::log($exc->getMessage() . "\n" . $exc->getTraceAsString(), CLogger::LEVEL_ERROR, 'application');
            return null;
        }
    }

    /**
     * @param string
     * @param boolean
     * @param string
     * @return array 
     * @soap
     */
    public function getPersonas($cedula = null, $opcion = true, $idComercial = null) {

        try {

            $parametro = "";

            if (isset($cedula)) {

                if (is_numeric($cedula)) {
                    $parametro .= " AND e.NumeroDocumento = " . $cedula;
                } else {
                    $parametro .= " AND e.NumeroDocumento  IN (" . $cedula . ")";
                }
            }

            if (isset($idComercial)) {
                $parametro .= " AND e.IdCentroCostos = " . $idComercial;
            }

            $sql = "SELECT p.NumeroDocumento,p.PrimerApellido,p.SegundoApellido,
						   p.Nombres,p.Direccion,b.NombreBarrio as 'Barrio',c.IdCiudad as 'Codigo',c.NombreCiudad as 'ExpedidaEn',
						   p.FechaNacimiento,td.TipoDocumento,p.Email, /* d.NombreDepartamento as 'Departamento', */
						   ci.NombreCiudad as 'Ciudad',car.NombreCargo as 'Cargo', e.IdCentroCostos ,cent.NombreCentroCostos as 'CentroCosto'
						   FROM m_Empleado e
						   LEFT JOIN m_Persona p ON p.NumeroDocumento = e.NumeroDocumento
						   LEFT OUTER JOIN m_Barrio b ON b.IdBarrio = p.IdBarrio
						   LEFT JOIN m_Ciudad c ON c.IdCiudad = p.ExpedidaEn
						   LEFT JOIN m_TipoDocumento td ON td.IdTipoDocumento = p.IdTipoDocumento
						/*   RIGHT JOIN m_Departamento d ON d.IdDepartamento = p.IdDepartamento */
						   RIGHT JOIN m_Ciudad ci ON ci.IdCiudad = p.IdCiudad
						   RIGHT JOIN m_Cargo car ON car.IdCargo = e.IdCargo
						   RIGHT JOIN m_CentroCostos cent ON cent.IdCentroCostos = e.IdCentroCostos
						   WHERE e.IdEstado = 1 " . $parametro;

            $data = Yii::app()->getDb()->createCommand($sql)->queryAll();

            if ($opcion) {
                if (!empty($data)) {
                    foreach ($data as $clave => $array) {
                        break;
                    }
                    return $array;
                } else {
                    return array();
                }
            } else {
                if (!empty($data) || empty($data)) {
                    return $data;
                }
            }
        } catch (Exception $exc) {
            Yii::log($exc->getMessage() . "\n" . $exc->getTraceAsString(), CLogger::LEVEL_ERROR, 'application');
            return null;
        }
    }

    /**
     * @param string
     * @param string
     * @return array 
     * @soap
     */
    public function getLogin($cedula = null, $password = null) {

        try {
            $usuario = Usuario::model()->find(
                    array(
                        'condition' => 'username =:cedula',
                        'params' => array(
                            'cedula' => $cedula
            )));

            if (empty($usuario)) {
                return array("result" => 0);
            } else if ($usuario->Estado != "A") {
                return array("result" => 1);
            } else if ($password != $usuario->Password) {
                return array("result" => 2);
            } else {
                $persona = Persona::model()->find('numeroDocumento =:documento', array("documento" => $cedula));
                return array("result" => 3,
                    "response" => array
                        (
                        "Username" => $cedula,
                        "Email" => $usuario->Email,
                        "NombreCompleto" => $persona->Nombres . " " . $persona->PrimerApellido . " " . $persona->SegundoApellido));
            }
        } catch (Exception $exc) {
            Yii::log($exc->getMessage() . "\n" . $exc->getTraceAsString(), CLogger::LEVEL_ERROR, 'application');
            return null;
        }
    }

    /**
     * @param string
     * @return array 
     * @soap
     */
    public function getLoginHash($hash = null) {

        try {
            $usuario = Usuario::model()->find(
                    array(
                        'condition' => 'md5(username) =:cedula',
                        'params' => array(
                            'cedula' => $hash
            )));

            if (empty($usuario)) {
                return array("result" => 0);
            } else if ($usuario->Estado != "A") {
                return array("result" => 1);
            } else {
                $persona = Persona::model()->find('numeroDocumento =:documento', array("documento" => $usuario->Username));
                return array("result" => 3,
                    "response" => array
                        (
                        "Username" => $usuario->Username,
                        "Email" => $usuario->Email,
                        "NombreCompleto" => $persona->Nombres . " " . $persona->PrimerApellido . " " . $persona->SegundoApellido));
            }
        } catch (Exception $exc) {
            Yii::log($exc->getMessage() . "\n" . $exc->getTraceAsString(), CLogger::LEVEL_ERROR, 'application');
            return null;
        }
    }

    /**
     * @param string
     * @param int
     * @return array
     * @soap
     */
    public function getCiudad($nombreCiudad = null, $idCiudad = null) {

        try {

            if (is_null($nombreCiudad)) {
                $nombreCiudad = "''";
            }

            $sql = "SELECT c.IdCiudad,c.NombreCiudad,c.IdDepartamento,d.NombreDepartamento
                FROM m_Ciudad c
                LEFT OUTER JOIN m_Departamento d ON c.IdDepartamento = d.IdDepartamento
                WHERE c.NombreCiudad LIKE '%" . $nombreCiudad . "%' OR c.IdCiudad = '" . $idCiudad . "';";

            $data = Yii::app()->getDb()->createCommand($sql)->queryAll();

            if (!empty($data)) {
                return $data;
            } else {
                return array();
            }
        } catch (Exception $exc) {
            Yii::log($exc->getMessage() . "\n" . $exc->getTraceAsString(), CLogger::LEVEL_ERROR, 'application');
            return null;
        }
    }

    /**
     * @param int cedula
     * @param boolean opcion
     * @param string idComercial
     * @return array 
     * @soap
     */
    public function getPersonaWithModel($cedula = null, $opcion = true, $idComercial = null) {
        try {

            $parametro = "";
            $telefonos = array();

            if (isset($cedula)) {
                $parametro .= " AND e.NumeroDocumento = " . $cedula;

                $sql2 = "SELECT NumeroTelefono FROM m_Telefono WHERE NumeroDocumento = " . $cedula;
                $telefonos = Yii::app()->getDb()->createCommand($sql2)->queryAll();
            }

            if (isset($idComercial)) {
                $parametro .= " AND e.IdCentroCostos = " . $idComercial;
            }

            $sql = "SELECT p.NumeroDocumento,p.PrimerApellido,p.SegundoApellido, p.EmailPersonal as 'CorreoPersonal',
               p.Nombres,p.Direccion,b.NombreBarrio as 'Barrio',ci.IdCiudad as 'Codigo',c.NombreCiudad as 'ExpedidaEn',
               p.FechaNacimiento,td.TipoDocumento,p.Email,d.NombreDepartamento as 'Departamento',
               ci.NombreCiudad as 'Ciudad',car.NombreCargo as 'Cargo', car.idCargo as 'CodigoCargo',
               e.IdCentroCostos, e.FechaIngreso as 'FechaVinculacion', cent.NombreCentroCostos as 'CentroCosto' 
               FROM m_Empleado e
               LEFT JOIN m_Persona p ON p.NumeroDocumento = e.NumeroDocumento
               LEFT OUTER JOIN m_Barrio b ON b.IdBarrio = p.IdBarrio
               LEFT JOIN m_Ciudad c ON c.IdCiudad = p.ExpedidaEn
               LEFT JOIN m_TipoDocumento td ON td.IdTipoDocumento = p.IdTipoDocumento
               RIGHT JOIN m_Departamento d ON d.IdDepartamento = p.IdDepartamento
               RIGHT JOIN m_Ciudad ci ON ci.IdCiudad = p.IdCiudad
               RIGHT JOIN m_Cargo car ON car.IdCargo = e.IdCargo
               RIGHT JOIN m_CentroCostos cent ON cent.IdCentroCostos = e.IdCentroCostos
               WHERE e.IdEstado = 1 " . $parametro;

            $data = Yii::app()->getDb()->createCommand($sql)->queryAll();


            if ($opcion) {
                if (!empty($data)) {
                    $data = $data[0];
                    $data['NumeroTelefono'] = [];

                    foreach ($telefonos as $key => $value) {
                        array_push($data['NumeroTelefono'], $value['NumeroTelefono']);
                    }

                    return $data;
                } else {
                    return array();
                }
            } else {
                if (!empty($data) || empty($data)) {
                    return $data;
                }
            }
        } catch (Exception $exc) {
            Yii::log($exc->getMessage() . "\n" . $exc->getTraceAsString(), CLogger::LEVEL_ERROR, 'application');
            return null;
        }
    }

    /**
     * @param array data
     * @return boolean 
     * @soap
     */
    public function actualizarPersona($data = array()) {

        try {

            if (!empty($data)) {

                $model = Persona::model()->findByAttributes(['NumeroDocumento' => $data['NumeroDocumento']]);

                //$model->Nombres = $data['Nombres'];
                //$model->PrimerApellido = $data['PrimerApellido'];
                //$model->SegundoApellido = $data['SegundoApellido'];
                //$model->ApellidosNombres = $data['PrimerApellido'] . ' ' . $data['SegundoApellido'] . ' ' . $data['Nombres'];
                //$model->FechaNacimiento = $data['FechaNacimiento'];
                $model->IdCiudad = $data['IdCiudad'];
                $model->Direccion = $data['Direccion'];
                //$model->Email = $data['Email'];
                $model->EmailPersonal = $data['EmailPersonal'];

                if ($model->save()) {
                    return true;
                } else {
                    Yii::log('actualizarPersona: Error al actualizar la informacion de la persona' . json_decode($model->getErrors()), CLogger::LEVEL_ERROR, 'application');
                    return false;
                }
            }
        } catch (Exception $e) {
            Yii::log('actualizarPersona: Error al actualizar la informacion de la persona: ' . $e->getMessage(), CLogger::LEVEL_ERROR, 'application');
            return false;
        }
    }

    /**
     * @param string username
     * @param string password
     * @return boolean 
     * @soap
     */
    public function cambiarClave($username = null, $password = null) {
        try {
            if (isset($password) && isset($username)) {
                $model = Usuario::model()->findByAttributes(['Username' => $username]);

                $model->Password = $password;

                if ($model->save()) {
                    return true;
                } else {
                    Yii::log('Cambiar Clave: Error al cambiar la contraseña del usuario' . json_decode($model->getErrors()), CLogger::LEVEL_ERROR, 'application');
                    return false;
                }
            }
        } catch (Exception $e) {
            Yii::log('Cambiar Clave: Error al cambiar la contraseña del usuario: ' . $e->getMessage(), CLogger::LEVEL_ERROR, 'application');
            return false;
        }
    }

    /**
     * @param string mes
     * @param string cedulas
     * @return array 
     * @soap
     */
    public function getCumpleanos($mes = null, $cedulas = '') {
        $parametro = '';

        try {
            if (isset($mes)) {
                $parametro .= ' AND month(p.FechaNacimiento) = ' . $mes;  //.' and day(p.FechaNacimiento) = '.$dia; //MONTH (NOW()) DAY(NOW()
            }

            if (!empty($cedulas)) {
                $parametro .= ' AND p.NumeroDocumento NOT IN (' . $cedulas . ')';
            }

            $sql = "SELECT p.NumeroDocumento,p.PrimerApellido,p.SegundoApellido, p.Nombres, 
                       month(p.FechaNacimiento) as Mes, day(p.FechaNacimiento) as Dia,
                          c.IdCiudad as 'CodigoCiudad',
                          car.IdCargo as 'CodigoCargo' 
                          FROM m_Empleado e
                          LEFT JOIN m_Persona p ON p.NumeroDocumento = e.NumeroDocumento
                          RIGHT JOIN m_Ciudad c ON c.IdCiudad = p.IdCiudad
                          RIGHT JOIN m_Cargo car ON car.IdCargo = e.IdCargo
                          WHERE e.IdEstado = 1" . $parametro;

            $data = Yii::app()->getDb()->createCommand($sql)->queryAll();
            return $data;
        } catch (Exception $e) {
            Yii::log('Error al sincronizar los cumpleanos: ' . $e->getMessage(), CLogger::LEVEL_ERROR, 'application');
            return array();
        }
    }

    /**
     * @param string mes
     * @param string cedulas
     * @return array 
     * @soap
     */
    public function getAniversarios($mes = null, $cedulas = '') {
        $parametro = '';

        try {
            if (isset($mes)) {
                $parametro .= ' and month(e.FechaIngreso) = ' . $mes;
            }

            if (!empty($cedulas)) {
                $parametro .= ' AND p.NumeroDocumento NOT IN (' . $cedulas . ')';
            }

            $sql = "SELECT p.NumeroDocumento,p.PrimerApellido,p.SegundoApellido, p.Nombres,
                          month(e.FechaIngreso) as Mes, day(e.FechaIngreso) as Dia,
                          c.IdCiudad as 'CodigoCiudad',
                          car.IdCargo as 'CodigoCargo' 
                          FROM m_Empleado e
                          LEFT JOIN m_Persona p ON p.NumeroDocumento = e.NumeroDocumento
                          RIGHT JOIN m_Ciudad c ON c.IdCiudad = p.IdCiudad
                          RIGHT JOIN m_Cargo car ON car.IdCargo = e.IdCargo
                          WHERE e.IdEstado = 1" . $parametro;

            $data = Yii::app()->getDb()->createCommand($sql)->queryAll();
            return $data;
        } catch (Exception $e) {
            Yii::log('Error al sincronizar los aniversarios: ' . $e->getMessage(), CLogger::LEVEL_ERROR, 'application');
            return array();
        }
    }

    /**
     * @param string idCargo
     * @return array 
     * @soap
     */
    public function getCargos($idCargo = null) {
        $parametro = '';

        try {

            if (isset($idCargo)) {
                if (is_numeric($idCargo)) {
                    $parametro = ' WHERE IdCargo = ' . $idCargo;
                } else {
                    $parametro = " WHERE IdCargo  IN (" . $idCargo . ")";
                }
            }

            $sql = "SELECT 
                      c.IdCargo as 'CodigoCargo', c.NombreCargo, c.TipoCargo
                          FROM m_Cargo c" . $parametro;

            $data = Yii::app()->getDb()->createCommand($sql)->queryAll();

            return $data;
        } catch (Exception $e) {
            
        }
    }

}

?>
