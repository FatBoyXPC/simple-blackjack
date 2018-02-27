<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('middleware-request');

        $response->assertJson([
            'foo_property' => 'foo',
            'foo_get' => 'foo',
        ]);
    }
}
