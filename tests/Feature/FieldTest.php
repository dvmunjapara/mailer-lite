<?php

namespace Tests\Feature;

use App\Enums\FieldType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class FieldTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * Test create field api
     *
     * @return void
     */
    public function test_able_to_create_fields()
    {
        $response = $this->json('post','api/v1/fields', [
            'title' => $this->faker->word(),
            'type' => collect(FieldType::cases())->pluck('value')->random(),
        ]);

        $response->assertStatus(200)->assertJson(fn (AssertableJson $json) =>
            $json->where('status', true)->has('field.title')->etc()
        );
    }

    /**
     * Test field validation
     *
     * @return void
     */
    public function test_field_validations()
    {
        $response = $this->json('post','api/v1/fields', [
            'type' => collect(FieldType::cases())->pluck('value')->random(),
        ]);

        $response->assertStatus(422);
    }

    /**
     * Test field type validation
     *
     * @return void
     */
    public function test_field_type_validations()
    {
        $response = $this->json('post','api/v1/fields', [
            'title' => $this->faker->word(),
            'type' => 'str',
        ]);

        $response->assertStatus(422);
    }
}
