<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\ClientRepository;
use Tests\TestCase;

class UserControllerTest extends TestCase
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

    public function testIndex()
    {
        $secondUser = factory(User::class)->create();

        $this->json(
            'GET',
            '/api/user',
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
                    'id' => $this->user->id,
                    'name' => $this->user->name,
                    'email' => $this->user->email,
                ],
                [
                    'id' => $secondUser->id,
                    'name' => $secondUser->name,
                    'email' => $secondUser->email,
                ]
            ]
        ]);
    }

    public function testIndexUnAuthenticated()
    {
        $this->json(
            'GET',
            '/api/user',
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
        $secondUser = factory(User::class)->create();
        $this->json(
            'GET',
            '/api/user',
            ['name' => $secondUser->name],
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
                        'id' => $secondUser->id,
                        'name' => $secondUser->name,
                        'email' => $secondUser->email,
                    ]
                ]
            ]);
    }

    public function testIndexSearchByNameUnValid()
    {
        $this->json(
            'GET',
            '/api/user',
            ['name' => 'Wrong Name'],
            [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        )
            ->assertStatus(200)
            ->assertJson(['data' => []]);
    }

    public function testIndexSearchByEmail()
    {
        $secondUser = factory(User::class)->create();
        $this->json(
            'GET',
            '/api/user',
            ['email' => $secondUser->email],
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
                        'id' => $secondUser->id,
                        'name' => $secondUser->name,
                        'email' => $secondUser->email,
                    ]
                ]
            ]);
    }

    public function testIndexSearchByEmailUnValid()
    {
        $this->json(
            'GET',
            '/api/user',
            ['email' => 'wrong.email@example.com'],
            [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        )
            ->assertStatus(200)
            ->assertJson(['data' => []]);
    }

    public function testIndexSearchByAll()
    {
        $secondUser = factory(User::class)->create();
        $this->json(
            'GET',
            '/api/user',
            ['all' => $secondUser->name],
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
                        'id' => $secondUser->id,
                        'name' => $secondUser->name,
                        'email' => $secondUser->email,
                    ]
                ]
            ]);
    }

    public function testIndexSearchByAllUnValid()
    {
        $this->json(
            'GET',
            '/api/user',
            ['all' => 'Wrong all'],
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
        $secondUser = factory(User::class)->create();
        $this->json(
            'GET',
            '/api/user',
            [
                'all' => $secondUser->name,
                'name' => $this->user->name
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
                        'id' => $this->user->id,
                        'name' => $this->user->name,
                        'email' => $this->user->email,
                    ],
                    [
                        'id' => $secondUser->id,
                        'name' => $secondUser->name,
                        'email' => $secondUser->email,
                    ]
                ]
            ]);
    }

    public function testStoreWithNonExistentArguments()
    {
        $this->json(
            'POST',
            '/api/user',
            [],
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        )
            ->assertStatus(400)
            ->assertJson(
                [
                    "The name field is required.",
                    "The email field is required.",
                    "The password field is required.",
                ]
            );
    }

    public function testStoreWithInvalidArguments()
    {
        $this->json(
            'POST',
            '/api/user',
            [
                'name' => str_random(256),
                'email' => str_random(256),
                'password' => str_random(4)
            ],
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        )
            ->assertStatus(400)
            ->assertJson([
                "The name may not be greater than 255 characters.",
                "The email must be a valid email address.",
                "The email may not be greater than 255 characters.",
                "The password must be at least 6 characters.",
            ]);
    }

    public function testStoreWithExistingEmail()
    {
        $this->json(
            'POST',
            '/api/user',
            [
                'name' => str_random(10),
                'email' => $this->user->email,
                'password' => str_random(6)
            ],
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        )
            ->assertStatus(400)
            ->assertJson([
                "The email has already been taken.",
            ]);
    }

    public function testStoreWithValidArguments()
    {
        $name = 'TestName';
        $email = 'test@example.com';
        $password = 'TestPassword';

        $this->json(
            'POST',
            '/api/user',
            [
                'name' => $name,
                'email' => $email,
                'password' => $password
            ],
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        )
            ->assertStatus(201)
            ->assertJson([
                "data" => [
                    "name" => $name,
                    "email" => $email,
                ],
            ]);

        $this->assertDatabaseHas('users', ['name' => $name, 'email' => $email]);
    }

    public function testShowWithInvalidId()
    {
        $this->json(
            'GET',
            '/api/user/99999',
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
                'message' => 'User with such parameters does not exists.'
            ]);
    }

    public function testShowWithValidId()
    {
        $this->json(
            'GET',
            '/api/user/' . $this->user->id,
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
                    'id' => $this->user->id,
                    'email' => $this->user->email,
                    'name' => $this->user->name
                ],
            ]);
    }

    public function testShowUnauthenticated()
    {
        $this->json(
            'GET',
            '/api/user/' . $this->user->id,
            [],
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]
        )
            ->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);
    }

    public function testUpdateWithNonExistentArguments()
    {
        $this->json(
            'PATCH',
            '/api/user',
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
                    'id' => $this->user->id,
                    'email' => $this->user->email,
                    'name' => $this->user->name
                ],
            ]);
    }

    public function testUpdateWithInvalidArguments()
    {
        $this->json(
            'PATCH',
            '/api/user',
            [
                'name' => str_random(256),
                'email' => str_random(256),
                'password' => str_random(4)
            ],
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->accessToken,
            ]
        )
            ->assertStatus(400)
            ->assertJson([
                "The name may not be greater than 255 characters.",
                "The email must be a valid email address.",
                "The email may not be greater than 255 characters.",
                "The password must be at least 6 characters.",
            ]);
    }

    public function testUpdateWithExistingEmail()
    {
        $secondUser = factory(User::class)->create();

        $this->json(
            'PATCH',
            '/api/user',
            [
                'email' => $secondUser->email,
            ],
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->accessToken
            ]
        )
            ->assertStatus(400)
            ->assertJson([
                "The email has already been taken.",
            ]);
    }

    public function testUpdateWithValidArguments()
    {
        $name = 'TestName';
        $email = 'test@example.com';
        $password = 'TestPassword';

        $this->json(
            'PATCH',
            '/api/user',
            [
                'name' => $name,
                'email' => $email,
                'password' => $password
            ],
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->accessToken
            ]
        )
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name' => $name,
                    'email' => $email,
                    'id' => $this->user->id,
                ]
            ]);

        $this->assertDatabaseHas('users', ['name' => $name, 'email' => $email]);
    }

    public function testUpdateUnauthenticated()
    {
        $name = 'TestName';
        $email = 'test@example.com';
        $password = 'TestPassword';

        $this->json(
            'PATCH',
            '/api/user',
            [
                'name' => $name,
                'email' => $email,
                'password' => $password
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
        $this->json(
            'DELETE',
            '/api/user',
            [],
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->accessToken
            ]
        )
            ->assertStatus(200)
            ->assertJson([
                'message' => 'User deleted.',
            ]);
    }

    public function testDestroyUnauthenticated()
    {
        $this->json(
            'DELETE',
            '/api/user',
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
