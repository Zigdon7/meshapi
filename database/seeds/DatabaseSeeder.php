<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(HospitalTableSeeder::class);
        // $this->call(UsersTableSeeder::class);
        $this->call(WhitelistTableSeeder::class);


    }
}
