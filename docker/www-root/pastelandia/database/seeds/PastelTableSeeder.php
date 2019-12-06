<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PastelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pasteis')->delete();
        factory(App\Pastel::class, 50)->create();
    }
}
