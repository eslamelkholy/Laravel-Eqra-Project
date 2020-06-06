<?php

use Illuminate\Database\Seeder;

class PlikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Plike::class, 50)->create();
    }
}
