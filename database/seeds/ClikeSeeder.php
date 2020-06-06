<?php

use Illuminate\Database\Seeder;

class ClikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Clike::class, 50)->create();
    }
}
