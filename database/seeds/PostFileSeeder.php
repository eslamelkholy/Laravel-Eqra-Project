<?php

use Illuminate\Database\Seeder;

class PostFileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\PostFile::class, 50)->create();
    }
}
