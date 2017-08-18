<?php 

namespace app\modules\intranet\modules\formacioncomunicaciones\models;

use Yii;

class Indicadores
{
    public static function cursosNuevos()
    {
        $semanaPasada = $next_week = date('Y-m-d', strtotime('-1 week'));
        $cursosNuevos = (new yii\db\Query())
            ->from('m_FORCO_Contenido')
            ->where(['>=', 'fechaCreacion', $semanaPasada])
            ->count();
        return $cursosNuevos;
    }

    public static function cursosHechos()
    {
        $numeroDocumento = Yii::$app->user->identity->numeroDocumento;
        $cursosHechos = (new yii\db\Query())
            ->from('t_FORCO_ContenidoLeidoUsuario')
            ->where("numeroDocumento = {$numeroDocumento}")
            ->count();
        return $cursosHechos;
    }

    public static function cursosPendientes()
    {
        $gruposInteres = (array) Yii::$app->user->identity->getGruposCodigos();
        $numeroDocumento = Yii::$app->user->identity->numeroDocumento;
        $subQueryModulos = Modulo::find()
            ->select('idModulo');
            // ->where(['idCurso' => $this->idCurso]);

        $capitulosObligatorios = Capitulo::find()
            ->select('m_FORCO_Capitulo.idCapitulo')
            ->joinWith('objGruposInteres')
            ->where([
                'estadoCapitulo' => Modulo::ESTADO_ACTIVO,
                'idModulo' => $subQueryModulos,
                'm_GrupoInteres.idGrupoInteres' => $gruposInteres,
            ]);

        $contenidosLeidos = ContenidoLeidoUsuario::find()
            ->where(['numeroDocumento' => $numeroDocumento])
            ->all();
        
        $idsTerminados = \yii\helpers\ArrayHelper::getColumn($contenidosLeidos, 'idContenido');

        $contenidosPendientes = Contenido::find()
            ->select('idContenido')
            ->where(['idCapitulo' => $capitulosObligatorios])
            ->andWhere(['NOT IN', 'idContenido', $idsTerminados])
            ->count();

        return $contenidosPendientes;
    }

    public static function puntosObtenidos()
    {
        $numeroDocumento = Yii::$app->user->identity->numeroDocumento;
        $puntosObtenidos = (new yii\db\Query())
            ->select(['puntos'])
            ->from('t_FORCO_PuntosTotales')
            ->where("numeroDocumento = {$numeroDocumento}")
            ->scalar();
        return $puntosObtenidos;
    }

    public static function ranking()
    {
        $numeroDocumento = Yii::$app->user->identity->numeroDocumento;
        $sql = "
        SELECT rank FROM
            (SELECT numeroDocumento, @curRank := @curRank + 1 AS rank
                FROM t_FORCO_PromedioPonderadoUsuario p, (SELECT @curRank := 0) r
                ORDER BY promedio DESC
            ) AS ranking
        WHERE numeroDocumento = {$numeroDocumento}";

        $db = Yii::$app->db;
        $command = $db->createCommand($sql);
        $rank = $command->queryScalar();
        return $rank;
    }
}