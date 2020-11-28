<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Testing\TestResponse;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;
use Illuminate\Support\Facades\DB;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    protected ?User $user = null;
    protected string $token = '';
    protected string $grantType = 'password';
    protected array $tokenParams = [];

    /**
     * Setup method
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:refresh');
        $this->artisan('db:seed');
    }


    /**
     * Ajax request testing
     * @param $method
     * @param $route
     * @param array $parameters
     * @return TestResponse
     */
    protected function ajax(string $method, string $route, array $parameters = []): \Illuminate\Testing\TestResponse
    {
        return $this->json(
            $method, $route, $parameters, ['HTTP_X-Requested-With' => 'XMLHttpRequest']
        );
    }


    /**
     * Ajax request testing with OAuth
     * @param $method
     * @param $route
     * @param array $parameters
     * @return TestResponse
     */
    protected function ajaxWithOAuth(string $method, string $route, array $parameters = []):TestResponse
    {
        $token = $this->getToken();
        return $this->json(
            $method, $route, $parameters, [
                'HTTP_X-Requested-With' => 'XMLHttpRequest',
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '.$token
            ]
        );
    }

    /**
     * Set token OAuth params
     * You need call it before ajaxWithOAuth
     *
     * @param array $params
     * @return array
     */
    protected function setTokenParams(Array $params = []):array
    {
        $user = User::first();
        $data = $this->tokenParams;
        if(!count($data)) {
            Artisan::call('passport:install', ['-vvv' => true]);
            Artisan::call('passport:client --client --name=TestClient --no-interaction');
            $client = DB::table('oauth_clients')->where('id', 2)->first();
            $data = [
                'grant_type' => $this->grantType,
                'client_id' => $client->id,
                'client_secret' => $client->secret,
                'username' => $user->email,
                'password' => 'password',
                'scope' => '*',
            ];
        }
        $this->tokenParams = array_merge( $data, $params);
        return $this->tokenParams;
    }

    /**
     * Get OAuth token
     *
     * @return string
     */
    protected function getToken():string
    {
        $response =  $this->json('post','/oauth/token', $this->setTokenParams());
        $token = $response->json('access_token');
        return $this->token = ($token)?$token: '';
    }
}
