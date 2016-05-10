<?php

use yii\db\Migration;

class m160510_195752_houseint extends Migration
{
    public $tableName = '{{%houseint}}';

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql')
        {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable($this->tableName, [
            'postalcode' => 'VARCHAR(6)',
            'ifnsfl' => 'VARCHAR(4)',
            'terrifnsfl' => 'VARCHAR(4)',
            'ifnsul' => 'VARCHAR(4)',
            'terrifnsul' => 'VARCHAR(4)',
            'okato' => 'VARCHAR(11)',
            'oktmo' => 'VARCHAR(11)',
            'updatedate' => 'DATE',
            'intstart' => 'INT',
            'intend' => 'INT',
            'houseintid' => 'VARCHAR(36)',
            'intguid' => 'VARCHAR(36)',
            'aoguid' => 'VARCHAR(36)',
            'startdate' => 'DATE',
            'enddate' => 'DATE',
            'intstatus' => 'INT',
            'normdoc' => 'VARCHAR(36)',
            'counter' => 'INT',            
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable($this->tableName);
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
