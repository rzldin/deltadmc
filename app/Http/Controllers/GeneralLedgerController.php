<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeneralLedgerController extends Controller
{
    public function index()
    {
        return view('general_ledger.list_general_ledger');
    }

    public function save(Request $request)
    {
        # code...
    }
}
