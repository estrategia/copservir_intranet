<?php

use yii\db\Migration;

class m170317_172137_agrega_referencia_m_FORCO_Curso_m_FORCO_Modulo extends Migration
{
    public function up()
    {
        $this->addColumn('m_FORCO_Modulo', 'idCurso', $this->integer(10)->unsigned()->notNull());

        $this->addForeignKey(
            'fk_m_FORCO_Modulo_m_FORCO_Curso',
            'm_FORCO_Modulo',
            'idCurso',
            'm_FORCO_Curso',
            'idCurso'
        );
    }

    public function down()
    {
        $this->dropForeignKey(
            'fk_m_FORCO_Modulo_m_FORCO_Curso',
            'm_FORCO_Modulo'
        );

        $this->dropColumn('m_FORCO_Modulo', 'idCurso');
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
