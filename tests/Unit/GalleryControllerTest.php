<?php

namespace Tests\Unit;

use App\User;
use App\Gallery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Routing\Middleware\ThrottleRequests;
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
        $this->accessToken = null;
    }

    //--------------------------
    //
    // TEST UPDATE
    //
    //--------------------------
    
    public function testUpdateWithNonExistentArguments()
    {
        $gallery = $this->gallery;
        $this->json(
            'PATCH',
            '/api/gallery/',
            [],
            [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]
        )
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $gallery->id,
                    'name' => $gallery->name,
                    'address' => $gallery->address,
                    'phone' => $gallery->phone
                ],
            ]);
    }

    public function testUpdateWithInvalidArguments()
    {
        $gallery = $this->gallery;
        $this->json(
            'PATCH',
            '/api/gallery/',
            [
                'name' => str_random(256),
                'address' => str_random(256),
                'phone' => str_random(256)
            ],
            [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]
        )
            ->assertStatus(400)
            ->assertJson([
                "error" => "validation_failed",
                "messages" => [
                    "The name may not be greater than 255 characters.",
                    "The address may not be greater than 255 characters.",
                    "The phone may not be greater than 255 characters."
                ]
            ]);
    }

    //TODO : Test with existing number or address

    public function testUpdateWithValidArguments()
    {
        $name = 'testName';
        $address = 'testAddress';
        $phone = 'testPhone';
        $gallery = $this->gallery;
        $this->json(
            'PATCH',
            '/api/gallery/',
            [
                'name' => $name,
                'address' => $address,
                'phone' => $phone
            ],
            [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]
        )
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $gallery->id,
                    'name' => $name,
                    'address' => $address,
                    'phone' => $phone,
                ]
            ]);
    }

    public function testUpdateUnauthenticated()
    {
        $name = 'testName';
        $address = 'testAddress';
        $phone = 'testPhone';
        $this->json(
            'PATCH',
            '/api/gallery/',
            [
                'name' => $name,
                'address' => $address,
                'phone' => $phone
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
            '/api/gallery/',
            [],
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->accessToken
            ]
        )
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Gallery deleted.',
            ]);
    }

    public function testDestroyUnauthenticated()
    {
        $this->json(
            'DELETE',
            '/api/gallery/',
            [],
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]
        )
            ->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.',
            ]);
    }
}
