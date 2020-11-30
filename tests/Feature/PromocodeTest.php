<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class PromocodeTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('db:seed');
    }

    /**
     * Testing all promocodes API endpoint
     *
     * @return void
     */
    public function testGetAllPromocodes()
    {
        $response = $this->get('/api/promocodes');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'data' => [
                'current_page',
                'data' => [
                    [
                        'id',
                        'title',
                        'code',
                        'description',
                        'radius',
                        'radius_unit',
                        'start_at',
                        'end_at',
                        'is_active',
                        'created_at',
                        'updated_at',
                        'deleted_at',
                    ]
                ],
                'first_page_url',
                'from',
                'last_page',
                'last_page_url',
                'links' => [
                    [
                        'url',
                        'label',
                        'active',
                    ]
                ],
                'next_page_url',
                'path',
                'per_page',
                'prev_page_url',
                'to',
                'total',
            ]
        ]);
    }

    /**
     * Testing all promocodes API endpoint
     *
     * @return void
     */
    public function testGetAllActivePromocodes()
    {
        $response = $this->get('/api/promocodes/active');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'data' => [
                'current_page',
                'data' => [
                    [
                        'id',
                        'title',
                        'code',
                        'description',
                        'radius',
                        'radius_unit',
                        'start_at',
                        'end_at',
                        'is_active',
                        'created_at',
                        'updated_at',
                        'deleted_at',
                    ]
                ],
                'first_page_url',
                'from',
                'last_page',
                'last_page_url',
                'links' => [
                    [
                        'url',
                        'label',
                        'active',
                    ]
                ],
                'next_page_url',
                'path',
                'per_page',
                'prev_page_url',
                'to',
                'total',
            ]
        ]);
    }

    /**
     * Testing Add new promocode API endpoint
     *
     * @return void
     */
    public function testAddNewPromocode()
    {
        $response = $this->post('/api/promocodes', [
            'title' => '12km Radius free',
            'code' => 'FREE12KM',
            'radius' => 12,
            'radius_unit' => 'km',
            'description' => 'This promocode gives free ride within 12 km radius',
            'start_at' => now(),
            'end_at' => now()->addMonth(),
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'message',
            'data' => [
                'id',
                'title',
                'description',
                'code',
                'radius',
                'radius_unit',
                'start_at',
                'end_at',
                'created_at',
                'updated_at',
            ]
        ]);
    }

    /**
     * Testing Add new promocode API endpoint
     *
     * @return void
     */
    public function testAddNewPromocodeWithInvalidInput()
    {
        $response = $this->post('/api/promocodes', [
            'title' => '12km Radius free',
            'code' => 'FREE12KM',
            'radius' => 12,
            'radius_unit' => 'somethingelse',
            'description' => 'This promocode gives free ride within 12 km radius',
            'start_at' => now(),
            'end_at' => now()->addMonth(),
        ]);

        $response->assertStatus(400);
        $response->assertJsonStructure([
            'status',
            'message',
        ]);
    }

    /**
     * Testing Add new promocode API endpoint
     *
     * @return void
     */
    public function testAddNewPromocodeWithDuplicateCode()
    {
        $response = $this->post('/api/promocodes', [
            'title' => '12km Radius free',
            'code' => 'FREE12KM',
            'radius' => 12,
            'radius_unit' => 'km',
            'description' => 'This promocode gives free ride within 12 km radius',
            'start_at' => now(),
            'end_at' => now()->addMonth(),
        ]);
        $response->assertStatus(200);

        $response = $this->post('/api/promocodes', [
            'title' => '12km Radius free',
            'code' => 'FREE12KM',
            'radius' => 12,
            'radius_unit' => 'km',
            'description' => 'This promocode gives free ride within 12 km radius',
            'start_at' => now(),
            'end_at' => now()->addMonth(),
        ]);

        $response->assertStatus(400);
        $response->assertJsonStructure([
            'status',
            'message',
        ]);
    }

    /**
     * Testing Activate promocode API endpoint
     *
     * @return void
     */
    public function testActivatePromocode()
    {
        $response = $this->post('/api/promocodes', [
            'title' => '12km Radius free',
            'code' => 'FREE12KM',
            'radius' => 12,
            'radius_unit' => 'km',
            'description' => 'This promocode gives free ride within 12 km radius',
            'start_at' => now(),
            'end_at' => now()->addMonth(),
            'is_active' => false,
        ]);

        $promocodeData = $response->json();

        $response = $this->put('/api/promocodes/' . $promocodeData['data']['id'] . '/activate');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'message',
        ]);
    }

    /**
     * Testing Deactivate promocode API endpoint
     *
     * @return void
     */
    public function testDeactivatePromocode()
    {
        $response = $this->post('/api/promocodes', [
            'title' => '12km Radius free',
            'code' => 'FREE12KM',
            'radius' => 12,
            'radius_unit' => 'km',
            'description' => 'This promocode gives free ride within 12 km radius',
            'start_at' => now(),
            'end_at' => now()->addMonth(),
        ]);

        $promocodeData = $response->json();

        $response = $this->put('/api/promocodes/' . $promocodeData['data']['id'] . '/deactivate');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'message',
        ]);
    }

    /**
     * Testing Apply promocode API endpoint
     *
     * @return void
     */
    public function testApplyValidPromocode()
    {
        $this->post('/api/promocodes', [
            'title' => '12km Radius free',
            'code' => 'FREE12KM',
            'radius' => 12,
            'radius_unit' => 'km',
            'description' => 'This promocode gives free ride within 12 km radius',
            'start_at' => now()->subMonth(),
            'end_at' => now()->addMonth(),
        ]);


        $response = $this->post('/api/promocodes/apply', [
            'origin_latitude' => 33.9587799,
            'origin_longitude' => -118.4111962,
            'destination_latitude' => 33.9793132,
            'destination_longitude' => -118.4674853,
            'code' => 'FREE12KM'
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'message',
            'data' => [
                'promocode' => [
                    'id',
                    'title',
                    'description',
                    'code',
                    'radius',
                    'radius_unit',
                    'start_at',
                    'end_at',
                    'created_at',
                    'updated_at',
                    'deleted_at',
                ],
                'routes' => [
                    [
                        'bounds',
                        'copyrights',
                        'legs' => [
                            [
                                'distance',
                                'duration',
                                'end_address',
                                'end_location',
                                'start_address',
                                'start_location',
                                'steps' => [
                                    [
                                        'distance',
                                        'duration',
                                        'end_location',
                                        'html_instructions',
                                        'polyline',
                                        'start_location',
                                        'travel_mode',
                                    ]
                                ],
                                'traffic_speed_entry',
                                'via_waypoint',
                            ]
                        ],
                        'overview_polyline' => [
                            'points' => [
                                [
                                    'lat',
                                    'lng',
                                ]
                            ]
                        ],
                        'summary',
                        'warnings',
                        'waypoint_order',
                    ]
                ]
            ]
        ]);
    }

    /**
     * Testing Apply Invalid Promocode API endpoint
     *
     * @return void
     */
    public function testApplyInvalidPromocode()
    {
        $response = $this->post('/api/promocodes/apply', [
            'origin_latitude' => 33.9587799,
            'origin_longitude' => -118.4111962,
            'destination_latitude' => 33.9793132,
            'destination_longitude' => -118.4674853,
            'code' => 'FREE50KM'
        ]);

        $response->assertStatus(400);
        $response->assertJsonStructure([
            'status',
            'message',
        ]);
    }

    /**
     * Testing Update promocode API endpoint
     *
     * @return void
     */
    public function testUpdatePromocode()
    {
        // Insert New Promocode
        $response = $this->post('/api/promocodes', [
            'title' => '12km Radius free',
            'code' => 'FREE12KM',
            'radius' => 12,
            'radius_unit' => 'km',
            'description' => 'This promocode gives free ride within 12 km radius',
            'start_at' => now(),
            'end_at' => now()->addMonth(),
        ]);
        $promocodeData = $response->json();

        $response = $this->put('/api/promocodes/' . $promocodeData['data']['id'], [
            'title' => '15km Radius free',
            'code' => 'FREE15KM',
            'radius' => 15,
            'radius_unit' => 'km',
            'description' => 'This promocode gives free ride within 15 km radius',
            'start_at' => now(),
            'end_at' => now()->addMonth(),
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'message',
            'data' => [
                'id',
                'title',
                'description',
                'code',
                'radius',
                'radius_unit',
                'start_at',
                'end_at',
                'created_at',
                'updated_at',
            ]
        ]);
    }

    /**
     * Testing Delete promocode API endpoint
     *
     * @return void
     */
    public function testDeletePromocode()
    {
        // Insert New Promocode
        $response = $this->post('/api/promocodes', [
            'title' => '12km Radius free',
            'code' => 'FREE12KM',
            'radius' => 12,
            'radius_unit' => 'km',
            'description' => 'This promocode gives free ride within 12 km radius',
            'start_at' => now(),
            'end_at' => now()->addMonth(),
        ]);
        $promocodeData = $response->json();

        $response = $this->delete('/api/promocodes/' . $promocodeData['data']['id']);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'message',
        ]);
    }
}
