<?php

namespace Tests\Unit;

use App\Customer;
use App\User;
use App\Gallery;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Laravel\Passport\ClientRepository;
use Tests\TestCase;

class CustomerControllerTest extends TestCase
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
        $this->userPassword = 'CustomerControllerTest';
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
        $this->customers = factory(Customer::class, 2)->create(['gallery_id' => $this->gallery->id]);

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
        $this->customer = null;
        $this->accessToken = null;
    }


    public function testIndex()
    {
        $this->json(
            'GET',
            '/api/customer',
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
                        'id' => $this->customers[0]->id,
                        'first_name' => $this->customers[0]->first_name,
                        'last_name' => $this->customers[0]->last_name,
                        'phone' => $this->customers[0]->phone,
                        'email' => $this->customers[0]->email,
                        'address' => $this->customers[0]->address,
                        'city' => $this->customers[0]->city,
                        'country' => $this->customers[0]->country
                    ],
                    [
                        'id' => $this->customers[1]->id,
                        'first_name' => $this->customers[1]->first_name,
                        'last_name' => $this->customers[1]->last_name,
                        'phone' => $this->customers[1]->phone,
                        'email' => $this->customers[1]->email,
                        'address' => $this->customers[1]->address,
                        'city' => $this->customers[1]->city,
                        'country' => $this->customers[1]->country
                    ]
                ]
            ]);
    }

    public function testIndexUnAuthenticated()
    {
        $this->json(
            'GET',
            '/api/customer',
            [],
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        )
            ->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);
    }

    public function testIndexSearchByFirstName()
    {
        $this->json(
            'GET',
            '/api/customer',
            ['first_name' => $this->customers[0]->first_name],
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
                        'id' => $this->customers[0]->id,
                        'first_name' => $this->customers[0]->first_name,
                        'last_name' => $this->customers[0]->last_name,
                        'phone' => $this->customers[0]->phone,
                        'email' => $this->customers[0]->email,
                        'address' => $this->customers[0]->address,
                        'city' => $this->customers[0]->city,
                        'country' => $this->customers[0]->country
                    ]
                ]
            ]);
    }

    public function testIndexSearchByNonValidFirstName()
    {
        $this->json(
            'GET',
            '/api/customer',
            ['first_name' => 'Wrong FirstName'],
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

    public function testIndexSearchByLastName()
    {
        $this->json(
            'GET',
            '/api/customer',
            ['last_name' => $this->customers[0]->last_name],
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
                        'id' => $this->customers[0]->id,
                        'first_name' => $this->customers[0]->first_name,
                        'last_name' => $this->customers[0]->last_name,
                        'phone' => $this->customers[0]->phone,
                        'email' => $this->customers[0]->email,
                        'address' => $this->customers[0]->address,
                        'city' => $this->customers[0]->city,
                        'country' => $this->customers[0]->country
                    ]
                ]
            ]);
    }

    public function testIndexSearchByNonValidLastName()
    {
        $this->json(
            'GET',
            '/api/customer',
            ['last_name' => 'Wrong LastName'],
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

    public function testIndexSearchByPhone()
    {
        $this->json(
            'GET',
            '/api/customer',
            ['phone' => $this->customers[0]->phone],
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
                        'id' => $this->customers[0]->id,
                        'first_name' => $this->customers[0]->first_name,
                        'last_name' => $this->customers[0]->last_name,
                        'phone' => $this->customers[0]->phone,
                        'email' => $this->customers[0]->email,
                        'address' => $this->customers[0]->address,
                        'city' => $this->customers[0]->city,
                        'country' => $this->customers[0]->country
                    ]
                ]
            ]);
    }

    public function testIndexSearchByNonValidPhone()
    {
        $this->json(
            'GET',
            '/api/customer',
            ['phone' => 'Wrong Phone'],
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

    public function testIndexSearchByEmail()
    {
        $this->json(
            'GET',
            '/api/customer',
            ['email' => $this->customers[0]->email],
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
                        'id' => $this->customers[0]->id,
                        'first_name' => $this->customers[0]->first_name,
                        'last_name' => $this->customers[0]->last_name,
                        'phone' => $this->customers[0]->phone,
                        'email' => $this->customers[0]->email,
                        'address' => $this->customers[0]->address,
                        'city' => $this->customers[0]->city,
                        'country' => $this->customers[0]->country
                    ]
                ]
            ]);
    }

    public function testIndexSearchByNonValidEmail()
    {
        $this->json(
            'GET',
            '/api/customer',
            ['email' => 'Wrong Email'],
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

    public function testIndexSearchByAddress()
    {
        $this->json(
            'GET',
            '/api/customer',
            ['address' => $this->customers[0]->address],
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
                        'id' => $this->customers[0]->id,
                        'first_name' => $this->customers[0]->first_name,
                        'last_name' => $this->customers[0]->last_name,
                        'phone' => $this->customers[0]->phone,
                        'email' => $this->customers[0]->email,
                        'address' => $this->customers[0]->address,
                        'city' => $this->customers[0]->city,
                        'country' => $this->customers[0]->country
                    ]
                ]
            ]);
    }

    public function testIndexSearchByNonValidAddress()
    {
        $this->json(
            'GET',
            '/api/customer',
            ['address' => 'Wrong Address'],
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

    public function testIndexSearchByCity()
    {
        $this->json(
            'GET',
            '/api/customer',
            ['city' => $this->customers[0]->city],
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
                        'id' => $this->customers[0]->id,
                        'first_name' => $this->customers[0]->first_name,
                        'last_name' => $this->customers[0]->last_name,
                        'phone' => $this->customers[0]->phone,
                        'email' => $this->customers[0]->email,
                        'address' => $this->customers[0]->address,
                        'city' => $this->customers[0]->city,
                        'country' => $this->customers[0]->country
                    ]
                ]
            ]);
    }

    public function testIndexSearchByNonValidCity()
    {
        $this->json(
            'GET',
            '/api/customer',
            ['city' => 'Wrong City'],
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

    public function testIndexSearchByCountry()
    {
        $this->json(
            'GET',
            '/api/customer',
            ['country' => $this->customers[0]->country],
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
                        'id' => $this->customers[0]->id,
                        'first_name' => $this->customers[0]->first_name,
                        'last_name' => $this->customers[0]->last_name,
                        'phone' => $this->customers[0]->phone,
                        'email' => $this->customers[0]->email,
                        'address' => $this->customers[0]->address,
                        'city' => $this->customers[0]->city,
                        'country' => $this->customers[0]->country
                    ]
                ]
            ]);
    }

    public function testIndexSearchByNonValidCountry()
    {
        $this->json(
            'GET',
            '/api/customer',
            ['country' => 'Wrong Country'],
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

    public function testIndexWithOtherGallery()
    {
        $secondGallery = factory(Gallery::class)->create();
        factory(Customer::class, 2)->create(['gallery_id' => $secondGallery->id]);

        $this->json(
            'GET',
            '/api/customer',
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
                        'id' => $this->customers[0]->id,
                        'first_name' => $this->customers[0]->first_name,
                        'last_name' => $this->customers[0]->last_name,
                        'phone' => $this->customers[0]->phone,
                        'email' => $this->customers[0]->email,
                        'address' => $this->customers[0]->address,
                        'city' => $this->customers[0]->city,
                        'country' => $this->customers[0]->country
                    ],
                    [
                        'id' => $this->customers[1]->id,
                        'first_name' => $this->customers[1]->first_name,
                        'last_name' => $this->customers[1]->last_name,
                        'phone' => $this->customers[1]->phone,
                        'email' => $this->customers[1]->email,
                        'address' => $this->customers[1]->address,
                        'city' => $this->customers[1]->city,
                        'country' => $this->customers[1]->country
                    ]
                ]
            ]);
    }

    public function testStoreWithNonExistentArguments()
    {
        $this->json(
            'POST',
            '/api/customer',
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
                        "The first name field is required.",
                        "The last name field is required.",
                        "The email field is required.",
                        "The phone field is required.",
                        "The address field is required.",
                        "The city field is required.",
                        "The country field is required.",
                    ]
                ]
            );
    }

    public function testStoreWithInvalidArguments()
    {
        $this->json(
            'POST',
            '/api/customer',
            [
                'first_name' => str_random(256),
                'last_name' => str_random(256),
                'email' => str_random(256),
                'phone' => str_random(256),
                'address' => str_random(256),
                'city' => str_random(256),
                'country' => str_random(256),
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
                    "The first name may not be greater than 255 characters.",
                    "The last name may not be greater than 255 characters.",
                    "The email must be a valid email address.",
                    "The email may not be greater than 255 characters.",
                    "The phone field contains an invalid number.",
                    "The address may not be greater than 255 characters.",
                    "The city may not be greater than 255 characters.",
                    "The country may not be greater than 255 characters."
                ]
            ]);
    }

    public function testStoreWithValidArguments()
    {
        $firstName = 'firstName';
        $lastName = 'lastName';
        $email = 'email@example.com';
        $phone = '+33612345678';
        $address = 'address';
        $city = 'city';
        $country = 'country';

        $this->json(
            'POST',
            '/api/customer',
            [
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'phone' => $phone,
                'address' => $address,
                'city' => $city,
                'country' => $country
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
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'email' => $email,
                    'phone' => $phone,
                    'address' => $address,
                    'city' => $city,
                    'country' => $country
                ],
            ]);

        $this->assertDatabaseHas('customers', [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'phone' => $phone,
            'address' => $address,
            'city' => $city,
            'country' => $country]);
    }

    public function testStoreUnAuthenticated()
    {
        $this->json(
            'POST',
            '/api/customer',
            [],
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        )
            ->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);
    }

    public function testShowWithInvalidId()
    {
        $this->json(
            'GET',
            '/api/customer/99999',
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
                'message' => 'Customer with such parameters does not exists.'
            ]);
    }

    public function testShowWithValidId()
    {
        $this->json(
            'GET',
            '/api/customer/' . $this->customers[0]->id,
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
                    'id' => $this->customers[0]->id,
                    'first_name' => $this->customers[0]->first_name,
                    'last_name' => $this->customers[0]->last_name,
                    'phone' => $this->customers[0]->phone,
                    'email' => $this->customers[0]->email,
                    'address' => $this->customers[0]->address,
                    'city' => $this->customers[0]->city,
                    'country' => $this->customers[0]->country
                ],
            ]);
    }

    public function testShowUnauthenticated()
    {
        $this->json(
            'GET',
            '/api/customer/' . $this->customers[0]->id,
            [],
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]
        )
            ->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);
    }

    public function testShowOtherGalleryCustomer()
    {
        $secondGallery = factory(Gallery::class)->create();
        $customer = factory(Customer::class)->create(['gallery_id' => $secondGallery->id]);

        $this->json(
            'GET',
            '/api/customer/' . $customer->id,
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
                'message' => 'The current gallery does not own this customer.'
            ]);
    }

    public function testUpdateWithNonExistentArguments()
    {
        $this->json(
            'PATCH',
            '/api/customer/' . $this->customers[0]->id,
            [],
            [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        )
            ->assertStatus(200)
            ->assertJson(
                [
                    'data' => [
                        'id' => $this->customers[0]->id,
                        'first_name' => $this->customers[0]->first_name,
                        'last_name' => $this->customers[0]->last_name,
                        'phone' => $this->customers[0]->phone,
                        'email' => $this->customers[0]->email,
                        'address' => $this->customers[0]->address,
                        'city' => $this->customers[0]->city,
                        'country' => $this->customers[0]->country
                    ]]
            );
    }

    public function testUpdateWithInvalidArguments()
    {
        $this->json(
            'PATCH',
            '/api/customer/' . $this->customers[0]->id,
            [
                'first_name' => str_random(256),
                'last_name' => str_random(256),
                'email' => str_random(256),
                'phone' => str_random(256),
                'address' => str_random(256),
                'city' => str_random(256),
                'country' => str_random(256),
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
                    "The first name may not be greater than 255 characters.",
                    "The last name may not be greater than 255 characters.",
                    "The email must be a valid email address.",
                    "The email may not be greater than 255 characters.",
                    "The phone field contains an invalid number.",
                    "The address may not be greater than 255 characters.",
                    "The city may not be greater than 255 characters.",
                    "The country may not be greater than 255 characters."
                ]
            ]);
    }

    public function testUpdateWithValidArguments()
    {
        $firstName = 'firstName';
        $lastName = 'lastName';
        $email = 'email@example.com';
        $phone = '+33612345678';
        $address = 'address';
        $city = 'city';
        $country = 'country';

        $this->json(
            'PATCH',
            '/api/customer/' . $this->customers[0]->id,
            [
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'phone' => $phone,
                'address' => $address,
                'city' => $city,
                'country' => $country
            ],
            [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        )
            ->assertStatus(200)
            ->assertJson([
                "data" => [
                    'id' => $this->customers[0]->id,
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'email' => $email,
                    'phone' => $phone,
                    'address' => $address,
                    'city' => $city,
                    'country' => $country
                ],
            ]);

        $this->assertDatabaseHas('customers', [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'phone' => $phone,
            'address' => $address,
            'city' => $city,
            'country' => $country]);
    }

    public function testUpdateUnAuthenticated()
    {
        $this->json(
            'PATCH',
            '/api/customer/' . $this->customers[0]->id,
            [],
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        )
            ->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);
    }

    public function testUpdateOtherGalleryCustomer()
    {
        $secondGallery = factory(Gallery::class)->create();
        $customer = factory(Customer::class)->create(['gallery_id' => $secondGallery->id]);

        $this->json(
            'PATCH',
            '/api/customer/' . $customer->id,
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
                'message' => 'The current gallery does not own this customer.'
            ]);
    }

    public function testDeleteWithInvalidId()
    {
        $this->json(
            'DELETE',
            '/api/customer/99999',
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
                'message' => 'Customer with such parameters does not exists.'
            ]);
    }

    public function testDeleteWithValidId()
    {
        $this->json(
            'DELETE',
            '/api/customer/' . $this->customers[0]->id,
            [],
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->accessToken,
            ]
        )
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Customer deleted.'
            ]);
    }

    public function testDeleteUnauthenticated()
    {
        $this->json(
            'DELETE',
            '/api/customer/' . $this->customers[0]->id,
            [],
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]
        )
            ->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);
    }

    public function testDeleteOtherUserCustomer()
    {
        $secondGallery = factory(Gallery::class)->create();
        $customer = factory(Customer::class)->create(['gallery_id' => $secondGallery->id]);

        $this->json(
            'DELETE',
            '/api/customer/' . $customer->id,
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
                'message' => 'The current gallery does not own this customer.'
            ]);
    }
}
