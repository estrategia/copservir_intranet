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

    public function getRegistrosAcceso($tiempo)
    {
      $sql = 'SELECT * FROM t_ConexionesUsuarios 
              WHERE 
                DAY(fechaConexion) = DAY(CURDATE()) AND 
                MONTH(fechaConexion) = MONTH(CURDATE()) AND 
                YEAR(fechaConexion) = YEAR(CURDATE())';

      switch ($tiempo) {
        case 'ayer':
          $sql = 'SELECT * FROM t_ConexionesUsuarios WHERE DAY(fechaConexion) = DAY(CURDATE()) -1 AND MONTH(fechaConexion) = MONTH(CURDATE())';
          break;

        case 'semana':
          $sql = 'SELECT * FROM t_ConexionesUsuarios WHERE  YEARWEEK(fechaConexion, 1) = YEARWEEK(CURDATE(), 1) AND YEAR(fechaConexion) = YEAR(CURDATE())';
          break;

        case 'semana-anterior':
          $sql = 'SELECT * FROM t_ConexionesUsuarios WHERE fechaConexion >= curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY AND fechaConexion < curdate() - INTERVAL DAYOFWEEK(curdate())-1 DAY AND YEAR(fechaConexion) = YEAR(CURDATE())';
          break;

        case 'mes':
          $sql = 'SELECT * FROM t_ConexionesUsuarios WHERE MONTH(fechaConexion) = MONTH(CURDATE()) AND YEAR(fechaConexion) = YEAR(CURDATE())';
          break;

        case 'mes-anterior':
          $sql = 'SELECT * FROM t_ConexionesUsuarios WHERE YEAR(fechaConexion) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) AND MONTH(fechaConexion) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)';
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
        $datosGrafica[$registro['numeroDocumento']] = 0;
      }

      foreach ($registros as $registro) {
        $datosGrafica[$registro['numeroDocumento']] ++;
      }
      
      foreach ($datosGrafica as $key => $dato) {
        $data['label'] = $key;
        $data['value'] = $dato;
        $dataset[] = $data;
      }
      return $dataset;
    }

    public function accesosSemana($registros)
    {
      if (empty($registros)) {
        $fecha = date('Y-m-d');
      } else {
        $fecha = $registros[0]['fechaConexion'];
      }
      // VarDumper::dump($registros, 10, true);
      $inicioSemana = date( 'Y-m-d', strtotime( 'monday this week', strtotime($fecha)));
      $finSemana = date( 'Y-m-d', strtotime( 'sunday this week', strtotime($fecha)));

      $registroAcceso = [];
      $datosGrafica = [];

      for ($j=0; $j < sizeof($registros) ; $j++) { 
          $registroAcceso[$registros[$j]['numeroDocumento']] = 0;
      }

      $r = $registroAcceso;

      for ($i= $inicioSemana; $i <= $finSemana ; $i++) { 
        $registroAcceso = $r;
        $registroAcceso['fechaConexion'] = $i;
        
        for ($j=0; $j < sizeof($registros) ; $j++) {
          if (date('Y-m-d', strtotime($registros[$j]['fechaConexion'])) == $i ) {
            $registroAcceso[$registros[$j]['numeroDocumento']] += 1;
          }
        }
        $datosGrafica[] = $registroAcceso;
      }
      return $datosGrafica;
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

      for ($j=0; $j < sizeof($registros) ; $j++) { 
          $registroAcceso[$registros[$j]['numeroDocumento']] = 0;
      }

      $r = $registroAcceso;

      for ($i= $inicioMes; $i <= $finMes ; $i++) { 
        $registroAcceso = $r;
        $registroAcceso['fechaConexion'] = $i;
        
        for ($j=0; $j < sizeof($registros) ; $j++) {
          if (date('Y-m-d', strtotime($registros[$j]['fechaConexion'])) == $i ) {
            $registroAcceso[$registros[$j]['numeroDocumento']] += 1;
          }
        }
        $datosGrafica[] = $registroAcceso;
      }
      return $datosGrafica;
    }

    public function getRegistrosConsultaProductos($tiempo)
    {
      $sql = 'SELECT * FROM t_VIMED_RegistroAccesoDetalleProducto 
              WHERE 
                DAY(fechaConsulta) = DAY(CURDATE()) AND 
                MONTH(fechaConsulta) = MONTH(CURDATE()) AND 
                YEAR(fechaConsulta) = YEAR(CURDATE())';

      switch ($tiempo) {
        case 'ayer':
          $sql = 'SELECT * FROM t_VIMED_RegistroAccesoDetalleProducto WHERE DAY(fechaConsulta) = DAY(CURDATE()) -1 AND MONTH(fechaConsulta) = MONTH(CURDATE())';
          break;

        case 'semana':
          $sql = 'SELECT * FROM t_VIMED_RegistroAccesoDetalleProducto WHERE  YEARWEEK(fechaConsulta, 1) = YEARWEEK(CURDATE(), 1) AND YEAR(fechaConsulta) = YEAR(CURDATE())';
          break;

        case 'semana-anterior':
          $sql = 'SELECT * FROM t_VIMED_RegistroAccesoDetalleProducto WHERE fechaConsulta >= curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY AND fechaConsulta < curdate() - INTERVAL DAYOFWEEK(curdate())-1 DAY AND YEAR(fechaConsulta) = YEAR(CURDATE())';
          break;

        case 'mes':
          $sql = 'SELECT * FROM t_VIMED_RegistroAccesoDetalleProducto WHERE MONTH(fechaConsulta) = MONTH(CURDATE()) AND YEAR(fechaConsulta) = YEAR(CURDATE())';
          break;

        case 'mes-anterior':
          $sql = 'SELECT * FROM t_VIMED_RegistroAccesoDetalleProducto WHERE YEAR(fechaConsulta) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) AND MONTH(fechaConsulta) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)';
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
        $datosGrafica[$registro['codigoProducto']] = 0;
      }

      foreach ($registros as $registro) {
        $datosGrafica[$registro['codigoProducto']] ++;
      }
      
      foreach ($datosGrafica as $key => $dato) {
        $data['label'] = $key;
        $data['value'] = $dato;
        $dataset[] = $data;
      }
      return $dataset;
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

      for ($j=0; $j < sizeof($registros) ; $j++) { 
          $registroAcceso[$registros[$j]['codigoProducto']] = 0;
      }

      $r = $registroAcceso;

      for ($i= $inicioSemana; $i <= $finSemana ; $i++) { 
        $registroAcceso = $r;
        $registroAcceso['fechaConsulta'] = $i;
        
        for ($j=0; $j < sizeof($registros) ; $j++) {
          if (date('Y-m-d', strtotime($registros[$j]['fechaConsulta'])) == $i ) {
            $registroAcceso[$registros[$j]['codigoProducto']] += 1;
          }
        }
        $datosGrafica[] = $registroAcceso;
      }
      return $datosGrafica;
    }

    public function productosMes($registros)
    {
      if (empty($registros)) {
        $fecha = date('Y-m-d');
      } else {
        $fecha = $registros[0]['fechaConsulta'];
      }
      // VarDumper::dump($registros, 10, true);
      $inicioMes = date( 'Y-m-01', strtotime( $fecha ));
      $finMes = date( 'Y-m-t', strtotime( $fecha ));

      $registroAcceso = [];
      $datosGrafica = [];

      for ($j=0; $j < sizeof($registros) ; $j++) { 
          $registroAcceso[$registros[$j]['codigoProducto']] = 0;
      }

      $r = $registroAcceso;

      for ($i= $inicioMes; $i <= $finMes ; $i++) { 
        $registroAcceso = $r;
        $registroAcceso['fechaConsulta'] = $i;
        
        for ($j=0; $j < sizeof($registros) ; $j++) {
          if (date('Y-m-d', strtotime($registros[$j]['fechaConsulta'])) == $i ) {
            $registroAcceso[$registros[$j]['codigoProducto']] += 1;
          }
        }
        $datosGrafica[] = $registroAcceso;
      }
      return $datosGrafica;
    }
}