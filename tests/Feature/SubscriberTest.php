<?php

namespace Tests\Feature;

use App\Models\Subscriber;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class SubscriberTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    protected $subscriber;
    public function setUp(): void
    {
        parent::setUp();

        $this->subscriber = Subscriber::factory(1)->create()->first();
    }
    /**
     * Test create subscriber.
     *
     * @return void
     */
    public function test_subscriber_is_being_created()
    {
        $response = $this->json('post','api/v1/subscriber', [
            'name' => 'Divyank',
            'email' => 'mail@divyank.dev',
            'status' => 'active',
            'fields' => [
                [
                    'title' => 'Address',
                    'value' => 'Surat, GJ',
                    'type' => 'string'
                ],
                [
                    'title' => 'Phone',
                    'value' => '0000000000',
                    'type' => 'string'
                ],
                [
                    'title' => 'T&C',
                    'value' => true,
                    'type' => 'boolean'
                ]
            ]
        ]);

        $response->assertSuccessful()->assertJson(fn(AssertableJson $json) =>
            $json->where('status', true)
                ->where('subscriber.email', 'mail@divyank.dev')
                ->has('subscriber.fields')->count('subscriber.fields', 3)
        );
    }

    public function test_unique_subscriber() {

        $response = $this->json('post','api/v1/subscriber', [
            'name' => $this->subscriber->name,
            'email' => $this->subscriber->email,
            'status' => 'active'
        ]);

        $response->assertJson(fn(AssertableJson $json) =>
            $json->where('message', 'The email has already been taken.')->etc()
        );
    }

    public function test_edit_subscriber() {

        $response = $this->json('put',"api/v1/subscriber/".$this->subscriber->id, [
            'name' => 'Sam',
            'email' => 'sam@gmail.com',
            'status' => 'active'
        ]);


        $response->assertSuccessful()->assertJson(fn(AssertableJson $json) =>
            $json->where('status', true)
            ->where('subscriber.email', 'sam@gmail.com')
            ->where('subscriber.name', 'Sam')
        );
    }
}
