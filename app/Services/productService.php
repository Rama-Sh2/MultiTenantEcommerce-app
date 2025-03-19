<?php

namespace App\Services;

use App\Events\NewProduct;
use App\Models\Product;
use App\Traits\ServiceTrait;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductService 
{
    protected $tenantId;

    public function __construct()
    {
        $this->tenantId = request('tenant_id'); 
    }

    public function all($data = [], $paginated = true, $withes = [])
    {
         $query = Product::withTrashed()
            ->where('tenant_id', $this->tenantId) 
            ->when(isset($data['search']), function ($query) use ($data) {
                return $query->where('name', 'like', "%{$data['search']}%")
                    ->orWhere('description', 'like', "%{$data['search']}%");
            })
            ->with($withes)
            ->latest();

        return $paginated ? $query->paginate() : $query->get();

    }

    public function show($id, $withes = [], $withTrashed = false)
    {
        return Product::with($withes)
        ->where('tenant_id', $this->tenantId) 
        ->withTrashed($withTrashed)
        ->findOrFail($id);    }

    
        public function create(array $data)
    {
        $data['tenant_id'] = $this->tenantId; 
        return Product::create($data);
    }
    

    public function update(int $id, array $data)
    {
        $product = Product::where('id', $id)
            ->where('tenant_id', $this->tenantId) 
            ->firstOrFail();
        $product->update($data);
        return $product;
    }

    public function destroy($id)
    {
        $product = Product::where('id', $id)
        ->where('tenant_id', $this->tenantId) 
        ->withTrashed()
        ->firstOrFail();

    if ($product->deleted_at) {
        $deleted = $product->restore();
    } else {
        $deleted = $product->delete();
    }

    return $deleted;
    }

    
}
