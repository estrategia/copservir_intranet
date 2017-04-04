<?php

use yii\db\Migration;

class m170324_164753_elimina_t_FORCO_ContenidoGruposInteres_crea_t_FORCO_CursoGruposInteres extends Migration
{
    public function up()
    {
        $this->dropTable('t_FORCO_ContenidoGruposInteres');
        
        $this->createTable('t_FORCO_CursoGruposInteres', [
            'idGrupoInteres' => $this->integer(10)->unsigned()->notNull(),
            'idCurso' => $this->integer(10)->unsigned()->notNull(),
            'PRIMARY KEY (idGrupoInteres, idCurso)'
        ]);

        $this->addForeignKey(
            'fk_t_FORCO_CursoGruposInteres_m_GrupoInteres',
            't_FORCO_CursoGruposInteres',
            'idGrupoInteres',
            'm_GrupoInteres',
            'idGrupoInteres'
        );

        $this->addForeignKey(
            'fk_t_FORCO_CursoGruposInteres_m_FORCO_Curso',
            't_FORCO_CursoGruposInteres',
            'idCurso',
            'm_FORCO_Curso',
            'idCurso'
        );
    }

    public function down()
    {
        $this->dropTable('t_FORCO_CursoGruposInteres');

        $this->createTable('t_FORCO_ContenidoGruposInteres', [
            'idGrupoInteres' => $this->integer(10)->unsigned()->notNull(),
            'idContenido' => $this->integer(10)->unsigned()->notNull(),
            'PRIMARY KEY (idGrupoInteres, idContenido)'
        ]);

        $this->addForeignKey(
            'fk_t_FORCO_ContenidoGruposInteres_m_GrupoInteres',
            't_FORCO_ContenidoGruposInteres',
            'idGrupoInteres',
            'm_GrupoInteres',
            'idGrupoInteres'
        );

        $this->addForeignKey(
            'fk_t_FORCO_ContenidoGruposInteres_m_FORCO_Contenido',
            't_FORCO_ContenidoGruposInteres',
            'idContenido',
            'm_FORCO_Contenido',
            'idContenido'
        );
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
