<?php

namespace Database\Seeders;

use App\Models\Field;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        //Need to work on logic to set pivot value based of field type
//        $fields = Field::factory()->count(5)->create();
//         \App\Models\Subscriber::factory(10)->hasAttached($fields, ['value' => ?])->create();


        $this->call(FieldSeeder::class);
        \App\Models\Subscriber::factory(10);
    }
}
