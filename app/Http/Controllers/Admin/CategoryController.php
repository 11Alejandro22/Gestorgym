<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\category_schudules;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth('web')->user();

        $categories = Category::where('gym_id', $user->gym_id)
                    ->orderBy('id', 'desc')
                    ->paginate();

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'          => 'required|string|max:255|min:3',
            'monthly_price' => 'required|numeric|max:100000|min:0'
        ]);

        $data['slug'] = Str::slug($data['name']);

        $user = auth('web')->user();

        $data['gym_id'] = $user->gym_id;

        Category::create($data);

        session()->flash('swal', [
            'text'   => 'La categoría se ha creado correctamente.',
            'title' => '¡Bien hecho!',
            'icon'   => 'success',
        ]);

        return Redirect()->route('admin.categories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {

        $data = $request->validate([
            'name' => 'required|string|max:255|min:3',
            'monthly_price' => 'required|numeric|max:100000|min:0'
        ]);

        $name = $data['name'];

        $slug = Str::slug($name);

        $data['slug'] = $slug;

        $category->update($data);

        session()->flash('swal', [
            'text'   => 'La categoría se ha actualizado correctamente.',
            'title' => '¡Bien hecho!',
            'icon'   => 'success',
        ]);

        return redirect()->route('admin.categories.edit', $category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        session()->flash('swal', [
            'icon'  => 'success',
            'title' => '¡Bien hecho!',
            'text'  => 'La categoria se ha eliminado correctamente',
        ]);

        return redirect()->route('admin.categories.index');
    }
}
