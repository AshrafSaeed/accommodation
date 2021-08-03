<?php
namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\{User, Item, Location};


class ItemTest extends TestCase
{

    /**
     * Validate accommodation payload.
     *
     * @return void
    */
    public function tests_accommodation_name_cannot_contain_banned_words_Free_Offer_Book_Website()
    {
        $user = User::factory()->create();
        $auth_token = $user->createToken('auth-token')->plainTextToken;

        $headers = [
            'Authorization' => 'Bearer '.$auth_token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ];
        $payload = [
            'name' => 'My Offer Awesome Free Hotel', // ["Free", "Offer", "Book", "Website"],
            'rating' => 5,
            'category' => 'hotel',
            'location' => [
                'city' => 'Cuernavaca',
                'state' => 'Morelos',
                'country' => 'Mexico',
                'zip_code' => '62448',
                'address' => 'Boulevard Diaz Ordaz No. 9 Cantarranas'
            ],
            'image_url' => 'http://example.com/folder/image.png',
            'reputation' => 500,
            'price' => 1000,
            'availability' => 10            
        ];

        $this->json('POST', '/api/accommodation', $payload, $headers)
            ->assertStatus(422)
            ->assertJson([
                'message' => "The given data was invalid.",
                'errors' => [
                    'name' => [
                        'The name should not contain the words (free,offer,book,website)'
                    ]
                ]
            ]);
    }


    /**
     * Test some other Validate accommodation payload.
     *
     * @return void
    */
    public function tests_accommodation_category_name_must_be_from_hotel_alternative_hostel_lodge_resort_guesthouse()
    {
        $user = User::factory()->create();
        $auth_token = $user->createToken('auth-token')->plainTextToken;

        $headers = [
            'Authorization' => 'Bearer '.$auth_token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ];
        $payload = [
            'name' => 'My Awesome Hotel in town',
            'rating' => 5,
            'category' => 'my own category', // [hotel, alternative, hostel, lodge, resort, guesthouse ]
            'location' => [
                'city' => 'Cuernavaca',
                'state' => 'Morelos',
                'country' => 'Mexico',
                'zip_code' => '62448',
                'address' => 'Boulevard Diaz Ordaz No. 9 Cantarranas'
            ],
            'image_url' => 'http://example.com/folder/image.png',
            'reputation' => 500,
            'price' => 1000,
            'availability' => 10            
        ];

        $this->json('POST', '/api/accommodation', $payload, $headers)
            ->assertStatus(422)
            ->assertJson([
                'message' => "The given data was invalid.",
                'errors' => [
                    'category' => [
                        'The category must be one of [hotel,alternative,hostel,lodge,resort,guesthouse]'
                    ],
                ]
            ]);
    }

    /**
     * Test some more validate accommodation payload.
     *
     * @return void
    */
    public function tests_rate_must_in_0_to_5__calculate_reputation_badge__image_url__zip_code_lenght_5()
    {
        $user = User::factory()->create();
        $auth_token = $user->createToken('auth-token')->plainTextToken;

        $headers = [
            'Authorization' => 'Bearer '.$auth_token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ];
        $payload = [
            'name' => 'My Awesome Hotel in town',
            'rating' => 16,
            'category' => 'alternative', // [hotel, alternative, hostel, lodge, resort, guesthouse ]
            'location' => [
                'city' => 'Cuernavaca',
                'state' => 'Morelos',
                'country' => 'Mexico',
                'zip_code' => '624444448',
                'address' => 'Boulevard Diaz Ordaz No. 9 Cantarranas'
            ],
            'image_url' => 'image.png',
            'reputation' => 500,
            'price' => 1000,
            'availability' => 10            
        ];

        $this->json('POST', '/api/accommodation', $payload, $headers)
            ->assertStatus(422)
            ->assertJson([
                'message' => "The given data was invalid.",
                'errors' => [
                    "rating" => ["The rating must be between 0 and 5."],
                    'location.zip_code' => ["The location.zip code must be between 1 and 5 digits."],
                    "image_url" => ["The image url must be URL e.g (http//example.com/folder/image.png)"]
                ]
            ]);       
    }

    /**
     * Test get accomodation list payload.
     *
     * @return void
    */
    public function tests_get_all_accommodation_list()
    {
        $user = User::factory()
                    ->has(Item::factory()
                        ->has(Location::factory()->count(1))
                        ->count(5))
                    ->create();
        $auth_token = $user->createToken('auth-token')->plainTextToken;

        $headers = [
            'Authorization' => 'Bearer '.$auth_token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ];

        $payload = [];

        $this->json('GET', '/api/accommodation/list', $payload, $headers)
            ->assertStatus(200);
    }

     /**
     * Test create new accommodation payload.
     *
     * @return void
    */
    public function tests_create_new_accommodation()
    {
        $faker = \Faker\Factory::create();
        $user = User::factory()->create();
        $auth_token = $user->createToken('auth-token')->plainTextToken;

        $headers = [
            'Authorization' => 'Bearer '.$auth_token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ];
        $payload = [
            'name' => $faker->name(),
            'rating' => 5,
            'category' => 'hotel',
            'location' => [
                'city' => 'Cuernavaca',
                'state' => 'Morelos',
                'country' => 'Mexico',
                'zip_code' => '62448',
                'address' => 'Boulevard Diaz Ordaz No. 9 Cantarranas'
            ],
            'image_url' => 'http://example.com/folder/image.png',
            'reputation' => 600,
            'price' => 1000,
            'availability' => 10            
        ];

        $this->json('POST', '/api/accommodation', $payload, $headers)
            ->assertStatus(200);
    }

    /**
     * Test get single accommodation payload.
     *
     * @return void
    */
    public function tests_get_a_single_accommodation()
    {
        $user = User::factory()
                    ->has(Item::factory()
                        ->has(Location::factory()->count(1))
                        ->count(1))
                    ->create();
        $auth_token = $user->createToken('auth-token')->plainTextToken;

        $headers = [
            'Authorization' => 'Bearer '.$auth_token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ];

        $payload = [];

        $item = Item::whereUserId($user->id)->first();

        $this->json('GET', '/api/accommodation/'.$item->id, $payload, $headers)
            ->assertStatus(200);
    }

    /**
     * Test update accommodation payload.
     *
     * @return void
    */
    public function tests_update_accommodation()
    {
        $user = User::factory()
                    ->has(Item::factory()
                        ->has(Location::factory()->count(1))
                        ->count(1))
                    ->create();
        $auth_token = $user->createToken('auth-token')->plainTextToken;

        $headers = [
            'Authorization' => 'Bearer '.$auth_token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ];

        $item = Item::whereUserId($user->id)->first();

        $payload = [
            'name' => 'Updated item Name',
            'rating' => 5,
            'category' => 'resort',
            'location' => [
                'city' => 'Cuernavaca',
                'state' => 'Morelos',
                'country' => 'Mexico',
                'zip_code' => '62448',
                'address' => 'Boulevard Diaz Ordaz No. 9 Cantarranas'
            ],
            'image_url' => 'http://example.com/folder/image.png', //
            'reputation' => 800,
            'price' => 20000,
            'availability' => 10            
        ];

        $this->json('PUT', '/api/accommodation/'.$item->id, $payload, $headers)
            ->assertStatus(200);
    }

    /**
     * Test delete accommodation payload.
     *
     * @return void
    */
    public function tests_delete_accommodation()
    {
        $user = User::factory()
                    ->has(Item::factory()
                        ->has(Location::factory()->count(1))
                        ->count(1))
                    ->create();
        $auth_token = $user->createToken('auth-token')->plainTextToken;

        $headers = [
            'Authorization' => 'Bearer '.$auth_token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ];

        $payload = [];

        $item = Item::whereUserId($user->id)->first();

        $this->json('DELETE', '/api/accommodation/'.$item->id, $payload, $headers)
            ->assertStatus(200);
    }
}