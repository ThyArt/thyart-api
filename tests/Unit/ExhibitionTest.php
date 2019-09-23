<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Http\Resources\MediaResource;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Spatie\MediaLibrary\Models\Media;
use App\Exhibition;
use App\User;
use App\Gallery;
use Laravel\Passport\ClientRepository;
use Faker\Provider\DateTime as FakeDate;


class ExhibitionTest extends TestCase
{
    private $clientRepository;
    private $userPassword;
    private $user;
    private $gallery;
    private $accessToken;
    private $customers;

    use RefreshDatabase;

    public function __construct()
    {
        parent::__construct();
        $this->clientRepository = new ClientRepository();
        $this->userPassword = 'ExhibitionControllerTest';
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(
            ThrottleRequests::class
        );

        $this->seed('PermissionsAndRolesTableSeeder');
        $this->gallery = factory(Gallery::class)->create();
        $this->user = factory(User::class)->create(
            [
                'password' => bcrypt($this->userPassword),
                'gallery_id' => $this->gallery->id,
                'role' => 'admin'
            ]
        );
        $this->user->assignRole('admin');
        $this->exhibition = factory(Exhibition::class)->create(['gallery_id' => $this->gallery->id]);

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

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->user = null;
        $this->exhibitionss = null;
        $this->accessToken = null;
    }

    ////////////////
    //
    //    INDEX
    //
    ////////////////

    public function testIndexUnAuthenticated()
    {
        $this->json(
            'GET',
            '/api/exhibition',
            [],
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        )
            ->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);
    }


    public function testIndex()
    {
        $this->json(
            'GET',
            '/api/exhibition',
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
                        'id' => $this->exhibition->id,
                        'name' => $this->exhibition->name,
                        'begin' => $this->exhibition->begin,
                        'end' => $this->exhibition->end,
                    ],
                ]
            ]);
    }

    public function testIndexSearchByValidName()
    {
        $this->json(
            'GET',
            '/api/exhibition',
            ['name' => $this->exhibition->name],
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
                        'id' => $this->exhibition->id,
                        'name' => $this->exhibition->name,
                        'begin' => $this->exhibition->begin,
                        'end' => $this->exhibition->end,
                    ]
                ]
            ]);
    }

    public function testIndexSearchByNonValidName()
    {
        $this->json(
            'GET',
            '/api/exhibition',
            ['name' => "nonvalide"],
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

        public function testIndexSearchByValidId()
    {
        $this->json(
            'GET',
            '/api/exhibition',
            ['id' => $this->exhibition->id],
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
                        'id' => $this->exhibition->id,
                        'name' => $this->exhibition->name,
                        'begin' => $this->exhibition->begin,
                        'end' => $this->exhibition->end,
                    ]
                ]
            ]);
    }

    public function testIndexSearchByNonValidId()
    {
        $this->json(
            'GET',
            '/api/exhibition',
            ['id' => "9999"],
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

        public function testIndexSearchByValidBegin()
    {
        $this->json(
            'GET',
            '/api/exhibition',
            ['begin' => $this->exhibition->begin],
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
                        'id' => $this->exhibition->id,
                        'name' => $this->exhibition->name,
                        'begin' => $this->exhibition->begin,
                        'end' => $this->exhibition->end,
                    ]
                ]
            ]);
    }

    public function testIndexSearchByNonValidBegin()
    {
        $this->json(
            'GET',
            '/api/exhibition',
            ['begin' => "111-11-11"],
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

        public function testIndexSearchByValidEnd()
    {
        $this->json(
            'GET',
            '/api/exhibition',
            ['end' => $this->exhibition->end],
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
                        'id' => $this->exhibition->id,
                        'name' => $this->exhibition->name,
                        'begin' => $this->exhibition->begin,
                        'end' => $this->exhibition->end,
                    ]
                ]
            ]);
    }

    public function testIndexSearchByNonValidEnd()
    {
        $this->json(
            'GET',
            '/api/exhibition',
            ['end' => "111-11-11"],
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

////////////////
//
//    STORE
//
////////////////

    public function testStoreWithNonExistentArguments()
    {
        $this->json(
            'POST',
            '/api/exhibition',
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
                        "The begin field is required.",
                        "The end field is required.",
                    ]
                ]
            );
    }

    public function testStoreWithInvalidArguments()
    {
        $this->json(
            'POST',
            '/api/exhibition',
            [
                'name' => str_random(256),
                'begin' => '11',
                'end' => '11',
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
                    "The begin is not a valid date.",
                    "The end is not a valid date.",
                    "The end must be a date after begin."
                ]
            ]);
    }

    public function testStoreWithValidArguments()
    {
        $this->json(
            'POST',
            '/api/exhibition',
            [
                'name' => 'jerome',
                'begin' => '2015-05-05',
                'end' => '2015-05-06',
            ],
            [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        )
            ->assertStatus(201)
            ->assertJson([
                "data" => [
                    'name' => 'jerome',
                    'begin' => '2015-05-05',
                    'end' => '2015-05-06',
                ],
            ]);
    }


    public function testStoreUnAuthenticated()
    {
        $this->json(
            'POST',
            '/api/exhibition',
            [],
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        )
            ->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);
    }

    ////////////////
    //
    //    SHOW
    //
    ////////////////

    public function testShowWithInvalidId()
    {
        $this->json(
            'GET',
            '/api/exhibition/99999',
            [],
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->accessToken,
            ]
        )
            ->assertStatus(404)
            ->assertJson([
                'error' => 'model_not_found',
                'message' => 'Exhibition with such parameters does not exists.'
            ]);
    }

    public function testShowUnauthenticated()
    {
        $this->json(
            'GET',
            '/api/exhibition/' . $this->exhibition->id,
            [],
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]
        )
            ->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);
    }

    ////////////////
    //
    //    DELETE
    //
    ////////////////


    public function testDeleteWithInvalidId()
    {
        $this->json(
            'DELETE',
            '/api/exhibition/99999',
            [],
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->accessToken,
            ]
        )
            ->assertStatus(404)
            ->assertJson([
                'error' => 'model_not_found',
                'message' => 'Exhibition with such parameters does not exists.'
            ]);
    }

    public function testDeleteWithValidId()
    {
        $this->json(
            'DELETE',
            '/api/exhibition/' . $this->exhibition->id,
            [],
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->accessToken,
            ]
        )
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Exhibition deleted.'
            ]);

    }

    public function testDeleteUnauthenticated()
    {
        $this->json(
            'DELETE',
            '/api/exhibition/' . $this->exhibition->id,
            [],
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]
        )
            ->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);
    }
}
