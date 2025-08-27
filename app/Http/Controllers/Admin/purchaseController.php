<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class purchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.purchases.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth('web')->user();

        $suppliers = Supplier::where('is_active', 1)
                    ->where('gym_id', $user->gym_id)
                    ->get();

        $products = Product::where('is_active', 1)
                            ->where('gym_id', $user->gym_id)
                            ->get();

        return view('admin.purchases.create', compact('suppliers', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Purchase $purchase)
    {
        $user = auth('web')->user();

        $purchaseDetails = PurchaseDetail::with([
            'purchase',
            'purchase.supplier',
            'product',              // Compra y su proveedor
            'product.brand',                  // Producto y su marca
            'product.productType'              // Producto y su tipo
        ])
        ->whereHas('purchase', function ($query) use ($user, $purchase) {
            $query->where('gym_id', $user->gym_id)
                ->where('id', $purchase->id);
        })
        ->get();

        return view('admin.purchases.show', compact('purchaseDetails', 'purchase'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Purchase $purchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Purchase $purchase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase)
    {
        //
    }
}
