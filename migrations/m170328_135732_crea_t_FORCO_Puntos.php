<?php

use yii\db\Migration;

class m170328_135732_crea_t_FORCO_Puntos extends Migration
{
    public function up()
    {
        $this->createTable('t_FORCO_Puntos', [
            'idPunto' => $this->integer(10)->unsigned()->notNull() .' NOT NULL AUTO_INCREMENT',
            'numeroDocumento' => $this->bigInteger(20)->unsigned()->notNull(),
            'valorPuntos' => $this->integer()->unsigned()->notNull(),
            'descripcionPunto' => $this->string(100)->notNull(),
            'idCuestionario' => $this->integer(10)->unsigned(),
            'idParametroPunto' => $this->integer(10)->unsigned(),
            'tipoParametro' => $this->integer(10),
            'idTipoContenido' => $this->integer(10)->unsigned(),
            'condicion' => $this->integer(2)->unsigned(),
            'fechaCreacion' => $this->dateTime(),
            'PRIMARY KEY (idPunto)'
        ]);

        $this->addForeignKey(
            'fk_t_FORCO_Puntos_m_FORCO_Cuestionario',
            't_FORCO_Puntos',
            'idCuestionario',
            'm_FORCO_Cuestionario',
            'idCuestionario'
        );

        $this->addForeignKey(
            'fk_t_FORCO_Puntos_m_FORCO_ParametrosPuntos',
            't_FORCO_Puntos',
            'idParametroPunto',
            'm_FORCO_ParametrosPuntos',
            'idParametroPunto'
        );

        $this->addForeignKey(
            'fk_t_FORCO_Puntos_m_Usuario',
            't_FORCO_Puntos',
            'numeroDocumento',
            'm_Usuario',
            'numeroDocumento'
        );
    
    }

    public function down()
    {
        $this->dropForeignKey(
            'fk_t_FORCO_Puntos_m_FORCO_Cuestionario',
            't_FORCO_Puntos'
        );

        $this->dropForeignKey(
            'fk_t_FORCO_Puntos_m_FORCO_ParametrosPuntos',
            't_FORCO_Puntos'
        );

        $this->dropForeignKey(
            'fk_t_FORCO_Puntos_m_Usuario',
            't_FORCO_Puntos'
        );

        $this->dropTable('t_FORCO_Puntos');
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
