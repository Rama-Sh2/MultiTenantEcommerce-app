<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
/**
 * @OA\Schema(
 *     schema="UserResource",
 *     title="User Resource",
 *     description="تمثيل بيانات المستخدم",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="John Doe"),
 *     @OA\Property(property="email", type="string", format="email", example="johndoe@example.com"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-03-19T10:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-03-19T10:00:00Z"),
 *     @OA\Property(property="token", type="string", example="1|abcdef1234567890"),
 * )
 */

class UserResource extends JsonResource
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
            'email' => $this->email,
            'token' => $this->token ?? null,
        ];
    
    }
}
