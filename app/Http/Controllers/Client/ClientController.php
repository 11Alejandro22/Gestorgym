<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\category_schedule;
use App\Models\CategoryScheduleClient;
use App\Models\Client;
use App\Models\Installment;
use App\Models\Payment;
use App\Models\Payment_method;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        

        return view('admin.clients.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $schedules = category_schedule::with(['category', 'user.coach', 'days'])
                    ->whereHas('user.coach', function ($query) {
                        $query->where('is_active', 1);
                    })
                    ->get();

        return view('admin.clients.create', compact('schedules'));
    }




















    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            $data = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name'  => 'required|string|max:255',
                'DNI'        => 'required|string|max:8|unique:persons,DNI',
                'phone'      => 'required|string',
                'email'      => 'required|email|unique:users,email|unique:persons,email',
                'category_schedules'   => 'required|array',
                'category_schedules.*' => 'integer',
            ]);

            $person = Person::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'DNI' => $data['DNI'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'status' => 1,
            ]);

            $user = auth('web')->user();

            $client = Client::create([
                'gym_id' => $user->gym_id,
                'person_id' => $person->id,
                'is_active' => 1,
            ]);

            $totalAmount = 0;

            foreach ($data['category_schedules'] as $categoryScheduleId) {
                $categoryScheduleClient = CategoryScheduleClient::create([
                    'enrollment_date' => now(),
                    'category_schedule_id' => $categoryScheduleId,
                    'client_id' => $client->id,
                ]);

                $categorySchedule = category_schedule::with('category')->findOrFail($categoryScheduleId);
                $totalAmount += $categorySchedule->category->monthly_price;
            }

            Installment::create([
                'client_id' => $client->id,
                'due_date' => now()->addDays(30),
                'amount' => $totalAmount,
                'paid_date' => null,
                'status_id' => 1,
            ]);
            

            session()->flash('swal', [
                'text' => 'El cliente se ha creado correctamente.',
                'title' => '¡Bien hecho!',
                'icon' => 'success',
            ]);

            return redirect()->route('admin.clients.index');

    }






















    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        $schedules = category_schedule::with(['category', 'user.coach', 'days'])
                    ->whereHas('user.coach', function ($query) {
                        $query->where('is_active', 1);
                    })
                    ->get();

        $selectedSchedules = $client->categorySchedules()->pluck('category_schedule_id')->toArray();

        return view('admin.clients.edit', compact('client', 'schedules', 'selectedSchedules'));
    }


























    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        $data = $request->validate([
            'first_name'            => 'required|string|max:255',
            'last_name'             => 'required|string|max:255',
            'DNI'                   => 'required|string|max:8|unique:persons,DNI,' . $client->person_id,
            'phone'                 => 'required|string',
            'email'                 => 'required|email|unique:users,email,' . $client->person->user_id . '|unique:persons,email,' . $client->person_id,
            'category_schedules'    => 'required|array',
            'category_schedules.*'  => 'integer',
        ]);

        $client->person->update([
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'DNI'        => $data['DNI'],
            'phone'      => $data['phone'],
            'email'      => $data['email'],
        ]);
        
        $currentSchedules = $client->categorySchedules()
        ->get()
        ->mapWithKeys(function ($schedule) {
            return [$schedule->id => $schedule->pivot->enrollment_date];
        })
        ->toArray();
        
        $syncData = [];
        foreach ($data['category_schedules'] as $scheduleId) {
            $syncData[$scheduleId] = [
                'enrollment_date' => $currentSchedules[$scheduleId] ?? now(),
            ];
        }

        $client->categorySchedules()->sync($syncData);

        session()->flash('swal', [
            'text'  => 'El cliente se ha actualizado correctamente.',
            'title' => '¡Bien hecho!',
            'icon'  => 'success',
        ]);

        return redirect()->route('admin.clients.index');
    }
















    public function showPaymentsForm(Client $client)
    {
        $category_schedules = category_schedule::with([
            'category',
            'user.coach',
            'days',
            'clients.person'
        ])
        ->whereHas('user.coach', fn ($q) => $q->where('is_active', 1))
        ->whereHas('clients', fn ($q) => $q->where('clients.id', $client->id))
        ->get();

        $installment = Installment::where('client_id', $client->id)
        ->orderBy('due_date', 'asc')
        ->first();

        $total = $category_schedules->sum(fn($schedule) => $schedule->category->monthly_price);

        $paymentMethod = Payment_method::all();

        $historial = DB::table('payments')
        ->join('payment_methods', 'payments.payment_method_id', '=', 'payment_methods.id')
        ->join('installments', 'payments.installment_id', '=', 'installments.id')
        ->join('clients', 'installments.client_id', '=', 'clients.id')
        ->join('persons', 'clients.person_id', '=', 'persons.id')
        ->where('clients.id', $client->id)
        ->select(
            'payments.payment_date',
            'payment_methods.name as metodo_pago',
            'payments.amount_paid',
        )
        ->orderByDesc('payments.payment_date')
        ->paginate(10);

        return view('admin.clients.payments', compact('client', 'category_schedules', 'total', 'paymentMethod', 'installment', 'historial'));
    }





















    public function storeMonthlyPayment(Request $request, Client $client)
    {
        $validated = $request->validate([
            'payment_method_id'   => 'required|exists:payment_methods,id',
        ]);

        $category_schedules = category_schedule::with([
            'category',
            'user.coach',
            'days',
            'clients.person'
        ])
        ->whereHas('user.coach', fn ($q) => $q->where('is_active', 1))
        ->whereHas('clients', fn ($q) => $q->where('clients.id', $client->id))
        ->get();

        $total = $category_schedules->sum(fn($schedule) => $schedule->category->monthly_price);
        // Verificar que la cuota pertenece al cliente


        $installment = Installment::where('client_id', $client->id)
        ->orderBy('due_date', 'asc')
        ->first();


        $paymentMethodId = (int)$validated['payment_method_id'];
        
        

        $payment = Payment::create([
            'installment_id'          => $installment->id,
            'payment_method_id'       => $paymentMethodId,
            'payment_status_id'       => 1,
            'amount_paid'             => $total,
            'payment_date'            => now(),
            'gateway_transaction_id'  => null,
            'gateway_preference_id'   => null,
            'gateway_status_detail'   => null,
        ]);

        $nuevoVencimiento = now()->addDays(30);

        $installment->status_id = 1;
        $installment->due_date  = $nuevoVencimiento->toDateString();
        $installment->save();

        session()->flash('swal', [
        'text'  => 'El Pago se ha realizado correctamente.',
        'title' => '¡Bien hecho!',
        'icon'  => 'success',
        ]);

        return redirect()->route('admin.clients.index');

    }


























    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Client $client)
    {
        //
    }
}
