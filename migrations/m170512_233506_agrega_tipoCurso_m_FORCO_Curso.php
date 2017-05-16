<?php

use yii\db\Migration;

class m170512_233506_agrega_tipoCurso_m_FORCO_Curso extends Migration
{
    public function up()
    {
        $this->addColumn('m_FORCO_Curso', 'tipoCurso', 'TINYINT(1) NOT NULL DEFAULT 1');
    }

    public function down()
    {
        $this->dropColumn('m_FORCO_Curso', 'tipoCurso');
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
