<?php
namespace app\modules\proveedores\modules\visitamedica\models;

class Reportes extends \yii\base\Model
{

    public function rules()
    {
        return [
            // define validation rules here
        ];
    }

    public function getRegistrosAcceso($tiempo, $nitLaboratorio)
    {
      // $sql = 'SELECT * FROM t_ConexionesUsuarios 
      //         WHERE 
      //           DAY(fechaConexion) = DAY(CURDATE()) AND 
      //           MONTH(fechaConexion) = MONTH(CURDATE()) AND 
      //           YEAR(fechaConexion) = YEAR(CURDATE())';
      $sql = "SELECT idConexion, t_ConexionesUsuarios.numeroDocumento, fechaConexion, ip, nombre, primerApellido, segundoApellido 
              FROM t_ConexionesUsuarios 
              JOIN m_PROV_Usuario 
              ON t_ConexionesUsuarios.numeroDocumento = m_PROV_Usuario.numeroDocumento 
              WHERE DAY(fechaConexion) = DAY(CURDATE()) 
                AND MONTH(fechaConexion) = MONTH(CURDATE()) 
                AND YEAR(fechaConexion) = YEAR(CURDATE()) 
                AND nitLaboratorio = {$nitLaboratorio}";

      switch ($tiempo) {
        case 'ayer':
          // $sql = 'SELECT * FROM t_ConexionesUsuarios WHERE DAY(fechaConexion) = DAY(CURDATE()) -1 AND MONTH(fechaConexion) = MONTH(CURDATE())';
          $sql = "SELECT idConexion, t_ConexionesUsuarios.numeroDocumento, fechaConexion, ip, nombre, primerApellido, segundoApellido 
                  FROM t_ConexionesUsuarios 
                  JOIN m_PROV_Usuario 
                  ON t_ConexionesUsuarios.numeroDocumento = m_PROV_Usuario.numeroDocumento 
                  WHERE DAY(fechaConexion) = DAY(CURDATE()) -1 
                  AND MONTH(fechaConexion) = MONTH(CURDATE()) 
                  AND nitLaboratorio = {$nitLaboratorio}";
          break;

        case 'semana':
          // $sql = 'SELECT * FROM t_ConexionesUsuarios WHERE  YEARWEEK(fechaConexion, 1) = YEARWEEK(CURDATE(), 1) AND YEAR(fechaConexion) = YEAR(CURDATE())';
          $sql = "SELECT idConexion, t_ConexionesUsuarios.numeroDocumento, fechaConexion, ip, nombre, primerApellido, segundoApellido 
                  FROM t_ConexionesUsuarios 
                  JOIN m_PROV_Usuario 
                  ON t_ConexionesUsuarios.numeroDocumento = m_PROV_Usuario.numeroDocumento 
                  WHERE  YEARWEEK(fechaConexion, 1) = YEARWEEK(CURDATE(), 1) 
                    AND YEAR(fechaConexion) = YEAR(CURDATE())
                    AND nitLaboratorio = {$nitLaboratorio}";
          break;

        case 'semana-anterior':
          // $sql = 'SELECT * FROM t_ConexionesUsuarios WHERE fechaConexion >= curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY AND fechaConexion < curdate() - INTERVAL DAYOFWEEK(curdate())-1 DAY AND YEAR(fechaConexion) = YEAR(CURDATE())';
          $sql = "SELECT idConexion, t_ConexionesUsuarios.numeroDocumento, fechaConexion, ip, nombre, primerApellido, segundoApellido 
                FROM t_ConexionesUsuarios 
                JOIN m_PROV_Usuario 
                ON t_ConexionesUsuarios.numeroDocumento = m_PROV_Usuario.numeroDocumento 
                WHERE fechaConexion >= curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY 
                  AND fechaConexion < curdate() - INTERVAL DAYOFWEEK(curdate())-1 DAY 
                  AND YEAR(fechaConexion) = YEAR(CURDATE()) 
                  AND nitLaboratorio = {$nitLaboratorio}";
          break;

        case 'mes':
          // $sql = 'SELECT * FROM t_ConexionesUsuarios WHERE MONTH(fechaConexion) = MONTH(CURDATE()) AND YEAR(fechaConexion) = YEAR(CURDATE())';
          $sql = "SELECT idConexion, t_ConexionesUsuarios.numeroDocumento, fechaConexion, ip, nombre, primerApellido, segundoApellido 
                  FROM t_ConexionesUsuarios 
                  JOIN m_PROV_Usuario 
                  ON t_ConexionesUsuarios.numeroDocumento = m_PROV_Usuario.numeroDocumento 
                  WHERE MONTH(fechaConexion) = MONTH(CURDATE()) 
                    AND YEAR(fechaConexion) = YEAR(CURDATE()) 
                    AND nitLaboratorio = {$nitLaboratorio}";
          break;

        case 'mes-anterior':
          // $sql = 'SELECT * FROM t_ConexionesUsuarios WHERE YEAR(fechaConexion) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) AND MONTH(fechaConexion) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)';
          $sql = "SELECT idConexion, t_ConexionesUsuarios.numeroDocumento, fechaConexion, ip, nombre, primerApellido, segundoApellido 
                  FROM t_ConexionesUsuarios 
                  JOIN m_PROV_Usuario 
                  ON t_ConexionesUsuarios.numeroDocumento = m_PROV_Usuario.numeroDocumento 
                  WHERE YEAR(fechaConexion) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) 
                    AND MONTH(fechaConexion) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH) 
                    AND nitLaboratorio = {$nitLaboratorio}";
          break;
      }
      $connection = \Yii::$app->db;
      $model = $connection->createCommand($sql);
      $registros = $model->queryAll();
      return $registros;
    }

    public function accesosDia($registros)
    {
      $datosGrafica = [];
      $dataset = [];
      $data = ['label' => '', 'value' => ''];
      foreach ($registros as $registro) {
        $datosGrafica[$registro['numeroDocumento']][0] = 0;
        $datosGrafica[$registro['numeroDocumento']][1] = $registro['nombre'] . " " . $registro['primerApellido'] . " " . $registro['segundoApellido'];
      }

      foreach ($registros as $registro) {
        $datosGrafica[$registro['numeroDocumento']][0] ++;
      }
      
      foreach ($datosGrafica as $key => $dato) {
        $data['label'] = $dato[1];
        $data['value'] = $dato[0];
        $dataset[] = $data;
      }
      return [$dataset];
    }

    public function accesosSemana($registros)
    {
      if (empty($registros)) {
        $fecha = date('Y-m-d');
      } else {
        $fecha = $registros[0]['fechaConexion'];
      }
      // \yii\helpers\VarDumper::dump($registros, 10, true);exit();
      $inicioSemana = date( 'Y-m-d', strtotime( 'monday this week', strtotime($fecha)));
      $finSemana = date( 'Y-m-d', strtotime( 'sunday this week', strtotime($fecha)));

      $registroAcceso = [];
      $datosGrafica = [];
      $nombres = [];

      for ($j=0; $j < sizeof($registros) ; $j++) { 
          $registroAcceso[$registros[$j]['numeroDocumento']] = 0;
          // $registroAcceso[$registros[$j]['numeroDocumento']][1] = $registros[$j]['nombre'] ." ". $registros[$j]['nombre'] ." ". $registros[$j]['nombre'];
      }

      $r = $registroAcceso;

      for ($i= $inicioSemana; $i <= $finSemana ; $i = date('Y-m-d', strtotime($i . ' +1 day'))) { 
        $registroAcceso = $r;
        $registroAcceso['fechaConexion'] = $i;
        
        for ($j=0; $j < sizeof($registros) ; $j++) {
          if (date('Y-m-d', strtotime($registros[$j]['fechaConexion'])) == $i ) {
            $registroAcceso[$registros[$j]['numeroDocumento']] += 1;
            $nombres[$registros[$j]['numeroDocumento']] = $registros[$j]['nombre'] ." ". $registros[$j]['segundoApellido'] ." ". $registros[$j]['primerApellido'];
          }
        }
        $datosGrafica[] = $registroAcceso;
      }
      // var_dump($nombres);
      $puntos = [];
      $punto = [];
      foreach ($datosGrafica as $dato) {
        foreach ($dato as $key => $value) {
          if (isset($nombres[$key])) {
            $punto[$nombres[$key]] = $value;
          }
        }
        foreach ($dato as $key => $value) {
           $punto['fechaConexion'] = $value;
        }
        $puntos[] = $punto;
      }
        // \yii\helpers\VarDumper::dump($puntos,10,true);
        // exit();
      return [$datosGrafica, $puntos];
    }

    public function accesosMes($registros)
    {
      if (empty($registros)) {
        $fecha = date('Y-m-d');
      } else {
        $fecha = $registros[0]['fechaConexion'];
      }
      // VarDumper::dump($registros, 10, true);
      $inicioMes = date( 'Y-m-01', strtotime( $fecha ));
      $finMes = date( 'Y-m-t', strtotime( $fecha ));

      $registroAcceso = [];
      $datosGrafica = [];
      $nombres = [];

      for ($j=0; $j < sizeof($registros) ; $j++) { 
          $registroAcceso[$registros[$j]['numeroDocumento']] = 0;
      }

      $r = $registroAcceso;

      for ($i= $inicioMes; $i <= $finMes ; $i = date('Y-m-d', strtotime($i . ' +1 day'))) { 
        $registroAcceso = $r;
        $registroAcceso['fechaConexion'] = $i;
        
        for ($j=0; $j < sizeof($registros) ; $j++) {
          if (date('Y-m-d', strtotime($registros[$j]['fechaConexion'])) == $i ) {
            $registroAcceso[$registros[$j]['numeroDocumento']] += 1;
            $nombres[$registros[$j]['numeroDocumento']] = $registros[$j]['nombre'] ." ". $registros[$j]['segundoApellido'] ." ". $registros[$j]['primerApellido'];
          }
        }
        $datosGrafica[] = $registroAcceso;
      }
      $puntos = [];
      $punto = [];
      foreach ($datosGrafica as $dato) {
        foreach ($dato as $key => $value) {
          if (isset($nombres[$key])) {
            $punto[$nombres[$key]] = $value;
          }
        }
        foreach ($dato as $key => $value) {
           $punto['fechaConexion'] = $value;
        }
        $puntos[] = $punto;
      }
      return [$datosGrafica, $puntos];
    }

    public function getRegistrosConsultaProductos($tiempo, $nitLaboratorio)
    {
      $sql = "SELECT * FROM t_VIMED_RegistroAccesoDetalleProducto 
              WHERE DAY(fechaConsulta) = DAY(CURDATE()) 
                AND MONTH(fechaConsulta) = MONTH(CURDATE()) 
                AND YEAR(fechaConsulta) = YEAR(CURDATE())
                AND nitLaboratorio = {$nitLaboratorio}";

      switch ($tiempo) {
        case 'ayer':
          $sql = "SELECT * FROM t_VIMED_RegistroAccesoDetalleProducto 
                  WHERE DAY(fechaConsulta) = DAY(CURDATE()) -1 
                    AND MONTH(fechaConsulta) = MONTH(CURDATE())
                    AND nitLaboratorio = {$nitLaboratorio}";
          break;

        case 'semana':
          $sql = "SELECT * FROM t_VIMED_RegistroAccesoDetalleProducto 
                  WHERE  YEARWEEK(fechaConsulta, 1) = YEARWEEK(CURDATE(), 1) 
                    AND YEAR(fechaConsulta) = YEAR(CURDATE())
                    AND nitLaboratorio = {$nitLaboratorio}";
          break;

        case 'semana-anterior':
          $sql = "SELECT * FROM t_VIMED_RegistroAccesoDetalleProducto 
                  WHERE fechaConsulta >= curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY 
                    AND fechaConsulta < curdate() - INTERVAL DAYOFWEEK(curdate())-1 DAY 
                    AND YEAR(fechaConsulta) = YEAR(CURDATE())
                    AND nitLaboratorio = {$nitLaboratorio}";
          break;

        case 'mes':
          $sql = "SELECT * FROM t_VIMED_RegistroAccesoDetalleProducto 
                  WHERE MONTH(fechaConsulta) = MONTH(CURDATE()) 
                    AND YEAR(fechaConsulta) = YEAR(CURDATE())
                    AND nitLaboratorio = {$nitLaboratorio}";
          break;

        case 'mes-anterior':
          $sql = "SELECT * FROM t_VIMED_RegistroAccesoDetalleProducto 
                  WHERE YEAR(fechaConsulta) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) 
                    AND MONTH(fechaConsulta) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)
                    AND nitLaboratorio = {$nitLaboratorio}";
          break;
      }
      $connection = \Yii::$app->db;
      $model = $connection->createCommand($sql);
      $registros = $model->queryAll();
      return $registros;
    }

    public function productosDia($registros)
    {
      $datosGrafica = [];
      $dataset = [];
      $data = ['label' => '', 'value' => ''];
      foreach ($registros as $registro) {
        $datosGrafica[$registro['codigoProducto']][0] = 0;
      }

      foreach ($registros as $registro) {
        $datosGrafica[$registro['codigoProducto']][0] ++;
        $datosGrafica[$registro['codigoProducto']][1] = $registro['descripcionProducto'] ." ". $registro['presentacionProducto'];
      }
      
      foreach ($datosGrafica as $key => $dato) {
        $data['label'] = $dato[1];
        $data['value'] = $dato[0];
        $dataset[] = $data;
      }
      return [$dataset];
    }

    public function productosSemana($registros)
    {
      if (empty($registros)) {
        $fecha = date('Y-m-d');
      } else {
        $fecha = $registros[0]['fechaConsulta'];
      }
      // VarDumper::dump($registros, 10, true);
      $inicioSemana = date( 'Y-m-d', strtotime( 'monday this week', strtotime($fecha)));
      $finSemana = date( 'Y-m-d', strtotime( 'sunday this week', strtotime($fecha)));

      $registroAcceso = [];
      $datosGrafica = [];
      $nombres = [];
      
      for ($j=0; $j < sizeof($registros) ; $j++) { 
          $registroAcceso[$registros[$j]['codigoProducto']] = 0;
      }

      $r = $registroAcceso;

      for ($i= $inicioSemana; $i <= $finSemana ; $i = date('Y-m-d', strtotime($i . ' +1 day'))) { 
        $registroAcceso = $r;
        $registroAcceso['fechaConsulta'] = $i;
      // \yii\helpers\VarDumper::dump($registroAcceso, 10, true);
        
        for ($j=0; $j < sizeof($registros) ; $j++) {
          if (date('Y-m-d', strtotime($registros[$j]['fechaConsulta'])) == $i ) {
            $registroAcceso[$registros[$j]['codigoProducto']] += 1;
            $nombres[$registros[$j]['codigoProducto']] = $registros[$j]['descripcionProducto'] ." ". $registros[$j]['presentacionProducto'];
          }
        }
        $datosGrafica[] = $registroAcceso;
      }
      $puntos = [];
      $punto = [];
      foreach ($datosGrafica as $dato) {
        foreach ($dato as $key => $value) {
          if (isset($nombres[$key])) {
            $punto[$nombres[$key]] = $value;
          }
        }
        foreach ($dato as $key => $value) {
           $punto['fechaConsulta'] = $value;
        }
        $puntos[] = $punto;
      }
      return [$datosGrafica, $puntos];
    }

    public function productosMes($registros)
    {
      if (empty($registros)) {
        $fecha = date('Y-m-d');
      } else {
        $fecha = $registros[0]['fechaConsulta'];
      }
      $inicioMes = date( 'Y-m-01', strtotime( $fecha ));
      $finMes = date( 'Y-m-t', strtotime( $fecha ));

      $registroAcceso = [];
      $datosGrafica = [];
      $nombres = [];

      for ($j=0; $j < sizeof($registros) ; $j++) { 
          $registroAcceso[$registros[$j]['codigoProducto']] = 0;
      }

      $r = $registroAcceso;

      for ($i= $inicioMes; $i <= $finMes ; $i = date('Y-m-d', strtotime($i . ' +1 day'))) { 
        $registroAcceso = $r;
        $registroAcceso['fechaConsulta'] = $i;
        
        for ($j=0; $j < sizeof($registros) ; $j++) {
          if (date('Y-m-d', strtotime($registros[$j]['fechaConsulta'])) == $i ) {
            $registroAcceso[$registros[$j]['codigoProducto']] += 1;
            $nombres[$registros[$j]['codigoProducto']] = $registros[$j]['descripcionProducto'] ." ". $registros[$j]['presentacionProducto'];
          }
        }
        $datosGrafica[] = $registroAcceso;
      }
      $puntos = [];
      $punto = [];
      foreach ($datosGrafica as $dato) {
        foreach ($dato as $key => $value) {
          if (isset($nombres[$key])) {
            $punto[$nombres[$key]] = $value;
          }
        }
        foreach ($dato as $key => $value) {
           $punto['fechaConsulta'] = $value;
        }
        $puntos[] = $punto;
      }
      return [$datosGrafica, $puntos];
    }

    public function getResumenAcceso($registros)
    {
      $resumen = [];
      $filaResumen = ['nombre' => '', 'conexiones' => ''];
      foreach ($registros as $key => $registro) {
        $numeroDocumento = $registro['numeroDocumento'];
        if (isset($resumen[$numeroDocumento])) {
          $resumen[$numeroDocumento]['conexiones'] ++;
        }
        else {
          $nombre = $registro['nombre'] ." ". $registro['primerApellido'] ." ". $registro['segundoApellido'];
          $filaResumen['nombre'] = $nombre;
          $filaResumen['conexiones'] = 1;
          $resumen[$numeroDocumento] = $filaResumen;
        }
      }
      return $resumen;
    }
}