<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('admin.suppliers.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth('web')->user();

        $data = $request->validate([
                'name'    => 'required|string|min:3|max:255',
                'phone'   => 'required|string|regex:/^[0-9\s\+\-()]+$/|min:7|max:20',
                'email'   => 'required|email|max:255',
                'address' => 'required|string|max:255',
            ]);

        $data['gym_id']    = $user->gym_id;
        $data['is_active'] = 1;

        Supplier::create($data);

        session()->flash('swal', [
            'text'  => 'El Proveedor se ha creado correctamente.',
            'title' => '¡Bien hecho!',
            'icon'  => 'success',
        ]);

        return redirect()->route('admin.suppliers.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        return view('admin.suppliers.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        $user = auth('web')->user();

        $data = $request->validate([
                'name'    => 'required|string|min:3|max:255',
                'phone'   => 'required|string|regex:/^[0-9\s\+\-()]+$/|min:7|max:20',
                'email'   => 'required|email|max:255',
                'address' => 'required|string|max:255',
            ]);

        $supplier->update($data);

        session()->flash('swal', [
            'text'  => 'El Proveedor se ha actualizado correctamente.',
            'title' => '¡Bien hecho!',
            'icon'  => 'success',
        ]);

        return redirect()->route('admin.suppliers.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        //
    }
}
