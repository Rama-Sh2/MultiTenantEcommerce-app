<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderIndexRequest;
use App\Http\Requests\OrderStoreRequest;
use App\Http\Resources\OrderResource;
use App\Services\OrderService;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Orders",
 *     description="إدارة الطلبات في النظام"
 * )
 */

class OrderController extends Controller
{
    protected $orderService;
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }
    /**
     * Display a listing of the resource.
     */

      /**
     * عرض قائمة الطلبات
     *
     * @OA\Get(
     *     path="/api/orders",
     *     summary="إرجاع قائمة الطلبات",
     *     tags={"Orders"},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="بحث عن طلب بالاسم أو الوصف",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="تم استرجاع قائمة الطلبات بنجاح",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/OrderResource"))
     *     )
     * )
     */
    public function index(OrderIndexRequest $request)
    {
        try {
            $data = $request->afterValidation();
            $orders = $this->orderService->all($data);
            return response()->json(['data' => OrderResource::collection($orders)], 200);
    
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while fetching orders',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */

       /**
     * إنشاء طلب جديد
     *
     * @OA\Post(
     *     path="/api/orders",
     *     summary="إنشاء طلب جديد",
     *     tags={"Orders"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/OrderStoreRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="تم إنشاء الطلب بنجاح",
     *         @OA\JsonContent(ref="#/components/schemas/OrderResource")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="خطأ في التحقق من البيانات"
     *     )
     * )
     */
    public function store(OrderStoreRequest $request)
    {
        try {
            $data = $request->afterValidation();
            $order = $this->orderService->store($data);
    
            return $this->response(OrderResource::make($order), message: "Order created successfully", code: 201);
    
        }
         catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while creating the order',
                'error' => $e->getMessage(),
            ], 500);
        }
    
    }


    /**
     * Display the specified resource.
     */
    /**
     * عرض تفاصيل طلب معين
     *
     * @OA\Get(
     *     path="/api/orders/{id}",
     *     summary="إرجاع بيانات طلب معين",
     *     tags={"Orders"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="رقم معرف الطلب",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="تم استرجاع بيانات الطلب بنجاح",
     *         @OA\JsonContent(ref="#/components/schemas/OrderResource")
     *     )
     * )
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
