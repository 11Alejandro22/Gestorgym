<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coach;
use App\Models\Person;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use function Ramsey\Uuid\v1;

class CoachController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currentUser = auth('web')->user();

        $coaches = Coach::with(['user', 'person'])
            ->whereHas('user', fn($q) => $q->where('gym_id', $currentUser->gym_id))
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('admin.coaches.index', compact('coaches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.coaches.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $currentUser = auth('web')->user();

        $gym_id = $currentUser->gym_id;

        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'DNI'        => 'required|string|max:8|unique:persons,DNI',
            'phone'      => 'required|string',
            'email'      => 'required|email|unique:users,email|unique:persons,email',
        ]);

        $person = Person::create([
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'DNI'        => $data['DNI'],
            'phone'      => $data['phone'],
            'email'      => $data['email'],
            'status'     => 1,
        ]);
        
        $newUser = User::create([
            'name'     => $person->first_name . ' ' . $person->last_name,
            'email'    => $person->email,
            'password' => Hash::make($data['DNI']),
            'gym_id'   => $gym_id,
        ]);

        Coach::create([
            'user_id'   => $newUser->id,
            'person_id'  => $person->id,
        ]);

        session()->flash('swal',[
            'text'   => 'El ususario se ha creado correctamente.',
            'title' => '¡Bien hecho!',
            'icon'   => 'success',
        ]);

        return redirect()->route('admin.coaches.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(Coach $coach)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Coach $coach)
    {
        return view('admin.coaches.edit', compact('coach'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Coach $coach)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'DNI'        => 'required|string|max:8|unique:persons,DNI,' . $coach->person_id,
            'phone'      => 'required|string',
        ]);

        $coach->person->update([
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'DNI'        => $data['DNI'],
            'phone'      => $data['phone'],
        ]);


        session()->flash('swal',[
            'text'   => 'El entrenador se ha actualizado correctamente.',
            'title' => '¡Bien hecho!',
            'icon'   => 'success',
        ]);

        return redirect()->route('admin.coaches.edit', $coach);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Coach $coach)
    {
        $coach->delete();

        session()->flash('swal',[
            'text'   => 'El entrenador se ha eliminado correctamente.',
            'title' => '¡Bien hecho!',
            'icon'   => 'success',
        ]);

        return redirect()->route('admin.coaches.index');
    }
}
