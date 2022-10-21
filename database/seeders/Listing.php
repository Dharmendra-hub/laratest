<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class Listing extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Listing::factory(7)->create();
    }
}
