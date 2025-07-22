<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (is_null($user->gym_id)) {
            return redirect()->route('admin.gyms.create')->with('message', 'Debe agregar un gimnasio antes de continuar');
        }

        return view('dashboard');
    }
}
