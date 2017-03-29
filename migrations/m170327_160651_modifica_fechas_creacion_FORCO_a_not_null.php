<?php

use yii\db\Migration;

class m170327_160651_modifica_fechas_creacion_FORCO_a_not_null extends Migration
{
    public function up()
    {
        $this->alterColumn('m_FORCO_Curso', 'fechaCreacion', $this->datetime()->notNull());
        $this->alterColumn('m_FORCO_Modulo', 'fechaCreacion', $this->datetime()->notNull());
        $this->alterColumn('m_FORCO_Capitulo', 'fechaCreacion', $this->datetime()->notNull());
        $this->alterColumn('m_FORCO_Contenido', 'fechaCreacion', $this->datetime()->notNull());
    }

    public function down()
    {
        $this->alterColumn('m_FORCO_Curso', 'fechaCreacion', $this->datetime()->null());
        $this->alterColumn('m_FORCO_Modulo', 'fechaCreacion', $this->datetime()->null());
        $this->alterColumn('m_FORCO_Capitulo', 'fechaCreacion', $this->datetime()->null());
        $this->alterColumn('m_FORCO_Contenido', 'fechaCreacion', $this->datetime()->null());
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
