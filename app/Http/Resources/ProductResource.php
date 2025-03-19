<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="ProductResource",
 *     type="object",
 *     title="Product",
 *     description="تمثيل بيانات المنتج",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="هاتف ذكي"),
 *     @OA\Property(property="price", type="number", format="float", example=599.99),
 *     @OA\Property(property="description", type="string", example="هاتف ذكي حديث مع كاميرا 64MP"),
 *     @OA\Property(property="tenant", ref="#/components/schemas/TenantResource")
 * )
 */

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'description' => $this->description,
            'tenant_id' => $this->tenant_id,
        ];
    }
}

