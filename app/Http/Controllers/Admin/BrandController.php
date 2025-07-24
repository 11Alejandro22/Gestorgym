<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth('web')->user();

        $brands = Brand::where('gym_id', $user->gym_id)
                    ->orderBy('id', 'desc')
                    ->paginate();

        return view('admin.brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brands.create');
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
        
        Brand::create($data);

        session()->flash('swal', [
            'text'  => 'La marca se ha creado correctamente.',
            'title' => '¡Bien hecho!',
            'icon'  => 'success',
        ]);

        return redirect()->route('admin.brands.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand)
    {
        $data = $request->validate([
            'name'          => 'required|max:100',
            'description'   => 'nullable|string|max:300'
        ]);

        $data['description'] = $data['description'] ?? 'Sin Descripción';
    
        $brand->update($data);

        session()->flash('swal', [
            'text'  => 'La marca se ha editado correctamente.',
            'title' => '¡Bien hecho!',
            'icon'  => 'success',
        ]);

        return redirect()->route('admin.brands.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();

        session()->flash('swal', [
            'icon'  => 'success',
            'title' => '¡Bien hecho!',
            'text'  => 'La marca se ha eliminado correctamente',
        ]);

        return redirect()->route('admin.brands.index');
    }
}
