<?php

use Illuminate\Database\Seeder;

class ExhibitionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Exhibition::class, 100)->create();
    }
}
