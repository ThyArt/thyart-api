<?php

namespace Tests\Unit;

use App\Customer;
use App\User;
use Tests\TestCase;
use Laravel\Passport\ClientRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerControllerTest extends TestCase
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
        $this->userPassword = 'CustomerControllerTest';
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

    public function testIndex()
    {
        $customer = factory(Customer::class)->create();
        $secondCustomer = factory(Customer::class)->create();

        $this->json(
            'GET',
            '/api/customer',
            [],
            [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        )->assertJsonFragment([
            'data' => [
                [
                    'id' => $customer->id,
                    'user_id' => $customer->user_id,
                    'firstname' => $customer->firstname,
                    'lastname' => $customer->lastname,
                    'phone' => $customer->phone,
                    'email' => $customer->email,
                    'address' => $customer->address,
                    'country' => $customer->country,
                    'city' => $customer->city,
                ],
                [
                    'id' => $secondCustomer->id,
                    'user_id' => $secondCustomer->user_id,
                    'firstname' => $secondCustomer->firstname,
                    'lastname' => $secondCustomer->lastname,
                    'phone' => $secondCustomer->phone,
                    'email' => $secondCustomer->email,
                    'address' => $secondCustomer->address,
                    'country' => $secondCustomer->country,
                    'city' => $secondCustomer->city,
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

    public function testIndexMultiUsers()
    {
        $customer = factory(Customer::class)->create();
        $secondUser = factory(User::class)->create();
        $secondCustomer = factory(Customer::class)->create(['user_id' => $secondUser->id]);

        $this->json(
            'GET',
            '/api/customer',
            [],
            [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        )->assertJsonFragment([
            'data' => [
                [
                    'id' => $customer->id,
                    'user_id' => $customer->user_id,
                    'firstname' => $customer->firstname,
                    'lastname' => $customer->lastname,
                    'phone' => $customer->phone,
                    'email' => $customer->email,
                    'address' => $customer->address,
                    'country' => $customer->country,
                    'city' => $customer->city,
                ]
            ]
        ]);
    }
}
