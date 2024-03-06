<?php

namespace App\Http\Controllers;

use App\Models\Payment_Reason;
use Illuminate\Http\Request;

class PaymentReasonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $payment_Reason = Payment_Reason::all();
        return response()->json($payment_Reason);
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
        $payment_Reason = new Payment_Reason;
        $payment_Reason->payment_reason_name = $request->payment_reason_name;
        $payment_Reason->save();
        $data = [
            'message' => 'Payment reason created successfully',
            'payment_reason' => $payment_Reason
        ];
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment_Reason $payment_Reason)
    {
        //
        return response()->json($payment_Reason);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment_Reason $payment_Reason)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment_Reason $payment_Reason)
    {
        //
        $payment_Reason->payment_reason_name = $request->payment_reason_name;
        $payment_Reason->save();
        $data = [
            'message' => 'Payment reason updated successfully',
            'payment_reason' => $payment_Reason
        ];
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment_Reason $payment_Reason)
    {
        //
        $payment_Reason->delete();
        $data = [
            'message' => 'Payment reason deleted successfully',
            'payment_reason' => $payment_Reason
        ];
        return response()->json($data);
    }
}
