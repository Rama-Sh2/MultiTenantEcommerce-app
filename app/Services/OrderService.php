<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderService
{
    protected $tenantId;

    public function __construct()
    {
        $this->tenantId = request('tenant_id'); 
    }

    public function all($data = [], $paginated = true, $withes = [])
    {
        $tenantId = request('tenant_id');
        $query = Order::withTrashed()
        ->where('tenant_id', $tenantId)         
        ->when(isset($data['search']), function ($query) use ($data) {
            return $query->where('name', 'like', "%{$data['search']}%")
                ->orWhere('description', 'like', "%{$data['search']}%");
        })
        ->with($withes)
        ->latest();

    return $paginated ? $query->paginate() : $query->get();

    }

    public function store(array $data)
    {
        $data['tenant_id'] = $this->tenantId; 
        
        Log::info('Order creation data:', $data);

        return Order::create($data);
    }
}