<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            'product_id' => Product::factory(),
            'user_id' => User::factory(),
            'quantity' => $this->faker->numberBetween(1, 10),
            'total' => $this->faker->randomFloat(2, 10, 1000),
            'discount' => $this->faker->randomFloat(2, 0, 100),
            'grand_total' => $this->faker->randomFloat(2, 10, 1000),
            'tenant_id' => Tenant::factory(),
        ];
    }
}