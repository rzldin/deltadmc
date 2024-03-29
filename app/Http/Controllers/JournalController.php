<?php

namespace App\Http\Controllers;

use App\Deposit;
use App\DepositDetail;
use App\GeneralLedger;
use App\InvoiceModel;
use App\Journal;
use App\JournalDetail;
use App\MasterModel;
use App\PembayaranModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class JournalController extends Controller
{
    public function indexJournal()
    {
        $journals = Journal::findAllJournals()->get();

        return view('journal.list_journal', compact('journals'));
    }

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
        if ($request->has('source')){
            if ($request->source == 'invoice') $data['invoice'] = $this->saveDetailJournalInvoice($request);
            if ($request->source == 'pembayaran') $data['pembayaran'] = $this->saveDetailJournalPembayaran($request);
        }

        return view('journal.add_journal')->with($data);
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
            $request->account_id = $account_bank->id;
            $request->account_number = $account_bank->account_number;
            $request->account_name = $account_bank->account_name;
            $request->debit = 1;
            $request->credit = 0;
            $request->memo = null;
            $this->saveDetailJournal($request);

            $account_piutang = MasterModel::findAccountByAccountNumber('1-1200')->first();
            $request->account_id = $account_piutang->id;
            $request->account_number = $account_piutang->account_number;
            $request->account_name = $account_piutang->account_name;
            $request->debit = 0;
            $request->credit = 1;
            $request->memo = null;
            $this->saveDetailJournal($request);

            $account_deposit = MasterModel::findAccountByAccountNumber('1-1220')->first();
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
            $request->account_id = $account_hutang->id;
            $request->account_number = $account_hutang->account_number;
            $request->account_name = $account_hutang->account_name;
            $request->debit = 1;
            $request->credit = 0;
            $request->memo = null;
            $this->saveDetailJournal($request);

            $account_deposit = MasterModel::findAccountByAccountNumber('1-1220')->first();
            $request->account_id = $account_deposit->id;
            $request->account_number = $account_deposit->account_number;
            $request->account_name = $account_deposit->account_name;
            $request->debit = 1;
            $request->credit = 0;
            $request->memo = null;
            $this->saveDetailJournal($request);

            $account_bank = MasterModel::findAccountByAccountNumber('1-1100')->first();
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

    public function clearSessionJournal(Request $request)
    {
        Session::forget('journal_details');
    }

    public function saveDefaultDetailJournal(Request $request)
    {
        if ($request->source == 'invoice') $this->saveDetailJournalInvoice($request);
        if ($request->source == 'pembayaran') $this->saveDetailJournalPembayaran($request);
    }

    public function saveDetailJournalInvoice(Request $request)
    {
        $company = MasterModel::company_detail_get($request->client_id);
        $invoice = InvoiceModel::find($request->reference_id);

        if ($company != []) {
            if ($invoice->tipe_inv == 0) {
                /** invoice piutang */
                // account ar di debit
                $newItem = [
                    'account_id' => $company[0]->account_receivable_id,
                    'account_number' => $company[0]->account_receivable_number,
                    'account_name' => $company[0]->account_receivable_name,
                    'transaction_type' => 'D',
                    'debit' => $invoice->total_invoice + $invoice->pph23,
                    'credit' => 0,
                    'memo' => 'AR ' . $company[0]->client_name . ' ' . $invoice->invoice_no,
                ];

                $request->session()->push('journal_details', $newItem);

                // if ($invoice->pph23 > 0) {
                //     // account pph23 di debit
                //     $account_pajak = MasterModel::findAccountByAccountNumber('1-1401')->first();
                //     $newItem = [
                //         'account_id' => $account_pajak->id,
                //         'account_number' => $account_pajak->account_number,
                //         'account_name' => $account_pajak->account_name,
                //         'transaction_type' => 'D',
                //         'debit' => $invoice->pph23,
                //         'credit' => 0,
                //         'memo' => 'PPh 23 DIBAYAR DIMUKA',
                //     ];

                //     $request->session()->push('journal_details', $newItem);
                // }

                if ($invoice->total_vat > 0) {
                    // account tax di credit
                    $account_pajak = MasterModel::findAccountByAccountNumber('2-1205')->first();
                    $newItem = [
                        'account_id' => $account_pajak->id,
                        'account_number' => $account_pajak->account_number,
                        'account_name' => $account_pajak->account_name,
                        'transaction_type' => 'C',
                        'debit' => 0,
                        'credit' => $invoice->total_vat,
                        'memo' => 'PPN',
                    ];

                    $request->session()->push('journal_details', $newItem);
                }

                // account pendapatan di credit
                $account_number = 0;
                if ($invoice->activity == 'export') $account_number = '4-1001';
                else if ($invoice->activity == 'import') $account_number = '4-1002';
                else if ($invoice->activity == 'logistic') $account_number = '4-1003';
                else if ($invoice->activity == 'domestic') $account_number = '4-1004';
                else $account_number = '4-1005';
                $account_pendapatan = MasterModel::findAccountByAccountNumber($account_number)->first();
                $newItem = [
                    'account_id' => $account_pendapatan->id,
                    'account_number' => $account_pendapatan->account_number,
                    'account_name' => $account_pendapatan->account_name,
                    'transaction_type' => 'C',
                    'debit' => 0,
                    'credit' => $invoice->total_before_vat,
                    'memo' => 'Sales ' . $company[0]->client_name . ' ' . $invoice->invoice_no,
                ];

                $request->session()->push('journal_details', $newItem);
                /** end invoice piutang */
            } else {
                /** invoice hutang */

                // account pembelian di debit
                $account_number = 0;
                if ($invoice->activity == 'export') $account_number = '5-1001';
                else if ($invoice->activity == 'import') $account_number = '5-1002';
                else if ($invoice->activity == 'logistic') $account_number = '5-1003';
                else if ($invoice->activity == 'domestic') $account_number = '5-1004';
                else $account_number = '5-1005';
                $account_pembelian = MasterModel::findAccountByAccountNumber($account_number)->first();
                $newItem = [
                    'account_id' => $account_pembelian->id,
                    'account_number' => $account_pembelian->account_number,
                    'account_name' => $account_pembelian->account_name,
                    'transaction_type' => 'C',
                    'debit' => $invoice->total_before_vat,
                    'credit' => 0,
                    'memo' => 'HPP ' . $company[0]->client_name . ' ' . $invoice->invoice_no,
                ];

                $request->session()->push('journal_details', $newItem);

                if ($invoice->total_vat > 0) {
                    // account tax di credit
                    $account_pajak = MasterModel::findAccountByAccountNumber('1-1403')->first();
                    $newItem = [
                        'account_id' => $account_pajak->id,
                        'account_number' => $account_pajak->account_number,
                        'account_name' => $account_pajak->account_name,
                        'transaction_type' => 'D',
                        'debit' => $invoice->total_vat,
                        'credit' => 0,
                        'memo' => 'PPN',
                    ];

                    $request->session()->push('journal_details', $newItem);
                }

                if ($invoice->ppn1 > 0) {
                    // account tax di credit
                    $account_pajak = MasterModel::findAccountByAccountNumber('1-1403')->first();
                    $newItem = [
                        'account_id' => $account_pajak->id,
                        'account_number' => $account_pajak->account_number,
                        'account_name' => $account_pajak->account_name,
                        'transaction_type' => 'D',
                        'debit' => $invoice->ppn1,
                        'credit' => 0,
                        'memo' => 'PPN 1%',
                    ];

                    $request->session()->push('journal_details', $newItem);
                }

                // if ($invoice->pph23 > 0) {
                //     // account pph23 di credit
                //     $account_pajak = MasterModel::findAccountByAccountNumber('2-1203')->first();
                //     $newItem = [
                //         'account_id' => $account_pajak->id,
                //         'account_number' => $account_pajak->account_number,
                //         'account_name' => $account_pajak->account_name,
                //         'transaction_type' => 'C',
                //         'debit' => 0,
                //         'credit' => $invoice->pph23,
                //         'memo' => 'HUTANG PAJAK - PPH PASAL 23',
                //     ];

                //     $request->session()->push('journal_details', $newItem);
                // }

                // account ap di credit
                $newItem = [
                    'account_id' => $company[0]->account_payable_id,
                    'account_number' => $company[0]->account_payable_number,
                    'account_name' => $company[0]->account_payable_name,
                    'transaction_type' => 'D',
                    'debit' => 0,
                    'credit' => $invoice->total_invoice + $invoice->pph23,
                    'memo' => 'AP ' . $company[0]->client_name . ' ' . $invoice->invoice_no,
                ];

                $request->session()->push('journal_details', $newItem);
                /** end invoice hutang */
            }
        }
        return $invoice;
    }

    public function saveDetailJournalPembayaran(Request $request)
    {
        $company = collect(MasterModel::company_detail_get($request->client_id))->first();
        $pembayaran = PembayaranModel::find($request->reference_id);

        if ($company != []) {
            if ($pembayaran->jenis_pmb == 0) {
                /** pembayaran piutang */
                // account bank di debit
                $account_pembayaran = MasterModel::account_get_detail($pembayaran->id_kas);
                $account_no_pembayaran = ($pembayaran->id_kas == 0 ? '1-1101' : $account_pembayaran->account_number);
                // $account_no_pembayaran = '1-1101';
                $account = MasterModel::findAccountByAccountNumber($account_no_pembayaran)->first();

                $total_pph23 = 0;
                $loop_pph23 = PembayaranModel::get_list_pmb_invoice_piutang($pembayaran->id);
                foreach ($loop_pph23 as $key => $value) {
                    $total_pph23 += $value->pph23;
                }

                $newItem = [
                    'account_id' => $account->id,
                    'account_number' => $account->account_number,
                    'account_name' => $account->account_name,
                    'transaction_type' => 'D',
                    'debit' => $pembayaran->nilai_pmb - $total_pph23,
                    'credit' => 0,
                    'memo' => 'Payment ' . $company->client_name . ' ' . $pembayaran->no_pembayaran,
                ];

                $request->session()->push('journal_details', $newItem);

                if($pembayaran->flag_pph23==1){
                    // account pph23 di debit
                    $account_pajak = MasterModel::findAccountByAccountNumber('1-1401')->first();
                    foreach ($loop_pph23 as $key => $value) {
                        $newItem = [
                            'account_id' => $account_pajak->id,
                            'account_number' => $account_pajak->account_number,
                            'account_name' => $account_pajak->account_name,
                            'transaction_type' => 'D',
                            'debit' => $value->pph23,
                            'credit' => 0,
                            'memo' => $value->external_invoice_no.' PPh 23 DIBAYAR DIMUKA',
                        ];
                        $request->session()->push('journal_details', $newItem);
                    }
                }

                // account ar di credit
                $newItem = [
                    'account_id' => $company->account_receivable_id,
                    'account_number' => $company->account_receivable_number,
                    'account_name' => $company->account_receivable_name,
                    'transaction_type' => 'C',
                    'debit' => 0,
                    'credit' => $pembayaran->nilai_pmb,
                    'memo' => 'Piutang ' . $company->client_name . ' ' . $pembayaran->no_pembayaran,
                ];

                $request->session()->push('journal_details', $newItem);
                /** end pembayaran piutang */
            } else {
                /** pembayaran hutang */
                // account bank di debit
                $account_pembayaran = MasterModel::account_get_detail($pembayaran->id_kas);
                $account_no_pembayaran = ($pembayaran->id_kas == 0 ? '1-1101' : $account_pembayaran->account_number);
                // $account_no_pembayaran = '1-1101';
                $account = MasterModel::findAccountByAccountNumber($account_no_pembayaran)->first();

                $total_pph23 = 0;
                $loop_pph23 = PembayaranModel::get_list_pmb_invoice_piutang($pembayaran->id);
                $newItem = [
                    'account_id' => $account->id,
                    'account_number' => $account->account_number,
                    'account_name' => $account->account_name,
                    'transaction_type' => 'C',
                    'debit' => 0,
                    'credit' => $pembayaran->nilai_pmb,
                    'memo' => 'Hutang ' . $company->client_name . ' ' . $pembayaran->no_pembayaran,
                ];

                $request->session()->push('journal_details', $newItem);

                $loop_pmb = PembayaranModel::get_list_pmb_invoice($pembayaran->id);
                $total_pph23 = 0;
                if($pembayaran->flag_pph23==1){
                    // account pph23 di debit
                    $account_pajak = MasterModel::findAccountByAccountNumber('1-1401')->first();
                    foreach ($loop_pmb as $key => $value) {
                        $newItem = [
                            'account_id' => $account_pajak->id,
                            'account_number' => $account_pajak->account_number,
                            'account_name' => $account_pajak->account_name,
                            'transaction_type' => 'C',
                            'debit' => 0,
                            'credit' => $value->pph23,
                            'memo' => $value->invoice_no.' PPh 23 DIBAYAR DIMUKA',
                        ];
                        $request->session()->push('journal_details', $newItem);
                        $total_pph23 += $value->pph23;
                    }
                }

                // account bank di credit
                $account_pembayaran = MasterModel::account_get_detail($pembayaran->id_kas);
                $account_no_pembayaran = ($pembayaran->id_kas == 0 ? '1-1101' : $account_pembayaran->account_number);
                // $account_no_pembayaran = '1-1101';
                foreach ($loop_pmb as $key => $value) {
                     $tipe = 'Payment';
                     $account_id     = $company->account_payable_id;
                     $account_number = $company->account_payable_number;
                     $account_name   = $company->account_payable_name;
                     if($value->deposit_id>0){
                        $account_id     = $company->account_deposit_id;
                        $account_number = $company->account_deposit_number;
                        $account_name   = $company->account_deposit_name;
                        $tipe = 'Payment Deposit';
                     }
                     $newItem = [
                         'account_id' => $account_id,
                         'account_number' => $account_number,
                         'account_name' => $account_name,
                         'transaction_type' => 'D',
                         'debit' => $value->nilai - $value->pph23,
                         'credit' => 0,
                         'memo' => $tipe.' '. $company->client_name . ' ' . $pembayaran->no_pembayaran,
                     ];

                     $request->session()->push('journal_details', $newItem);
                }

                /** end pembayaran hutang */
            }
        }
        return $pembayaran;
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

    public function updatepph23Journal(Request $request)
    {
        DB::table('t_pembayaran')->where('no_pembayaran',$request->reference_no)->update([
            'flag_pph23' => $request->status,
            'modified_at' => Carbon::now(),
            'modified_by' => Auth::user()->id
        ]);
    }

    public function updateDetailJournal(Request $request)
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
            $param['journal_date'] = Carbon::createFromFormat('d/m/Y', $request->journal_date)->format('Y-m-d');
            $param['currency_id'] = $request->currency_id;
            $param['company_id'] = $request->company_id;
            $param['amount'] = $request->amount;
            $param['created_by'] = Auth::user()->name;
            $param['created_on'] = date('Y-m-d h:i:s');

            if ($request->has('source')) {
                if ($request->source == 'invoice') {
                    $param['invoice_id'] = $request->reference_id;
                } else if ($request->source == 'pembayaran') {
                    $param['pembayaran_id'] = $request->reference_id;
                }
            }

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
        $data['header']->journal_type = 'general_journal';
        if ($data['header']->invoice_id_deposit != 0) $data['header']->journal_type = 'deposit_vendor';
        else if ($data['header']->external_invoice_id_deposit != 0) $data['header']->journal_type = 'deposit_client';
        $details = JournalDetail::findAllJournalDetails($journalId)->get();
        if (Session::get('journal_details') == []) Session::put('journal_details', $details->toArray());

        return view('journal.edit_journal')->with($data);
    }

    public function viewJournal($journalId)
    {
        $data['accounts'] = MasterModel::account_get();
        $data['currency'] = MasterModel::currency();
        $data['header'] = Journal::findJournal($journalId)->first();
        $data['header']->journal_type = 'General Journal';
        if ($data['header']->invoice_id_deposit != 0) $data['header']->journal_type = 'Deposit Vendor';
        else if ($data['header']->external_invoice_id_deposit != 0) $data['header']->journal_type = 'Deposit Client';
        $data['details'] = JournalDetail::findAllJournalDetails($journalId)->get();

        return view('journal.view_journal')->with($data);
    }

    public function deleteJournal($journalId)
    {
        DB::beginTransaction();
        try {
            $journal = Journal::find($journalId);
            $amount = 0;
            // $deposit_dtl = DepositDetail::where('journal_id', $journalId);
            // if ($deposit_dtl->count() > 0) {
            //     foreach ($deposit_dtl->get() as $key => $dtl) {
            //         if ($dtl->pembayaran_id != 0) {
            //             DB::rollBack();

            //             return redirect()->back()->with('error', 'Hapus jurnal gagal, karena deposit sudah dilakukan pembayaran');
            //         }
            //         $amount += $dtl->amount;
            //     }
            //     $amount *= -1;
            //     DepositDetail::where('journal_id', $journalId)->delete();
            //     $deposit = Deposit::where('company_id', $journal->company_id)->first();
            //     $deposit->balance += $amount;
            //     $deposit->save();
            // }

            JournalDetail::where('journal_id', $journalId)->delete();
            $journal->delete();

            DB::commit();
            return redirect()->route('journal.index')->with('success', 'Deleted!');
        } catch (\Throwable $th) {
            DB::rollBack();

            Log::error("deleteJournal Error {$th->getTraceAsString()}");

            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function postJournal(Request $request)
    {
        try {
            DB::beginTransaction();

            $journal = Journal::find($request->id);
            $journal_details = JournalDetail::where('journal_id', $request->id)->get();
            foreach ($journal_details as $key => $detail) {
                $param['id'] = 0;
                $param['gl_date'] = Carbon::createFromFormat('d/m/Y', $request->journal_date)->format('Y-m-d');
                $param['journal_id'] = $request->id;
                $param['account_id'] = $detail->account_id;
                $param['currency_id'] = $journal->currency_id;
                $param['debit'] = $detail->debit;
                $param['credit'] = $detail->credit;
                $param['balance'] = ($detail->debit - $detail->credit);
                $param['memo'] = $detail->memo;
                $param['created_by'] = Auth::user()->name;
                $param['created_on'] = date('Y-m-d h:i:s');

                GeneralLedger::saveGL($param);

                $refresh = GeneralLedgerController::refreshBalance($detail->account_id, $journal->currency_id, date('Y-m-d', strtotime($journal->journal_date)));
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
            Log::error("postJournal Error " . $th->getMessage());
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
