<?php

use yii\db\Migration;

class m170405_171254_agrega_idCurso_t_FORCO_ContenidoLeidoUsuario extends Migration
{
    public function up()
    {
        $this->addColumn('t_FORCO_ContenidoLeidoUsuario', 'idCurso', $this->integer(10)->unsigned()->notNull());
         $this->addForeignKey(
            'fk_t_FORCO_ContenidoLeidoUsuario_m_FORCO_Curso',
            't_FORCO_ContenidoLeidoUsuario',
            'idCurso',
            'm_FORCO_Curso',
            'idCurso'
        );
    }

    public function down()
    {
        $this->dropForeignKey('fk_t_FORCO_ContenidoLeidoUsuario_m_FORCO_Curso', 't_FORCO_ContenidoLeidoUsuario');
        $this->dropColumn('t_FORCO_ContenidoLeidoUsuario', 'idCurso');
    }

}
