<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Http\Resources\MediaResource;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Spatie\MediaLibrary\Models\Media;
use App\Newsletter;
use App\Customer;
use App\User;
use App\Gallery;
use Laravel\Passport\ClientRepository;

class NewsletterControllerTest extends TestCase
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
        $this->userPassword = 'NewsletterControllerTest';
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
        $this->customers = factory(Customer::class)->create(['gallery_id' => $this->gallery->id]);
        $this->newsletter = factory(Newsletter::class)->create(['gallery_id' => $this->gallery->id]);


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
        $this->newsletter = null;
        $this->accessToken = null;
        $this->customers = null;
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
            '/api/newsletter',
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
            '/api/newsletter',
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
                        'id' => $this->newsletter->id,
                        'subject' => $this->newsletter->subject,
                        'description' => $this->newsletter->description,
                    ],
                ]
            ]);
    }

    public function testStoreWithNonExistentArguments()
    {

        $this->json(
            'POST',
            '/api/newsletter',
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
                        "The subject field is required.",
                        "The description field is required.",
                        "The customer list field is required.",
                    ]
                ]
            );
    }
}
