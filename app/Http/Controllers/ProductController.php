<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductIndexRequest;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
     /**
     * @OA\Get(
     *     path="/products",
     *     summary="جلب قائمة المنتجات",
     *     tags={"Products"},
     *     @OA\Response(response=200, description="قائمة المنتجات بنجاح"),
     *     @OA\Response(response=401, description="غير مصرح لك"),
     * )
     */
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(ProductIndexRequest $request)
    {
        $data = $request->validated();
        $products = $this->productService->all(data: $data, withes: ['tenant']);
        $data = ProductResource::collection($products);
        return $this->response(data: $data, message: __("api.success"), code: 200);
    }

    /**
     * Store a newly created resource in storage.
     */

      /**
     * @OA\Post(
     *     path="/products",
     *     summary="إضافة منتج جديد",
     *     tags={"Products"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","price"},
     *             @OA\Property(property="name", type="string", example="Laptop"),
     *             @OA\Property(property="price", type="number", example=999.99),
     *             @OA\Property(property="description", type="string", example="A powerful laptop"),
     *             @OA\Property(property="tenant_id", type="integer", example=1),
     *         ),
     *     ),
     *     @OA\Response(response=201, description="تم إنشاء المنتج بنجاح"),
     *     @OA\Response(response=400, description="بيانات غير صحيحة"),
     * )
     */
    public function store(ProductStoreRequest $request)
    {
         $data = $request->validated();
        $product = $this->productService->create($data);
        return response()->json(['data' => new ProductResource($product)], 201); 

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = $this->productService->show(id: $id, withes: ['tenant']);
        $data = ProductResource::make($product);
        return $this->response(ProductResource::make($product));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductStoreRequest $request, string $id)
    {
        $data = $request->validated();
        $product = $this->productService->update($id, $data);
        return $this->response(ProductResource::make($product));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = $this->productService->destroy($id);
        return $this->response(['message' => 'Product deleted successfully']);

    }
}
