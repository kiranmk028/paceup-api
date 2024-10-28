<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = [
            ['code' => 'US', 'name' => 'United States', 'continent_name' => 'North America'],
            ['code' => 'CA', 'name' => 'Canada', 'continent_name' => 'North America'],
            ['code' => 'MX', 'name' => 'Mexico', 'continent_name' => 'North America'],
            ['code' => 'BR', 'name' => 'Brazil', 'continent_name' => 'South America'],
            ['code' => 'AR', 'name' => 'Argentina', 'continent_name' => 'South America'],
            ['code' => 'GB', 'name' => 'United Kingdom', 'continent_name' => 'Europe'],
            ['code' => 'FR', 'name' => 'France', 'continent_name' => 'Europe'],
            ['code' => 'DE', 'name' => 'Germany', 'continent_name' => 'Europe'],
            ['code' => 'CN', 'name' => 'China', 'continent_name' => 'Asia'],
            ['code' => 'IN', 'name' => 'India', 'continent_name' => 'Asia'],
            ['code' => 'JP', 'name' => 'Japan', 'continent_name' => 'Asia'],
            ['code' => 'ZA', 'name' => 'South Africa', 'continent_name' => 'Africa'],
            ['code' => 'NG', 'name' => 'Nigeria', 'continent_name' => 'Africa'],
            ['code' => 'EG', 'name' => 'Egypt', 'continent_name' => 'Africa'],
            ['code' => 'AU', 'name' => 'Australia', 'continent_name' => 'Oceania'],
            ['code' => 'NZ', 'name' => 'New Zealand', 'continent_name' => 'Oceania'],
            ['code' => 'NP', 'name' => 'Nepal', 'continent_name' => 'Asia'],
            // Add more countries as needed...
        ];

        // Insert the countries into the database
        Country::insert($countries);
    }
}
