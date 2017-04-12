<?php

use yii\db\Migration;

class m170403_161229_agrega_idPuntoSincronizado_t_FORCO_Puntos extends Migration
{
    public function up()
    {
        $this->addColumn('t_FORCO_Puntos', 'idPuntoSincronizado', $this->integer(10)->unsigned());
    }

    public function down()
    {
        $this->dropColumn('t_FORCO_Puntos', 'idPuntoSincronizado');
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
