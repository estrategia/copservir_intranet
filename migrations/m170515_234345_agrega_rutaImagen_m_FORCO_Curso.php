<?php

use yii\db\Migration;

class m170515_234345_agrega_rutaImagen_m_FORCO_Curso extends Migration
{
    public function up()
    {
        $this->addColumn('m_FORCO_Curso', 'rutaImagen', $this->string(100));
    }

    public function down()
    {
        $this->dropColumn('m_FORCO_Curso', 'rutaImagen');
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
