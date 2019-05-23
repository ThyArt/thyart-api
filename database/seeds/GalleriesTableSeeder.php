<?php

use Illuminate\Database\Seeder;

class GalleriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Gallery::class, 10)
            ->create()
            ->each(function (App\Gallery $gallery) {
                factory(App\User::class, 1)
                    ->create([
                        'role' => 'admin',
                        'gallery_id' => $gallery->id
                    ])->each(function (App\User $user) {
                        $user->assignRole('admin');
                    });

                factory(App\User::class, 3)
                    ->create([
                        'role' => 'member',
                        'gallery_id' => $gallery->id
                    ])->each(function (App\User $user) {
                        $user->assignRole('member');
                    });
            });
    }
}
