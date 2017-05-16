<?php

use yii\db\Migration;

class m170424_164236_crea_m_FORCO_ContactoCategoria extends Migration
{
    public function up()
    {
        $this->createTable('m_FORCO_ContactoCategoria', [
            'idCategoriaPremio' => $this->integer(10)->unsigned()->notNull(),
            'numeroDocumento' => $this->bigInteger(20)->unsigned()->notNull(),
            'PRIMARY KEY (idCategoriaPremio, numeroDocumento)'
        ]);

        $this->addForeignKey(
            'fk_m_FORCO_ContactoCategoria_m_FORCO_CategoriasPremios',
            'm_FORCO_ContactoCategoria',
            'idCategoriaPremio',
            'm_FORCO_CategoriasPremios',
            'idCategoria'
        );

        $this->addForeignKey(
            'fk_m_FORCO_ContactoCategoria_m_Usuario',
            'm_FORCO_ContactoCategoria',
            'numeroDocumento',
            'm_Usuario',
            'numeroDocumento'
        );
        
        $this->dropColumn('m_FORCO_Premio', 'numeroPremios');
        
    }

    public function down()
    {
        $this->dropForeignKey(
            'fk_m_FORCO_ContactoCategoria_m_FORCO_CategoriasPremios',
            'm_FORCO_ContactoCategoria'
        );

        $this->dropForeignKey(
            'fk_m_FORCO_ContactoCategoria_m_Usuario',
            'm_FORCO_ContactoCategoria'
        );

        $this->dropTable('m_FORCO_ContactoCategoria');
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
