<?php

namespace App\Http\Controllers;

use App\Deposit;
use App\DepositDetail;
use App\Journal;
use App\JournalDetail;
use App\MasterModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class JournalDepositController extends Controller
{
    public function addJournal(Request $request)
    {
        $data['companies'] = MasterModel::company_data();
        $data['accounts'] = MasterModel::account_get();
        $data['currency'] = MasterModel::currency();
        $data['reference_no'] = $request->reference_no;
        $data['reference_id'] = $request->reference_id;
        $data['client_id'] = $request->client_id;
        $data['source'] = $request->source;

        Session::forget('journal_details');
        // $journals = Session::get('journal_details');
        // if ($request->has('source')) $this->saveDefaultDetailJournal($request);

        return view('journal_deposit.add_journal')->with($data);
    }

    public function loadDetailJournal(Request $request)
    {
        $html = '';
        $amount = 0;
        $total_debit = 0;
        $total_credit = 0;

        $details = Session::get('journal_details');
        if ($details == [] && $request->journal_type == "deposit_client") {
            # deposit client (customer terjadi lebih bayar ke deltadmc)
            $account_bank = MasterModel::findAccountByAccountNumber('1-1100')->first();
            // $request = new Request();
            $request->account_id = $account_bank->id;
            $request->account_number = $account_bank->account_number;
            $request->account_name = $account_bank->account_name;
            $request->debit = 1;
            $request->credit = 0;
            $request->memo = null;
            $this->saveDetailJournal($request);

            $account_piutang = MasterModel::findAccountByAccountNumber('1-1200')->first();
            // $request = new Request();
            $request->account_id = $account_piutang->id;
            $request->account_number = $account_piutang->account_number;
            $request->account_name = $account_piutang->account_name;
            $request->debit = 0;
            $request->credit = 1;
            $request->memo = null;
            $this->saveDetailJournal($request);

            $account_deposit = MasterModel::findAccountByAccountNumber('1-1220')->first();
            // $param = new Request();
            $request->account_id = $account_deposit->id;
            $request->account_number = $account_deposit->account_number;
            $request->account_name = $account_deposit->account_name;
            $request->debit = 0;
            $request->credit = 1;
            $request->memo = null;
            $this->saveDetailJournal($request);
        } else if ($details == [] && $request->journal_type == "deposit_vendor") {
            # deposit vendor (deltadmc terjadi lebih bayar ke vendor)
            $account_hutang = MasterModel::findAccountByAccountNumber('2-1000')->first();
            // $request = new Request();
            $request->account_id = $account_hutang->id;
            $request->account_number = $account_hutang->account_number;
            $request->account_name = $account_hutang->account_name;
            $request->debit = 1;
            $request->credit = 0;
            $request->memo = null;
            $this->saveDetailJournal($request);

            $account_deposit = MasterModel::findAccountByAccountNumber('1-1220')->first();
            // $param = new Request();
            $request->account_id = $account_deposit->id;
            $request->account_number = $account_deposit->account_number;
            $request->account_name = $account_deposit->account_name;
            $request->debit = 1;
            $request->credit = 0;
            $request->memo = null;
            $this->saveDetailJournal($request);

            $account_bank = MasterModel::findAccountByAccountNumber('1-1100')->first();
            // $request = new Request();
            $request->account_id = $account_bank->id;
            $request->account_number = $account_bank->account_number;
            $request->account_name = $account_bank->account_name;
            $request->debit = 0;
            $request->credit = 1;
            $request->memo = null;
            $this->saveDetailJournal($request);
        }
        $details = Session::get('journal_details');
        if ($details != []) {
            $accounts = MasterModel::account_get();
            foreach ($details as $key => $detail) {
                $html .= '<tr>';
                $html .= '<td align="center">' . ($key + 1) . '</td>';
                $html .= '<td>';
                $html .= '<label class="" id="label_account_number_' . $key . '">' . $detail['account_number'] . '</label>';
                $html .= '<select id="account_id_' . $key . '" class="form-control select2bs44 display-none" onchange="getDetailAccountForEdit(this.value, ' . $key . ')">';
                foreach ($accounts as $idx => $acc) {
                    $html .= '<option value="' . $acc->id . '" ' . ($acc->id == $detail['account_id'] ? 'selected' : '') . '>' . $acc->account_number . ' - ' . $acc->account_name . '</option>';
                }
                $html .= '</select>';
                $html .= '</td>';
                $html .= '<td>';
                $html .= '<label class="" id="label_account_name_' . $key . '">' . $detail['account_name'] . '</label>';
                $html .= '<input type="hidden" id="account_number_' . $key . '" value="' . $detail['account_number'] . '"/>';
                $html .= '<input type="text" id="account_name_' . $key . '" class="form-control display-none" value="' . $detail['account_name'] . '" readonly/>';
                $html .= '</td>';
                $html .= '<td align="right">';
                $html .= '<label class="" id="label_debit_' . $key . '">' . number_format($detail['debit'], 2, '.', ',') . '</label>';
                $html .= '<input type="number" id="debit_' . $key . '" class="form-control display-none" value="' . $detail['debit'] . '"/>';
                $html .= '</td>';
                $html .= '<td align="right">';
                $html .= '<label class="" id="label_credit_' . $key . '">' . number_format($detail['credit'], 2, '.', ',') . '</label>';
                $html .= '<input type="number" id="credit_' . $key . '" class="form-control display-none" value="' . $detail['credit'] . '"/>';
                $html .= '</td>';
                $html .= '<td>';
                $html .= '<label class="" id="label_memo_' . $key . '">' . $detail['memo'] . '</label>';
                $html .= '<textarea id="memo_' . $key . '" class="form-control display-none">' . $detail['memo'] . '</textarea>';
                $html .= '</td>';
                $html .= '<td align="center">';
                $html .= '<a href="javascript:void(0);" id="btn_edit_' . $key . '" class="btn btn-xs btn-warning" onclick="editDetailJournal(' . $key . ')">';
                $html .= '<i class="fa fa-edit"></i>';
                $html .= '</a>&nbsp;';
                $html .= '<a href="javascript:void(0);" id="btn_update_' . $key . '" class="btn btn-xs btn-primary display-none" onclick="updateDetailJournal(' . $key . ')">';
                $html .= '<i class="fa fa-save"></i>';
                $html .= '</a>&nbsp;';
                $html .= '<a href="javascript:void(0);" class="btn btn-xs btn-danger" onclick="deleteDetailJournal(' . $key . ')">';
                $html .= '<i class="fa fa-trash"></i>';
                $html .= '</a>&nbsp;';
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

    public function updateDetailJournal(Request $request)
    {
        // dd($request->session()->get('journal_details'));
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

        $request->session()->put('journal_details.' . $request->key, $newItem);
    }

    public function deleteDetailJournal(Request $request)
    {
        $details = Session::get('journal_details');
        foreach ($details as $detail) {
            unset($details[$request->key]);
        }

        $request->session()->put('journal_details', $details);
    }

    public function clearSessionJournal(Request $request)
    {
        Session::forget('journal_details');
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
            if ($request->has('journal_type') && $request->journal_type != 'general_journal') {
                $param['company_id'] = $request->company_id;
                $param['invoice_id_deposit'] = $request->invoice_id_deposit;
                $param['external_invoice_id_deposit'] = 0;
                if ($request->journal_type == 'deposit_client') {
                    $param['invoice_id_deposit'] = 0;
                    $param['external_invoice_id_deposit'] = $request->invoice_id_deposit;
                }
            }
            $param['amount'] = $request->amount;
            $param['created_by'] = Auth::user()->name;
            $param['created_on'] = date('Y-m-d h:i:s');

            $journal = Journal::saveJournal($param);

            $amount = 0;
            if ($request->id != 0) JournalDetail::deleteJournalDetailByJournalId($request->id);
            foreach ($details as $key => $detail) {
                $account_deposit = MasterModel::findAccountByAccountNumber('1-1220')->first();
                if ($detail['account_id'] == $account_deposit->id && $detail['debit'] > 0) {
                    if ($request->journal_type == 'deposit_vendor') {
                        #jika journal type = deposit vendor dan detail account adalah account deposit, dan posisi nya ada di debit, maka tambah saldo deposit
                        $amount += $detail['debit'];
                    } else {
                        #jika journal type = deposit client dan detail account adalah account deposit, dan posisi nya ada di debit, maka kurangi saldo deposit
                        $amount += ($detail['debit'] * -1);
                    }
                } else if ($detail['account_id'] == $account_deposit->id && $detail['credit'] > 0) {
                    if ($request->journal_type == 'deposit_vendor') {
                        #jika journal type = deposit_client dan account deposit ada di kredit, maka kurangi saldo deposit
                        $amount += $detail['credit'];
                    } else {
                        #jika journal type = deposit_client dan account deposit ada di kredit, maka tambah saldo deposit
                        $amount += $detail['credit'];
                    }
                }
                unset($detail['account_number']);
                unset($detail['account_name']);
                $detail['id'] = 0;
                $detail['journal_id'] = $journal->id;
                $detail['created_by'] = Auth::user()->name;
                $detail['created_on'] = date('Y-m-d h:i:s');

                JournalDetail::saveJournalDetail($detail);
            }
            $deposit_detail = DepositDetail::where('journal_id', $journal->id)->first();
            $deposit = Deposit::where('company_id', $request->company_id)->where('currency_id', $request->currency_id)->first();
            if ($deposit_detail != [] && $deposit != []) {
                # kalau edit jurnal, nilai balance deposit di reset ke posisi awal dulu
                # balance di deposit kurangi dulu dengan amount di deposit detail, agar dapet nilai balance awal, kemudian baru ditambah dengan amount yang baru diedit di jurnal
                $paramDepositH['balance'] = $deposit->balance - $deposit_detail->amount + $amount;
            } else if ($deposit_detail == [] && $deposit != []) {
                # kalau jurnal baru, tapi sudah pernah deposit
                $paramDepositH['balance'] = $deposit->balance + $amount;
            } else {
                # jurnal baru, dan belum pernah deposit sama sekali
                $paramDepositH['balance'] = $amount;
            }

            $paramDepositH['id'] = $deposit == [] ? 0 : $deposit->id;
            $paramDepositH['currency_id'] = $request->currency_id;
            $paramDepositH['company_id'] = $request->company_id;
            $paramDepositH['created_by'] = Auth::user()->name;
            $paramDepositH['created_on'] = date('Y-m-d h:i:s');
            $deposit = Deposit::saveDeposit($paramDepositH);

            $paramDepositD['id'] = $deposit_detail == [] ? 0 : $deposit_detail->id;
            $paramDepositD['deposit_id'] = $deposit->id;
            $paramDepositD['deposit_date'] = date('Y-m-d', strtotime($request->journal_date));
            $paramDepositD['amount'] = $amount;
            $paramDepositD['invoice_id'] = ($request->has('invoice_id') ? $request->invoice_id : 0);
            $paramDepositD['journal_id'] = $journal->id;
            $paramDepositD['remark'] = ($request->has('remark') ? $request->remark : null);
            $paramDepositD['created_by'] = Auth::user()->name;
            $paramDepositD['created_on'] = date('Y-m-d h:i:s');
            $depositDetail = DepositDetail::saveDepositDetail($paramDepositD);
            DB::commit();

            Session::forget('journal_details');
            return redirect()->route('journal.index')->with('success', 'Data saved!');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error("saveJournal Error ", $th->getTrace());
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function editJournal($journalId)
    {
        Session::forget('journal_details');
        $data['companies'] = MasterModel::company_data();
        $data['accounts'] = MasterModel::account_get();
        $data['currency'] = MasterModel::currency();
        $data['header'] = Journal::findJournal($journalId)->first();

        /**
         * kalau journal deposit, cek dulu depositnya sudah dipakai pembayaran atau belum
         */
        if ($data['header']->external_invoice_id_deposit != 0 || $data['header']->invoice_id_deposit != 0) {
            $deposit_dtl = DepositDetail::where('journal_id', $journalId);
            if ($deposit_dtl->count() > 0) {
                foreach ($deposit_dtl->get() as $key => $dtl) {
                    if ($dtl->pembayaran_id != 0) {
                        return redirect()->back()->with('error', 'Journal deposit sudah digunakan pembayaran, tidak dapat edit');
                    }
                }
            }
        }

        $data['header']->journal_type = 'general_journal';

        if ($data['header']->invoice_id_deposit != 0) $data['header']->journal_type = 'deposit_vendor';
        else if ($data['header']->external_invoice_id_deposit != 0) $data['header']->journal_type = 'deposit_client';

        $details = JournalDetail::findAllJournalDetails($journalId)->get();
        if (Session::get('journal_details') == []) Session::put('journal_details', $details->toArray());

        return view('journal_deposit.edit_journal')->with($data);
    }
}
