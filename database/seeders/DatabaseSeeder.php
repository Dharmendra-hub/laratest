<?php

namespace Database\Seeders;


use App\Models\User;
use App\Models\Listing;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //\App\Models\User::factory(10)->create();
        //Create a user and assign Listings to it, here using Admin user
        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com'
        ]);
        
        //Assign listings to the user defined above
        Listing::factory(7)->create([
            'user_id' => $user->id
        ]);
    }
}
