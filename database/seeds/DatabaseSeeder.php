<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CarrierTableSeeder::class);
        $this->call(SimTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(SimUserTableSeeder::class);
        $this->call(ReportTypeTableSeeder::class);
        $this->call(SiteTableSeeder::class);
        $this->call(SettingTableSeeder::class);
        $this->call(ReportTypeSiteDefaultTableSeeder::class);
        $this->call(ReportTypeSiteValueTableSeeder::class);
        $this->call(RolesTableSeeder::class);
    }
}
