<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Routing\Middleware\ThrottleRequests;
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
        $this->withoutMiddleware(
            ThrottleRequests::class
        );

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
                        'firstname' => $this->user->firstname,
                        'lastname' => $this->user->lastname,
                        'name' => $this->user->name,
                        'email' => $this->user->email,
                        'role' => $this->user->role,
                    ],
                    [
                        'id' => $secondUser->id,
                        'firstname' => $secondUser->firstname,
                        'lastname' => $secondUser->lastname,
                        'name' => $secondUser->name,
                        'email' => $secondUser->email,
                        'role' => $secondUser->role,

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

    public function testIndexSearchByFirstname()
    {
        $secondUser = factory(User::class)->create();
        $this->json(
            'GET',
            '/api/user',
            ['firstname' => $secondUser->firstname],
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
                        'firstname' => $secondUser->firstname,
                        'email' => $secondUser->email,
                    ]
                ]
            ]);
    }

    public function testIndexSearchByFirstnameUnValid()
    {
        $this->json(
            'GET',
            '/api/user',
            ['firstname' => 'Wrong Firstname'],
            [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        )
            ->assertStatus(200)
            ->assertJson(['data' => []]);
    }

    public function testIndexSearchByLastname()
    {
        $secondUser = factory(User::class)->create();
        $this->json(
            'GET',
            '/api/user',
            ['lastname' => $secondUser->lastname],
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
                        'lastname' => $secondUser->lastname,
                        'email' => $secondUser->email,
                    ]
                ]
            ]);
    }

    public function testIndexSearchByLastnameUnValid()
    {
        $this->json(
            'GET',
            '/api/user',
            ['lastname' => 'Wrong lastname'],
            [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        )
            ->assertStatus(200)
            ->assertJson(['data' => []]);
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

    public function testIndexSearchByRole()
    {
        $secondUser = factory(User::class)->create();
        $this->json(
            'GET',
            '/api/user',
            ['role' => $secondUser->role],
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
                        'firstname' => $this->user->firstname,
                        'lastname' => $this->user->lastname,
                        'name' => $this->user->name,
                        'role' => $this->user->role,
                        'email' => $this->user->email,
                    ],
                    [
                        'id' => $secondUser->id,
                        'firstname' => $secondUser->firstname,
                        'lastname' => $secondUser->lastname,
                        'name' => $secondUser->name,
                        'role' => $secondUser->role,
                        'email' => $secondUser->email,
                    ]
                ]
            ]);
    }

    public function testIndexSearchByRoleUnValid()
    {
        $this->json(
            'GET',
            '/api/user',
            ['role' => 'Wrong role'],
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
                'firstname' => $this->user->firstname,
                'lastname' => $this->user->lastname,
                'name' => $this->user->name,
                'email' => $secondUser->email,
                'role' => $secondUser->role
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
                    "error" => "validation_failed",
                    "messages" => [
                        "The name field is required.",
                        "The firstname field is required.",
                        "The lastname field is required.",
                        "The email field is required.",
                        "The password field is required."
                    ]
                ]
            );
    }

    public function testStoreWithInvalidArguments()
    {
        $this->json(
            'POST',
            '/api/user',
            [
                'firstname' => str_random(256),
                'lastname' => str_random(256),
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
                "error" => "validation_failed",
                "messages" => [
                    "The name may not be greater than 255 characters.",
                    "The firstname may not be greater than 255 characters.",
                    "The lastname may not be greater than 255 characters.",
                    "The email must be a valid email address.",
                    "The email may not be greater than 255 characters.",
                    "The password must be at least 6 characters.",
                ]
            ]);
    }

    public function testStoreWithExistingEmail()
    {
        $this->json(
            'POST',
            '/api/user',
            [
                'firstname' => str_random(10),
                'lastname' => str_random(10),
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
                "error" => "validation_failed",
                "messages" => [
                    "The email has already been taken.",
                ]
            ]);
    }

    public function testStoreWithValidArguments()
    {
        $firstname = 'TestFirstname';
        $lastname = 'TestLastname';
        $name = 'TestName';
        $email = 'test@example.com';
        $password = 'TestPassword';

        $this->json(
            'POST',
            '/api/user',
            [
                'firstname' => $firstname,
                'lastname' => $lastname,
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
                'data' => [
                    'firstname' => $firstname,
                    'lastname' => $lastname,
                    'name' => $name,
                    'email' => $email,
                    'role' => 'admin'
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
                    'firstname' => $this->user->firstname,
                    'lastname' => $this->user->lastname,
                    'name' => $this->user->name,
                    'email' => $this->user->email,
                    'role' => $this->user->role
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
                    'firstname' => $this->user->firstname,
                    'lastname' => $this->user->lastname,
                    'name' => $this->user->name,
                    'email' => $this->user->email,
                    'role' => $this->user->role
                ],
            ]);
    }

    public function testUpdateWithInvalidArguments()
    {
        $this->json(
            'PATCH',
            '/api/user',
            [
                'firstname' => str_random(256),
                'lastname' => str_random(256),
                'name' => str_random(256),
                'email' => str_random(256),
                'role' => str_random(256),
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
                "error" => "validation_failed",
                "messages" => [
                    "The name may not be greater than 255 characters.",
                    "The firstname may not be greater than 255 characters.",
                    "The lastname may not be greater than 255 characters.",
                    "The role may not be greater than 255 characters.",
                    "The email must be a valid email address.",
                    "The email may not be greater than 255 characters.",
                    "The password must be at least 6 characters.",
                ]
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
                "error" => "validation_failed",
                "messages" => [
                    "The email has already been taken.",
                ]
            ]);
    }

    public function testUpdateWithValidArguments()
    {
        $firstname = 'TestFirstname';
        $lastname = 'TestLastname';
        $name = 'TestName';
        $email = 'test@example.com';
        $role = 'test';
        $password = 'TestPassword';

        $this->json(
            'PATCH',
            '/api/user',
            [
                'firstname' => $firstname,
                'lastname' => $lastname,
                'name' => $name,
                'email' => $email,
                'role' => $role,
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
                    'id' => $this->user->id,
                    'firstname' => $firstname,
                    'lastname' => $lastname,
                    'name' => $name,
                    'role' => $role,
                    'email' => $email,
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
