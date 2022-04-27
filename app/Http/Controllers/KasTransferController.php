<?php

namespace App\Http\Controllers;

use App\Journal;
use App\KasTransfer;
use App\MasterModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class KasTransferController extends Controller
{
    public function indexKasTransfer()
    {
        $kas_transfers = KasTransfer::getAllKasTransfer()->get();

        return view('kas.transfer.list_kas_transfer', compact('kas_transfers'));
    }

    public function addKasTransfer()
    {
        $data['accounts'] = MasterModel::account_get();

        return view('kas.transfer.add_kas_transfer')->with($data);
    }

    public function saveKasTransfer(Request $request)
    {
        $rules = [
            'transfer_date' => 'required',
            'from_account_id' => 'required',
            'to_account_id' => 'required',
            'amount' => 'required',
            'memo' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->with('errorForm', $validator->errors()->messages());
        }

        try {
            DB::beginTransaction();

            $param = $request->all();
            $param['id'] = 0;
            $param['transfer_date'] = Carbon::createFromFormat('d/m/Y', $request->transfer_date)->format('Y-m-d');
            $param['created_by'] = Auth::user()->name;
            $param['created_on'] = date('Y-m-d h:i:s');

            KasTransfer::saveKasTransfer($param);

            // $transactonGroupId = (Journal::findMaxTransactionGroupId() + 1);

            // for ($i = 0; $i < 2; $i++) {
            //     $paramJournal['id'] = 0;
            //     $paramJournal['journal_date'] = $param['transfer_date'];
            //     $paramJournal['currency_id'] = 1;
            //     $paramJournal['amount'] = $param['amount'];
            //     $paramJournal['memo'] = $param['memo'];
            //     $paramJournal['transaction_group_id'] = $transactonGroupId;
            //     $paramJournal['created_by'] = $param['created_by'];
            //     $paramJournal['created_on'] = $param['created_on'];
            //     if ($i == 0) {
            //         $paramJournal['account_id'] = $param['from_account_id'];
            //         $paramJournal['transaction_type'] = 'D';
            //     } else if ($i == 1) {
            //         $paramJournal['account_id'] = $param['to_account_id'];
            //         $paramJournal['transaction_type'] = 'K';
            //     }

            //     Journal::saveJournal($paramJournal);
            // }

            DB::commit();
            return redirect()->route('kas.transfer.index')->with('success', 'Data saved!');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error("Save Kas Transfer Error ".$th->getMessage());

            return redirect()->back()->with('error', 'Something wrong, please try again later!');
        }
    }
}
