<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="MultiTenantEcommerce API",
 *      description="هذا هو التوثيق الرسمي لـ MultiTenantEcommerce API",
 *      @OA\Contact(
 *          email="support@yourdomain.com"
 *      ),
 *      @OA\License(
 *          name="MIT",
 *          url="https://opensource.org/licenses/MIT"
 *      )
 * )
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="الخادم الأساسي"
 * )
 */

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function response(mixed $data = [], string $message = 'success', int $code = 200)
    {
        return response()->json(['status' => true, 'message' => $message, 'data' => $data], $code);  
    }
}
