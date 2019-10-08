<?php

namespace Tests\Feature;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
class WelcomeUsersTest extends TestCase
{
    /** @test */
    function it_welcomes_users_with_nickname()
    {
        $this->get('saludo/pedro/birdman')
            ->assertStatus(200)
            ->assertSee('Bienvenido Pedro, Tu apodo es Birdman');
    }

    /** @test */
    function it_welcomes_users_without_nickname()
    {
        $this->get('saludo/pedro')
            ->assertStatus(200)
            ->assertSee('Bienvenido Pedro');
    }
}
