<?php

use yii\db\Migration;

class m240701_133424_update_applications extends Migration
{
    public function safeUp()
    {
        $this->addColumn('applications', 'city_id', $this->integer()->notNull());

        $this->addForeignKey(
            'applications_to_cities_fk',
            'applications',
            'city_id',
            'cities',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropColumn('applications', 'city_id');
    }
}
