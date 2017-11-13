<?php

use yii\db\Schema; 
use yii\db\Migration;

/**
 * Class m171113_061810_admin_log
 */
class m171113_061810_admin_log extends Migration
{
    const TBL_NAME = 'admin_log';
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $tableOptions = null;  

        if ($this->db->driverName === 'mysql') {  
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';  
        }  
        
        $this->createTable(self::TBL_NAME, [  
            'id'                => Schema::TYPE_PK,  
            'user_id'           => Schema::TYPE_INTEGER . '(11) unsigned NOT NULL',
            'type'              => Schema::TYPE_INTEGER . '(11) NOT NULL COMMENT "1更新，2删除，3添加"',
            'table_name'        => Schema::TYPE_STRING  . '(50) NOT NULL COMMENT "表名称"',    
            'description'       => Schema::TYPE_TEXT,
            'route'             => Schema::TYPE_STRING  . '(50) NOT NULL DEFAULT ""', 
            'ip'                => Schema::TYPE_STRING  . '(20) NOT NULL DEFAULT ""',  
            'created_at'        => Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',  
        ], $tableOptions);

        $this->createIndex('index_user_id', self::TBL_NAME, ['user_id']);  
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m171113_061810_admin_log cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171113_061810_admin_log cannot be reverted.\n";

        return false;
    }
    */
}
