<?php

use yii\db\Migration;

class m240630_083928_update_user_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('users', 'verification_code', $this->integer(6));
    }

    public function safeDown()
    {
        $this->dropColumn('users', 'verification_code');
    }
}
