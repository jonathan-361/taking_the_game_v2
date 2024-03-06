<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Team;
use App\Models\Payment;
use App\Models\Payment_Reason;
use Carbon\Carbon;


class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $transactions = Transaction::with(['user', 'payment'])->get();

        // Transformar los datos según sea necesario
        $data = $transactions->map(function ($transaction) {
            return [
                'id' => $transaction->id,
                'user_name' => $transaction->user ? $transaction->user->name . ' ' . $transaction->user->first_surname . ' ' . $transaction->user->second_surname : null,
                'payment_reason' => $transaction->payment->payment_reason->payment_reason_name ?? null,
                'amount' => $transaction->payment->amount ?? null,
                'card_type' => $transaction->card_type,
                'payment_date' => $transaction->payment_date,
                'card_number' => $transaction->card_number,
                'expiry_date' => $transaction->expiry_date,
                'associeted_address' => $transaction->associeted_address,
                'card_owner' => $transaction->card_owner,
                'cvv' => $transaction->cvv,
                'created_at' => $transaction->created_at,
                'updated_at' => $transaction->updated_at,
            ];
        });

        // Construir la respuesta
        $responseData = [
            'transactions' => $data,
        ];

        // Retornar la respuesta
        return response()->json($responseData);
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
            'payment_reason' => 'required|string',
            'amount' => 'required|numeric',
            'team_name' => 'required|string',
            'due_date' => 'required|date',
            'card_type' => 'required|string',
            'payment_date' => 'required|date',
            'card_number' => 'required|numeric',
            'expiry_date' => 'required|date',
            'associeted_address' => 'nullable|string',
            'card_owner' => 'required|string',
            'cvv' => 'required|numeric',
        ]);
    
        // Obtener el usuario
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
    
        // Obtener el equipo
        $team = Team::where('name', $request->team_name)->first();
    
        if (!$team) {
            return response()->json(['error' => 'Equipo no encontrado'], 404);
        }
    
        // Obtener el motivo de pago
        $paymentReason = Payment_Reason::where('payment_reason_name', $request->payment_reason)->first();
    
        if (!$paymentReason) {
            return response()->json(['error' => 'Motivo de pago no encontrado'], 404);
        }
    
        // Obtener el pago
        $dueDate = Carbon::parse($request->due_date);
    
        $payment = Payment::where('user_id', $user->id)
            ->where('payment_reason_id', $paymentReason->id)
            ->where('amount', $request->amount)
            ->where('team_id', $team->id)
            ->where('due_date', $dueDate)
            ->first();
    
        if (!$payment) {
            return response()->json(['error' => 'Pago no encontrado'], 404);
        }
    
        // Crear la transacción
        $transaction = new Transaction;
        $transaction->user_id = $user->id;
        $transaction->payment_id = $payment->id;
        $transaction->card_type = $request->card_type;
        $transaction->payment_date = Carbon::parse($request->payment_date);
        $transaction->card_number = $request->card_number;
        $transaction->expiry_date = Carbon::parse($request->expiry_date);
        $transaction->associeted_address = $request->associeted_address;
        $transaction->card_owner = $request->card_owner;
        $transaction->cvv = $request->cvv;
        $transaction->save();

        $payment->status = 'Pagado';
        $payment->save();
    
        // Construir la respuesta
        $responseData = [
            'message' => 'Transaction created successfully',
            'transaction' => [
                'id' => $transaction->id,
                'user_name' => $request->user_name,
                'payment_reason' => $request->payment_reason,
                'amount' => $request->amount,
                'team_name' => $request->team_name,
                'due_date' => $request->due_date,
                'card_type' => $request->card_type,
                'payment_date' => $request->payment_date,
                'card_number' => $request->card_number,
                'expiry_date' => $request->expiry_date,
                'associeted_address' => $request->associeted_address,
                'card_owner' => $request->card_owner,
                'cvv' => $request->cvv,
                'created_at' => $transaction->created_at,
                'updated_at' => $transaction->updated_at,
            ],
        ];
    
        // Retornar la respuesta
        return response()->json($responseData, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
        $data = [
            'id' => $transaction->id,
            'user_name' => $transaction->user ? $transaction->user->name . ' ' . $transaction->user->first_surname . ' ' . $transaction->user->second_surname : null,
            'payment_reason' => $transaction->payment->payment_reason->payment_reason_name ?? null,
            'amount' => $transaction->payment->amount ?? null,
            'card_type' => $transaction->card_type,
            'payment_date' => $transaction->payment_date,
            'card_number' => $transaction->card_number,
            'expiry_date' => $transaction->expiry_date,
            'associeted_address' => $transaction->associeted_address,
            'card_owner' => $transaction->card_owner,
            'cvv' => $transaction->cvv,
            'created_at' => $transaction->created_at,
            'updated_at' => $transaction->updated_at,
        ];
    
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
        $transaction->delete();

        $data = [
            'message' => 'Transaction deleted successfully',
            'transaction' => [
                'id' => $transaction->id,
                'user_name' => $transaction->user ? $transaction->user->name . ' ' . $transaction->user->first_surname . ' ' . $transaction->user->second_surname : null,
                'payment_reason' => $transaction->payment->payment_reason->payment_reason_name ?? null,
                'amount' => $transaction->payment->amount ?? null,
                'card_type' => $transaction->card_type,
                'payment_date' => $transaction->payment_date,
                'card_number' => $transaction->card_number,
                'expiry_date' => $transaction->expiry_date,
                'associeted_address' => $transaction->associeted_address,
                'card_owner' => $transaction->card_owner,
                'cvv' => $transaction->cvv,
                'created_at' => $transaction->created_at,
                'updated_at' => $transaction->updated_at,
            ],
        ];

        return response()->json($data);
    }
}
