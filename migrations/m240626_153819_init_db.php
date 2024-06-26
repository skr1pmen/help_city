<?php

use yii\db\Migration;

class m240626_153819_init_db extends Migration
{
    public function safeUp()
    {
        $this->createTable('users', [
            'id' => $this->primaryKey()->unique(),
            'name' => $this->string()->notNull(),
            'surname' => $this->string()->notNull(),
            'login' => $this->string()->notNull(),
            'password' => $this->string()->notNull(),
            'create_date' => $this->timestamp()->defaultExpression("NOW()"),
            'count_applications' => $this->integer()->defaultValue(0)
        ]);

        $this->createTable('applications', [
            'id' => $this->primaryKey()->unique(),
            'title' => $this->string()->notNull(),
            'description' => $this->text()->notNull(),
            'address' => $this->text()->notNull(),
            'status_id' => $this->integer()->defaultValue(1),
            'create_date' => $this->timestamp()->defaultExpression("NOW()"),
            'user_id' => $this->integer()->notNull()
        ]);

        $this->createTable('statuses', [
            'id' => $this->primaryKey()->unique(),
            'name' => $this->string()->notNull()
        ]);

        $this->createTable('comments', [
            'id' => $this->primaryKey()->unique(),
            'user_id' => $this->integer()->notNull(),
            'application_id' => $this->integer()->notNull(),
            'text' => $this->text()->notNull(),
            'create_date' => $this->timestamp()->defaultExpression("NOW()")
        ]);

        $this->addForeignKey(
            'applications_to_users_fk',
            'applications',
            'user_id',
            'users',
            'id',
            'CASCADE',
            'CASCADE',
        );
        $this->addForeignKey(
            'comments_to_users_fk',
            'comments',
            'user_id',
            'users',
            'id',
            'CASCADE',
            'CASCADE',
        );
        $this->addForeignKey(
            'comments_to_applications_fk',
            'comments',
            'application_id',
            'applications',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'applications_to_statuses_fk',
            'applications',
            'status_id',
            'statuses',
            'id',
            'CASCADE',
            'CASCADE',
        );


        $this->insert('statuses', [
            'name' => 'Заявка создана'
        ]);
        $this->insert('statuses', [
            'name' => 'Заявка обработана'
        ]);
        $this->insert('statuses', [
            'name' => 'Заявка в работе'
        ]);
        $this->insert('statuses', [
            'name' => 'Заявка решена'
        ]);
    }

    public function safeDown()
    {
        echo "m240626_153819_init_db cannot be reverted.\n";

        return false;
    }
}
