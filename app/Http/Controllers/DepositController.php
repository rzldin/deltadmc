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

        $resultJson = $this->processSave($request);
        $result = json_decode($resultJson);

        if ($result->status == 'success') {
            return redirect()->route('deposit.index')->with('success', $result->message);
        } else {
            return redirect()->back()->with('error', $result->message);
        }
    }

    public function processSave(Request $request)
    {
        DB::beginTransaction();
        $response = [];
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
            $paramDetail['invoice_id'] = ($request->has('invoice_id') ? $request->invoice_id : 0);
            $paramDetail['remark'] = ($request->has('remark') ? $request->remark : null);
            $paramDetail['created_by'] = Auth::user()->name;
            $paramDetail['created_on'] = date('Y-m-d h:i:s');
            $depositDetail = DepositDetail::create($paramDetail);
            DB::commit();

            $response = [
                'status' => 'success',
                'message' => 'Data saved!',
                'data' => ['deposit' => $deposit, 'deposit_detail' => $depositDetail]
            ];

            return response()->json($response);
        } catch (\Throwable $th) {
            DB::rollBack();

            $response = [
                'status' => 'failed',
                'message' => $th->getMessage(),
                'data' => null
            ];

            Log::error('SaveDeposit Error '.$th->getMessage());
            return response()->json($response);
        }
    }

    public function getDepositCompany(Request $request)
    {
        $deposit = Deposit::where('company_id', $request->company_id)->first();

        return $deposit;
    }

    public static function deleteDepositPembayaran($request)
    {
        DB::beginTransaction();
        try {
            $depositDetail = DepositDetail::find($request['deposit_detail_id']);
            $deposit = Deposit::find($depositDetail->deposit_id);

            $paramHeader['id'] = $deposit->id;
            $paramHeader['balance'] = $deposit->balance + ($depositDetail->amount * -1);
            $paramHeader['created_by'] = Auth::user()->name;
            $paramHeader['created_on'] = date('Y-m-d h:i:s');

            $deposit = Deposit::saveDeposit($paramHeader);
            $depositDetail->delete();

            $response = [
                'status' => 'success',
                'message' => 'Data saved!',
                'data' => $deposit
            ];

            DB::commit();
            return response()->json($response);
        } catch (\Throwable $th) {
            $response = [
                'status' => 'failed',
                'message' => $th->getMessage(),
                'data' => null
            ];

            DB::rollBack();
            Log::error('DeleteDepositPembayaran Error '.$th->getMessage());
            return response()->json($response);
        }
    }
}
