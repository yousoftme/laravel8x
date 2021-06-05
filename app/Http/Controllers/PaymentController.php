<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function updatePaymentMethod()
    {
        return view('update-payment-method', [
            'intent' => Auth::user()->createSetupIntent()
        ]);
    }
}
