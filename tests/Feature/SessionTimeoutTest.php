<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;


class SessionTimeoutTest extends TestCase
{
    /**
     * Test that user session expires after inactivity timeout.
     */
    public function test_session_expires_after_timeout()
    {
        $response = $this->post('/login', [
            'email' => 'valery.v.krukov@gmail.com',
            'password' => 'B!e281ckr',
        ]);

        $this->assertAuthenticated();

        // Simulate session timeout
        session()->setInactiveTimeout(15 * 60); // 15 minutes
        
        $response = $this->get('/dashboard');
        
        $this->assertGuest();
        $response->assertRedirect('/login');
    }

    /**
     * Test that active session does not timeout.
     */
    public function test_active_session_does_not_timeout()
    {
        $this->actingAs($this->createUser());

        $response = $this->get('/dashboard');

        $this->assertAuthenticated();
        $response->assertOk();
    }

    private function createUser()
    {
        return \App\Models\User::factory()->create();
    }
}