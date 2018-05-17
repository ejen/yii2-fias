<?php

use yii\db\Migration;

class m160510_195627_addrobj extends Migration
{
    public $tableName = '{{%fias_addrobj}}';

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql')
        {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'aoguid' => 'VARCHAR(36)',
            'formalname' => 'VARCHAR(120)',
            'regioncode' => 'VARCHAR(2)',
            'autocode' => 'VARCHAR(1)',
            'areacode' => 'VARCHAR(3)',
            'citycode' => 'VARCHAR(3)',
            'ctarcode' => 'VARCHAR(3)',
            'placecode' => 'VARCHAR(3)',
            'plancode' => 'VARCHAR(4)',
            'streetcode' => 'VARCHAR(4)',
            'extrcode' => 'VARCHAR(4)',
            'sextcode' => 'VARCHAR(3)',
            'offname' => 'VARCHAR(120)',
            'postalcode' => 'VARCHAR(6)',
            'ifnsfl' => 'VARCHAR(4)',
            'terrifnsfl' => 'VARCHAR(4)',
            'ifnsul' => 'VARCHAR(4)',
            'terrifnsul' => 'VARCHAR(4)',
            'okato' => 'VARCHAR(11)',
            'oktmo' => 'VARCHAR(11)',
            'updatedate' => 'DATE',
            'shortname' => 'VARCHAR(10)',
            'aolevel' => 'INT',
            'parentguid' => 'VARCHAR(36)',
            'aoid' => 'VARCHAR(36)',
            'previd' => 'VARCHAR(36)',
            'nextid' => 'VARCHAR(36)',
            'code' => 'VARCHAR(17)',
            'plaincode' => 'VARCHAR(15)',
            'actstatus' => 'INT',
            'centstatus' => 'INT',
            'operstatus' => 'INT',
            'currstatus' => 'INT',
            'livestatus' => 'INT',
            'startdate' => 'date',
            'enddate' => 'date',
            'normdoc' => 'VARCHAR(36)',
            'cadnum' => 'VARCHAR(100)',
            'divtype' => 'INT',
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
