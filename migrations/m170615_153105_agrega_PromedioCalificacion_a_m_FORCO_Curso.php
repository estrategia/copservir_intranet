<?php

use yii\db\Migration;

class m170615_153105_agrega_PromedioCalificacion_a_m_FORCO_Curso extends Migration
{
    public function up()
    {
        $this->addColumn('m_FORCO_Curso', 'promedioCalificacion', $this->float());
    }

    public function down()
    {
        $this->dropColumn('m_FORCO_Curso', 'promedioCalificacion');
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
