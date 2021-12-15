<?php

namespace App\Http\Controllers;

use App\GeneralLedger;
use App\Journal;
use App\JournalDetail;
use App\MasterModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class JournalController extends Controller
{
    public function indexJournal()
    {
        $journals = Journal::findAllJournals()->get();

        return view('journal.list_journal', compact('journals'));
    }

    public function addJournal()
    {
        $accounts = MasterModel::account_get();
        $currency = MasterModel::currency();

        return view('journal.add_journal', compact('accounts', 'currency'));
    }

    public function loadDetailJournal(Request $request)
    {
        $html = '';
        $amount = 0;
        $total_debit = 0;
        $total_credit = 0;

        $details = Session::get('journal_details');
        if ($details != []) {
            foreach ($details as $key => $detail) {
                $html .= '<tr>';
                $html .= '<td align="center">' . ($key + 1) . '</td>';
                $html .= '<td>' . $detail['account_number'] . '</td>';
                $html .= '<td>' . $detail['account_name'] . '</td>';
                $html .= '<td align="right">' . number_format($detail['debit'], 2, ',', '.') . '</td>';
                $html .= '<td align="right">' . number_format($detail['credit'], 2, ',', '.') . '</td>';
                $html .= '<td>' . $detail['memo'] . '</td>';
                $html .= '<td align="center">';
                $html .= '<a href="javascript:void(0);" class="btn btn-xs btn-danger" onclick="deleteDetailJournal(' . $key . ')">';
                $html .= '<i class="fa fa-trash"></i>';
                $html .= '</a>';
                $html .= '</td>';
                $html .= '</tr>';

                $total_debit += $detail['debit'];
                $total_credit += $detail['credit'];
                $amount += $detail['debit'];
            }
        }

        $html .= '<input type="hidden" name="total_debit" id="total_debit" value="' . $total_debit . '"/>';
        $html .= '<input type="hidden" name="total_credit" id="total_credit" value="' . $total_credit . '"/>';
        $html .= '<input type="hidden" name="amount" id="amount" value="' . $amount . '"/>';

        return $html;
    }

    public function saveDetailJournal(Request $request)
    {
        $transaction_type = 'D';
        if ($request->credit != 0) $transaction_type = 'C';

        $newItem = [
            'account_id' => $request->account_id,
            'account_number' => $request->account_number,
            'account_name' => $request->account_name,
            'transaction_type' => $transaction_type,
            'debit' => $request->debit,
            'credit' => $request->credit,
            'memo' => $request->memo,
        ];

        $request->session()->push('journal_details', $newItem);
    }

    public function deleteDetailJournal(Request $request)
    {
        $details = Session::get('journal_details');
        foreach ($details as $detail) {
            unset($details[$request->key]);
        }

        $request->session()->put('journal_details', $details);
    }

    public function saveJournal(Request $request)
    {
        $rules = [
            'journal_no' => 'required',
            'journal_date' => 'required',
            'currency_id' => 'required',
            'total_debit' => 'same:total_credit',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->with('errorForm', $validator->errors()->messages());
        }

        $details = Session::get('journal_details');
        if ($details == []) {
            return redirect()->back()->with('error', 'Please add detail!');
        }

        try {
            DB::beginTransaction();

            $param['id'] = $request->id;
            $param['journal_no'] = $request->journal_no;
            $param['journal_date'] = date('Y-m-d', strtotime($request->journal_date));
            $param['currency_id'] = $request->currency_id;
            $param['amount'] = $request->amount;
            $param['created_by'] = Auth::user()->name;
            $param['created_on'] = date('Y-m-d h:i:s');

            $journal = Journal::saveJournal($param);

            if ($request->id != 0) JournalDetail::deleteJournalDetailByJournalId($request->id);
            foreach ($details as $key => $detail) {
                unset($detail['account_number']);
                unset($detail['account_name']);
                $detail['id'] = 0;
                $detail['journal_id'] = $journal->id;
                $detail['created_by'] = Auth::user()->name;
                $detail['created_on'] = date('Y-m-d h:i:s');

                JournalDetail::saveJournalDetail($detail);
            }
            DB::commit();

            Session::forget('journal_details');
            return redirect()->route('journal.index')->with('success', 'Data saved!');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error("saveJournal Error ".$th->getMessage());
            return redirect()->back()->with('error', 'Something wrong, try again later!');
        }
    }

    public function editJournal($journalId)
    {
        $data['accounts'] = MasterModel::account_get();
        $data['currency'] = MasterModel::currency();
        $data['header'] = Journal::find($journalId);
        $details = JournalDetail::findAllJournalDetails($journalId)->get();

        if (Session::get('journal_details') == []) Session::put('journal_details', $details);

        return view('journal.edit_journal')->with($data);
    }

    public function viewJournal($journalId)
    {
        $data['accounts'] = MasterModel::account_get();
        $data['currency'] = MasterModel::currency();
        $data['header'] = Journal::find($journalId);
        $data['details'] = JournalDetail::findAllJournalDetails($journalId)->get();

        return view('journal.view_journal')->with($data);
    }

    public function postJournal(Request $request)
    {
        try {
            DB::beginTransaction();

            $journal_details = JournalDetail::where('journal_id', $request->id)->get();
            foreach ($journal_details as $key => $detail) {
                $param['id'] = 0;
                $param['gl_date'] = date('Y-m-d');
                $param['journal_id'] = $request->id;
                $param['account_id'] = $detail->account_id;
                $param['debit'] = $detail->debit;
                $param['credit'] = $detail->credit;
                $param['balance'] = ($detail->debit - $detail->credit);
                $param['created_by'] = Auth::user()->name;
                $param['created_on'] = date('Y-m-d h:i:s');

                GeneralLedger::saveGL($param);

                $refresh = GeneralLedgerController::refreshBalance($detail->account_id, date('Y-m-d'));
                if ($refresh['status'] == 'failed') {
                    return redirect()->back()->with('error', $refresh['message']);
                }
            }

            $paramJournal['id'] = $request->id;
            $paramJournal['flag_post'] = 1;
            $paramJournal['created_by'] = Auth::user()->name;
            $paramJournal['created_on'] = date('Y-m-d h:i:s');
            Journal::saveJournal($paramJournal);

            DB::commit();
            return redirect()->route('journal.index')->with('success', 'Journal posted!');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error("postJournal Error ".$th->getMessage());
            return redirect()->back()->with('error', 'Something wrong, try again later!');
        }
    }
}
