<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function invoice()
    {
        return view('admin.invoice');
    }

    public function invoicePrint(Request $request)
    {
        return view('admin.invoice-print', $request);
    }
}
