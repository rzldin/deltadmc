<?php

namespace App\Http\Controllers;

use App\KasKeluar;
use App\KasKeluarDetail;
use App\MasterModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class KasKeluarController extends Controller
{
    public function indexKasKeluar()
    {
        $data['kas_keluar'] = KasKeluar::getAllKasKeluar()->get();

        return view('kas.keluar.list_kas_keluar')->with($data);
    }

    public function addKasKeluar()
    {
        $data['kas_accounts'] = MasterModel::getKasAccount()->get();
        $data['companies'] = MasterModel::company_data();
        $data['accounts'] = MasterModel::account_get();

        return view('kas.keluar.add_kas_keluar')->with($data);
    }

    public function loadDetailKasKeluar(Request $request)
    {
        $html = '';
        $subtotal = 0;

        $details = Session::get('kas_keluar_details');
        if ($details != []) {
            foreach ($details as $key => $detail) {
                $html .= '<tr>';
                $html .= '<td align="center">' . ($key + 1) . '</td>';
                $html .= '<td>' . $detail['account_number'] . '</td>';
                $html .= '<td>' . $detail['account_name'] . '</td>';
                $html .= '<td align="right">' . number_format($detail['amount'], 2, ',', '.') . '</td>';
                $html .= '<td align="center">';
                $html .= '<a href="javascript:void(0);" class="btn btn-xs btn-danger" onclick="deleteDetailKasKeluar('.$key.')">';
                $html .= '<i class="fa fa-trash"></i>';
                $html .= '</a>';
                $html .= '</td>';
                $html .= '</tr>';

                $subtotal += $detail['amount'];
            }
        }

        $html .= '<input type="hidden" id="subtotal" value="'.$subtotal.'"/>';
        $html .= '<input type="hidden" id="subtotal_txt" value="'.number_format($subtotal, 2, ',', '.').'"/>';

        return $html;
    }

    public function saveDetailKasKeluar(Request $request)
    {
        $newItem = [
            'account_id' => $request->account_id,
            'account_number' => $request->account_number,
            'account_name' => $request->account_name,
            'amount' => $request->amount,
        ];

        Session::push('kas_keluar_details', $newItem);
    }

    public function deleteDetailKasKeluar(Request $request)
    {
        $details = Session::get('kas_keluar_details');

        unset($details[$request->key]);

        Session::put('kas_keluar_details', $details);
    }

    public function saveKasKeluar(Request $request)
    {
        $rules = [
            'kas_keluar_date' => 'required',
            'account_id' => 'required',
            'client_id' => 'required',
            'memo' => 'required',
            'transaction_no' => 'required',
            'transaction_date' => 'required',
            'no_giro' => 'required_if:is_giro,on',
            'due_date' => 'required_if:is_giro,on',
            'bank' => 'required_if:is_giro,on',
            'bank_account' => 'required_if:is_giro,on',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->with('errorForm', $validator->errors()->messages());
        }

        $details = Session::get('kas_keluar_details');
        if ($details == []) return redirect()->back()->with('warning', 'Please add detail!');

        try {
            DB::beginTransaction();

            $param = $request->all();
            $param['id'] = 0;
            $param['kas_keluar_date'] = date('Y-m-d', strtotime($request->kas_keluar_date));
            $param['transaction_date'] = date('Y-m-d', strtotime($request->transaction_date));
            $param['created_by'] = Auth::user()->name;
            $param['created_on'] = date('Y-m-d h:i:s');
            if ($request->has('giro')) {
                unset($param['giro']);
                $param['due_date'] = date('Y-m-d', strtotime($request->due_date));
            }
            $kasKeluar = KasKeluar::saveKasKeluar($param);

            foreach ($details as $key => $detail) {
                unset($detail['account_number']);
                unset($detail['account_name']);
                $detail['id'] = 0;
                $detail['kas_keluar_id'] = $kasKeluar->id;
                $detail['created_by'] = Auth::user()->name;
                $detail['created_on'] = date('Y-m-d h:i:s');
                KasKeluarDetail::saveKasKeluarDetail($detail);
            }

            DB::commit();
            Session::forget('kas_keluar_details');

            return redirect()->route('kas.keluar.index')->with('success', 'Data saved!');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error("saveKasKeluar Error ".$th->getMessage());
            return redirect()->back()->with('error', 'Something wrong, try again later!');
        }
    }

    public function viewKasKeluar($id)
    {
        $data['header'] = KasKeluar::findKasKeluar($id);
        $data['details'] = KasKeluarDetail::getAllKasKeluarDetail($id)->get();
        $data['kas_accounts'] = MasterModel::getKasAccount()->get();
        $data['companies'] = MasterModel::company_data();
        $data['accounts'] = MasterModel::account_get();

        return view('kas.keluar.view_kas_keluar')->with($data);
    }
}
