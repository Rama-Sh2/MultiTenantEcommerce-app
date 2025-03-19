<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\VerifyRequest;
use App\Http\Resources\UserResource;
use App\Mail\SendOtpMail;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

/**
 * @OA\Tag(
 *     name="Authentication",
 *     description="API لتسجيل الدخول والتسجيل والتحقق"
 * )
 */

class AuthController extends Controller
{
    public function __construct(private AuthService $authService)
    {
        
    }
     /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     summary="تسجيل الدخول",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/LoginRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="تم إرسال رمز التحقق إلى البريد الإلكتروني",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Your verification code has been sent to your email")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="بيانات غير صحيحة",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Invalid credentials")
     *         )
     *     )
     * )
     */
    
    public function login(LoginRequest $request)
    {
        // $data = $request->validated();
        // $user = User::where('email', $data['email'])->first();
        // $code = rand(111111, 999999);
        // Cache::put($data['email'], $code, now()->addMinutes(5));
        // Mail::to($data['email'])->send(new SendOtpMail($user));
        // return $this->response(message: "Your verification code has been sent to your email");
        $data = $request->validated();
    $user = User::where('email', $data['email'])->first();

    if (!$user || !Hash::check($data['password'], $user->password)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    $code = rand(111111, 999999);
    Cache::put($data['email'], $code, now()->addMinutes(5));
    Mail::to($data['email'])->send(new SendOtpMail($user));

    return response()->json(['message' => 'Your verification code has been sent to your email']);
    }
     /**
     * @OA\Post(
     *     path="/api/auth/verify",
     *     summary="التحقق من الرمز",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/VerifyRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="تم التحقق بنجاح وتم إنشاء التوكن",
     *         @OA\JsonContent(ref="#/components/schemas/UserResource")
     *     )
     * )
     */

    public function verify(VerifyRequest $request)
    {
        $data = $request->validated();
        $user = User::where('email', $data['email'])->first();
        $user->token = $user->createToken('auth_token')->plainTextToken;
        Cache::forget($user->email);
        return $this->response(UserResource::make($user));
    }

    /**
     * @OA\Post(
     *     path="/api/auth/register",
     *     summary="تسجيل مستخدم جديد",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/RegisterRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="تم إنشاء المستخدم بنجاح",
     *         @OA\JsonContent(ref="#/components/schemas/UserResource")
     *     )
     * )
     */

    public function register(RegisterRequest $request)
    {
        $data = $request->afterValidation();
        $user = $this->authService->register($data);
        return response()->json(['data' => new UserResource($user)], 201); 
    }
}
