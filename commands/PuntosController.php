<?php 
namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\httpclient\Client;

use app\modules\intranet\modules\formacioncomunicaciones\models\ParametrosPuntos;


  /**
   * Este comando solicita los puntos de los usuarios por web service y los guarda
   * en la BD de la intranet en la tabla t_FORCO_Puntos
   */
class PuntosController extends Controller
{
  public function actionSincronizar()
  {
    \Yii::info('sincronizar puntos -- inicio');
    $connection = Yii::$app->getDb();
    $idSincronizado = $connection->createCommand("SELECT MAX([[idPuntoSincronizado]]) FROM {{t_FORCO_Puntos}}")->queryScalar();
    if (is_null($idSincronizado)) {
      $idSincronizado = 0;
    }
    $client = new Client();
    $urlPuntosSiicop = \Yii::$app->params['formacioncomunicaciones']['wsSincronizarPuntos'] . "?idSincronizado={$idSincronizado}";
    $puntosRequest = $client->createRequest()
      ->setMethod('get')
      ->setUrl($urlPuntosSiicop)
      ->setData([''])
      ->setOptions([
        'timeout' => 5,
      ])
      ->send();
    $puntos = JSON::decode($puntosRequest->content);
    $columnas = ['numeroDocumento', 'valorPuntos', 'descripcionPunto', 'tipoParametro', 'idPuntoSincronizado', 'fechaCreacion'];
    $filas = [];
    $fechaCreacion = date('Y-m-d H:i:s');
    foreach ($puntos as $key => $punto) {
      $filas[] = [
        $punto['numeroDocumento'],
        $punto['valorPuntos'],
        $punto['descripcionPunto'],
        999,
        $punto['idPunto'],
        $fechaCreacion
      ];
    }

    $transaction = $connection->beginTransaction();
    try {
      $connection->createCommand()->batchInsert('t_FORCO_Puntos', $columnas, $filas)->execute();
      $transaction->commit();
    } catch (\Exception $e) {
      $transaction->rollBack();
      throw $e;
    } catch (\Throwable $e) {
      $transaction->rollBack();
      throw $e;
    }
    \Yii::info('sincronizar puntos -- fin');
  }

  public function actionAsignarPuntosCumpleanios()
  {
    echo "PuntosController::actionAsignarPuntosCumpleanios -- INICIO\n";
    \Yii::info("PuntosController::actionAsignarPuntosCumpleanios -- INICIO");
    $connection = Yii::$app->getDb();
    $fechaHoy = date('Y-m-d H:i:s');
    $parametrosCumpleanios = ParametrosPuntos::PARAMETRO_CUMPLEANIOS;
    $parametrosEstado = ParametrosPuntos::ESTADO_ACTIVO;
    $cumpleaniosQuery = "
      SELECT cumpleanios.numeroDocumento, parametro.valorPuntos 
      FROM t_CumpleanosPersona as cumpleanios
      JOIN m_FORCO_ParametrosPuntos as parametro
      WHERE parametro.estado = {$parametrosEstado}
        AND parametro.tipoParametro = {$parametrosCumpleanios}
        AND DATE_FORMAT(cumpleanios.fecha, '%m-%d') = DATE_FORMAT('{$fechaHoy}', '%m-%d')
    ";
    $cumpleanios = $connection->createCommand($cumpleaniosQuery)->queryAll();
    $columnas = ['numeroDocumento', 'valorPuntos', 'descripcionPunto', 'tipoParametro', 'fechaCreacion'];
    $filas = [];
    foreach ($cumpleanios as $dato) {
      $filas[] = [
        'numeroDocumento' => $dato['numeroDocumento'],
        'valorPuntos' => $dato['valorPuntos'],
        'descripcionPunto' => 'Puntos por cumpleaños',
        'tipoParametro' => ParametrosPuntos::PARAMETRO_CUMPLEANIOS,
        'fechaCreacion' => $fechaHoy
      ];
    }
    \Yii::info("Cantidad de cumpleanios: " . count($filas));
    echo "Cantidad de cumpleanios: " . count($filas) . "\n";
    $transaction = $connection->beginTransaction();
    try {
        $connection->createCommand("set foreign_key_checks = 0")->execute();
        $result = $connection->createCommand()->batchInsert('t_FORCO_Puntos', $columnas, $filas);
        \Yii::info("batchInsert: " . $result->rawSql);
        $result = $result->execute();
        \Yii::info("Cantidad de puntos insertados: $result");
        echo "Cantidad de puntos insertados: $result \n";
        $transaction->commit();
        $connection->createCommand("set foreign_key_checks = 1")->execute();
    } catch (\Exception $e) {
      $transaction->rollBack();
      \Yii::error("Exception :: " . $e->getTraceAsString());
      echo "Exception :: " . $e->getTraceAsString() . "\n";
    } catch (\Throwable $e) {
      $transaction->rollBack();
      \Yii::error("Throwable :: " . $e->getTraceAsString());
      echo "Throwable :: " . $e->getTraceAsString() . "\n";
    }
    
    \Yii::info("PuntosController::actionAsignarPuntosCumpleanios -- FIN");
    echo "PuntosController::actionAsignarPuntosCumpleanios -- FIN \n";
  }

  public function actionAsignarPuntosAniversarios()
  {
    echo "PuntosController::actionAsignarPuntosAniversarios -- INICIO\n";
    \Yii::info("PuntosController::actionAsignarPuntosAniversarios -- INICIO");
    $connection = Yii::$app->getDb();
    $fechaHoy = date('Y-m-d H:i:s');
    $parametrosAniversario = ParametrosPuntos::PARAMETRO_ANIVERSARIO;
    $parametrosEstado = ParametrosPuntos::ESTADO_ACTIVO;
    $aniversariosQuery = "
      SELECT aniversario.numeroDocumento, parametro.valorPuntos 
      FROM t_CumpleanosLaboral as aniversario
      JOIN m_FORCO_ParametrosPuntos as parametro
      WHERE parametro.estado = {$parametrosEstado}
        AND parametro.tipoParametro = {$parametrosAniversario}
        AND DATE_FORMAT('{$fechaHoy}', '%Y') - DATE_FORMAT(aniversario.fechaIngreso , '%Y') = parametro.condicion
        AND DATE_FORMAT(aniversario.fecha, '%m-%d') = DATE_FORMAT('{$fechaHoy}', '%m-%d')
    ";
    $aniversarios = $connection->createCommand($aniversariosQuery)->queryAll();
    $columnas = ['numeroDocumento', 'valorPuntos', 'descripcionPunto', 'tipoParametro', 'fechaCreacion'];
    $filas = [];
    foreach ($aniversarios as $aniversario) {
      $filas[] = [
        'numeroDocumento' => $aniversario['numeroDocumento'],
        'valorPuntos' => $aniversario['valorPuntos'],
        'descripcionPunto' => 'Puntos por aniversario laboral',
        'tipoParametro' => ParametrosPuntos::PARAMETRO_ANIVERSARIO,
        'fechaCreacion' => $fechaHoy
      ];
    }
    \Yii::info("Cantidad de aniversarios: " . count($filas));
    echo "Cantidad de aniversarios: " . count($filas) . "\n";
    $transaction = $connection->beginTransaction();
    try {
        $connection->createCommand("set foreign_key_checks = 0")->execute();
        $result = $connection->createCommand()->batchInsert('t_FORCO_Puntos', $columnas, $filas)->execute();
        \Yii::info("Cantidad de puntos insertados: $result");
        echo "Cantidad de puntos insertados: $result \n";
        $transaction->commit();
        $connection->createCommand("set foreign_key_checks = 1")->execute();
    } catch (\Exception $e) {
        $transaction->rollBack();
        \Yii::error("Exception :: " . $e->getTraceAsString());
        echo "Exception :: " . $e->getTraceAsString() . "\n";
    } catch (\Throwable $e) {
        $transaction->rollBack();
        \Yii::error("Throwable :: " . $e->getTraceAsString());
        echo "Throwable :: " . $e->getTraceAsString() . "\n";
    }
    \Yii::info("PuntosController::actionAsignarPuntosAniversarios -- FIN");
    echo "PuntosController::actionAsignarPuntosAniversarios -- FIN \n";
  }
}
?>