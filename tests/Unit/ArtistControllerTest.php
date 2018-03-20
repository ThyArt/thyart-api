<?php

namespace Tests\Unit;

use App\Artist;
use App\User;
use Faker\Provider\fr_FR\PhoneNumber;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\ClientRepository;
use Tests\TestCase;

class ArtistControllerTest extends TestCase
{
    private $clientRepository;
    private $userPassword;
    private $user;
    private $accessToken;
    private $artists;

    use RefreshDatabase;

    public function __construct()
    {
        parent::__construct();
        $this->clientRepository = new ClientRepository();
        $this->userPassword = 'ArtistControllerTest';
    }

    protected function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create(['password' => bcrypt($this->userPassword)]);
        $this->artists = factory(Artist::class, 2)->create(['user_id' => $this->user->id]);

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
        $this->artist = null;
        $this->accessToken = null;
    }


    public function testIndex()
    {
        $this->json(
            'GET',
            '/api/artist',
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
                        'id' => $this->artists[0]->id,
                        'first_name' => $this->artists[0]->first_name,
                        'last_name' => $this->artists[0]->last_name,
                        'phone' => $this->artists[0]->phone,
                        'email' => $this->artists[0]->email,
                        'address' => $this->artists[0]->address,
                        'city' => $this->artists[0]->city,
                        'country' => $this->artists[0]->country
                    ],
                    [
                        'id' => $this->artists[1]->id,
                        'first_name' => $this->artists[1]->first_name,
                        'last_name' => $this->artists[1]->last_name,
                        'phone' => $this->artists[1]->phone,
                        'email' => $this->artists[1]->email,
                        'address' => $this->artists[1]->address,
                        'city' => $this->artists[1]->city,
                        'country' => $this->artists[1]->country
                    ]
                ]
            ]);
    }

    public function testIndexUnAuthenticated()
    {
        $this->json(
            'GET',
            '/api/artist',
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
            '/api/artist',
            ['first_name' => $this->artists[0]->first_name],
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
                        'id' => $this->artists[0]->id,
                        'first_name' => $this->artists[0]->first_name,
                        'last_name' => $this->artists[0]->last_name,
                        'phone' => $this->artists[0]->phone,
                        'email' => $this->artists[0]->email,
                        'address' => $this->artists[0]->address,
                        'city' => $this->artists[0]->city,
                        'country' => $this->artists[0]->country
                    ]
                ]
            ]);
    }

    public function testIndexSearchByNonValidFirstName()
    {
        $this->json(
            'GET',
            '/api/artist',
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
            '/api/artist',
            ['last_name' => $this->artists[0]->last_name],
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
                        'id' => $this->artists[0]->id,
                        'first_name' => $this->artists[0]->first_name,
                        'last_name' => $this->artists[0]->last_name,
                        'phone' => $this->artists[0]->phone,
                        'email' => $this->artists[0]->email,
                        'address' => $this->artists[0]->address,
                        'city' => $this->artists[0]->city,
                        'country' => $this->artists[0]->country
                    ]
                ]
            ]);
    }

    public function testIndexSearchByNonValidLastName()
    {
        $this->json(
            'GET',
            '/api/artist',
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
            '/api/artist',
            ['phone' => $this->artists[0]->phone],
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
                        'id' => $this->artists[0]->id,
                        'first_name' => $this->artists[0]->first_name,
                        'last_name' => $this->artists[0]->last_name,
                        'phone' => $this->artists[0]->phone,
                        'email' => $this->artists[0]->email,
                        'address' => $this->artists[0]->address,
                        'city' => $this->artists[0]->city,
                        'country' => $this->artists[0]->country
                    ]
                ]
            ]);
    }

    public function testIndexSearchByNonValidPhone()
    {
        $this->json(
            'GET',
            '/api/artist',
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
            '/api/artist',
            ['email' => $this->artists[0]->email],
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
                        'id' => $this->artists[0]->id,
                        'first_name' => $this->artists[0]->first_name,
                        'last_name' => $this->artists[0]->last_name,
                        'phone' => $this->artists[0]->phone,
                        'email' => $this->artists[0]->email,
                        'address' => $this->artists[0]->address,
                        'city' => $this->artists[0]->city,
                        'country' => $this->artists[0]->country
                    ]
                ]
            ]);
    }

    public function testIndexSearchByNonValidEmail()
    {
        $this->json(
            'GET',
            '/api/artist',
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
            '/api/artist',
            ['address' => $this->artists[0]->address],
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
                        'id' => $this->artists[0]->id,
                        'first_name' => $this->artists[0]->first_name,
                        'last_name' => $this->artists[0]->last_name,
                        'phone' => $this->artists[0]->phone,
                        'email' => $this->artists[0]->email,
                        'address' => $this->artists[0]->address,
                        'city' => $this->artists[0]->city,
                        'country' => $this->artists[0]->country
                    ]
                ]
            ]);
    }

    public function testIndexSearchByNonValidAddress()
    {
        $this->json(
            'GET',
            '/api/artist',
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
            '/api/artist',
            ['city' => $this->artists[0]->city],
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
                        'id' => $this->artists[0]->id,
                        'first_name' => $this->artists[0]->first_name,
                        'last_name' => $this->artists[0]->last_name,
                        'phone' => $this->artists[0]->phone,
                        'email' => $this->artists[0]->email,
                        'address' => $this->artists[0]->address,
                        'city' => $this->artists[0]->city,
                        'country' => $this->artists[0]->country
                    ]
                ]
            ]);
    }

    public function testIndexSearchByNonValidCity()
    {
        $this->json(
            'GET',
            '/api/artist',
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
            '/api/artist',
            ['country' => $this->artists[0]->country],
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
                        'id' => $this->artists[0]->id,
                        'first_name' => $this->artists[0]->first_name,
                        'last_name' => $this->artists[0]->last_name,
                        'phone' => $this->artists[0]->phone,
                        'email' => $this->artists[0]->email,
                        'address' => $this->artists[0]->address,
                        'city' => $this->artists[0]->city,
                        'country' => $this->artists[0]->country
                    ]
                ]
            ]);
    }

    public function testIndexSearchByNonValidCountry()
    {
        $this->json(
            'GET',
            '/api/artist',
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

    public function testIndexWithOtherUser()
    {
        $secondUser = factory(User::class)->create();
        factory(Artist::class, 2)->create(['user_id' => $secondUser->id]);

        $this->json(
            'GET',
            '/api/artist',
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
                        'id' => $this->artists[0]->id,
                        'first_name' => $this->artists[0]->first_name,
                        'last_name' => $this->artists[0]->last_name,
                        'phone' => $this->artists[0]->phone,
                        'email' => $this->artists[0]->email,
                        'address' => $this->artists[0]->address,
                        'city' => $this->artists[0]->city,
                        'country' => $this->artists[0]->country
                    ],
                    [
                        'id' => $this->artists[1]->id,
                        'first_name' => $this->artists[1]->first_name,
                        'last_name' => $this->artists[1]->last_name,
                        'phone' => $this->artists[1]->phone,
                        'email' => $this->artists[1]->email,
                        'address' => $this->artists[1]->address,
                        'city' => $this->artists[1]->city,
                        'country' => $this->artists[1]->country
                    ]
                ]
            ]);
    }

    public function testStoreWithNonExistentArguments()
    {
        $this->json(
            'POST',
            '/api/artist',
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
                    "The first name field is required.",
                    "The last name field is required.",
                    "The email field is required.",
                    "The phone field is required.",
                    "The address field is required.",
                    "The city field is required.",
                    "The country field is required.",
                ]

            );
    }

    public function testStoreWithInvalidArguments()
    {
        $this->json(
            'POST',
            '/api/artist',
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
                "The first name may not be greater than 255 characters.",
                "The last name may not be greater than 255 characters.",
                "The email must be a valid email address.",
                "The email may not be greater than 255 characters.",
                "The phone field contains an invalid number.",
                "The address may not be greater than 255 characters.",
                "The city may not be greater than 255 characters.",
                "The country may not be greater than 255 characters."
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
            '/api/artist',
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

        $this->assertDatabaseHas('artists', [
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
            '/api/artist',
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
            '/api/artist/99999',
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
                'message' => 'Artist with such parameters does not exists.'
            ]);
    }

    public function testShowWithValidId()
    {
        $this->json(
            'GET',
            '/api/artist/' . $this->artists[0]->id,
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
                    'id' => $this->artists[0]->id,
                    'first_name' => $this->artists[0]->first_name,
                    'last_name' => $this->artists[0]->last_name,
                    'phone' => $this->artists[0]->phone,
                    'email' => $this->artists[0]->email,
                    'address' => $this->artists[0]->address,
                    'city' => $this->artists[0]->city,
                    'country' => $this->artists[0]->country
                ],
            ]);
    }

    public function testShowUnauthenticated()
    {
        $this->json(
            'GET',
            '/api/artist/' . $this->artists[0]->id,
            [],
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]
        )
            ->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);
    }

    public function testShowOtherUserArtist()
    {
        $secondUser = factory(User::class)->create();
        $artist = factory(Artist::class)->create(['user_id' => $secondUser->id]);

        $this->json(
            'GET',
            '/api/artist/' . $artist->id,
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
                'message' => 'The current user does not own this artist.'
            ]);
    }

    public function testUpdateWithNonExistentArguments()
    {
        $this->json(
            'PATCH',
            '/api/artist/' . $this->artists[0]->id,
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
                    'id' => $this->artists[0]->id,
                    'first_name' => $this->artists[0]->first_name,
                    'last_name' => $this->artists[0]->last_name,
                    'phone' => $this->artists[0]->phone,
                    'email' => $this->artists[0]->email,
                    'address' => $this->artists[0]->address,
                    'city' => $this->artists[0]->city,
                    'country' => $this->artists[0]->country
                ]]
            );
    }

    public function testUpdateWithInvalidArguments()
    {
        $this->json(
            'PATCH',
            '/api/artist/' . $this->artists[0]->id,
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
                "The first name may not be greater than 255 characters.",
                "The last name may not be greater than 255 characters.",
                "The email must be a valid email address.",
                "The email may not be greater than 255 characters.",
                "The phone field contains an invalid number.",
                "The address may not be greater than 255 characters.",
                "The city may not be greater than 255 characters.",
                "The country may not be greater than 255 characters."
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
            '/api/artist/' . $this->artists[0]->id,
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
                    'id' => $this->artists[0]->id,
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'email' => $email,
                    'phone' => $phone,
                    'address' => $address,
                    'city' => $city,
                    'country' => $country
                ],
            ]);

        $this->assertDatabaseHas('artists', [
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
            '/api/artist/' . $this->artists[0]->id,
            [],
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        )
            ->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);
    }

    public function testUpdateOtherUserArtist()
    {
        $secondUser = factory(User::class)->create();
        $artist = factory(Artist::class)->create(['user_id' => $secondUser->id]);

        $this->json(
            'PATCH',
            '/api/artist/' . $artist->id,
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
                'message' => 'The current user does not own this artist.'
            ]);
    }

    public function testDeleteWithInvalidId()
    {
        $this->json(
            'DELETE',
            '/api/artist/99999',
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
                'message' => 'Artist with such parameters does not exists.'
            ]);
    }

    public function testDeleteWithValidId()
    {
        $this->json(
            'DELETE',
            '/api/artist/' . $this->artists[0]->id,
            [],
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->accessToken,
            ]
        )
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Artist deleted.'
            ]);
    }

    public function testDeleteUnauthenticated()
    {
        $this->json(
            'DELETE',
            '/api/artist/' . $this->artists[0]->id,
            [],
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]
        )
            ->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);
    }

    public function testDeleteOtherUserArtist()
    {
        $secondUser = factory(User::class)->create();
        $artist = factory(Artist::class)->create(['user_id' => $secondUser->id]);

        $this->json(
            'DELETE',
            '/api/artist/' . $artist->id,
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
                'message' => 'The current user does not own this artist.'
            ]);
    }
}
