<?php

use yii\db\Migration;

class m170327_211157_crea_m_FORCO_ParametrosPuntos extends Migration
{
    public function up()
    {
        $this->createTable('m_FORCO_ParametrosPuntos', [
            'idParametroPunto' => $this->integer(10)->unsigned()->notNull() .' NOT NULL AUTO_INCREMENT',
            'tipoParametro' => $this->integer(1)->unsigned()->notNull(),
            'valorPuntos' => $this->integer()->unsigned()->notNull(),
            'idTipoContenido' => $this->integer(10)->unsigned()->notNull(),
            'condicion' => $this->integer(2)->unsigned(),
            'estado' => 'TINYINT(1) NOT NULL DEFAULT 1',
            'fechaCreacion' => $this->dateTime(),
            'fechaActualizacion' => $this->timestamp() . ' DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            'PRIMARY KEY (idParametroPunto)'
        ]);

        $this->addForeignKey(
            'fk_m_FORCO_ParametrosPuntos_m_FORCO_TipoContenido',
            'm_FORCO_ParametrosPuntos',
            'idTipoContenido',
            'm_FORCO_TipoContenido',
            'idTipoContenido'
        );
    
    }

    public function down()
    {
        $this->dropForeignKey(
            'fk_m_FORCO_ParametrosPuntos_m_FORCO_TipoContenido',
            'm_FORCO_ParametrosPuntos'
        );

        $this->dropTable('m_FORCO_ParametrosPuntos');
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
