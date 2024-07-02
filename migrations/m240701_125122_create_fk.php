<?php

use yii\db\Migration;

class m240701_125122_create_fk extends Migration
{
    public function safeUp()
    {
        $this->addForeignKey(
            'users_to_sities_fk',
            'users',
            'city_id',
            'cities',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        echo "m240701_125122_create_fk cannot be reverted.\n";

        return false;
    }

}
