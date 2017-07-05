<?php

use yii\db\Migration;

class m170623_151200_prioridad_m_FORCO_Curso_y_promedioCalificacion_m_FORCO_Curso_default_0 extends Migration
{
    public function up()
    {
        $this->alterColumn('m_FORCO_Curso', 'promedioCalificacion', $this->float()->notNull() . ' DEFAULT 0');
        $this->alterColumn('m_FORCO_Curso', 'prioridad', $this->integer()->unsigned()->notNull() . ' DEFAULT 0');
    }

    public function down()
    {
        $this->alterColumn('m_FORCO_Curso', 'promedioCalificacion', $this->float());
        $this->alterColumn('m_FORCO_Curso', 'prioridad', $this->integer()->unsigned()->notNull());
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
