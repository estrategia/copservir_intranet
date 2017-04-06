<?php

use yii\db\Migration;

class m170405_143116_crea_t_FORCO_CursosUsuario extends Migration
{
    public function up()
    {
        $this->createTable('t_FORCO_CursosUsuario', [
            'idCurso' => $this->integer(10)->unsigned()->notNull(),
            'numeroDocumento' => $this->bigInteger(20)->unsigned()->notNull(),
            'fechaCreacion' => $this->dateTime(),
            'PRIMARY KEY (idCurso, numeroDocumento)'
        ]);

        $this->addForeignKey(
            'fk_t_FORCO_CursosUsuario_m_FORCO_Curso',
            't_FORCO_CursosUsuario',
            'idCurso',
            'm_FORCO_Curso',
            'idCurso'
        );

        $this->addForeignKey(
            'fk_t_FORCO_CursosUsuario_m_Usuario',
            't_FORCO_CursosUsuario',
            'numeroDocumento',
            'm_Usuario',
            'numeroDocumento'
        );
    }

    public function down()
    {
        $this->dropForeignKey('fk_t_FORCO_CursosUsuario_m_FORCO_Curso', 't_FORCO_CursosUsuario');
        $this->dropForeignKey('fk_t_FORCO_CursosUsuario_m_Usuario', 't_FORCO_CursosUsuario');
        $this->dropTable('t_FORCO_CursosUsuario');
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
