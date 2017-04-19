<?php

use yii\db\Migration;

class m170419_144543_agrega_tiempoLectura_t_FORCO_ContenidoLeidoUsuario extends Migration
{
    public function up()
    {
        $this->addColumn('t_FORCO_ContenidoLeidoUsuario', 'tiempoLectura', $this->integer(10)->unsigned());
    }

    public function down()
    {
        $this->dropColumn('t_FORCO_ContenidoLeidoUsuario', 'tiempoRequerido');
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
