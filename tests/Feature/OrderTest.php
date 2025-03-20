<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_all_orders()
{
    $user = User::factory()->create();
    $tenant = Tenant::factory()->create();
    $product = Product::factory()->create(['tenant_id' => $tenant->id]);

    Order::factory()->count(5)->create([
        'tenant_id' => $tenant->id,
        'product_id' => $product->id,
        'user_id' => $user->id,
    ]);

    $this->actingAs($user);

    $response = $this->getJson('/api/orders', [
        'tenant_id' => $tenant->id, 
    ]);

    $response->assertStatus(200)
             ->assertJsonStructure(['data' => [['id', 'product_id', 'user_id', 'quantity', 'total', 'discount', 'grand_total']]]);
}

    public function test_create_order()
    {
        $user = User::factory()->create(); 
        $tenant = Tenant::factory()->create();
        $product = Product::factory()->create(['tenant_id' => $tenant->id]);

        $this->actingAs($user);

        $orderData = [
            'product_id' => $product->id,
            'user_id' => $user->id, 
            'quantity' => 5,
            'total' => 981.13,
            'discount' => 66.93,
            'grand_total' => 307.56,
            'tenant_id' => $tenant->id,
        ];
        
        $response = $this->postJson('/api/orders', $orderData);

        $response->assertStatus(201)
                 ->assertJsonStructure(['data' => ['id', 'product_id', 'user_id', 'quantity', 'total', 'discount', 'grand_total']]);
    }

    
}
