<?php

use Illuminate\Database\Seeder;

class LanguagesSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('languages')->insert([
            'name' => 'en'
        ]);
        DB::table('languages')->insert([
            'name' => 'ru'
        ]);
    }
}
