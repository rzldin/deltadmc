<?php

namespace App\Http\Controllers;

use App\Deposit;
use App\DepositDetail;
use App\ExternalInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\PembayaranModel;
use App\InvoiceModel;
use App\Journal;
use App\JournalDetail;
use App\MasterModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PembayaranController extends Controller
{
    //
    public function index()
    {
        $pembayaran = PembayaranModel::getAllPembayaranByJenis(1)->get();
        return view('pembayaran.index', compact('pembayaran'));
    }

    public function add(Request $request)
    {
        $data['company'] = MasterModel::company_data();
        $data['bank'] = MasterModel::bank_account();
        $data['currency'] = MasterModel::currency();
        return view('pembayaran.add')->with($data);
    }

    public function save(Request $request)
    {
        $rules = [
            'tanggal' => 'required',
            'jenis_pmb' => 'required',
            'currency_id' => 'required',
            'no_pembayaran' => 'required|unique:t_pembayaran',
            'customer' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->with('errorForm', $validator->errors()->messages());
        }
        DB::beginTransaction();
        try {
            $flag_giro = 0;
            $id_kas = $request->akun_kas;
            $no_giro = '';
            $tgl_jatuh_tempo = null;
            $no_rekening = '';
            $bank = '';
            if (isset($request->giro_checkbox)) {
                $flag_giro = 1;
                $id_kas = 0;
                $no_giro = $request->no_giro;
                $tgl_jatuh_tempo = Carbon::createFromFormat('d/m/Y', $request->tanggal_giro)->format('Y-m-d');
                $no_rekening = $request->no_rekening;
                $bank = $request->nama_bank;
            }

            $id_pmb = PembayaranModel::insertGetId([
                'no_pembayaran' => $request->no_pembayaran,
                'jenis_pmb' => $request->jenis_pmb,
                'tanggal' => Carbon::createFromFormat('d/m/Y', $request->tanggal)->format('Y-m-d'),
                'id_company' => $request->customer,
                'id_kas' => $id_kas,
                'currency_id' => $request->currency_id,
                'flag_giro' => $flag_giro,
                'no_giro' => $no_giro,
                'tgl_jatuh_tempo' => $tgl_jatuh_tempo,
                'no_rekening' => $no_rekening,
                'bank' => $bank,
                'keterangan' => $request->keterangan
            ]);

            DB::commit();

            return redirect()->route('pembayaran.edit', ['id' => $id_pmb]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function edit($id)
    {
        $data['header'] = PembayaranModel::leftJoin('t_mcompany AS b', 't_pembayaran.id_company', '=', 'b.id')
            ->join('t_mcurrency AS c', 'c.id', 't_pembayaran.currency_id')
            ->where('t_pembayaran.id', $id)
            ->select('t_pembayaran.*', 'b.client_name', 'c.code')
            ->first();
        $data['company'] = MasterModel::company_data();
        $data['bank'] = MasterModel::bank_account();
        // $data['deposit'] = Deposit::findDepositByCompanyId($data['header']->id_company)->first();
        // dd($data);

        if ($data['header']->jenis_pmb == 0) {
            return view('pembayaran.edit_piutang')->with($data);
        } else {
            return view('pembayaran.edit')->with($data);
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            DB::table('t_pembayaran')->where('id',$id)->delete();

            DB::commit();
            return redirect()->back()->with('status', 'Pembayaran Deleted!');
        } catch (\Throwable $th) {
            DB::rollBack();

            Log::error("delete Pembayaran Error {$th->getMessage()}");

            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function view($id)
    {
        $data['header'] = PembayaranModel::leftJoin('t_mcompany AS b', 't_pembayaran.id_company', '=', 'b.id')->where('t_pembayaran.id', $id)
            ->leftJoin('t_maccount As bank', 't_pembayaran.id_kas', '=', 'bank.id')
            ->select('t_pembayaran.*', 'b.client_name', 'bank.account_name')->first();
        $data['detail'] = PembayaranModel::get_list_detail($data['header']->id);
        return view('pembayaran.view')->with($data);
    }

    public function list_detail(Request $request)
    {
        $tabel      = "";
        $no         = 1;
        $data       = PembayaranModel::get_list_detail($request->id);

        $total_nilai = 0;
        foreach ($data as $v) {
            $total_nilai+= $v->nilai;
            // Cost
            $tabel .= '<tr>';
            // $tabel .= '<td><input type="checkbox" name="cek_cost[]" value="'.$v->id.'"  id="cekx_'.$no.'"></td>';
            $tabel .= '<td>' . $no . '</td>';
            $tabel .= '<td class="text-left">' . $v->invoice_no . '</td>';
            $tabel .= '<td class="text-left">' . $v->invoice_date . '</td>';
            $tabel .= '<td class="text-right">' . number_format($v->kurs, 2, ',', '.') . '</td>';
            $tabel .= '<td class="text-right">' . number_format($v->nilai, 2, ',', '.') . '</td>';
            $tabel .= '<td>';
            $tabel .= '<a href="javascript:;" class="btn btn-warning btn-xs red" onclick="delete_detail(' . $v->id . ');" style="margin-top:2px; margin-bottom:2px;" id="addInv"><i class="fa fa-trash"></i> Delete </a>';
            $tabel .= '</td>';
            $tabel .= '</tr>';
            $no++;
        }
        $tabel .= '<tr>';
        // $tabel .= '<td><input type="checkbox" name="cek_cost[]" value="'.$v->id.'"  id="cekx_'.$no.'"></td>';
        $tabel .= '<td>Total</td>';
        $tabel .= '<td colspan="4" class="text-right">' . number_format($total_nilai, 2, ',', '.') . '</td>';
        $tabel .= '<td></td>';
        $tabel .= '</tr>';

        header('Content-Type: application/json');
        echo json_encode($tabel);
    }

    public function list_hutang(Request $request)
    {
        $tabel      = "";
        $no         = 1;
        $data       = PembayaranModel::get_list_hutang($request->id, $request->id_pmb, $request->currency);

        foreach ($data as $v) {

            // Cost
            $tabel .= '<tr>';
            // $tabel .= '<td><input type="checkbox" name="cek_cost[]" value="'.$v->id.'"  id="cekx_'.$no.'"></td>';
            $tabel .= '<td>' . $no . '</td>';
            $tabel .= '<td class="text-left">' . $v->invoice_no . '</td>';
            $tabel .= '<td class="text-left">' . $v->invoice_date . '</td>';
            if($v->flag_nopph23==0){
                $tabel .= '<td class="text-right">' . number_format($v->total_invoice - $v->invoice_bayar, 2, ',', '.') . '</td>';
            }else{
                $tabel .= '<td class="text-right">' . number_format($v->total_invoice + $v->pph23 - $v->invoice_bayar, 2, ',', '.') . '</td>';
            }
            $tabel .= '<td>';
            if ($v->count == 0) {
                $tabel .= '<a href="javascript:;" class="btn btn-warning btn-xs" onclick="input_bayar(' . $v->id . ');" style="margin-top:2px; margin-bottom:2px;" id="addInv"><i class="fa fa-plus"></i> Tambah </a>';
            } else {
                $tabel .= 'Added!';
            }
            $tabel .= '</td>';
            $tabel .= '</tr>';
            $no++;
        }

        header('Content-Type: application/json');
        echo json_encode($tabel);
    }

    public function getDataInv(Request $request)
    {

        $result = DB::table('t_invoice AS i')
            ->leftJoin('t_mcurrency AS c', 'c.id', 'i.currency')
            ->select('i.*', 'c.code')
            ->where('i.id', $request->id)
            ->first();
        $data = $result;
        $data->total_invoice_pph23 = $result->total_invoice + $result->pph23;
        $data->nilai_sisa_pph23 = $result->total_invoice + $result->pph23 - $result->invoice_bayar;
        $data->nilai_sisa = $result->total_invoice - $result->invoice_bayar;

        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function saveDetailPembayaran(Request $request)
    {
        DB::beginTransaction();
        try{
            $return_data = array();
            $tanggal   = date('Y-m-d H:i:s');

            $total_invoice = str_replace(',', '', $request->total_invoice);
            $nilai_bayar = str_replace(',', '', $request->nilai_bayar);
            $nilai_sisa = str_replace(',', '', $request->nilai_sisa);

            $invoice = DB::table('t_invoice')->where('id', $request->id_invoice)->first();
            $invoice_bayar = $invoice->invoice_bayar + $nilai_bayar;
            $sisa = $invoice->total_invoice - $invoice_bayar;
            if($invoice->invoice_bayar>0){
                $nopph23 = $invoice->flag_nopph23;
            }else{
                $nopph23 = $request->is_nopph23;
            }
            if ($sisa <= 0) {
                $flag = 1;
                $tanggal_lunas = Carbon::createFromFormat('d/m/Y', $request->tanggal_bayar)->format('Y-m-d');
            } else {
                $flag = 2;
                $tanggal_lunas = null;
            }
            DB::table('t_invoice')->where('id', $request->id_invoice)->update([
                'invoice_bayar' => $invoice_bayar,
                'flag_bayar' => $flag,
                'flag_nopph23' => $nopph23,
                'tanggal_lunas' => $tanggal_lunas,
                'modified_by' => Auth::user()->id,
                'modified_at' => Carbon::now()
            ]);

            DB::table('t_pembayaran_detail')->insert([
                'id_pmb' => $request->id_pmb,
                'jenis_pmb' => $request->jenis_pmb,
                'id_invoice' => $request->id_invoice,
                'currency_id' => $request->currency_id,
                'kurs' => $request->kurs,
                'nilai' => $nilai_bayar
            ]);

            $return_data['status'] = "sukses";
            $return_data['message'] = "Berhasil menyimpan detail pembayaran!";

            DB::commit();
            header('Content-Type: application/json');
            echo json_encode($return_data);
        } catch (\Throwable $th) {
            Log::error("saveDetailPembayaran Error {$th->getMessage()}");
            Log::error($th->getTraceAsString());
            $return_data['status'] = "failed";
            $return_data['message'] = $th->getMessage();

            DB::rollBack();
            header('Content-Type: application/json');
            echo json_encode($return_data);
        }
    }

    public function deleteDetailPembayaran(Request $request)
    {
        $return_data = array();
        DB::beginTransaction();
        try {
            $tanggal   = date('Y-m-d H:i:s');

            $data = PembayaranModel::get_detail($request->id)->first();
            $invoice_bayar = $data->invoice_bayar - $data->nilai;
            $tanggal_lunas = null;
            $flag = 2;
            if ($invoice_bayar == 0) {
                $flag = 0;
            }

            $inv = InvoiceModel::find($data->id_invoice);
            $inv->invoice_bayar = $data->invoice_bayar - $data->nilai;
            $inv->flag_bayar = $flag;
            if($invoice_bayar==0){
                $inv->flag_nopph23 = 0;
            }
            $inv->tanggal_lunas = $tanggal_lunas;
            $inv->modified_by = Auth::user()->id;
            $inv->modified_at =  Carbon::now();
            $inv->save();

            /**
             * kalau ada deposit
             */
            // if ($data->deposit_detail_id != 0) {
            //     $param['deposit_detail_id'] = $data->deposit_detail_id;
            //     DepositController::deleteDepositPembayaran($param);
            // }
            $deposits = DepositDetail::where('pembayaran_id', $data->id_pmb)->get();
            if (empty($deposits)) {
                $amount = 0;
                foreach ($deposits as $dtl) {
                    $amount += $dtl->amount;
                    DepositDetail::find($dtl->id)->delete();
                }
                $amount = $amount * -1;
                $deposit = Deposit::where('company_id', $request->company_id)->where('currency_id', $request->currency_id)->first();
                $deposit->balance = $deposit->balance + $amount;
                $deposit->save();
            }
            /** end */

            /**
             * kalau udah ada jurnalnya
             */
            $journal = Journal::where('pembayaran_id', $data->id_pmb)->first();
            if ($journal != []) {
                JournalDetail::deleteJournalDetailByJournalId($journal->id);
                $journal->delete();
            }
            /** end */

            DB::table('t_pembayaran_detail')->where('id', $request->id)->delete();

            $return_data['status'] = "sukses";
            $return_data['message'] = "Berhasil menyimpan detail pembayaran!";

            DB::commit();
            header('Content-Type: application/json');
            echo json_encode($return_data);
        } catch (\Throwable $th) {
            Log::error("deleteDetailPembayaran Error {$th->getMessage()}");
            Log::error($th->getTraceAsString());
            $return_data['status'] = "failed";
            $return_data['message'] = $th->getMessage();

            DB::rollBack();
            header('Content-Type: application/json');
            echo json_encode($return_data);
        }
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

        DB::beginTransaction();
        try {
            $flag_giro = 0;
            $id_kas = $request->akun_kas;
            $no_giro = '';
            $tgl_jatuh_tempo = null;
            $no_rekening = '';
            $bank = '';
            if (isset($request->giro_checkbox)) {
                $flag_giro = 1;
                $id_kas = 0;
                $no_giro = $request->no_giro;
                $tgl_jatuh_tempo = Carbon::createFromFormat('d/m/Y', $request->tanggal_giro)->format('Y-m-d');
                $no_rekening = $request->no_rekening;
                $bank = $request->nama_bank;
            }

            $data = PembayaranModel::get_list_detail($request->id);
            $nilai_pembayaran = 0;

            foreach ($data as $v) {
                $nilai_pembayaran += $v->nilai;
            }

            if ($nilai_pembayaran != 0) {

                $id_pmb = PembayaranModel::where('id', $request->id)->update([
                    'no_pembayaran' => $request->no_pembayaran,
                    'status' => 1,
                    'tanggal' => Carbon::createFromFormat('d/m/Y', $request->tanggal)->format('Y-m-d'),
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
                if ($request->jenis_pmb == 0) {
                    return redirect()->route('pembayaran.piutang')->with('status', 'Pembayaran berhasil di approve!');
                } else {
                    return redirect()->route('pembayaran.index')->with('status', 'Pembayaran berhasil di approve!');
                }
            } else {
                return redirect()->route('pembayaran.edit', ['id' => $request->id])->with('error', 'Pembayaran detail masih kosong !');
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function piutang()
    {
        $pembayaran = PembayaranModel::getAllPembayaranByJenis(0)->get();
        return view('pembayaran.piutang', compact('pembayaran'));
    }

    public function add_piutang(Request $request)
    {
        $data['company'] = MasterModel::company_data();
        $data['bank'] = MasterModel::bank_account();
        $data['currency'] = MasterModel::currency();
        return view('pembayaran.add_piutang')->with($data);
    }

    public function list_piutang(Request $request)
    {
        $tabel      = "";
        $no         = 1;
        $data       = PembayaranModel::get_list_piutang($request->id, $request->id_pmb, $request->currency_id);

        foreach ($data as $v) {

            // Cost
            $tabel .= '<tr>';
            // $tabel .= '<td><input type="checkbox" name="cek_cost[]" value="'.$v->id.'"  id="cekx_'.$no.'"></td>';
            $tabel .= '<td>' . $no . '</td>';
            $tabel .= '<td class="text-left">' . $v->external_invoice_no . '</td>';
            $tabel .= '<td class="text-left">' . $v->external_invoice_date . '</td>';
            $tabel .= '<td class="text-left">' . $v->code . '</td>';
            $tabel .= '<td class="text-right">' . number_format($v->total_invoice - $v->invoice_bayar, 2, ',', '.') . '</td>';
            $tabel .= '<td>';
            if ($v->count == 0) {
                $tabel .= '<a href="javascript:;" class="btn btn-warning btn-xs" onclick="input_bayar(' . $v->id . ');" style="margin-top:2px; margin-bottom:2px;" id="addInv"><i class="fa fa-plus"></i> Tambah </a>';
            } else {
                $tabel .= 'Added!';
            }
            $tabel .= '</td>';
            $tabel .= '</tr>';
            $no++;
        }

        header('Content-Type: application/json');
        echo json_encode($tabel);
    }

    public function saveDetailPembayaranPiutang(Request $request)
    {
        $return_data = array();
        $tanggal   = date('Y-m-d H:i:s');

        $total_invoice = str_replace(',', '', $request->total_invoice);
        $nilai_bayar = str_replace(',', '', $request->nilai_bayar);
        $nilai_sisa = str_replace(',', '', $request->nilai_sisa);

        $invoice = DB::table('t_external_invoice')->where('id', $request->id_invoice)->first();
        $invoice_bayar = $invoice->invoice_bayar + $nilai_bayar;
        $sisa = $invoice->total_invoice - $invoice_bayar;
        if($invoice->invoice_bayar>0){
            $nopph23 = $invoice->flag_nopph23;
        }else{
            $nopph23 = $request->is_nopph23;
        }
        if ($sisa <= 0) {
            $flag = 1;
            $tanggal_lunas = Carbon::createFromFormat('d/m/Y', $request->tanggal_bayar)->format('Y-m-d');
        } else {
            $flag = 2;
            $tanggal_lunas = null;
        }
        DB::table('t_external_invoice')->where('id', $request->id_invoice)->update([
            'invoice_bayar' => $invoice_bayar,
            'flag_bayar' => $flag,
            'flag_nopph23' => $nopph23,
            'tanggal_lunas' => $tanggal_lunas,
            'modified_by' => Auth::user()->id,
            'modified_at' => Carbon::now()
        ]);

        DB::table('t_pembayaran_detail')->insert([
            'id_pmb' => $request->id_pmb,
            // 'deposit_detail_id' => $request->deposit_detail_id,
            'currency_id' => $request->currency_id,
            'jenis_pmb' => $request->jenis_pmb,
            'id_invoice' => $request->id_invoice,
            'nilai' => $nilai_bayar
        ]);

        $return_data['status'] = "sukses";
        $return_data['message'] = "Berhasil menyimpan detail pembayaran!";

        header('Content-Type: application/json');
        echo json_encode($return_data);
    }

    public function deleteDetailPembayaranPiutang(Request $request)
    {
        $return_data = array();
        DB::beginTransaction();
        try {
            $tanggal   = date('Y-m-d H:i:s');

            $data = PembayaranModel::get_detail_piutang($request->id)->first();
            $invoice_bayar = $data->invoice_bayar - $data->nilai;
            $tanggal_lunas = null;
            $flag = 2;
            if ($invoice_bayar == 0) {
                $flag = 0;
            }
            DB::table('t_external_invoice')->where('id', $data->id_invoice)->update([
                'invoice_bayar' => $data->invoice_bayar - $data->nilai,
                'flag_bayar' => $flag,
                'tanggal_lunas' => $tanggal_lunas,
                'modified_by' => Auth::user()->id,
                'modified_at' => Carbon::now()
            ]);

            /**
             * kalau ada deposit
             */
            // if ($data->deposit_detail_id != 0) {
            //     $param['deposit_detail_id'] = $data->deposit_detail_id;
            //     DepositController::deleteDepositPembayaran($param);
            // }
            $deposits = DepositDetail::where('pembayaran_id', $data->id_pmb)->get();
            if (count($deposits)) {
                $amount = 0;
                foreach ($deposits as $dtl) {
                    $amount += $dtl->amount;
                    DepositDetail::find($dtl->id)->delete();
                }
                $amount = $amount * -1;
                $deposit = Deposit::where('company_id', $request->company_id)->where('currency_id', $request->currency_id)->first();
                $deposit->balance = $deposit->balance + $amount;
                $deposit->save();
            }
            /** end */

            /**
             * kalau udah ada jurnalnya
             */
            $journal = Journal::where('pembayaran_id', $data->id_pmb)->first();
            if ($journal != []) {
                JournalDetail::deleteJournalDetailByJournalId($journal->id);
                $journal->delete();
            }
            /** end */

            DB::table('t_pembayaran_detail')->where('id', $request->id)->delete();

            $return_data['status'] = "sukses";
            $return_data['message'] = "Berhasil menyimpan detail pembayaran!";

            DB::commit();
            header('Content-Type: application/json');
            echo json_encode($return_data);
        } catch (\Throwable $th) {
            Log::error("deleteDetailPembayaranPiutang Error {$th->getMessage()}");
            Log::error($th->getTraceAsString());
            $return_data['status'] = "failed";
            $return_data['message'] = $th->getMessage();

            DB::rollBack();
            header('Content-Type: application/json');
            echo json_encode($return_data);
        }
    }

    public function getDataInvExt(Request $request)
    {
        $result = DB::table('t_external_invoice AS i')
            ->join('t_mcurrency AS c', 'c.id', 'i.currency')
            ->select('i.*', 'c.code')
            ->where('i.id', $request->id)
            ->first();
        $data = $result;
        $data->total_invoice_pph23 = $result->total_invoice + $result->pph23;
        $data->nilai_sisa_pph23 = $result->total_invoice + $result->pph23 - $result->invoice_bayar;
        $data->nilai_sisa = $result->total_invoice - $result->invoice_bayar;

        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function cancelPembayaran($id, Request $request)
    {
        $user_id = Auth::user()->id;
        $now = Carbon::now();
        DB::beginTransaction();
        try {
            $pmb_detail = PembayaranModel::getAllDetailsByIdPmb($id)->get();
            foreach ($pmb_detail as $key => $detail) {
                $ext_invoice = ExternalInvoice::find($detail->id_invoice);
                $invoice_bayar = $ext_invoice->invoice_bayar - $pmb_detail->nilai;
                if ($invoice_bayar == 0) $flag = 0;
                else $flag = 2;

                $ext_invoice->invoice_bayar = $invoice_bayar;
                $ext_invoice->flag_bayar = $flag;
                $ext_invoice->tanggal_lunas = null;
                $ext_invoice->modified_at = $now;
                $ext_invoice->modified_by = $user_id;
                $ext_invoice->save();
            }

            $pmb_detail->status = 0;
            $pmb_detail->save();
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function openPMB(Request $request)
    {
        $rules = [
            'id_pmb' => 'required',
            'jenis_pmb' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->with('errorForm', $validator->errors()->messages());
        }

        DB::beginTransaction();
        try {
            PembayaranModel::where('id', $request->id_pmb)->update([
                'status' => 0,
            ]);

            DB::table('log_detail')->insert([
                'jenis' => 'Pembayaran',
                'id_table' => $request->id_pmb,
                'keterangan' => 'Open PMB ' . (($request->jenis_pmb == 0) ? 'Piutang' : 'Hutang'),
                'created_by' => Auth::user()->id,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            DB::commit();

            return redirect()->route('pembayaran.edit', ['id' => $request->id_pmb])->with('status', 'Berhasil dibuka');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
