<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\PembayaranModel;
use App\MasterModel;
use DB;

class PembayaranController extends Controller
{
    //
    public function index()
    {
        $pembayaran = PembayaranModel::all();
        return view('pembayaran.index', compact('pembayaran'));
    }

    public function add(Request $request)
    {
        $data['company'] = MasterModel::company_data();
        $data['bank'] = MasterModel::bank_account();
        return view('pembayaran.add')->with($data);
    }

    public function save(Request $request)
    {
        $rules = [
            'tanggal' => 'required',
            'no_pembayaran' => 'required|unique:t_pembayaran',
            'customer' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->with('errorForm', $validator->errors()->messages());
        }

        try {
            $flag_giro = 0;
            if(isset($request->giro_checkbox)){
                $flag_giro = 1;
            }

            $id_pmb = PembayaranModel::insertGetId([
                'no_pembayaran' => $request->no_pembayaran,
                'jenis_pmb' => 1,
                'tanggal' => date('Y-m-d', strtotime($request->tanggal)),
                'id_company' => $request->customer,
                'id_kas' => $request->akun_kas,
                'flag_giro' => $flag_giro,
                'no_giro' => $request->no_giro,
                'tgl_jatuh_tempo' => date('Y-m-d', strtotime($request->tanggal_giro)),
                'no_rekening' => $request->no_rekening,
                'keterangan' => $request->keterangan
            ]);

            DB::commit();

            return redirect()->route('pembayaran.edit', ['id'=>$id_pmb]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function edit($id)
    {
        $data['header'] = PembayaranModel::leftJoin('t_mcompany AS b', 't_pembayaran.id_company', '=', 'b.id')->where('id',$id)->select('t_pembayaran.*','b.client_name')->first();
        $data['company'] = MasterModel::company_data();
        $data['bank'] = MasterModel::bank_account();
        return view('pembayaran.edit')->with($data);
    }
}
