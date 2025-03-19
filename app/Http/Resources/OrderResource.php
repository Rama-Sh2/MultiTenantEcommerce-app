<?php

namespace App\Http\Resources;

use App\Enums\OrderStatusEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="OrderResource",
 *     type="object",
 *     title="Order",
 *     description="تمثيل بيانات الطلب",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="product_id", type="integer", example=10),
 *     @OA\Property(property="quantity", type="integer", example=2),
 *     @OA\Property(property="total", type="number", format="float", example=199.99),
 *     @OA\Property(property="discount", type="number", format="float", example=10.00),
 *     @OA\Property(property="grand_total", type="number", format="float", example=189.99),
 *     @OA\Property(property="status", type="string", example="Pending"),
 * )
 */

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'quantity' => $this->quantity,
            'discount' => $this->discount ?? 0 ,
            'total_price' => $this->total_price,
            'status' => $this->status ?? OrderStatusEnum::PENDING->value,
            'tenant' => TenantResource::make($this->whenLoaded('tenant')),
            'product' => ProductResource::make($this->whenLoaded('product')),
        ];
    }
}