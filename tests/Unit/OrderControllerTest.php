<?php

namespace Tests\Unit;

use App\Artwork;
use App\Customer;
use App\Order;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Laravel\Passport\ClientRepository;
use Tests\TestCase;
use Faker\Provider\DateTime as FakeDate;

class OrderControllerTest extends TestCase
{
    private $clientRepository;
    private $userPassword;
    private $user;
    private $accessToken;
    private $customer;
    private $artwork;
    private $order;

    use RefreshDatabase;

    public function __construct()
    {
        parent::__construct();
        $this->clientRepository = new ClientRepository();
        $this->userPassword = 'OrderControllerTest';
    }

    protected function setUp()
    {
        parent::setUp();
        $this->withoutMiddleware(
            ThrottleRequests::class
        );

        $this->user = factory(User::class)->create(['password' => bcrypt($this->userPassword)]);
        $this->customer = factory(Customer::class)->create(['user_id' => $this->user->id]);
        $this->artwork = factory(Artwork::class)->create(['user_id' => $this->user->id, 'state' => Artwork::STATE_IN_STOCK]);

        $this->order = factory(Order::class)->create([
            'user_id' => $this->user->id,
            'customer_id' => $this->customer->id,
            'artwork_id' => $this->artwork->id
        ]);

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

        unset($this->user);
        unset($this->order);
        unset($this->accessToken);
        unset($this->customer);
        unset($this->artwork);
    }

    public function testIndex()
    {
        $this->json(
            'GET',
            '/api/order',
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
                        'id' => $this->order->id,
                        'customer_id' => $this->customer->id,
                        'artwork_id' => $this->artwork->id,
                        'date' => $this->order->date->format('Y-m-d'),
                    ]
                ]
            ]);
    }

    public function testIndexUnAuthenticated()
    {
        $this->json(
            'GET',
            '/api/order',
            [],
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        )
            ->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);
    }

    public function testStoreWithNonExistentArguments()
    {
        $this->json(
            'POST',
            '/api/order',
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
                        "The artwork id field is required.",
                        "The date field is required."
                    ]
                ]

            );
    }

    public function testStoreWithInvalidArguments()
    {
        $this->json(
            'POST',
            '/api/order',
            [
                'first_name' => str_random(256),
                'last_name' => str_random(256),
                'email' => str_random(256),
                'phone' => str_random(256),
                'address' => str_random(256),
                'city' => str_random(256),
                'country' => str_random(256),
                'artwork_id' => str_random(256),
                'date' => str_random(256)
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
                    "The country may not be greater than 255 characters.",
                    "The artwork id must be an integer.",
                    "The date is not a valid date."
                ]
            ]);
    }

    public function testStoreWithValidArguments()
    {
        $this->artwork = factory(Artwork::class)->create(['user_id' => $this->user->id]);
        $date = FakeDate::date();
        $this->json(
            'POST',
            '/api/order',
            [
                'first_name' => $this->customer->first_name,
                'last_name' => $this->customer->last_name,
                'email' => $this->customer->email,
                'phone' => $this->customer->phone,
                'address' => $this->customer->address,
                'city' => $this->customer->city,
                'country' => $this->customer->country,
                'artwork_id' => $this->artwork->id,
                'date' => $date,
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
                    'customer_id' => $this->customer->id,
                    'artwork_id' => $this->artwork->id,
                    'date' => $date,
                ],
            ]);
    }

    public function testStoreUnAuthenticated()
    {
        $this->json(
            'POST',
            '/api/order',
            [],
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        )
            ->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);
    }

    //------------
    // DELETE
    // -----------


    public function testDeleteWithInvalidId()
    {
        $this->json(
            'DELETE',
            '/api/order/99999',
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
                'message' => 'Order with such parameters does not exists.'
            ]);
    }

    public function testDeleteWithValidId()
    {
        $this->json(
            'DELETE',
            '/api/order/' . $this->order->id,
            [],
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->accessToken,
            ]
        )
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Order deleted.'
            ]);
    }

    public function testDeleteUnauthenticated()
    {
        $this->json(
            'DELETE',
            '/api/order/' . $this->order->id,
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
