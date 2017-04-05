<?php

use yii\db\Migration;

class m170328_170227_agrega_fecha_inicio_fecha_fin_m_FORCO_Curso extends Migration
{
    public function up()
    {
        $this->addColumn('m_FORCO_Curso', 'fechaInicio', $this->dateTime()->notNull());
        $this->addColumn('m_FORCO_Curso', 'fechaFin', $this->dateTime());
    }

    public function down()
    {
       $this->dropColumn('m_FORCO_Curso', 'fechaInicio');
       $this->dropColumn('m_FORCO_Curso', 'fechaFin');
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
