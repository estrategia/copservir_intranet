<?php

use yii\db\Migration;

class m170420_143752_crea_t_FORCO_CategoriasPremios extends Migration
{
    public function up()
    {
        $this->createTable('m_FORCO_CategoriasPremios', [
            'idCategoria' => $this->integer(10)->unsigned()->notNull() .' NOT NULL AUTO_INCREMENT',
            'nombreCategoria' => $this->string(100),
            'orden' => $this->integer(5)->unsigned()->notNull(),
            'rutaIcono' => $this->string(100),
            'estado' => 'TINYINT(1) NOT NULL DEFAULT 1',
            'idCategoriaPadre' => $this->integer()->unsigned(),
            'fechaCreacion' => $this->dateTime(),
            'fechaActualizacion' => $this->timestamp() . ' DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            'PRIMARY KEY (idCategoria)'
        ]);

        $this->addForeignKey(
            'fk_m_FORCO_CategoriasPremios_m_FORCO_CategoriasPremios',
            'm_FORCO_CategoriasPremios',
            'idCategoriaPadre',
            'm_FORCO_CategoriasPremios',
            'idCategoria'
        );
    }

    public function down()
    {
        $this->dropForeignKey(
            'fk_m_FORCO_CategoriasPremios_m_FORCO_CategoriasPremios',
            'm_FORCO_CategoriasPremios'
        );
        $this->dropTable('m_FORCO_CategoriasPremios');
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
