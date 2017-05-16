<?php

use yii\db\Migration;

class m170313_192527_crea_t_FORCO_ContenidoCalificaciones extends Migration
{
    // public function up()
    // {

    // }

    // public function down()
    // {
    //     echo "m170313_192527_crea_t_FORCO_ContenidoCalificaciones cannot be reverted.\n";

    //     return false;
    // }

    
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->createTable('t_FORCO_ContenidoCalificacion', [
            'numeroDocumento' => $this->bigInteger(20)->unsigned()->notNull(),
            'idContenido' => $this->integer(10)->unsigned()->notNull(),
            'titulo' => $this->string(45)->notNull(),
            'comentario' => $this->string(100)->notNull(),
            'calificacion' => $this->integer(1)->notNull(),
            'fecha' => $this->timestamp() . ' DEFAULT CURRENT_TIMESTAMP',
        ]);

        $this->addPrimaryKey('pk_t_FORCO_ContenidoCalificaciones', 't_FORCO_ContenidoCalificacion', ['numeroDocumento', 'idContenido']);
    }

    public function safeDown()
    {
        $this->dropPrimaryKey('pk_t_FORCO_ContenidoCalificaciones', 't_FORCO_ContenidoCalificacion');
        $this->dropTable('t_FORCO_ContenidoCalificacion');
    }
    
}
