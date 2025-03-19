<?php

namespace App\Http\Requests;

use App\Rules\VerifyOtpRule;
use Illuminate\Foundation\Http\FormRequest;
/**
 * @OA\Schema(
 *     schema="VerifyRequest",
 *     type="object",
 *     title="طلب التحقق من الرمز",
 *     description="البيانات المطلوبة للتحقق من رمز OTP",
 *     required={"email", "code"},
 *     @OA\Property(property="email", type="string", format="email", example="user@example.com"),
 *     @OA\Property(property="code", type="integer", example=123456),
 * )
 */

class VerifyRequest extends FormRequest
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
            'email' => ['required', 'exists:users,email'],
            'otp' => ['required', 'string', 'min:6', 'max:6', new VerifyOtpRule($this->email)],
        ];
    }
}
