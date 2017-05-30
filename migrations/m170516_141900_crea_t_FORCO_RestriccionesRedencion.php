<?php

use yii\db\Migration;

class m170516_141900_crea_t_FORCO_RestriccionesRedencion extends Migration
{
    public function up()
    {
        $this->createTable('t_FORCO_RestriccionesRedencion', [
            'numeroDocumento' => $this->bigInteger(20)->unsigned()->notNull(),
            'fechaCreacion' => $this->timestamp() . ' DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            'PRIMARY KEY (numeroDocumento)'
        ]);
    }

    public function down()
    {
        $this->dropTable('t_FORCO_RestriccionesRedencion');
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
