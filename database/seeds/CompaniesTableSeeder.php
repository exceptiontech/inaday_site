<?php

use Illuminate\Database\Seeder;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /* country - cities */

        $saudi = DB::table('countries')->insert([
            'title' => '{"en":"Saudi Arabia","ar":"\u0627\u0644\u0633\u0639\u0648\u062f\u064a\u0629"}',
            'slug' => 'saudi-arabia',
            'is_active' => 1,
        ]);

        DB::table('cities')->insert([
            'title' => '{"en":"Riyadh","ar":"\u0627\u0644\u0631\u064a\u0627\u0636"}',
            'slug' => 'riyadh',
            'country_id' => 1,
            'is_active' => 1,
        ]);
        DB::table('cities')->insert([
            'title' => '{"en":"Jeddah","ar":"\u062c\u062f\u0629"}',
            'slug' => 'jeddah',
            'country_id' => 1,
            'is_active' => 1,
        ]);



        /* statuses */

        DB::table('statuses')->insert([
            'title' => '{"en":"Active","ar":"\u062c\u062f\u0629"}',
            'type' => 'subscribe',
        ]);

        DB::table('statuses')->insert([
            'title' => '{"en":"Not active","ar":"\u062c\u062f\u0629"}',
            'type' => 'subscribe',
        ]);

        DB::table('statuses')->insert([
            'title' => '{"en":"Pending","ar":"\u062c\u062f\u0629"}',
            'type' => 'subscribe',
        ]);

        DB::table('statuses')->insert([
            'title' => '{"en":"Banned","ar":"\u062c\u062f\u0629"}',
            'type' => 'subscribe',
        ]);

        DB::table('statuses')->insert([
            'title' => '{"en":"just one ","ar":"\u062c\u062f\u0629"}',
            'type' => 'subscribe',
        ]);


        DB::table('statuses')->insert([
            'title' => '{"en":"Active","ar":"\u062c\u062f\u0629"}',
            'type' => 'coupon',
        ]);

        DB::table('statuses')->insert([
            'title' => '{"en":"Not active","ar":"\u062c\u062f\u0629"}',
            'type' => 'coupon',
        ]);


        /* sections */

        DB::table('sections')->insert([
            'title' => '{"en":"Painting","ar":"\u0634\u0631\u0643\u0627\u062a \u0627\u0644\u062f\u0647\u0627\u0646"}',
            'image' => 'uploads/sections/2018-04-09-7511.jpg',
            'icon' => 'im-paintbrush',
            'slug' => 'painting',
            'desc' => '{"en":"Painting companies have corner in this section","ar":"\u0634\u0631\u0643\u0627\u062a \u0627\u0644\u062f\u0647\u0627\u0646 \u0644\u062f\u064a\u0647\u0627 \u0645\u0643\u0627\u0646 \u0641\u064a \u0647\u0630\u0627 \u0627\u0644\u0642\u0633\u0645"}',
            'is_active' => 1,
        ]);

        DB::table('sections')->insert([
            'title' => '{"en":"Electricity","ar":"\u0634\u0631\u0643\u0627\u062a \u0627\u0644\u062f\u0647\u0627\u0646"}',
            'image' => 'uploads/sections/2018-04-09-7511.jpg',
            'icon' => 'im-lightning-bolt',
            'slug' => 'electricity',
            'desc' => '{"en":"Electricity companies have corner in this section","ar":"\u0634\u0631\u0643\u0627\u062a \u0627\u0644\u062f\u0647\u0627\u0646 \u0644\u062f\u064a\u0647\u0627 \u0645\u0643\u0627\u0646 \u0641\u064a \u0647\u0630\u0627 \u0627\u0644\u0642\u0633\u0645"}',
            'is_active' => 1,
        ]);


    }
}