<?php

use Faker\Provider\Image;
use Illuminate\Database\Seeder;

class ArtworkTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Artwork::class, 100)->create()->each(function ($artwork) {
            $artwork->storeImage(Image::image());
        });
    }
}
