<?php

use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $title  = array();
        $title['ar'] = 'الرياض';
        $title['en'] = 'Riyadh';
        $city = \App\City::create(['title' => $title, 'slug' => 'riyadh', 'country_id' =>  1, 'is_active' =>  1, 'order' =>  1]);

        $title  = array();
        $title['ar'] = 'جدة';
        $title['en'] = 'Jeddah';
        $city = \App\City::create(['title' => $title, 'slug' => 'jeddah', 'country_id' =>  1, 'is_active' =>  1, 'order' =>  2]);
    }
}
