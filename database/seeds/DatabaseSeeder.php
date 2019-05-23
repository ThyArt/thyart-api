<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            GalleriesTableSeeder::class,
            ArtistsTableSeeder::class,
            CustomersTableSeeder::class,
            ArtworkTableSeeder::class,
            OrdersTableSeeder::class
         ]);
    }
}
