<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Client;
use Tests\TestCase;

class DeployTest extends TestCase
{
    use RefreshDatabase;

    private $clientSecret;
    private $client;

    public function setUp()
    {
        $this->app = $this->createApplication();
        $this->clientSecret = str_random(40);

        $_SERVER['PASSPORT_CLIENT_SECRET'] = $this->clientSecret;
    }

    protected function tearDown()
    {
        unset($this->clientSecret);
        unset($this->app);
    }

    public function testClientIsCreatedWithValues()
    {
        $this->artisan('deploy');

        $testedClient = Client::first();
        $this->assertEquals($testedClient->user_id, null);
        $this->assertEquals($testedClient->name, 'ThyArt Password Grant Client');
        $this->assertEquals($testedClient->secret, $this->clientSecret);
        $this->assertEquals($testedClient->redirect, 'http://localhost');
        $this->assertEquals($testedClient->personal_access_client, false);
        $this->assertEquals($testedClient->password_client, true);
        $this->assertEquals($testedClient->revoked, false);
    }

    public function testClientIsCreatedOnce()
    {
        $this->artisan('deploy');
        $this->artisan('deploy');

        $this->assertEquals(Client::count(), 1);
    }
}
