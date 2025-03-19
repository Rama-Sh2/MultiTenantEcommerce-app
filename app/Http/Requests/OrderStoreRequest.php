<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
/**
 * @OA\Schema(
 *     schema="OrderStoreRequest",
 *     type="object",
 *     title="Order Store Request",
 *     required={"product_id", "quantity", "total", "grand_total"},
 *     @OA\Property(property="product_id", type="integer", example=10),
 *     @OA\Property(property="quantity", type="integer", example=2),
 *     @OA\Property(property="total", type="number", format="float", example=199.99),
 *     @OA\Property(property="discount", type="number", format="float", example=10.00),
 *     @OA\Property(property="grand_total", type="number", format="float", example=189.99),
 * )
 */

class OrderStoreRequest extends FormRequest
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
            'product_id' => ['required', 'numeric', 'exists:products,id'],
            'quantity' => ['required', 'numeric', 'min:1'],
            'total' => ['required', 'numeric', 'min:0'],
            'discount' => ['nullable', 'numeric', 'min:0'],
            'grand_total' => ['required', 'numeric', 'min:0'],
        ];
    }

    public function afterValidation()
{
    $data = $this->validated();
    $data['user_id'] = auth()->id(); 
    $data['tenant_id'] = auth()->user()->tenant_id; 
    return $data;
}
}
