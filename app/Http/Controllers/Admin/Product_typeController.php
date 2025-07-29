<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product_type;
use Illuminate\Http\Request;

class Product_typeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth('web')->user();

        $product_types = Product_type::where('gym_id', $user->gym_id)
                    ->orderBy('id', 'desc')
                    ->paginate();

        return view('admin.product_types.index', compact('product_types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.product_types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth('web')->user();
        
        $data = $request->validate([
            'name'        => 'required|max:100',
            'description' => 'nullable|string|max:300',
        ]);
        
        $data['description'] = $data['description'] ?? 'Sin Descripción';
        $data['is_active']   = 1;
        $data['gym_id']      = $user->gym_id;
        
        Product_type::create($data);

        session()->flash('swal', [
            'text'  => 'El Tipo de Producto se ha creado correctamente.',
            'title' => '¡Bien hecho!',
            'icon'  => 'success',
        ]);

        return redirect()->route('admin.product_types.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product_type $product_type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product_type $product_type)
    {
        return view('admin.product_types.edit', compact('product_type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product_type $product_type)
    {
        $data = $request->validate([
            'name'          => 'required|max:100',
            'description'   => 'nullable|string|max:300'
        ]);

        $data['description'] = $data['description'] ?? 'Sin Descripción';
    
        $product_type->update($data);

        session()->flash('swal', [
            'text'  => 'El tipo de Producto se ha editado correctamente.',
            'title' => '¡Bien hecho!',
            'icon'  => 'success',
        ]);

        return redirect()->route('admin.product_types.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product_type $product_type)
    {
        $product_type->delete();

        session()->flash('swal', [
            'icon'  => 'success',
            'title' => '¡Bien hecho!',
            'text'  => 'La tipo de producto se ha eliminado correctamente',
        ]);

        return redirect()->route('admin.product_types.index');
    }
}
