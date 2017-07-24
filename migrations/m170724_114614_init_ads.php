<?php

use yii\db\Migration;

class m170724_114614_init_ads extends Migration
{

    const USERS_TABLE_NAME = "{{%users}}";
    const ADS_TABLE_NAME = "{{%ads}}";


    public function up()
    {
        $this->createTable(self::USERS_TABLE_NAME, [
            'id' => $this->primaryKey(),
            'username' => $this->string()->unique()->notNull(),
            'password' => $this->string()->notNull(),
            'auth_key' => $this->string(),
            'accessToken' => $this->string(),
            'created_at' => $this->timestamp()->defaultExpression("NOW()")
        ]);

        $this->createTable(self::ADS_TABLE_NAME, [
            'id' => $this->primaryKey(),
            'author_id' => $this->integer()->notNull(),
            'title' => $this->string()->notNull(),
            'description' => $this->text()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('NOW()')
        ]);

        $this->addForeignKey('fk_ads_to_users', self::ADS_TABLE_NAME, 'author_id', self::USERS_TABLE_NAME, 'id', 'CASCADE', 'CASCADE');

        return true;
    }

    public function down()
    {
        $this->dropForeignKey('fk_ads_to_users', self::ADS_TABLE_NAME);

        $this->dropTable(self::ADS_TABLE_NAME);
        $this->dropTable(self::USERS_TABLE_NAME);
        return true;
    }
}
