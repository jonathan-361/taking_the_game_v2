<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Team;
use App\Models\Payment_Reason;
use Carbon\Carbon;


class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $payments = Payment::with(['payment_reason', 'user', 'team'])
            ->orderBy('id')
            ->get()
            ->map(function ($payment) {
                // Concatenar el nombre completo con apellidos
                $userName = $payment->user->name . ' ' . $payment->user->first_surname . ' ' . $payment->user->second_surname;

                return [
                    'id' => $payment->id,
                    'user' => $userName,
                    'due_date' => $payment->due_date,
                    'team' => $payment->team ? $payment->team->name : null,
                    'payment_reason' => $payment->payment_reason->payment_reason_name,
                    'amount' => $payment->amount,
                    'status' => $payment->status,
                    'created_at' => $payment->created_at,
                    'updated_at' => $payment->updated_at,
                ];
            });

        // Construir la respuesta con los pagos
        $data = [
            'payments' => $payments,
        ];

        // Retornar la respuesta
        return response()->json($data);
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
        //
        $request->validate([
            'user_name' => 'required|string',
            'due_date' => 'required|date',
            'team' => 'required|string',
            'payment_reason' => 'required|string',
            'amount' => 'required|numeric',
            'status' => 'required|string',
        ]);
    
        preg_match('/^(?<name>[^\d]+) (?<first_surname>[^\d]+) (?<second_surname>.+)$/', $request->user_name, $matches);
    
        $userName = $matches['name'] ?? '';
        $userFirstSurname = $matches['first_surname'] ?? '';
        $userSecondSurname = $matches['second_surname'] ?? '';
    
        $user = User::where('name', 'like', $userName . '%')
            ->where('first_surname', 'like', $userFirstSurname . '%')
            ->where('second_surname', 'like', $userSecondSurname . '%')
            ->first();
    
        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        $team = Team::where('name', $request->team)->first();
    
        if (!$team) {
            return response()->json(['error' => 'Equipo no encontrado'], 404);
        }
    
        $dueDate = Carbon::parse($request->due_date);
    
        $payment = new Payment;
        $payment->user_id = $user->id;
        $payment->due_date = $dueDate;
        $payment->team_id = $team->id;
        $payment->payment_reason_id = Payment_Reason::where('payment_reason_name', $request->payment_reason)->value('id');
        $payment->amount = $request->amount;
        $payment->status = $request->status;
        $payment->save();

        $data = [
            'message' => 'Payment created successfully',
            'payment' => [
                'id' => $payment->id,
                'user_name' => $user->name . ' ' . $user->first_surname . ' ' . $user->second_surname,
                'due_date' => $payment->due_date,
                'team' => $team->name,
                'payment_reason' => $request->payment_reason,
                'amount' => $payment->amount,
                'status' => $payment->status,
                'created_at' => $payment->created_at,
                'updated_at' => $payment->updated_at,
            ],
        ];
    
        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        //
        $payment->load(['payment_reason', 'user', 'team']);

        $userName = $payment->user->name . ' ' . $payment->user->first_surname . ' ' . $payment->user->second_surname;

        $data = [
            'id' => $payment->id,
            'user' => $userName,
            'due_date' => $payment->due_date,
            'team' => $payment->team ? $payment->team->name : null,
            'payment_reason' => $payment->payment_reason->payment_reason_name,
            'amount' => $payment->amount,
            'status' => $payment->status,
            'created_at' => $payment->created_at,
            'updated_at' => $payment->updated_at,
        ];

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        //
        $request->validate([
            'user_name' => 'required|string',
            'due_date' => 'required|date',
            'team' => 'required|string',
            'payment_reason' => 'required|string',
            'amount' => 'required|numeric',
            'status' => 'required|string',
        ]);
    
        preg_match('/^(?<name>[^\d]+) (?<first_surname>[^\d]+) (?<second_surname>.+)$/', $request->user_name, $matches);
    
        $userName = $matches['name'] ?? '';
        $userFirstSurname = $matches['first_surname'] ?? '';
        $userSecondSurname = $matches['second_surname'] ?? '';
    
        $user = User::where('name', 'like', $userName . '%')
            ->where('first_surname', 'like', $userFirstSurname . '%')
            ->where('second_surname', 'like', $userSecondSurname . '%')
            ->first();
    
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
    
        $team = Team::where('name', $request->team)->first();
    
        if (!$team) {
            return response()->json(['error' => 'Team not found'], 404);
        }
    
        $dueDate = Carbon::parse($request->due_date);
    
        $payment->user_id = $user->id;
        $payment->due_date = $dueDate;
        $payment->team_id = $team->id;
        $payment->payment_reason_id = Payment_Reason::where('payment_reason_name', $request->payment_reason)->value('id');
        $payment->amount = $request->amount;
        $payment->status = $request->status;
        $payment->save();
    
        $data = [
            'message' => 'Payment updated successfully',
            'payment' => [
                'id' => $payment->id,
                'user_name' => $user->name . ' ' . $user->first_surname . ' ' . $user->second_surname,
                'due_date' => $payment->due_date,
                'team' => $team->name,
                'payment_reason' => $request->payment_reason,
                'amount' => $payment->amount,
                'status' => $payment->status,
                'created_at' => $payment->created_at,
                'updated_at' => $payment->updated_at,
            ],
        ];
    
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
        $payment->delete();

        $data = [
            'message' => 'Payment deleted successfully',
            'payment' => [
                'id' => $payment->id,
                'user_name' => $payment->user->name . ' ' . $payment->user->first_surname . ' ' . $payment->user->second_surname,
                'due_date' => $payment->due_date,
                'team' => $payment->team ? $payment->team->name : null,
                'payment_reason' => $payment->payment_reason->payment_reason_name,
                'amount' => $payment->amount,
                'status' => $payment->status,
                'created_at' => $payment->created_at,
                'updated_at' => $payment->updated_at,
            ],
        ];
    
        return response()->json($data);
    }
}
