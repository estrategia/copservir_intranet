<?php 

namespace app\modules\intranet\modules\formacioncomunicaciones\models;

use Yii;

class Indicadores
{
    public static function cursosNuevos()
    {
        // Cursos nuevos del mes
        // $fechaPasada = date('Y-m-d', strtotime('-1 week'));
        $fechaPasada = date('Y-m-01 00:00:00');
        
        if (false) {
            $fechaPasada = date('Y-m-d', strtotime('-1 month'));
        }
        // var_dump($fechaPasada);
        $cursosNuevos = (new yii\db\Query())
            ->from('m_FORCO_Contenido')
            ->where(['>=', 'fechaCreacion', $fechaPasada])
            ->count();
        return $cursosNuevos;
    }

    public static function cursosNuevosDisponibles()
    {
        // Cursos nuevos 
        // $fechaPasada = $next_week = date('Y-m-d 00:00:00', strtotime('-1 week'));
        $numeroDocumento = Yii::$app->user->identity->numeroDocumento;
        $fechaPasada = date('Y-m-01 00:00:00');
        $cursosHechos = (new yii\db\Query())
            ->select('idContenido')
            ->from('t_FORCO_ContenidoLeidoUsuario')
            ->where("numeroDocumento = {$numeroDocumento}")
            ->all();
        $cursosNuevos = (new yii\db\Query())
            ->from('m_FORCO_Contenido')
            ->where(['>=', 'fechaCreacion', $fechaPasada])
            ->andWhere(['NOT IN', 'idContenido', $cursosHechos])
            ->andWhere(['estadoContenido' => Contenido::ESTADO_ACTIVO])
            ->count();
            // var_dump($cursosNuevos->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql);
        return $cursosNuevos;
    }

    public static function cursosHechos()
    {
        // Cursos terminados
        $numeroDocumento = Yii::$app->user->identity->numeroDocumento;
        $cursosHechos = (new yii\db\Query())
            ->from('t_FORCO_ContenidoLeidoUsuario')
            ->where("numeroDocumento = {$numeroDocumento}")
            ->count();
        return $cursosHechos;
    }

    public static function cursosPendientes()
    {
        // Cursos pendientes activos asignados por el grupo de interes
        $gruposInteres = (array) Yii::$app->user->identity->getGruposCodigos();
        $gruposInteres[] = 999999;
        
        $numeroDocumento = Yii::$app->user->identity->numeroDocumento;
        $subQueryModulos = Modulo::find()
            ->select('idModulo')
            ->joinWith('curso')
            ->where(['estadoModulo' => Modulo::ESTADO_ACTIVO])
            ->andWhere(['estadoCurso' => Curso::ESTADO_ACTIVO]);


        $capitulosObligatorios = Capitulo::find()
            ->select('m_FORCO_Capitulo.idCapitulo')
            ->joinWith('objGruposInteres')
            ->where([
                'estadoCapitulo' => Capitulo::ESTADO_ACTIVO,
                'idModulo' => $subQueryModulos,
                'm_GrupoInteres.idGrupoInteres' => $gruposInteres,
            ]);

        $contenidosLeidos = ContenidoLeidoUsuario::find()
            ->joinWith('contenido')
            ->where(['numeroDocumento' => $numeroDocumento])
            ->andWhere(['estadoContenido' => Contenido::ESTADO_ACTIVO])
            ->all();
        
        $idsTerminados = \yii\helpers\ArrayHelper::getColumn($contenidosLeidos, 'idContenido');

        $contenidosPendientes = Contenido::find()
            ->select('idContenido')
            ->where(['idCapitulo' => $capitulosObligatorios])
            ->andWhere(['NOT IN', 'idContenido', $idsTerminados])
            ->andWhere(['estadoContenido' => Contenido::ESTADO_ACTIVO])
            ->count();

        return $contenidosPendientes;
    }

    public static function puntosObtenidos()
    {
        // Puntos del mes
        $numeroDocumento = Yii::$app->user->identity->numeroDocumento;
        $inicioMes = date('Y-m-01 00:00:00');
        $puntosObtenidos = (new yii\db\Query())
            ->select(['SUM(valorPuntos)'])
            ->from('t_FORCO_Puntos')
            ->where(['numeroDocumento' => $numeroDocumento])
            ->andWhere(['>=', 'fechaCreacion', $inicioMes])
            ->scalar();
        return $puntosObtenidos;
    }

    public static function puntosTotales()
    {
        // Puntos totales historicos
        $numeroDocumento = Yii::$app->user->identity->numeroDocumento;
        $puntosObtenidos = (new yii\db\Query())
            ->select(['SUM(valorPuntos)'])
            ->from('t_FORCO_Puntos')
            ->where(['numeroDocumento' => $numeroDocumento])
            ->scalar();
        return $puntosObtenidos;
    }

    public function ranking()
    {
        $numeroDocumento = Yii::$app->user->identity->numeroDocumento;
        $inicioMes = date('Y-m-01 00:00:00');
        // $sql = "
        // SELECT rank 
        // FROM (
        // SELECT numeroDocumento, puntos, @curRank := @curRank + 1 AS rank 
        //     FROM (
        //         SELECT numeroDocumento, SUM(valorPuntos) AS puntos 
        //         FROM t_FORCO_Puntos
        //         WHERE fechaCreacion >= '{$inicioMes}'
        //         GROUP BY numeroDocumento
        //         ORDER BY puntos DESC
        //     ) AS acumulado, (SELECT @curRank := 0) r
        // ) AS rank
        // WHERE numeroDocumento = {$numeroDocumento}";
        $sql = "
        SELECT rank FROM (
            SELECT numeroDocumento, puntos, @curRank := @curRank + 1 AS rank
                FROM (
                SELECT acumulado.numeroDocumento, puntos, tiempos.tiempo, tiempos.numeroDocumento as doc
                FROM (
                    SELECT t_FORCO_Puntos.numeroDocumento, SUM(valorPuntos) AS puntos
                    FROM t_FORCO_Puntos
                    WHERE fechaCreacion >= '{$inicioMes}'
                    GROUP BY t_FORCO_Puntos.numeroDocumento

                ) AS acumulado
                LEFT JOIN (
                    SELECT numeroDocumento, SUM(unix_timestamp(fechaActualizacion) - unix_timestamp(fechaCreacion)) AS tiempo
                    FROM t_FORCO_CuestionarioUsuario as cuestionario
                    WHERE cuestionario.fechaActualizacion IS NOT NULL
                    AND cuestionario.fechaActualizacion > cuestionario.fechaCreacion
                    GROUP BY numeroDocumento

                ) tiempos
                ON tiempos.numeroDocumento = acumulado.numeroDocumento
                WHERE tiempos.numeroDocumento = acumulado.numeroDocumento
                ORDER BY puntos DESC, tiempos.tiempo ASC) ranking, (SELECT @curRank := 0) r
            ) a
        WHERE numeroDocumento = {$numeroDocumento}";

        $db = Yii::$app->db;
        $command = $db->createCommand($sql);
        $rank = $command->queryScalar();
        return $rank;
    }

    public static function cantidadRanking()
    {
        $inicioMes = date('Y-m-01 00:00:00');
        $sql = "
            SELECT COUNT(*) as total 
            FROM(
                SELECT *
                FROM t_FORCO_CuestionarioUsuario
                WHERE fechaCreacion >= '{$inicioMes}'
                GROUP BY numeroDocumento
            ) a";
        $db = Yii::$app->db;
        $command = $db->createCommand($sql);
        $total = $command->queryScalar();
        return $total;
    }

    public function top()
    {
        $inicioMes = date('Y-m-01 00:00:00');
        // $sql = "
        // SELECT numeroDocumento, puntos, @curRank := @curRank + 1 AS rank 
        // FROM (
        //     SELECT numeroDocumento, SUM(valorPuntos) AS puntos 
        //     FROM t_FORCO_Puntos
        //     WHERE fechaCreacion >= '{$inicioMes}'
        //     GROUP BY numeroDocumento
        //     ORDER BY puntos DESC
        //     LIMIT 10
        // ) AS acumulado, (SELECT @curRank := 0) r";
            // WHERE fechaCreacion >= '{$inicioMes}'
        $sql = "
            SELECT numeroDocumento, puntos, @curRank := @curRank + 1 AS rank, tiempo
            FROM (
            SELECT acumulado.numeroDocumento, puntos, tiempos.tiempo, tiempos.numeroDocumento as doc
            FROM (
                SELECT t_FORCO_Puntos.numeroDocumento, SUM(valorPuntos) AS puntos
                FROM t_FORCO_Puntos
                WHERE fechaCreacion >= '{$inicioMes}'
                GROUP BY t_FORCO_Puntos.numeroDocumento

            ) AS acumulado
            LEFT JOIN (
                SELECT numeroDocumento, SUM(unix_timestamp(fechaActualizacion) - unix_timestamp(fechaCreacion)) AS tiempo
                FROM t_FORCO_CuestionarioUsuario as cuestionario
                WHERE cuestionario.fechaActualizacion IS NOT NULL
                AND cuestionario.fechaActualizacion > cuestionario.fechaCreacion
                GROUP BY numeroDocumento

            ) tiempos
            ON tiempos.numeroDocumento = acumulado.numeroDocumento
            WHERE tiempos.numeroDocumento = acumulado.numeroDocumento
            ORDER BY puntos DESC, tiempos.tiempo ASC) ranking, (SELECT @curRank := 0) r
            LIMIT 10";
        $db = Yii::$app->db;
        $command = $db->createCommand($sql);
        $top = $command->queryAll();
        return $top;
    }
}
