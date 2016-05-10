<?php

use yii\db\Migration;

class m160510_195814_landmark extends Migration
{
    public $tableName = '{{%fias_landmark}}';

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql')
        {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable($this->tableName, [
            'location' => 'VARCHAR(500)',
            'postalcode' => 'VARCHAR(6)',
            'ifnsfl' => 'VARCHAR(4)',
            'terrifnsfl' => 'VARCHAR(4)',
            'ifnsul' => 'VARCHAR(4)',
            'terrifnsul' => 'VARCHAR(4)',
            'okato' => 'VARCHAR(11)',
            'oktmo' => 'VARCHAR(11)',
            'updatedate' => 'DATE',
            'landid' => 'VARCHAR(36)',
            'landguid' => 'VARCHAR(36)',
            'aoguid' => 'VARCHAR(36)',
            'startdate' => 'DATE',
            'enddate' => 'DATE',
            'normdoc' => 'VARCHAR(36)',
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
