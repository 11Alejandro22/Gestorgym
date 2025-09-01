<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gym;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GymController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth('web')->user();

        $gym = Gym::find($user->gym_id);

        return view('admin.gyms.index', compact('gym'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.gyms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /**
        * Cuando se cree el gym tengo que guardar en la tabla gym y al crearlo actualizar 
        * la tabla usuario y agregar al usuario que estan en session el id del gym creado
         */

        $data = $request->validate([
            'name'      => 'required|string|max:255|min:3',
            'address'   => 'required|string|max:255|min:3',
            'email'     => 'required|email|unique:gyms,email',
            'phone'     => 'required'
        ]);

        $data['slug'] = Str::slug($data['name']);

        $gym = Gym::create($data);

        /** @var \App\Models\User $user */
        $user = auth('web')->user();

        $user->gym_id = $gym->id; 
        $user->save();

        session()->flash('swal', [
            'text'   => 'El Gimnasio se ha creado correctamente.',
            'title' => '¡Bien hecho!',
            'icon'   => 'success',
        ]);

        return Redirect()->route('admin.gyms.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(Gym $gym)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gym $gym)
    {
        return view('admin.gyms.edit', compact('gym'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gym $gym)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255|min:3',
            'address' => 'required|string|max:255|min:3',
            'email'   => 'required|email|unique:gyms,email,' . $gym->id,
            'phone'   => 'required'
        ]);

        $data['slug'] = Str::slug($data['name']);

        // Actualizar en lugar de crear
        $gym->update($data);

        /** @var \App\Models\User $user */
        $user = auth('web')->user();
        $user->gym_id = $gym->id; 
        $user->save();

        session()->flash('swal', [
            'text'  => 'El Gimnasio se ha editado correctamente.',
            'title' => '¡Bien hecho!',
            'icon'  => 'success',
        ]);

        return redirect()->route('admin.gyms.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gym $gym)
    {
        //
    }
}
