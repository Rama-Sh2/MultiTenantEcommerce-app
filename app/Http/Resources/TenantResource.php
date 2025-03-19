<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="TenantResource",
 *     type="object",
 *     title="Tenant",
 *     description="تمثيل بيانات Tenant",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="شركة ABC"),
 *     @OA\Property(property="email", type="string", format="email", example="info@abc.com"),
 * )
 */

class TenantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
