<?php

namespace Tests\Unit;

use App\User;
use App\Gallery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\ClientRepository;
use Tests\TestCase;

class GalleryControllerTest extends TestCase
{
    protected $user;
    protected $accessToken;

    protected $clientRepository;
    protected $userPassword;

    use RefreshDatabase;

    public function __construct()
    {
        parent::__construct();
        $this->clientRepository = new ClientRepository();
        $this->userPassword = 'UserControllerTest';
    }

    protected function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create(['password' => bcrypt($this->userPassword)]);
        $client = $this->clientRepository->create($this->user->id, 'Testing', 'http://localhost', false, true);

        $this->accessToken = $this->json(
            'POST',
            '/oauth/token',
            [
                'grant_type' => 'password',
                'client_id' => $client->id,
                'client_secret' => $client->secret,
                'username' => $this->user->email,
                'password' => $this->userPassword,
                'scope' => '*'
            ],
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        )->json()['access_token'];
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->user = null;
        $this->accessToken = null;
    }

    //--------------------------
    //
    // TEST INDEX
    //
    //--------------------------

    public function testIndex()
    {
        $firstGallery = factory(Gallery::class)->create();
        $secondGallery = factory(Gallery::class)->create();

        $this->json(
            'GET',
            '/api/gallery',
            [],
            [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        )
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'id' => $firstGallery->id,
                        'name' => $firstGallery->name,
                        'phone' => $firstGallery->phone,
                        'address' => $firstGallery->address,

                    ],
                    [
                        'id' => $secondGallery->id,
                        'name' => $secondGallery->name,
                        'phone' => $secondGallery->phone,
                        'address' => $secondGallery->address,
                    ]
                ]
            ]);
    }


    public function testIndexUnAuthenticated()
    {
        $this->json(
            'GET',
            '/api/gallery',
            [],
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        )
            ->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);
    }

    public function testIndexSearchByName()
    {
        $gallery = factory(Gallery::class)->create();
        $this->json(
            'GET',
            '/api/gallery',
            ['name' => $gallery->name],
            [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        )
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'id' => $gallery->id,
                        'name' => $gallery->name,
                        'address' => $gallery->address,
                        'phone' => $gallery->phone,
                    ]
                ]
            ]);
    }

    public function testIndexSearchByNameUnValid()
    {
        $this->json(
            'GET',
            '/api/gallery',
            ['name' => 'Wrong name'],
            [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        )
            ->assertStatus(200)
            ->assertJson(['data' => []]);
    }


    public function testIndexSearchByAddress()
    {
        $gallery = factory(Gallery::class)->create();
        $this->json(
            'GET',
            '/api/gallery',
            ['address' => $gallery->address],
            [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        )
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'id' => $gallery->id,
                        'name' => $gallery->name,
                        'address' => $gallery->address,
                        'phone' => $gallery->phone,
                    ]
                ]
            ]);
    }

    public function testIndexSearchByAddressUnValid()
    {
        $this->json(
            'GET',
            '/api/gallery',
            ['address' => 'Wrong address'],
            [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        )
            ->assertStatus(200)
            ->assertJson(['data' => []]);
    }

    public function testIndexSearchByPhone()
    {
        $gallery = factory(Gallery::class)->create();
        $this->json(
            'GET',
            '/api/gallery',
            ['phone' => $gallery->phone],
            [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        )
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'id' => $gallery->id,
                        'name' => $gallery->name,
                        'address' => $gallery->address,
                        'phone' => $gallery->phone,
                    ]
                ]
            ]);
    }

    public function testIndexSearchByPhoneUnValid()
    {
        $this->json(
            'GET',
            '/api/gallery',
            ['phone' => 'Wrong phone'],
            [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        )
            ->assertStatus(200)
            ->assertJson(['data' => []]);
    }

    public function testIndexSearchByMultipleFields()
    {
        $firstGallery = factory(Gallery::class)->create();
        $secondGallery = factory(Gallery::class)->create();
        $this->json(
            'GET',
            '/api/gallery',
            [
                'name' => $firstGallery->name,
                'address' => $firstGallery->address,
                'phone' => $secondGallery->phone
            ],
            [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        )
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'id' => $firstGallery->id,
                        'name' => $firstGallery->name,
                        'address' => $firstGallery->address,
                        'phone' => $firstGallery->phone,
                    ],
                    [
                        'id' => $secondGallery->id,
                        'name' => $secondGallery->name,
                        'address' => $secondGallery->address,
                        'phone' => $secondGallery->phone,
                    ]
                ]
            ]);
    }

    //--------------------------
    //
    // TEST STORE
    //
    //--------------------------

    public function testStoreWithNonExistentArguments()
    {
        $this->json(
            'POST',
            '/api/gallery',
            [],
            [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        )
            ->assertStatus(400)
            ->assertJson(
                [
                    "error" => "validation_failed",
                    "messages" => [
                        "The name field is required.",
                        "The address field is required.",
                        "The phone field is required."
                    ]
                ]
            );
    }

    //TODO : Test with existing number or address

    public function testStoreWithInvalidArguments()
    {
        $this->json(
            'POST',
            '/api/gallery',
            [
                'name' => str_random(256),
                'address' => str_random(256),
                'phone' => str_random(256)
            ],
            [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        )
            ->assertStatus(400)
            ->assertJson([
                "error" => "validation_failed",
                "messages" => [
                    "The name may not be greater than 255 characters.",
                    "The address may not be greater than 255 characters.",
                    "The phone may not be greater than 255 characters.",
                ]
            ]);
    }

    public function testStoreWithValidArguments()
    {
        $name = 'TestName';
        $address = 'TestAddress';
        $phone = 'TestPhone';

        $this->json(
            'POST',
            '/api/gallery',
            [
                'name' => $name,
                'address' => $address,
                'phone' => $phone
            ],
            [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        )
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'name' => $name,
                    'address' => $address,
                    'phone' => $phone
                ],
            ]);

        $this->assertDatabaseHas('galleries', ['name' => $name, 'address' => $address, 'phone' => $phone]);
    }

    public function testStoreUnauthenticated()
    {
        $name = 'TestName';
        $address = 'TestAddress';
        $phone = 'TestPhone';

        $this->json(
            'POST',
            '/api/gallery',
            [
                'name' => $name,
                'address' => $address,
                'phone' => $phone
            ],
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        )

        ->assertStatus(401)
        ->assertJson(['message' => 'Unauthenticated.']);
    }

    //--------------------------
    //
    // TEST SHOW
    //
    //--------------------------

    public function testShowWithInvalidId()
    {
        $this->json(
            'GET',
            '/api/gallery/99999',
            [],
            [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]
        )
            ->assertStatus(404)
            ->assertJson([
                'error' => 'model_not_found',
                'message' => 'Gallery with such parameters does not exists.'
            ]);
    }

    public function testShowWithValidId()
    {
        $gallery = factory(Gallery::class)->create();
        $this->json(
            'GET',
            '/api/gallery/' . $gallery->id,
            [],
            [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]
        )
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $gallery->id,
                    'name' => $gallery->name,
                    'address' => $gallery->address,
                    'phone' => $gallery->phone
                ],
            ]);
    }

    public function testShowUnauthenticated()
    {
        $gallery = factory(Gallery::class)->create();
        $this->json(
            'GET',
            '/api/gallery/' . $gallery->id,
            [],
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]
        )
            ->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);
    }

    //--------------------------
    //
    // TEST UPDATE
    //
    //--------------------------
    
    public function testUpdateWithNonExistentArguments()
    {
        $gallery = factory(Gallery::class)->create();
        $this->json(
            'PATCH',
            '/api/gallery/' . $gallery->id,
            [],
            [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]
        )
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $gallery->id,
                    'name' => $gallery->name,
                    'address' => $gallery->address,
                    'phone' => $gallery->phone
                ],
            ]);
    }

    public function testUpdateWithInvalidArguments()
    {
        $gallery = factory(Gallery::class)->create();
        $this->json(
            'PATCH',
            '/api/gallery/' . $gallery->id,
            [
                'name' => str_random(256),
                'address' => str_random(256),
                'phone' => str_random(256)
            ],
            [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]
        )
            ->assertStatus(400)
            ->assertJson([
                "error" => "validation_failed",
                "messages" => [
                    "The name may not be greater than 255 characters.",
                    "The address may not be greater than 255 characters.",
                    "The phone may not be greater than 255 characters."
                ]
            ]);
    }

    //TODO : Test with existing number or address

    public function testUpdateWithValidArguments()
    {
        $name = 'testName';
        $address = 'testAddress';
        $phone = 'testPhone';
        $gallery = factory(Gallery::class)->create();
        $this->json(
            'PATCH',
            '/api/gallery/' . $gallery->id,
            [
                'name' => $name,
                'address' => $address,
                'phone' => $phone
            ],
            [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]
        )
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $gallery->id,
                    'name' => $name,
                    'address' => $address,
                    'phone' => $phone,
                ]
            ]);
    }

    public function testUpdateUnauthenticated()
    {
        $name = 'testName';
        $address = 'testAddress';
        $phone = 'testPhone';
        $gallery = factory(Gallery::class)->create();
        $this->json(
            'PATCH',
            '/api/gallery/' . $gallery->id,
            [
                'name' => $name,
                'address' => $address,
                'phone' => $phone
            ],
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]
        )
            ->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);
    }

    public function testDestroy()
    {
        $gallery = factory(Gallery::class)->create();
        $this->json(
            'DELETE',
            '/api/gallery/' . $gallery->id,
            [],
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->accessToken
            ]
        )
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Gallery deleted.',
            ]);
    }

    public function testDestroyUnauthenticated()
    {
        $gallery = factory(Gallery::class)->create();
        $this->json(
            'DELETE',
            '/api/gallery/' . $gallery->id,
            [],
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]
        )
            ->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.',
            ]);
    }
}
