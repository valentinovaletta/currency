<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use App\Http\Controllers\GetDataFromApi;

use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_currencyapi()
    {
        $appVersion = new GetDataFromApi();
        $this->assertEquals(true,$appVersion->getData());
    }
}
