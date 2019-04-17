<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Artwork;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\ClientRepository;
use Faker\Provider\Image;
use Illuminate\Http\UploadedFile;

class ArtworkControllerTest extends TestCase
{
    private $clientRepository;
    private $userPassword;
    private $user;
    private $accessToken;
    private $artworks;

    use RefreshDatabase;

    public function __construct()
    {
        parent::__construct();
        $this->clientRepository = new ClientRepository();
        $this->userPassword = 'ArtistControllerTest';
    }

    protected function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create(['password' => bcrypt($this->userPassword)]);
        $this->artworks = factory(Artwork::class, 1)->create(['user_id' => $this->user->id]);

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
        $this->artworks = null;
        $this->accessToken = null;
    }

    public function testIndex()
    {
        $this->json(
            'GET',
            '/api/artwork',
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
                        'id' => $this->artworks[0]->id,
                        'name' => $this->artworks[0]->name,
                        'price' => $this->artworks[0]->price,
                        'ref' => $this->artworks[0]->ref,
                        'state' => $this->artworks[0]->state,
                        'images' => $this->artworks[0]->images,
                    ],
                ]
            ]);
    }

    public function testIndexUnAuthenticated()
    {
        $this->json(
            'GET',
            '/api/artwork',
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
        $this->json(
            'GET',
            '/api/artwork',
            ['name' => $this->artworks[0]->name],
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
                        'id' => $this->artworks[0]->id,
                        'name' => $this->artworks[0]->name,
                        'price' => $this->artworks[0]->price,
                        'ref' => $this->artworks[0]->ref,
                        'state' => $this->artworks[0]->state,
                        'images' => $this->artworks[0]->images,
                    ],
                ]
            ]);
    }

    public function testIndexSearchInvalidName()
    {
        $this->json(
            'GET',
            '/api/artwork',
            ['name' => 'Most certainly not a good name'],
            [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        )
            ->assertStatus(200)
            ->assertJson([
                'data' => []
            ]);
    }

    public function testIndexSearchByPriceRange()
    {
        $this->json(
            'GET',
            '/api/artwork',
            ['price_min' => $this->artworks[0]->price, 'price_max' => $this->artworks[0]->price],
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
                        'id' => $this->artworks[0]->id,
                        'name' => $this->artworks[0]->name,
                        'price' => $this->artworks[0]->price,
                        'ref' => $this->artworks[0]->ref,
                        'state' => $this->artworks[0]->state,
                        'images' => $this->artworks[0]->images,
                    ],
                ]
            ]);
    }

    public function testIndexSearchInvalidPriceRange()
    {
        $this->json(
            'GET',
            '/api/artwork',
            ['price_min' => 10000, 'price_max' => -100],
            [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        )
            ->assertStatus(200)
            ->assertJson([
                'data' => []
            ]);
    }

    public function testIndexSearchByReference()
    {
        $this->json(
            'GET',
            '/api/artwork',
            ['ref' => $this->artworks[0]->ref],
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
                        'id' => $this->artworks[0]->id,
                        'name' => $this->artworks[0]->name,
                        'price' => $this->artworks[0]->price,
                        'ref' => $this->artworks[0]->ref,
                        'state' => $this->artworks[0]->state,
                        'images' => $this->artworks[0]->images,
                    ],
                ]
            ]);
    }

    public function testIndexSearchInvalidRef()
    {
        $this->json(
            'GET',
            '/api/artwork',
            ['ref' => 'Not a good ref'],
            [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        )
            ->assertStatus(200)
            ->assertJson([
                'data' => []
            ]);
    }

    public function testIndexSearchByState()
    {
        $this->json(
            'GET',
            '/api/artwork',
            ['state' => $this->artworks[0]->state],
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
                        'id' => $this->artworks[0]->id,
                        'name' => $this->artworks[0]->name,
                        'price' => $this->artworks[0]->price,
                        'ref' => $this->artworks[0]->ref,
                        'state' => $this->artworks[0]->state,
                        'images' => $this->artworks[0]->images,
                    ],
                ]
            ]);
    }

    public function testIndexSearchInvalidState()
    {
        $this->json(
            'GET',
            '/api/artwork',
            ['state' => "That's not a state"],
            [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        )
            ->assertStatus(400)
            ->assertJson([
                'error' => "validation_failed",
                "messages" => ["The selected state is invalid."]
            ]);
    }

    public function testStoreWithNonExistentArguments()
    {
        $this->json(
            'POST',
            '/api/artwork',
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
                        "The price field is required.",
                        "The ref field is required.",
                        "The state field is required.",
                    ]
                ]

            );
    }

    public function testStoreWithInvalidArguments()
    {
        $this->json(
            'POST',
            '/api/artwork',
            [
                'name' => str_random(256),
                'price' => 123456,
                'state' => str_random(256),
                'ref' => str_random(256),
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
                    "The ref may not be greater than 255 characters.",
                    "The selected state is invalid."
                ]
            ]);
    }

    public function testStore()
    {
        $name = str_random(128);
        $price = 145678;
        $ref = str_random(128);

        $this->json(
            'POST',
            '/api/artwork',
            [
                'name' => $name,
                'price' => $price,
                'ref' => $ref,
                'state' => Artwork::STATE_INCOMING,
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
                    'price' => $price,
                    'ref' => $ref,
                    'state' => Artwork::STATE_INCOMING,
                    'images' => []
                ]
            ]);
        $this->assertDatabaseHas('artworks', [
            'name' => $name,
            'price' => $price,
            'state' => Artwork::STATE_INCOMING,
            'ref' => $ref
        ]);
    }

    public function testStore_Invalid_State()
    {
        $name = str_random(128);
        $price = 145678;
        $ref = str_random(128);

        $this->json(
            'POST',
            '/api/artwork',
            [
                'name' => $name,
                'price' => $price,
                'ref' => $ref,
                'state' => "Invalid State Format",
            ],
            [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        )
            ->assertStatus(400);
    }

    public function testStore_Unauthenticated()
    {
        $this->json(
            'POST',
            '/api/artwork',
            [],
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        )
            ->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);
    }

    public function testShow()
    {
        $this->json(
            'GET',
            '/api/artwork/' . $this->artworks[0]->id,
            [],
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->accessToken,
            ]
        )
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name' => $this->artworks[0]->name,
                    'price' => $this->artworks[0]->price,
                    'ref' => $this->artworks[0]->ref,
                    'state' => Artwork::STATE_IN_STOCK,
                    'images' => []
                ]
            ]);
    }

    public function testShowInvalidId()
    {
        $this->json(
            'GET',
            '/api/artwork/' . 9876,
            [],
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->accessToken,
            ]
        )
            ->assertStatus(404);
    }

    public function testShowUnauthenticated()
    {
        $this->json(
            'GET',
            '/api/artwork/' . $this->artworks[0]->id,
            [],
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]
        )
            ->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);
    }

    public function testShowOtherUserArtwork()
    {
        $secondUser = factory(User::class)->create();
        $artwork = factory(Artwork::class)->create(['user_id' => $secondUser->id]);

        $this->json(
            'GET',
            '/api/artwork/' . $artwork->id,
            [],
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->accessToken,
            ]
        )
            ->assertStatus(403)
            ->assertJson([
                'error' => 'unauthorized',
                'message' => 'The current user does not own this artwork.'
            ]);
    }

    public function testUpdateWithNonExistentArguments()
    {
        $this->json(
            'PATCH',
            '/api/artwork/' . $this->artworks[0]->id,
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
                    'name' => $this->artworks[0]->name,
                    'price' => $this->artworks[0]->price,
                    'ref' => $this->artworks[0]->ref,
                    'state' => Artwork::STATE_IN_STOCK,
                    'images' => []
                ]
            ]);
    }

    public function testStoreImage()
    {
        $images = [
            UploadedFile::fake()->image('/home/alexis/Pictures/godwin.png')
        ];
        $this->json(
            'POST',
            '/api/artwork/' . $this->artworks[0]->id . '/image',
            [
                'images' => $images
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
                    'name' => $this->artworks[0]->name,
                    'price' => $this->artworks[0]->price,
                    'ref' => $this->artworks[0]->ref,
                    'state' => Artwork::STATE_IN_STOCK,
                    'images' => []
                ]
            ]);
    }
}
