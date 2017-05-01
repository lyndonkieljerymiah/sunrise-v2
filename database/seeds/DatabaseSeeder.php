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

        $this->call('ContractsAppSeeder');
        $this->call('SelectionSeeder');
        $this->call('VillaSeeder');
        $this->command->info('Seed Successfully completed');

    }
}


