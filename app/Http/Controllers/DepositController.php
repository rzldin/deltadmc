<?php

namespace App\Http\Controllers;

use App\Deposit;
use App\DepositDetail;
use App\MasterModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class DepositController extends Controller
{
    public function index()
    {
        $deposits = Deposit::getAllDeposits()->get();
        $companies = MasterModel::company_data();

        return view('deposit.list_deposit', compact('deposits', 'companies'));
    }

    public function save(Request $request)
    {
        $rules = [
            'deposit_date' => 'required',
            'company_id' => 'required',
            'amount' => 'required|numeric|not_in:0',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->with('errorForm', $validator->errors()->messages());
        }

        DB::beginTransaction();
        try {
            $paramHeader['id'] = $request->id;
            $paramHeader['company_id'] = $request->company_id;
            $paramHeader['balance'] = $request->amount;
            $paramHeader['created_by'] = Auth::user()->name;
            $paramHeader['created_on'] = date('Y-m-d h:i:s');

            $deposit = Deposit::find($request->id);
            if ($deposit != []) {
                $paramHeader['balance'] = ($deposit->balance + $request->amount);
            }
            $deposit = Deposit::saveDeposit($paramHeader);

            $paramDetail['deposit_id'] = $deposit->id;
            $paramDetail['deposit_date'] = date('Y-m-d', strtotime($request->deposit_date));
            $paramDetail['amount'] = $request->amount;
            $paramDetail['created_by'] = Auth::user()->name;
            $paramDetail['created_on'] = date('Y-m-d h:i:s');
            DepositDetail::create($paramDetail);

            DB::commit();
            return redirect()->route('deposit.index')->with('success', 'Data saved!');
        } catch (\Throwable $th) {
            DB::rollBack();

            Log::error('SaveDeposit Error '.$th->getMessage());
            return redirect()->back()->with('error', 'Something wrong, try again later!');
        }
    }
}
