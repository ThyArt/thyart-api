<?php

namespace Tests\Unit;

use App\Order;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\ClientRepository;
use Tests\TestCase;


class OrderControllerTest extends TestCase
{

	private $clientRepository;
    private $userPassword;
    private $user;
    private $accessToken;
    private $orders;

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

        $this->user = factory(User::class)->create(['password' => bcrypt($this->userPassword)]);
        $this->orders = factory(Order::class)->create(['user_id' => $this->user->id]);

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
        $this->orders = null;
        $this->accessToken = null;
    }

    //--------
    // Index
    //--------

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
                        'id' => $this->orders->id,
                        'price' => $this->orders->price
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

    public function testIndexSearchByPrice()
    {
        $this->json(
            'GET',
            '/api/order',
            ['price' => $this->orders->price],
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
                        'id' => $this->orders->id,
                        'price' => $this->orders->price
                    ]
                ]
            ]);
    }

    public function testIndexSearchByNonValidFirstName()
    {
        $this->json(
            'GET',
            '/api/order',
            ['price' => 'Wrong Price'],
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

    //----------------
    //STORE
    // --------------

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
                        "The price field is required.",
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
                'price' => str_random(256),
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
                    "The price may not be greater than 255 characters.",
                ]
            ]);
    }

    public function testStoreWithValidArguments()
    {
        $price = 'firstName';

        $this->json(
            'POST',
            '/api/order',
            [
                'price' => $price
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
                    'price' => $price
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
            '/api/order/' . $this->orders->id,
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
            '/api/order/' . $this->orders->id,
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
