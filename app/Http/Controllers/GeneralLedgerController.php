<?php

namespace App\Http\Controllers;

use App\GeneralLedger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GeneralLedgerController extends Controller
{
    public function index()
    {
        $data['accounts'] = GeneralLedger::getAllAccountHasGL();

        return view('general_ledger.list_general_ledger')->with($data);
    }

    public function loadDetail(Request $request)
    {
        $html = '';

        $details = GeneralLedger::getAllGLByAccountId($request->account_id)->get();
        foreach ($details as $key => $detail) {
            $html .= '<tr>';
            $html .= '<td>' . ($key + 1) . '</td>';
            $html .= '<td>' . date('d/m/Y', strtotime($detail->journal_date)) . '</td>';
            $html .= '<td>' . $detail->journal_no . '</td>';
            $html .= '<td align="right">' . number_format($detail->debit, 2, ',', '.') . '</td>';
            $html .= '<td align="right">' . number_format($detail->credit, 2, ',', '.') . '</td>';
            $html .= '<td align="right">' . number_format($detail->balance, 2, ',', '.') . '</td>';
            $html .= '</tr>';
        }

        return $html;
    }

    public static function refreshBalance($accountId, $date)
    {
        try {
            $balance[] = 0;
            $startDate = date('Y-m-d', strtotime($date. '-1 days'));
            // start date dibuat -1 day dari param $date karena untuk mengambil nilai balance 1 hari sebelumnya (date yang akan diupdate)
            // mis : mau refresh mulai dari tgl 14-12-2021, maka ambil balance -1 days yaitu 13-12-2021
            $gls = GeneralLedger::findALlGLsForRefreshBalance($accountId, $startDate)->get();
            foreach ($gls as $key => $gl) {
                // kalau key 0, balance ke 0 langsung ambil dari table
                if ($key == 0) $balance[$key] = $gl['balance'];
                // kalau key selain 0, balance ambil dari balance key sebelumnya
                else $balance[$key] = $balance[$key - 1] + $gl['debit'] - $gl['credit'];

                $param['balance'] = $balance[$key];
                $param['created_by'] = Auth::user()->name;
                $param['created_on'] = date('Y-m-d h:i:s');
                GeneralLedger::updateGL($gl->id, $param);
            }

            $return['status'] = 'success';
            $return['message'] = '';
            return $return;
        } catch (\Throwable $th) {
            $return['status'] = 'failed';
            $return['message'] = $th->getMessage();
            return $return;
        }
    }

    public function save(Request $request)
    {
        # code...
    }
}
