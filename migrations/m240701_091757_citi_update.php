<?php

use yii\db\Migration;

class m240701_091757_citi_update extends Migration
{
    public function safeUp()
    {
        $this->addColumn('users', 'city_id', $this->integer()->notNull());

        $city = json_decode(file_get_contents("web/data/cities.json"));

        $cities = [];
        foreach ($city->city as $item) {
            array_push($cities, trim($item->name));
        }
        sort($cities);

        $this->createTable('cities', [
            'id' => $this->primaryKey()->unique(),
            'name' => $this->string()->notNull(),
        ]);

        foreach ($cities as $city) {
            $this->insert('cities', ['name' => $city]);
        }
    }

    public function safeDown()
    {
        $this->dropTable('cities');
        $this->dropColumn('users', 'city_id');
    }
}
