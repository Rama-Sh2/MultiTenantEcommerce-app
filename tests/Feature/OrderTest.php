<?php

namespace Tests\Feature;

use App\Models\Order;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_order()
    {
        $tenant = Tenant::factory()->create();

        $orderData = [
            'product_id' => 1,
            'user_id' => 6,
            'quantity' => 5,
            'total' => 981.13,
            'discount' => 66.93,
            'grand_total' => 307.56,
            'tenant_id' => $tenant->id,
        ];
        
        $response = $this->postJson('/api/orders', $orderData);
        $response->assertStatus(201);
        
     }
    public function test_update_order()
{
    $user = User::factory()->create();
    $order = Order::factory()->create(['tenant_id' => $user->tenant_id]);

    $this->actingAs($user);

    $response = $this->putJson("/api/orders/{$order->id}", [
        'quantity' => 3,
        'total' => 300,
        'discount' => 15,
        'grand_total' => 285,
    ]);

    $response->assertStatus(200)
             ->assertJsonStructure(['data' => ['id', 'product_id', 'quantity']]);
}

}