<?php

namespace App\Http\Controllers;

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
        }
    }

    public function print_income_statement(Request $request)
    {
        $data['title'] = "Laporan Laba Rugi";
        $data['start_date'] = $request->start_date;
        $data['end_date'] = $request->end_date;

        $start_date = date('Y-m-d', strtotime($request->start_date));
        $end_date = date('Y-m-d', strtotime($request->end_date));
        $parent_account = DB::select("CALL getParentAccountIncomeStatement()");
        $data['parent_account'] = $parent_account;
        if ($parent_account != []) {
            foreach ($parent_account as $key => $parent) {
                $child_account = DB::select("CALL getChildAccountIncomeStatement('{$start_date}', '{$end_date}', '{$parent->account_number}', {$request->currency_id})");
                $data['parent_account'][$key]->child_account = $child_account;
            }
        }

        return view('report.print_income_statement')->with($data);
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
