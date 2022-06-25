<?php

namespace Database\Seeders;

use App\Enums\FieldType;
use App\Models\Field;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fields = [
            [
                'title' => 'Address',
                'type' => FieldType::String
            ],
            [
                'title' => 'Phone',
                'type' => FieldType::String
            ],
            [
                'title' => 'Member Id',
                'type' => FieldType::Number
            ],
            [
                'title' => 'T&C',
                'type' => FieldType::Boolean
            ]
        ];

        foreach ($fields as $field) {

            Field::updateOrCreate(['title' => $field['title']], $field);
        }
    }
}
