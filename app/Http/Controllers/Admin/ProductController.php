<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Product_type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.products.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth('web')->user();

        $brands = Brand::where('gym_id', $user->gym_id)
                    ->where('is_active', 1)
                    ->orderBy('id', 'desc')
                    ->get();

        $product_types = Product_type::where('gym_id', $user->gym_id)
                    ->where('is_active', 1)
                    ->orderBy('id', 'desc')
                    ->get();
        return view('admin.products.create', compact('brands', 'product_types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth('web')->user();

        $data = $request->validate([
            'name'              => 'required|string|max:255|min:3',
            'description'       => 'nullable|max:300',
            'price'             => 'required|numeric|min:1',
            'product_type_id'   => 'required|numeric',
            'brand_id'          => 'required|numeric',
            'image'             => 'nullable|image',
        ]);

        if($request->hasFile('image')){
            $data['image'] = Storage::put('Producto', $request->image);
        }

        $data['gym_id']     = $user->gym_id;
        $data['is_active']  = 1;
        $data['stock']      = 0;

        Product::create($data);

        session()->flash('swal', [
            'text'  => 'El producto se ha creado correctamente.',
            'title' => '¡Bien hecho!',
            'icon'  => 'success',
        ]);

        return redirect()->route('admin.products.showProducts.table');

    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }


    public function showProducts()
    {
        $user = auth('web')->user();

        $brands = Brand::where('gym_id', $user->gym_id)
                    ->where('is_active', 1)
                    ->orderBy('id', 'desc')
                    ->get();

        $product_types = Product_type::where('gym_id', $user->gym_id)
                    ->where('is_active', 1)
                    ->orderBy('id', 'desc')
                    ->get();

        $products = Product::with(['brand', 'productType', 'gym'])
                                ->where('gym_id', $user->gym_id)
                                ->where('is_active', 1)
                                ->get();

        return view('admin.products.showProducts', compact('products', 'brands', 'product_types'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $user = auth('web')->user();

        $brands = Brand::where('gym_id', $user->gym_id)
                    ->where('is_active', 1)
                    ->orderBy('id', 'desc')
                    ->get();

        $product_types = Product_type::where('gym_id', $user->gym_id)
                    ->where('is_active', 1)
                    ->orderBy('id', 'desc')
                    ->get();

        return view('admin.products.edit', compact('product', 'product_types', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $user = auth('web')->user();

        $data = $request->validate([
            'name'              => 'required|string|max:255|min:3',
            'description'       => 'nullable|max:300',
            'price'             => 'required|numeric|min:1',
            'product_type_id'   => 'required|numeric',
            'brand_id'          => 'required|numeric',
            'image'             => 'nullable|image',
        ]);

        if($request->hasFile('image')){
            if($product->image){
                Storage::delete($product->image);
            }
            $data['image'] = Storage::put('Producto', $request->image);
        }

        $data['gym_id']     = $user->gym_id;
        $data['is_active']  = 1;

        $product->update($data);

        session()->flash('swal', [
            'text'  => 'El producto se ha actualizado correctamente.',
            'title' => '¡Bien hecho!',
            'icon'  => 'success',
        ]);

        return redirect()->route('admin.products.showProducts.table');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
