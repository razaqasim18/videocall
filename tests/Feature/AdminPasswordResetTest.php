<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class AdminPasswordResetTest extends TestCase
{
    use WithoutMiddleware;

    public function test_admin_forgot_password_page_is_accessible(): void
    {
        $response = $this->get('/admin/forget-password');

        $response->assertStatus(200);
        $response->assertSee('Forgot your password?');
    }

    public function test_admin_reset_password_page_is_accessible(): void
    {
        $response = $this->get('/admin/reset-password/demo-token?email=admin@admin.com');

        $response->assertStatus(200);
        $response->assertSee('Set a new password');
    }
}
