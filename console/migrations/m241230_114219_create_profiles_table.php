<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%profiles}}`.
 */
class m241230_114219_create_profiles_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('profiles', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50),
            'picture_name' => $this->string(255),
            'picture_data' => $this->binary(),
            'bio' => $this->text(),
            'balance' => $this->decimal(15, 2),
            'user_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-profiles-user_id',
            'profiles',
            'user_id',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-profiles-user_id', 'profiles');
        $this->dropTable('profiles');
    }
}
