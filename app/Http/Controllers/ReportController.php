<?php

namespace App\Http\Controllers;

use App\GeneralLedger;
use App\IncomeStatementBalance;
use App\MasterModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{

    public function index()
    {
        $currency = MasterModel::currency();

        return view('report.index', compact('currency'));
    }

    public function print(Request $request)
    {
        $rules = [
            'currency_id' => 'required',
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->with('errorForm', $validator->errors()->messages())->withInput();
        }

        if ($request->report_code == 'income_statement') {
            return redirect()->route('report.print.income_statement', $request->all());
        } else if ($request->report_code == 'balance_sheet') {
            return redirect()->route('report.print.balance_sheet', $request->all());
        } else if ($request->report_code == 'general_ledger') {
            return redirect()->route('report.print.general_ledger', $request->all());
        }
    }

    public function print_income_statement(Request $request)
    {
        $start_date = date('Y-m-d', strtotime($request->start_date));
        $end_date = date('Y-m-d', strtotime($request->end_date));

        $data = $this->generateDataIncomeStatement($start_date, $end_date, $request->currency_id);

        $data['title'] = "Laporan Laba Rugi";
        $data['start_date'] = $request->start_date;
        $data['end_date'] = $request->end_date;

        return view('report.print_income_statement')->with($data);
    }

    public function generateDataIncomeStatement($start_date, $end_date, $currency_id)
    {
        $parent_account = DB::select("CALL getParentAccountIncomeStatement()");
        $data['parent_account'] = $parent_account;

        if ($parent_account != []) {
            foreach ($parent_account as $key => $parent) {
                $child_account = DB::select("CALL getChildAccountIncomeStatement('{$start_date}', '{$end_date}', '{$parent->account_number}', {$currency_id})");
                $data['parent_account'][$key]->child_account = $child_account;
            }

            // $this->insertIncomeStatementBalance($start_date, $end_date, $data, $currency_id);
        }

        return $data;
    }

    public function insertIncomeStatementBalance($start_date, $end_date, $data, $currency_id)
    {
        if ($data['parent_account'] != []) {
            $total_pendapatan = 0;
            $total_hpp = 0;
            $total_biaya_adm = 0;
            $total_biaya_umum = 0;
            $total_biaya_susut = 0;
            $total_pendapatan_luar = 0;
            $total_biaya_luar = 0;

            $total_laba_kotor = 0;
            $total_beban_operasional = 0;
            $total_pendapatan_operasional = 0;
            $total_laba_luar = 0;

            foreach ($data['parent_account'] as $key => $parent) {
                $parent_balance = 0;

                foreach ($parent->child_account as $idx => $child) {
                    $child_balance = $child->credit;
                    if ($child->flag_pengeluaran == 1) {
                        $child_balance = $child->debit;
                    }

                    $parent_balance += $child_balance;
                }

                if (substr($parent->account_number, 0, 3) == '4-1') {
                    $total_pendapatan += $parent_balance;
                } elseif (substr($parent->account_number, 0, 3) == '5-1') {
                    $total_hpp += $parent_balance;
                } elseif (substr($parent->account_number, 0, 3) == '6-1') {
                    $total_biaya_adm += $parent_balance;
                } elseif (substr($parent->account_number, 0, 3) == '6-2') {
                    $total_biaya_umum += $parent_balance;
                } elseif (substr($parent->account_number, 0, 3) == '6-3') {
                    $total_biaya_susut += $parent_balance;
                } elseif (substr($parent->account_number, 0, 3) == '7-1') {
                    $total_pendapatan_luar += $parent_balance;
                } elseif (substr($parent->account_number, 0, 3) == '7-2') {
                    $total_biaya_luar += $parent_balance;
                }

                if ($parent->account_number == '5-1000') {
                    $total_laba_kotor = $total_pendapatan - $total_hpp;
                }

                if ($parent->account_number == '6-3000') {
                    $total_beban_operasional = $total_biaya_adm + $total_biaya_umum + $total_biaya_susut;
                    $total_pendapatan_operasional = $total_laba_kotor - $total_beban_operasional;
                }

                if ($parent->account_number == '7-2000') {
                    $total_laba_luar = $total_pendapatan_luar - $total_biaya_luar;
                }
            }

            $total_laba_bersih = $total_pendapatan_operasional + $total_laba_luar;

            /**
             * insert ke tabel income statement balance berdasarkan start date, end date, dan currency
             */
            // IncomeStatementBalance::
        }
    }

    public function print_balance_sheet(Request $request)
    {
        $start_date = date('Y-m-d', strtotime($request->start_date));
        $end_date = date('Y-m-d', strtotime($request->end_date));

        $parent_account_aset_lancar = DB::select("CALL getParentAccountBalanceSheetAsetLancar()");
        $data['parent_account_aset_lancar'] = $parent_account_aset_lancar;

        if ($parent_account_aset_lancar != []) {
            foreach ($parent_account_aset_lancar as $key => $parent) {
                $child_account = DB::select("CALL getChildAccountBalanceSheet('{$start_date}', '{$end_date}', '{$parent->account_id}', {$request->currency_id})");
                $data['parent_account_aset_lancar'][$key]->child_account = $child_account;
            }
        }

        $parent_account_aset_tetap = DB::select("CALL getParentAccountBalanceSheetAsetTetap()");
        $data['parent_account_aset_tetap'] = $parent_account_aset_tetap;

        if ($parent_account_aset_tetap != []) {
            foreach ($parent_account_aset_tetap as $key => $parent) {
                $child_account = DB::select("CALL getChildAccountBalanceSheet('{$start_date}', '{$end_date}', '{$parent->account_id}', {$request->currency_id})");
                $data['parent_account_aset_tetap'][$key]->child_account = $child_account;
            }
        }

        $parent_account_passiva = DB::select("CALL getParentAccountBalanceSheetPassiva()");
        $data['parent_account_passiva'] = $parent_account_passiva;

        if ($parent_account_passiva != []) {
            foreach ($parent_account_passiva as $key => $parent) {
                $child_account = DB::select("CALL getChildAccountBalanceSheet('{$start_date}', '{$end_date}', '{$parent->account_id}', {$request->currency_id})");
                $data['parent_account_passiva'][$key]->child_account = $child_account;
            }
        }

        $data['title'] = "Laporan Neraca";
        $data['start_date'] = $request->start_date;
        $data['end_date'] = $request->end_date;

        return view('report.print_balance_sheet')->with($data);
    }

    public function print_general_ledger(Request $request)
    {
        $start_date = date('Y-m-d', strtotime($request->start_date));
        $end_date = date('Y-m-d', strtotime($request->end_date));
        $currency_id = $request->currency_id;

        $accounts = GeneralLedger::getAllAccountHasGLWithPeriod($currency_id, $start_date, $end_date);
        $data['header'] = $accounts;
        foreach ($accounts as $key => $account) {
            $details = GeneralLedger::getAllGLByAccountIdWithPeriod($account->id, $request->currency_id, $start_date, $end_date)->get();
            $data['header'][$key]->details = $details;
        }

        $data['title'] = "Laporan Neraca";
        $data['currency_id'] = $request->currency_id;
        $data['start_date'] = $request->start_date;
        $data['end_date'] = $request->end_date;
        // dd($data);

        return view('report.print_general_ledger')->with($data);
    }

    public function test()
    {
        DB::beginTransaction();
        try {
            /**
             * 4-xxxx Pendapatan
             * 5-xxxx HPP / COGS
             * 6-1xxx Biaya Adm
             * 6-2xxx Biaya umum dll
             * 6-3xxx Biaya penyusutan amortisasi
             * 7-1xxx Pendapatan diluar usaha
             * 7-2xxx Biaya diluar usaha
             */
            $date = date('Y-m-d');
            // $date = date('Y-m-d');
            $parent_acc = DB::select("CALL getParentAccountIncomeStatement('{$date}', '{$date}')");
            foreach ($parent_acc as $key => $parent) {
                $parent['period'] = $date;
                $parent['created_by'] = Auth::user()->name;
                $parent['created_on'] = now();
                DB::table("income_statement_report")->insert($parent);

                $child_acc = DB::select("CALL getChildAccountIncomeStatement('{$date}', '{$date}', '{$parent->account_number}')");
                foreach ($child_acc as $key => $child) {
                    $child['period'] = $date;
                    $child['created_by'] = Auth::user()->name;
                    $child['created_on'] = now();
                    DB::table("income_statement_report")->insert($child);
                }
            }

            DB::commit();

            echo "success";
        } catch (\Throwable $th) {
            DB::rollBack();

            Log::critical("Generate Income Statement Report Error {$th->getTraceAsString()}");

            echo $th->getTraceAsString();
        }
        dd($parent_acc, $child_acc);

    }
}
