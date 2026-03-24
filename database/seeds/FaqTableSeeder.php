<?php

use Illuminate\Database\Seeder;

class FaqTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Truncate the table before seeding
        DB::table('faqs')->truncate();

        // Insert sample data into the faqs table
        DB::table('faqs')->insert([
            ['description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.'],
            ['description' => 'Donec suscipit auctor dui, sed efficitur ligula.'],
            ['description' => 'Donec a nunc eget nisl efficitur commodo.'],
            ['description' => 'Donec at nunc a enim efficitur convallis.'],
        ]);
    }
}
