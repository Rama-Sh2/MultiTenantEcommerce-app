<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_product()
    {
   
        $tenant = Tenant::factory()->create();

        $productData = [
            'name' => 'Test Product',
            'price' => 50.00,
            'tenant_id' => $tenant->id, 
            'description' => 'This is a test product',
            'quantity' => 100,
        ];
        
        $response = $this->postJson('/api/products', $productData);
        $response->assertStatus(201);
        
    }

    public function test_update_product()
    {
        $user = User::factory()->create();
        $tenant = Tenant::factory()->create();

        $product = Product::factory()->create(['tenant_id' => $tenant->id]);

        $this->actingAs($user);

        $response = $this->putJson("/api/products/{$product->id}", [
            'name' => 'Updated Product',
            'price' => 150,
            'description' => 'This is an updated product',
            'tenant_id' => $tenant->id,
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['data' => ['id', 'name', 'price', 'description']]);
    }

    public function test_delete_product()
    {
        $user = User::factory()->create();
        $tenant = Tenant::factory()->create();
        $product = Product::factory()->create(['tenant_id' => $tenant->id]);

        $this->actingAs($user);

        $response = $this->deleteJson("/api/products/{$product->id}");

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Product deleted successfully']);
    }

    public function test_get_all_products()
    {
        $user = User::factory()->create();
        $tenant = Tenant::factory()->create();
        Product::factory()->count(5)->create(['tenant_id' => $tenant->id]);

        $this->actingAs($user);

        $response = $this->getJson('/api/products');

        $response->assertStatus(200)
                 ->assertJsonStructure(['data' => [['id', 'name', 'price', 'description']]]);
    }

    public function test_get_single_product()
    {
        $user = User::factory()->create();
        $tenant = Tenant::factory()->create();
        $product = Product::factory()->create(['tenant_id' => $tenant->id]);

        $this->actingAs($user);

        $response = $this->getJson("/api/products/{$product->id}");

        $response->assertStatus(200)
                 ->assertJsonStructure(['data' => ['id', 'name', 'price', 'description']]);
    }
}