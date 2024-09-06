<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Client;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Client::factory(10)->create();
        Clinet::create([
            "name" =>  'achraf',
            "contact_info" => "0710203040",
            "address" => '21-street hay rahma(makayena rahema)',
            "image" => '/storage/somename.png',
        ]);
    }
}
