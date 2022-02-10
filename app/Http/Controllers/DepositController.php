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
        $account = MasterModel::account_get_detail(265);
        $saldo = Deposit::findSaldoDeposit();
        $deposits = Deposit::getAllDeposits()->get();
        $companies = MasterModel::company_data();

        return view('deposit.list_deposit', compact('account', 'saldo', 'deposits', 'companies'));
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
            // $paramHeader['account_id'] = $request->account_id;
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
            $paramDetail['journal_id'] = ($request->has('journal_id') ? $request->journal_id : 0);
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

            return json_encode($response);
        } catch (\Throwable $th) {
            DB::rollBack();

            $response = [
                'status' => 'failed',
                'message' => $th->getMessage(),
                'data' => null
            ];
            Log::error('SaveDeposit Error ' . $th->getMessage());
            return json_encode($response);
        }
    }

    public function processSavePembayaranDeposit(Request $request)
    {
        DB::beginTransaction();
        $response = [];
        try {
            $amount = 0;
            $deposit = Deposit::find($request->id);
            foreach ($request->journal_id as $key => $journal_id) {
                $amount_detail = $request->amount[$key];
                $paramDetail['deposit_id'] = $deposit->id;
                $paramDetail['deposit_date'] = date('Y-m-d', strtotime($request->deposit_date));
                $paramDetail['amount'] = $amount_detail;
                $paramDetail['invoice_id'] = $request->invoice_id;
                $paramDetail['journal_id'] = $journal_id;
                $paramDetail['remark'] = ($request->has('remark') ? $request->remark : null);
                $paramDetail['created_by'] = Auth::user()->name;
                $paramDetail['created_on'] = date('Y-m-d h:i:s');
                $depositDetail = DepositDetail::create($paramDetail);

                $amount += $amount_detail;
            }
            $paramHeader['id'] = $request->id;
            // $paramHeader['account_id'] = $request->account_id;
            $paramHeader['company_id'] = $request->company_id;
            $paramHeader['balance'] = $amount;
            $paramHeader['created_by'] = Auth::user()->name;
            $paramHeader['created_on'] = date('Y-m-d h:i:s');

            if ($deposit != []) {
                $paramHeader['balance'] = ($deposit->balance + $amount);
            }
            $deposit = Deposit::saveDeposit($paramHeader);

            DB::commit();

            $response = [
                'status' => 'success',
                'message' => 'Data saved!',
                'data' => ['deposit' => $deposit, 'deposit_detail' => $depositDetail]
            ];

            return json_encode($response);
        } catch (\Throwable $th) {
            DB::rollBack();

            $response = [
                'status' => 'failed',
                'message' => $th->getMessage(),
                'data' => null
            ];
            Log::error('SaveDeposit Error ' . $th->getMessage());
            return json_encode($response);
        }
    }

    public function getDepositCompany(Request $request)
    {
        $deposit = Deposit::where('company_id', $request->company_id)->first();

        return $deposit;
    }

    public function getListDeposit(Request $request)
    {
        $deposits = DepositDetail::getListDeposit($request->company_id)->get();

        $html = "";
        if ($deposits != []) {
            foreach ($deposits as $key => $deposit) {
                $amount = number_format($deposit->amount, 2, '.', ',');
                $html .= "<div class='row mb-2'>";
                $html .= "<div class='col-md-5'>";
                $html .= "{$deposit->journal_no}";
                $html .= "</div>";
                $html .= "<div class='col-md-7'>";
                $html .= "<div class='row'>";
                $html .= "<div class='col-md-2'>";
                $html .= "<input class='form-check-input' type='checkbox' value='{$deposit->journal_id}' onchange='useDeposit({$deposit->journal_id})' name='deposit[journal_id]' id='check_{$deposit->journal_id}'>";
                $html .= "</div>";
                $html .= "<div class='col-md-10'>";
                $html .= "<label class='form-check-label' for='{$deposit->journal_id}'>";
                $html .= "<input type='text' class='form-control' value='{$amount}' id='amount_{$deposit->journal_id}' name='deposit[amount]' onkeyup='getComa(this.value, this.id)'/>";
                $html .= "</label>";
                $html .= "</div>";
                $html .= "</div>";
                $html .= "</div>";
                $html .= "</div>";
            }
        }

        return $html;
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
            Log::error('DeleteDepositPembayaran Error ' . $th->getMessage());
            return response()->json($response);
        }
    }
}
