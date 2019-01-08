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
}
