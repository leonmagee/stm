<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        DB::table('roles')->insert([
            [
                'name' => 'Admin',
            ],
            [
                'name' => 'Manager',
            ],
            [
                'name' => 'Agent',
            ],
            [
                'name' => 'Dealer',
            ],
            [
                'name' => 'Signature Store Dealer',
            ],
        ]);
    }
}