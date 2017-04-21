<?php 
namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\httpclient\Client;


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
    $columnas = ['numeroDocumento', 'valorPuntos', 'descripcionPunto', 'idPuntoSincronizado', 'fechaCreacion'];
    $filas = [];
    $fechaCreacion = date('Y-m-d H:i:s');
    foreach ($puntos as $key => $punto) {
      $filas[] = [
        $punto['numeroDocumento'],
        $punto['valorPuntos'],
        $punto['descripcionPunto'],
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
}
?>