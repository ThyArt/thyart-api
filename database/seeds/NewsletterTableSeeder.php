<?php

use Illuminate\Database\Seeder;


class NewsletterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
// Populate roles
    factory(App\Customer::class, 50)->create();

// Populate users
    factory(App\Newsletter::class, 50)->create();

// Get all the roles attaching up to 3 random roles to each user
    $newsletters = App\Newsletter::all();

// Populate the pivot table
    App\Customer::all()->each(function ($customers) use ($newsletters) { 
    $customers->newsletters()->attach(
        $newsletters->random(rand(1, 50))->pluck('id')->toArray()
    ); 
    });
    }
}
