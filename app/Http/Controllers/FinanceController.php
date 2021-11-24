<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FinanceModel;
use DB;

class FinanceController extends Controller
{
    public function index()
    {
        $data = FinanceModel::getQuote();
        return view('finance.index', compact('data'));
    }
}
