<?php

use yii\db\Migration;

class m170424_210155_cambia_relacion_FORCO_ContactoCategoria_m_Usuario_a_m_INTRA_Usuario extends Migration
{
    public function up()
    {
        $this->dropForeignKey(
            'fk_m_FORCO_ContactoCategoria_m_Usuario',
            'm_FORCO_ContactoCategoria'
        );

        $this->addForeignKey(
            'fk_m_FORCO_ContactoCategoria_m_INTRA_Usuario',
            'm_FORCO_ContactoCategoria',
            'numeroDocumento',
            'm_INTRA_Usuario',
            'numeroDocumento'
        );
    }

    public function down()
    {
        $this->dropForeignKey(
            'fk_m_FORCO_ContactoCategoria_m_INTRA_Usuario',
            'm_FORCO_ContactoCategoria'
        );

        $this->addForeignKey(
            'fk_m_FORCO_ContactoCategoria_m_Usuario',
            'm_FORCO_ContactoCategoria',
            'numeroDocumento',
            'm_Usuario',
            'numeroDocumento'
        );
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
