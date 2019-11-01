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
        $this->gallery = factory(App\Gallery::class)->create();

    factory(App\Customer::class, 50)->create();

// Populate users
    factory(App\Newsletter::class, 50)->create()->each(function ($newsletter) {
        $newsletter->customers()->attach(rand(1, 50))->id;
    });

    }
}
