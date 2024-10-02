<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\Cas;
use App\Models\Court;
use App\Models\Judge;
use App\Models\Document;
use App\Models\Invoice;
use App\Models\Procedure;
use App\Models\Todo;
use App\Models\Contact;



class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();


        // default judges
        $sqlFilePath = database_path('sql/courts.sql');
        $sql = File::get($sqlFilePath);
        DB::unprepared($sql);

        // default judges
        $sqlFilePath = database_path('sql/judges.sql');
        $sql = File::get($sqlFilePath);
        DB::unprepared($sql);
        // Client::factory(10)->create();
        // Court::factory(10)->create();
        // Judge::factory(10)->create();
        // Cas::factory(50)->create();
        // Document::factory(10)->create();
        // Invoice::factory(10)->create();
        // Procedure::factory(50)->create();
        // Todo::factory(10)->create();
        // Contact::factory(10)->create();
        
        if(!User::where('name', 'Admin')->first()){
            DB::table('users')->insert([
                'name'=> "Admin",
                'password'=> Hash::make('admin123'),
                'email' => 'admin@admin.com',
                'role' => 'SuperAdmin',
                'city' => 'Agadir',
                'name_in_arab' => 'ادمين',
                'city_in_arab' => 'كلميم',
                'gender' => "Male",
            ]);
        }
    }
}
