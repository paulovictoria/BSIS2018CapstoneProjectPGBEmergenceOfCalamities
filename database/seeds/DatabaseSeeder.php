<?php

use Illuminate\Database\Seeder;
use App\Admin;
use App\TideUpdates;
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminSeeder::class);
    }
}
