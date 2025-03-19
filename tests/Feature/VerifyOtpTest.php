<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class VerifyOtpTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_verify_otp()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);
    
        $otp = rand(111111, 999999);
        Cache::put('test@example.com', $otp, now()->addMinutes(5)); 
    
        $response = $this->postJson('/api/verify', [
            'email' => 'test@example.com',
            'otp' => (string)$otp, 
        ]);
    
        $response->assertStatus(200)
                 ->assertJsonStructure(['data' => ['id', 'name', 'email', 'token']]);
    }
}
