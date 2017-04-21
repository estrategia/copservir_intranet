<?php

use yii\db\Migration;

class m170407_191935_agrega_fechaInicioCurso_t_CursosUsuario extends Migration
{
    public function up()
    {
        $this->addColumn('t_FORCO_CursosUsuario', 'fechaInicioLectura', $this->dateTime());
    }

    public function down()
    {
        $this->dropColumn('t_FORCO_CursosUsuario', 'fechaInicioLectura');
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
