<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\category_schedule;
use App\Models\Day;
use App\Models\User;
use Illuminate\Http\Request;

class Category_scheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schedules = category_schedule::with(['category', 'user', 'days'])->get();

        return view('admin.category_schedules.index', compact('schedules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth('web')->user();

        $categories = Category::where('gym_id', $user->gym_id)
                    ->where('is_active', 1)
                    ->orderBy('id', 'desc')
                    ->get();

        $coaches = User::where('gym_id', $user->gym_id)
                    ->whereHas('coach', function ($q) {
                        $q->where('is_active', 1);
                    })
                    ->get();

        $days = Day::all();

        return view('admin.category_schedules.create', compact('categories', 'coaches', 'days'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|integer|exists:categories,id',
            'user_id'     => 'required|integer|exists:users,id',
            'day_id'      => 'required|array',
            'day_id.*'    => 'integer|between:1,7',
            'start_time'  => 'required|date_format:H:i',
            'end_time'    => 'required|date_format:H:i|after:start_time',
        ]);

        $categorySchedule = category_schedule::create([
            'category_id' => $data['category_id'],
            'user_id'     => $data['user_id'],
            'start_time'  => $data['start_time'],
            'end_time'    => $data['end_time'],
        ]);

        // Asociar los días seleccionados
        $categorySchedule->days()->sync($data['day_id']);

        session()->flash('swal', [
            'text'   => 'El horario se ha creado correctamente.',
            'title' => '¡Bien hecho!',
            'icon'   => 'success',
        ]);

        return redirect()->route('admin.category_schedules.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(category_schedule $category_schedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(category_schedule $category_schedule)
    {
        $user = auth('web')->user();

        $categories = Category::where('gym_id', $user->gym_id)
                    ->where('is_active', 1)
                    ->orderBy('id', 'desc')
                    ->get();

        $coaches = User::where('gym_id', $user->gym_id)
                    ->whereHas('coach', function ($q) {
                        $q->where('is_active', 1);
                    })
                    ->get();

        $days = Day::all();

        return view('admin.category_schedules.edit', compact('category_schedule', 'categories', 'coaches', 'days'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, category_schedule $category_schedule)
    {
        $data = $request->validate([
            'category_id' => 'required|integer|exists:categories,id',
            'user_id'     => 'required|integer|exists:users,id',
            'day_id'      => 'required|array',
            'day_id.*'    => 'integer|between:1,7',
            'start_time'  => 'required|date_format:H:i',
            'end_time'    => 'required|date_format:H:i|after:start_time',
        ]);

        $category_schedule->update([
            'category_id' => $data['category_id'],
            'user_id'     => $data['user_id'],
            'start_time'  => $data['start_time'],
            'end_time'    => $data['end_time'],
        ]);

        // Asociar los días seleccionados
        $category_schedule->days()->sync($data['day_id']);

        session()->flash('swal', [
            'text'   => 'El horario se ha actualizado correctamente.',
            'title' => '¡Bien hecho!',
            'icon'   => 'success',
        ]);

        return redirect()->route('admin.category_schedules.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(category_schedule $category_schedule)
    {
        $category_schedule->delete();

        session()->flash('swal', [
            'icon'  => 'success',
            'title' => '¡Bien hecho!',
            'text'  => 'El horario se ha eliminado correctamente',
        ]);

        return redirect()->route('admin.category_schedules.index');
    }


}
