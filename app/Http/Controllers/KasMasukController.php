<?php

namespace App\Http\Controllers;

use App\KasMasuk;
use App\KasMasukDetail;
use App\MasterModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class KasMasukController extends Controller
{
    public function indexKasMasuk()
    {
        $data['kas_masuk'] = KasMasuk::getAllKasMasuk()->get();

        return view('kas.masuk.list_kas_masuk')->with($data);
    }

    public function addKasMasuk()
    {
        Session::forget('kas_masuk_details');
        $data['kas_accounts'] = MasterModel::getKasAccount()->get();
        $data['companies'] = MasterModel::company_data();
        $data['accounts'] = MasterModel::account_get();
        $data['currency'] = MasterModel::currency();

        return view('kas.masuk.add_kas_masuk')->with($data);
    }

    public function loadDetailKasMasuk(Request $request)
    {
        $html = '';
        $subtotal = 0;

        $details = Session::get('kas_masuk_details');
        if ($details != []) {
            foreach ($details as $key => $detail) {
                $html .= '<tr>';
                $html .= '<td align="center">' . ($key + 1) . '</td>';
                $html .= '<td>' . $detail['account_number'] . '</td>';
                $html .= '<td>' . $detail['account_name'] . '</td>';
                $html .= '<td align="right">' . number_format($detail['amount'], 2, ',', '.') . '</td>';
                $html .= '<td align="center">';
                $html .= '<a href="javascript:void(0);" class="btn btn-xs btn-danger" onclick="deleteDetailKasMasuk('.$key.')">';
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

    public function saveDetailKasMasuk(Request $request)
    {
        $newItem = [
            'account_id' => $request->account_id,
            'account_number' => $request->account_number,
            'account_name' => $request->account_name,
            'amount' => $request->amount,
        ];

        Session::push('kas_masuk_details', $newItem);
    }

    public function deleteDetailKasMasuk(Request $request)
    {
        $details = Session::get('kas_masuk_details');

        unset($details[$request->key]);

        Session::put('kas_masuk_details', $details);
    }

    public function saveKasMasuk(Request $request)
    {
        $rules = [
            'kas_masuk_date' => 'required',
            'account_id' => 'required',
            'client_id' => 'required',
            'currency_id' => 'required',
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

        $details = Session::get('kas_masuk_details');
        if ($details == []) return redirect()->back()->with('warning', 'Please add detail!');

        try {
            DB::beginTransaction();

            $param = $request->all();
            $param['id'] = 0;
            $param['kas_masuk_date'] = date('Y-m-d', strtotime($request->kas_masuk_date));
            $param['transaction_date'] = date('Y-m-d', strtotime($request->transaction_date));
            $param['created_by'] = Auth::user()->name;
            $param['created_on'] = date('Y-m-d h:i:s');
            if ($request->has('giro')) {
                unset($param['giro']);
                $param['due_date'] = date('Y-m-d', strtotime($request->due_date));
            }
            $kasMasuk = KasMasuk::saveKasMasuk($param);

            foreach ($details as $key => $detail) {
                unset($detail['account_number']);
                unset($detail['account_name']);
                $detail['id'] = 0;
                $detail['kas_masuk_id'] = $kasMasuk->id;
                $detail['created_by'] = Auth::user()->name;
                $detail['created_on'] = date('Y-m-d h:i:s');
                KasMasukDetail::saveKasMasukDetail($detail);
            }

            DB::commit();
            Session::forget('kas_masuk_details');

            return redirect()->route('kas.masuk.index')->with('success', 'Data saved!');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error("saveKasMasuk Error ".$th->getMessage());
            return redirect()->back()->with('error', 'Something wrong, try again later!');
        }
    }

    public function viewKasMasuk($id)
    {
        $data['header'] = KasMasuk::findKasMasuk($id);
        $data['details'] = KasMasukDetail::getAllKasMasukDetail($id)->get();
        $data['kas_accounts'] = MasterModel::getKasAccount()->get();
        $data['companies'] = MasterModel::company_data();
        $data['accounts'] = MasterModel::account_get();
        $data['currency'] = MasterModel::currency();

        return view('kas.masuk.view_kas_masuk')->with($data);
    }
}
