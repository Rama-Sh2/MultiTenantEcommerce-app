<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="ProductStoreRequest",
 *     required={"name", "price", "tenant_id"},
 *     @OA\Property(property="name", type="string", example="Laptop"),
 *     @OA\Property(property="price", type="number", example=999.99),
 *     @OA\Property(property="description", type="string", example="High-end gaming laptop"),
 *     @OA\Property(property="tenant_id", type="integer", example=1),
 * )
 */

class ProductStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:4', 'max:255'],
            'price' => ['required', 'numeric', 'min:1', 'max:9999'],
            'description' => ['nullable', 'string', 'max:65000'],
            'tenant_id' => ['required','numeric', 'exists:tenants,id'],

        ];
    }
}
