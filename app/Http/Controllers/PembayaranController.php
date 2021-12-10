<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\PembayaranModel;
use App\InvoiceModel;
use App\MasterModel;
use Auth;
use Carbon\Carbon;
use DB;

class PembayaranController extends Controller
{
    //
    public function index()
    {
        $pembayaran = PembayaranModel::where('jenis_pmb',1)->get();
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
            'jenis_pmb' => 'required',
            'no_pembayaran' => 'required|unique:t_pembayaran',
            'customer' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->with('errorForm', $validator->errors()->messages());
        }

        try {
            $flag_giro = 0;
            $id_kas = $request->akun_kas;
            $no_giro = '';
            $tgl_jatuh_tempo = null;
            $no_rekening = '';
            $bank = '';
            if(isset($request->giro_checkbox)){
                $flag_giro = 1;
                $id_kas = 0;
                $no_giro = $request->no_giro;
                $tgl_jatuh_tempo = date('Y-m-d', strtotime($request->tanggal_giro));
                $no_rekening = $request->no_rekening;
                $bank = $request->nama_bank;
            }

            $id_pmb = PembayaranModel::insertGetId([
                'no_pembayaran' => $request->no_pembayaran,
                'jenis_pmb' => $request->jenis_pmb,
                'tanggal' => date('Y-m-d', strtotime($request->tanggal)),
                'id_company' => $request->customer,
                'id_kas' => $id_kas,
                'flag_giro' => $flag_giro,
                'no_giro' => $no_giro,
                'tgl_jatuh_tempo' => $tgl_jatuh_tempo,
                'no_rekening' => $no_rekening,
                'bank' => $bank,
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
        $data['header'] = PembayaranModel::leftJoin('t_mcompany AS b', 't_pembayaran.id_company', '=', 'b.id')->where('t_pembayaran.id',$id)->select('t_pembayaran.*','b.client_name')->first();
        $data['company'] = MasterModel::company_data();
        $data['bank'] = MasterModel::bank_account();

        if($data['header']->jenis_pmb==0){
            return view('pembayaran.edit_piutang')->with($data);
        }else{
            return view('pembayaran.edit')->with($data);
        }
    }

    public function list_detail(Request $request)
    {
        $tabel      = "";
        $no         = 1;
        $data       = PembayaranModel::get_list_detail($request->id);

        foreach($data as $v)
        {

            // Cost
            $tabel .= '<tr>';
            // $tabel .= '<td><input type="checkbox" name="cek_cost[]" value="'.$v->id.'"  id="cekx_'.$no.'"></td>';
            $tabel .= '<td>'.$no.'</td>';
            $tabel .= '<td class="text-left">'.$v->invoice_no.'</td>';
            $tabel .= '<td class="text-left">'.$v->invoice_date.'</td>';
            $tabel .= '<td class="text-right">'.number_format($v->nilai,2,',','.').'</td>';
            $tabel .= '<td>';
                $tabel .= '<a href="javascript:;" class="btn btn-warning btn-xs red" onclick="delete_detail('.$v->id.');" style="margin-top:2px; margin-bottom:2px;" id="addInv"><i class="fa fa-trash"></i> Delete </a>';
            $tabel .= '</td>';
            $tabel .= '</tr>';
            $no++;
        }

        header('Content-Type: application/json');
        echo json_encode($tabel);
    }

    public function list_hutang(Request $request)
    {
        $tabel      = "";
        $no         = 1;
        $data       = PembayaranModel::get_list_hutang($request->id, $request->id_pmb);

        foreach($data as $v)
        {

            // Cost
            $tabel .= '<tr>';
            // $tabel .= '<td><input type="checkbox" name="cek_cost[]" value="'.$v->id.'"  id="cekx_'.$no.'"></td>';
            $tabel .= '<td>'.$no.'</td>';
            $tabel .= '<td class="text-left">'.$v->invoice_no.'</td>';
            $tabel .= '<td class="text-left">'.$v->invoice_date.'</td>';
            $tabel .= '<td class="text-right">'.number_format($v->total_invoice-$v->invoice_bayar,2,',','.').'</td>';
            $tabel .= '<td>';
            if($v->count==0){
                $tabel .= '<a href="javascript:;" class="btn btn-warning btn-xs" onclick="input_bayar('.$v->id.');" style="margin-top:2px; margin-bottom:2px;" id="addInv"><i class="fa fa-plus"></i> Tambah </a>';
            }else{
                $tabel .= 'Added!';
            }
            $tabel .= '</td>';
            $tabel .= '</tr>';
            $no++;
        }

        header('Content-Type: application/json');
        echo json_encode($tabel);
    }

    public function getDataInv(Request $request){

        $result = DB::table('t_invoice')->where('id', $request->id)->first();
        $data['nilai_sisa'] = $result->total_invoice - $result->invoice_bayar;
        $data = $result;

        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function saveDetailPembayaran(Request $request){
        $return_data = array();
        $tanggal   = date('Y-m-d H:i:s');

        $total_invoice = str_replace(',', '', $request->total_invoice);
        $nilai_bayar = str_replace(',', '', $request->nilai_bayar);
        $nilai_sisa = str_replace(',', '', $request->nilai_sisa);

        $invoice = DB::table('t_invoice')->where('id', $request->id_invoice)->first();
        $invoice_bayar = $invoice->invoice_bayar + $nilai_bayar;
        $sisa = $invoice->total_invoice - $invoice_bayar;
        if($sisa <= 0){
            $flag = 1;
            $tanggal_lunas = $request->tanggal_bayar;
        }else{
            $flag = 2;
            $tanggal_lunas = null;
        }
        DB::table('t_invoice')->where('id', $request->id_invoice)->update([
            'invoice_bayar' => $invoice_bayar,
            'flag_bayar' => $flag,
            'tanggal_lunas' => $tanggal_lunas,
            'modified_by' => Auth::user()->id,
            'modified_at' => Carbon::now()
        ]);

        DB::table('t_pembayaran_detail')->insert([
            'id_pmb' => $request->id_pmb,
            'jenis_pmb' => $request->jenis_pmb,
            'id_invoice' => $request->id_invoice,
            'nilai' => $nilai_bayar
        ]);

        $return_data['status']= "sukses";
        $return_data['message']= "Berhasil menyimpan detail pembayaran!";

        header('Content-Type: application/json');
        echo json_encode($return_data);
    }

    public function deleteDetailPembayaran(Request $request){
        $return_data = array();
        $tanggal   = date('Y-m-d H:i:s');

        $data = PembayaranModel::get_detail($request->id)->first();
        $invoice_bayar = $data->invoice_bayar - $data->nilai;
        $tanggal_lunas = null;
        $flag = 2;
        if($invoice_bayar == 0){
            $flag = 0;
        }
        DB::table('t_invoice')->where('id', $data->id_invoice)->update([
            'invoice_bayar' => $data->invoice_bayar - $data->nilai,
            'flag_bayar' => $flag,
            'tanggal_lunas' => $tanggal_lunas,
            'modified_by' => Auth::user()->id,
            'modified_at' => Carbon::now()
        ]);

        DB::table('t_pembayaran_detail')->where('id',$request->id)->delete();

        $return_data['status']= "sukses";
        $return_data['message']= "Berhasil menyimpan detail pembayaran!";

        header('Content-Type: application/json');
        echo json_encode($return_data);
    }

    public function update(Request $request)
    {
        $rules = [
            'tanggal' => 'required',
            'no_pembayaran' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->with('errorForm', $validator->errors()->messages());
        }

        try {
            $flag_giro = 0;
            $id_kas = $request->akun_kas;
            $no_giro = '';
            $tgl_jatuh_tempo = null;
            $no_rekening = '';
            $bank = '';
            if(isset($request->giro_checkbox)){
                $flag_giro = 1;
                $id_kas = 0;
                $no_giro = $request->no_giro;
                $tgl_jatuh_tempo = date('Y-m-d', strtotime($request->tanggal_giro));
                $no_rekening = $request->no_rekening;
                $bank = $request->nama_bank;
            }

            $data = PembayaranModel::get_list_detail($request->id);
            $nilai_pembayaran = 0;

            foreach($data as $v)
            {
                $nilai_pembayaran += $v->nilai;
            }

            $id_pmb = PembayaranModel::where('id',$request->id)->update([
                'no_pembayaran' => $request->no_pembayaran,
                'status' => 1,
                'tanggal' => date('Y-m-d', strtotime($request->tanggal)),
                'id_kas' => $id_kas,
                'flag_giro' => $flag_giro,
                'no_giro' => $no_giro,
                'tgl_jatuh_tempo' => $tgl_jatuh_tempo,
                'no_rekening' => $no_rekening,
                'bank' => $bank,
                'keterangan' => $request->keterangan,
                'nilai_pmb' => $nilai_pembayaran
            ]);

            DB::commit();

            if($request->jenis_pmb==0){
                return redirect()->route('pembayaran.piutang');
            }else{
                return redirect()->route('pembayaran.index');
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function piutang()
    {
        $pembayaran = PembayaranModel::where('jenis_pmb',0)->get();
        return view('pembayaran.piutang', compact('pembayaran'));
    }

    public function add_piutang(Request $request)
    {
        $data['company'] = MasterModel::company_data();
        $data['bank'] = MasterModel::bank_account();
        return view('pembayaran.add_piutang')->with($data);
    }

    public function list_piutang(Request $request)
    {
        $tabel      = "";
        $no         = 1;
        $data       = PembayaranModel::get_list_piutang($request->id, $request->id_pmb);

        foreach($data as $v)
        {

            // Cost
            $tabel .= '<tr>';
            // $tabel .= '<td><input type="checkbox" name="cek_cost[]" value="'.$v->id.'"  id="cekx_'.$no.'"></td>';
            $tabel .= '<td>'.$no.'</td>';
            $tabel .= '<td class="text-left">'.$v->external_invoice_no.'</td>';
            $tabel .= '<td class="text-left">'.$v->external_invoice_date.'</td>';
            $tabel .= '<td class="text-right">'.number_format($v->total_invoice-$v->invoice_bayar,2,',','.').'</td>';
            $tabel .= '<td>';
            if($v->count==0){
                $tabel .= '<a href="javascript:;" class="btn btn-warning btn-xs" onclick="input_bayar('.$v->id.');" style="margin-top:2px; margin-bottom:2px;" id="addInv"><i class="fa fa-plus"></i> Tambah </a>';
            }else{
                $tabel .= 'Added!';
            }
            $tabel .= '</td>';
            $tabel .= '</tr>';
            $no++;
        }

        header('Content-Type: application/json');
        echo json_encode($tabel);
    }

    public function saveDetailPembayaranPiutang(Request $request){
        $return_data = array();
        $tanggal   = date('Y-m-d H:i:s');

        $total_invoice = str_replace(',', '', $request->total_invoice);
        $nilai_bayar = str_replace(',', '', $request->nilai_bayar);
        $nilai_sisa = str_replace(',', '', $request->nilai_sisa);

        $invoice = DB::table('t_external_invoice')->where('id', $request->id_invoice)->first();
        $invoice_bayar = $invoice->invoice_bayar + $nilai_bayar;
        $sisa = $invoice->total_invoice - $invoice_bayar;
        if($sisa <= 0){
            $flag = 1;
            $tanggal_lunas = $request->tanggal_bayar;
        }else{
            $flag = 2;
            $tanggal_lunas = null;
        }
        DB::table('t_external_invoice')->where('id', $request->id_invoice)->update([
            'invoice_bayar' => $invoice_bayar,
            'flag_bayar' => $flag,
            'tanggal_lunas' => $tanggal_lunas,
            'modified_by' => Auth::user()->id,
            'modified_at' => Carbon::now()
        ]);

        DB::table('t_pembayaran_detail')->insert([
            'id_pmb' => $request->id_pmb,
            'jenis_pmb' => $request->jenis_pmb,
            'id_invoice' => $request->id_invoice,
            'nilai' => $nilai_bayar
        ]);

        $return_data['status']= "sukses";
        $return_data['message']= "Berhasil menyimpan detail pembayaran!";

        header('Content-Type: application/json');
        echo json_encode($return_data);
    }

    public function deleteDetailPembayaranPiutang(Request $request){
        $return_data = array();
        $tanggal   = date('Y-m-d H:i:s');

        $data = PembayaranModel::get_detail_piutang($request->id)->first();
        $invoice_bayar = $data->invoice_bayar - $data->nilai;
        $tanggal_lunas = null;
        $flag = 2;
        if($invoice_bayar == 0){
            $flag = 0;
        }
        DB::table('t_external_invoice')->where('id', $data->id_invoice)->update([
            'invoice_bayar' => $data->invoice_bayar - $data->nilai,
            'flag_bayar' => $flag,
            'tanggal_lunas' => $tanggal_lunas,
            'modified_by' => Auth::user()->id,
            'modified_at' => Carbon::now()
        ]);

        DB::table('t_pembayaran_detail')->where('id',$request->id)->delete();

        $return_data['status']= "sukses";
        $return_data['message']= "Berhasil menyimpan detail pembayaran!";

        header('Content-Type: application/json');
        echo json_encode($return_data);
    }

    public function getDataInvExt(Request $request){
        $result = DB::table('t_external_invoice')->where('id', $request->id)->first();
        $data['nilai_sisa'] = $result->total_invoice - $result->invoice_bayar;
        $data = $result;

        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
