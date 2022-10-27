<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;

class PaymentController extends Controller
{

    public function store(Request $request)
    {   
        $request->validate([
            'payment_date' => 'required|date_format:Y-m-d H:i:s',
            'expires_at' => 'required|date_format:Y-m-d H:i:s',
            'status' => 'required|string',
            'client_id' => 'required|integer',
            'clp_usd' => 'required|numeric'
        ]);

        Payment::create([
            'payment_date' => $request->input('payment_date'),
            'expires_at' => $request->input('expires_at'),
            'status' => $request->input('status'),
            'client_id' => $request->input('client_id'),
            'clp_usd' => $request->input('clp_usd')
        ]);

        return response()->json([
            'message' => 'Successfully register payment!'
        ], 201);

    }

    public function paymentsByClient(Request $request) 
    {  
        $query = Payment::query();

        if ($request->has('client')) {
            $query->where('client_id', $request->input('client'));
        }

        return $query->get([
            'uuid', 'payment_date', 'expires_at', 'status', 'client_id', 'clp_usd'
        ]);
    }
}
