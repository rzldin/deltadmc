<?php

namespace App\Http\Controllers;

use App\BookingModel;
use App\Helpers\SiteHelpers;
use App\InvoiceDetailModel;
use App\InvoiceModel;
use App\MasterModel;
use App\ProformaInvoiceDetailModel;
use App\ProformaInvoiceModel;
use App\Tax;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ProformaInvoiceController extends Controller
{
    public function index()
    {
        $proforma_invoices = ProformaInvoiceModel::getAllProformaInvoice()->get();
        return view('proforma_invoice.list_proforma_invoice', compact('proforma_invoices'));
    }

    public function create($invoiceId)
    {
        Session::forget('invoice_details');
        $data['invoice_header'] = InvoiceModel::getInvoice($invoiceId)->first();
        $data['invoice_details'] = InvoiceDetailModel::getInvoiceDetails($invoiceId)->get();
        $data['companies'] = MasterModel::company_data();
        $data['addresses'] = MasterModel::get_address($data['invoice_header']['client_id']);
        $data['pics'] = MasterModel::get_pic($data['invoice_header']['client_id']);
        $data['currency']       = MasterModel::currency();
        $data['containers'] = BookingModel::get_container($data['invoice_header']['t_booking_id']);
        $data['goods'] = BookingModel::get_commodity($data['invoice_header']['t_booking_id']);
        $data['charges'] = MasterModel::charge();
        $data['taxes'] = Tax::all();

        return view('proforma_invoice.add_proforma_invoice')->with($data);
    }

    public function deleteSession()
    {
        Session::forget('invoice_details');
    }

    public function loadDetail(Request $request)
    {
        $html = '';

        $details = Session::get('invoice_details');
        if ($details == []) {
            if ($request->proforma_invoice_id != 0) {
                $data = ProformaInvoiceDetailModel::getProformaInvoiceDetails($request->proforma_invoice_id)->get();
            } else {
                $data = InvoiceDetailModel::getInvoiceDetails($request->invoice_id)->get();
            }

            foreach ($data as $key => $detail) {
                $newItem = [
                    // 'key' => $key,
                    'is_merge' => $detail['is_merge'],
                    'id' => $detail['id'],
                    'id_invoicenya' => (($request->proforma_invoice_id != 0)? $detail['id_invoice_detail']:$detail['id']),
                    't_mcharge_code_id' => $detail['t_mcharge_code_id'],
                    'charge_name' => $detail['charge_name'],
                    'desc' => $detail['desc'],
                    'reimburse_flag' => $detail['reimburse_flag'],
                    'qty' => $detail['qty'],
                    'currency' => $detail['currency'],
                    'currency_code' => $detail['currency_code'],
                    'cost' => $detail['cost'],
                    'sell' => $detail['sell'],
                    'cost_val' => $detail['cost_val'],
                    'sell_val' => $detail['sell_val'],
                    'rate' => $detail['rate'],
                    'vat' => $detail['vat'],
                    'pph23' => $detail['pph23'],
                    'subtotal' => $detail['subtotal'],
                    'routing' => $detail['routing'],
                    'transit_time' => $detail['transit_time'],
                    // 'note' => $detail['note'],
                ];
                // push data dari db ke dalam session invoice_details
                Session::push('invoice_details', $newItem);
            }
        }
        $details = Session::get('invoice_details');
        if ($details != []) {
            $total_ppn = 0;
            $total_pph23 = 0;
            $total_before_vat = 0;
            $total_invoice = 0;
            foreach ($details as $key => $detail) {
                $total_ppn += $detail['vat'];
                $total_pph23 += $detail['pph23'];
                $total_before_vat += $detail['sell_val'];
                $total_invoice += $detail['subtotal'];
                if ($detail['reimburse_flag'] == 1) {
                    $style = 'checked';
                } else {
                    $style = '';
                }
                $html .= '<tr>';
                $html .= '<td>';
                // if(!isset($detail['id_invoicenya'])){
                if ($detail['is_merge'] == 0) {
                    $html .= '<input type="checkbox" name="detail_id" id="detail_id_' . $key . '" value="' . $key . '"/>';
                }
                $html .= '</td>';
                $html .= '<td class="text-center">';
                $html .= ($key + 1);
                $html .= '</td>';
                $html .= '<td class="text-left">' . $detail['charge_name'] . '</td>';
                $html .= '<td class="text-left">' . $detail['desc'] . '</td>';
                $html .= '<td class="text-center"><input type="checkbox" name="reimburs" style="width:50px;" id="reimburs_' . ($key + 1) . '" onclick="return false;" ' . ($request->invoice_type == 'REM' ? 'checked' : '') . '></td>';
                $html .= '<td class="text-left">' . $detail['qty'] . '</td>';
                $html .= '<td class="text-left">' . $detail['currency_code'] . '</td>';
                $html .= '<td class="text-right">' . number_format($detail['sell'], 2, '.', ',') . '</td>';
                $html .= '<td class="text-right">' . number_format($detail['rate'], 2, '.', ',') . '</td>';
                $html .= '<td class="text-right">' . number_format($detail['sell_val'], 2, '.', ',') . '</td>';
                $html .= '<td class="text-right">' . number_format($detail['vat'], 2, '.', ',') . '</td>';
                $html .= '<td class="text-right">' . number_format($detail['pph23'], 2, '.', ',') . '</td>';
                $html .= '<td class="text-right">' . number_format($detail['subtotal'], 2, '.', ',') . '</td>';
                // $html .= '<td class="text-left"></td>';
                $html .= '</tr>';
            }
            $total_ppn = number_format($total_ppn, 2, '.', ',');
            $total_pph23 = number_format($total_pph23, 2, '.', ',');
            $total_before_vat = number_format($total_before_vat, 2, '.', ',');
            $total_invoice = number_format($total_invoice, 2, '.', ',');
            $html .= "<tr id='row_total_before_vat'>";
            $html .= "<td colspan='9' class='text-right'><span id='lbl_total_before_vat'>Total</span></td>";
            $html .= "<td class='text-right'>";
            $html .= "<input type='text' class='form-control' name='total_before_vat' id='total_before_vat' value='{$total_before_vat}' readonly/>";
            $html .= "</td>";
            $html .= "<td class='text-right'>";
            $html .= "<input type='text' class='form-control' name='input_ppn' id='input_ppn' value='{$total_ppn}' readonly/>";
            $html .= "</td>";
            $html .= "<td class='text-right'>";
            $html .= "<input type='text' class='form-control' name='input_pph23' id='input_pph23' value='{$total_pph23}' readonly/>";
            $html .= "</td>";
            $html .= "<td class='text-right'>";
            $html .= "<input type='text' class='form-control' name='total_invoice' id='total_invoice' value='{$total_invoice}' readonly/>";
            $html .= "</td>";
            $html .= "</tr>";
        }

        return $html;
    }

    public function loadDetailBefore(Request $request)
    {
        $html = '';
        $key = $request->id;
        // var key adalah array dari id / key yang akan di delete
        // ex : $key = [0,3];
        $total_cost = 0;
        $total_sell = 0;
        $total_cost_val = 0;
        $total_sell_val = 0;
        $rate = 0;
        $total_vat = 0;
        $total_pph23 = 0;
        $subtotal = 0;
        $routing = '';
        $transit_time = '';
        // $details = InvoiceDetailModel::getInvoiceDetailsInId($request->id)->get();
        $details = Session::get('invoice_details');
        if ($details != []) {
            // loop array key untuk mendapatkan data details yang index / key nya sesuai dengan var key
            // ex : hanya mengambil data details yang index nya 0 dan 3 // $details[3][field_name]
            $id_invoicenya = [];
            foreach ($key as $index => $id) {
                $id_invoicenya[$id] = $details[$id]['id'];
                $total_cost += $details[$id]['cost'];
                $total_sell += $details[$id]['sell'];
                $total_cost_val += $details[$id]['cost_val'];
                $total_sell_val += $details[$id]['sell_val'];
                $rate = $details[$id]['rate'];
                $total_vat += $details[$id]['vat'];
                $total_pph23 += $details[$id]['pph23'];
                $subtotal += $details[$id]['subtotal'];
                $routing = $details[$id]['routing'];
                $transit_time = $details[$id]['transit_time'];
                // $vat = $details[$id]['vat'];
                // $total += ($detail['qty'] * $detail['sell_val']);
                if ($details[$id]['reimburse_flag'] == 1) {
                    $style = 'checked';
                } else {
                    $style = '';
                }
                $html .= '<tr>';
                $html .= '<td>';
                // id / key disimpan ke array input untuk diambil dari jquery di depan
                $html .= '<input type="hidden" name="id_to_delete[]" id="id_to_delete_' . $id . '" value="' . $id . '"/>';
                $html .= ($index + 1);
                $html .= '</td>';
                $html .= '<td class="text-left">' . $details[$id]['charge_name'] . '</td>';
                $html .= '<td class="text-left">' . $details[$id]['desc'] . '</td>';
                $html .= '<td class="text-center"><input type="checkbox" name="reimburs" style="width:50px;" id="reimburs_' . ($index + 1) . '" onclick="return false;" ' . ($request->invoice_type == 'REM' ? 'checked' : '') . '></td>';
                $html .= '<td class="text-left">' . $details[$id]['qty'] . '</td>';
                $html .= '<td class="text-left">' . $details[$id]['currency_code'] . '</td>';
                $html .= '<td class="text-right">' . number_format($details[$id]['sell'], 2, '.', ',') . '</td>';
                $html .= '<td class="text-right">' . number_format($details[$id]['sell_val'], 2, '.', ',') . '</td>';
                $html .= '<td class="text-right">' . number_format($details[$id]['rate'], 2, '.', ',') . '</td>';
                $html .= '<td class="text-right">' . number_format($details[$id]['vat'], 2, '.', ',') . '</td>';
                $html .= '<td class="text-right">' . number_format($details[$id]['pph23'], 2, '.', ',') . '</td>';
                $html .= '<td class="text-right">' . number_format($details[$id]['subtotal'], 2, '.', ',') . '</td>';
                // $html .= '<td class="text-left"></td>';

            }
            $html .= '<tr>';
            $html .= '<td colspan="12">';
            $html .= '<input type="hidden" name="qty_before" id="qty_before" value="1"/>';
            $html .= '<input type="hidden" name="id_invoicenya_before" id="id_invoicenya_before" value="'.implode(",", $id_invoicenya).'"/>';
            $html .= '<input type="hidden" name="total_cost_before" id="total_cost_before" value="' . $total_cost . '"/>';
            $html .= '<input type="hidden" name="total_sell_before" id="total_sell_before" value="' . $total_sell . '"/>';
            $html .= '<input type="hidden" name="total_cost_val_before" id="total_cost_val_before" value="' . $total_cost_val . '"/>';
            $html .= '<input type="hidden" name="total_sell_val_before" id="total_sell_val_before" value="' . $total_sell_val . '"/>';
            $html .= '<input type="hidden" name="rate_before" id="rate_before" value="' . $rate . '"/>';
            $html .= '<input type="hidden" name="total_vat_before" id="total_vat_before" value="' . $total_vat . '"/>';
            $html .= '<input type="hidden" name="total_pph23_before" id="total_pph23_before" value="' . $total_pph23 . '"/>';
            $html .= '<input type="hidden" name="subtotal_before" id="subtotal_before" value="' . $subtotal . '"/>';
            $html .= '<input type="hidden" name="routing_before" id="routing_before" value="' . $routing . '"/>';
            $html .= '<input type="hidden" name="transit_time_before" id="transit_time_before" value="' . $transit_time . '"/>';
            $html .= '</td>';
            $html .= '</tr>';
        }

        return $html;
    }

    public function saveMergeDetail(Request $request)
    {
        $details = Session::get('invoice_details');

        if ($request->id_to_delete != []) {
            // menghapus data details yang index nya sesuai dengan array id_to_delete
            foreach ($request->id_to_delete as $key => $id) {
                unset($details[$id]);
            }
        }

        $newItem = [
            // 'key' => (sizeof($details) + 1),
            'is_merge' => 1,
            'id_invoicenya' => $request->id_invoicenya,
            't_mcharge_code_id' => $request->t_mcharge_code_id,
            'charge_name' => $request->t_mcharge_code_name,
            'desc' => $request->desc,
            'reimburse_flag' => $request->reimburse_flag,
            'qty' => $request->qty,
            'currency' => $request->currency_id,
            'currency_code' => $request->currency_code,
            'cost' => $request->cost,
            'sell' => $request->sell,
            'cost_val' => $request->cost_val,
            'sell_val' => $request->sell_val,
            'rate' => $request->rate,
            'vat' => $request->vat,
            'pph23' => $request->pph23,
            'subtotal' => $request->subtotal,
            'routing' => $request->routing,
            'transit_time' => $request->transit_time,
            // 'note' => $request->note,
        ];

        // push item baru ke array
        array_push($details, $newItem);

        // restruktur array, agar index arraynya reset
        $details = array_values($details);

        // session invoice_details direplace dengan array details baru
        Session::put('invoice_details', $details);
        // Session::push('invoice_details', $newItem);

        return true;
    }

    public function save(Request $request)
    {
        $rules = [
            'client_id' => 'required',
            // 'proforma_invoice_no' => 'required',
            'proforma_invoice_date' => 'required',
            'currency' => 'required',
            // 'pol_id' => 'required',
            // 'pod_id' => 'required',
        ];
        if ($request->has('proforma_invoice_no')) {
            $rules = array_merge(['proforma_invoice_no' => 'required|unique:t_proforma_invoice'], $rules);
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->with('errorForm', $validator->errors()->messages());
        }

        try {
            DB::beginTransaction();

            $param = $request->all();
            $param['id'] = $request->id;
            $param['t_invoice_id'] = $request->t_invoice_id;
            $param['t_booking_id'] = $request->t_booking_id;
            $param['activity'] = $request->activity;
            $param['client_id'] = $request->client_id;
            $param['client_addr_id'] = $request->client_addr_id;
            $param['client_pic_id'] = $request->client_pic_id;
            if ($request->has('proforma_invoice_no')) {
                $param['proforma_invoice_no'] = $request->proforma_invoice_no;
            }
            $param['truck_no'] = $request->truck_no;
            $param['proforma_invoice_date'] = date('Y-m-d', strtotime($request->proforma_invoice_date));
            $param['reimburse_flag'] = (($request->invoice_type == 'REM') ? 1 : 0);
            $param['debit_note_flag'] = (($request->invoice_type == 'DN') ? 1 : 0);
            $param['credit_note_flag'] = (($request->invoice_type == 'CN') ? 1 : 0);
            $param['top'] = $request->top;
            $param['currency'] = $request->currency;
            $param['mbl_shipper'] = $request->mbl_shipper;
            $param['hbl_shipper'] = $request->hbl_shipper;
            $param['vessel'] = $request->vessel;
            $param['m_vessel'] = $request->m_vessel;
            $param['pol_id'] = $request->pol_id;
            $param['pod_id'] = $request->pod_id;
            $param['onboard_date'] = date('Y-m-d', strtotime($request->onboard_date));
            $param['rate'] = $request->rate;
            $param['total_before_vat'] = str_replace(',', '', $request->total_before_vat);
            $param['total_vat'] = str_replace(',', '', $request->input_ppn);
            $param['pph23'] = str_replace(',', '', $request->input_pph23);
            $param['total_invoice'] = str_replace(',', '', $request->total_invoice);
            // $param['rate'] = 1;
            $param['created_by'] = Auth::user()->name;
            $param['created_on'] = date('Y-m-d h:i:s');
            unset($param['reimburs']);
            unset($param['invoice_type']);
            unset($param['pol_name']);
            unset($param['pod_name']);
            unset($param['input_ppn']);
            unset($param['input_pph23']);

            // dd($request->all(), $param);
            $proforma_invoice = ProformaInvoiceModel::saveProformaInvoice($param);

            $details = $request->session()->get('invoice_details');
            // dd($details);
            $total_before_vat = 0;
            $total_vat = 0;
            $total_invoice = 0;

            // clear proforma details first
            if ($request->id != 0) {
                ProformaInvoiceDetailModel::deleteProformaInvoiceDetailsByProformaId($request->id);
            }

            foreach ($details as $key => $detail) {
                // dd($proforma_invoice->id);
                $paramDetail['id'] = 0;
                $paramDetail['proforma_invoice_id'] = $proforma_invoice->id;
                $paramDetail['t_mcharge_code_id'] = $detail['t_mcharge_code_id'];
                $paramDetail['reimburse_flag'] = (($request->invoice_type == 'REM') ? 1 : 0);
                $paramDetail['desc'] = $detail['desc'];
                $paramDetail['currency'] = $request['currency'];
                $paramDetail['rate'] = $detail['rate'];
                $paramDetail['cost'] = $detail['cost'];
                $paramDetail['sell'] = $detail['sell'];
                $paramDetail['qty'] = $detail['qty'];
                $paramDetail['cost_val'] = $detail['cost_val'];
                $paramDetail['sell_val'] = $detail['sell_val'];
                $paramDetail['vat'] = $detail['vat'];
                $paramDetail['pph23'] = $detail['pph23'];
                $paramDetail['subtotal'] = $detail['subtotal'];
                $paramDetail['routing'] = $detail['routing'];
                $paramDetail['transit_time'] = $detail['transit_time'];
                $paramDetail['created_by'] = Auth::user()->name;
                $paramDetail['created_on'] = date('Y-m-d h:i:s');
                $paramDetail['id_invoice_detail'] = ((isset($detail['id_invoicenya']))? $detail['id_invoicenya']:NULL);
                // dd($details, $paramDetail);
                $total_before_vat += $detail['sell_val'];
                $total_vat += $detail['vat'];
                $total_invoice += $detail['subtotal'];
                $pid = ProformaInvoiceDetailModel::saveProformaInvoiceDetail($paramDetail);
                if(isset($detail['id'])){
                    InvoiceDetailModel::where('id', $detail['id'])->update([
                        'pfi_detail_id' => $pid->id
                    ]);
                }elseif(isset($detail['id_invoicenya'])){
                    InvoiceDetailModel::whereIn('id', explode(',',$detail['id_invoicenya']))->update([
                        'pfi_detail_id' => $pid->id
                    ]);
                }

            }

            // DB::table('t_proforma_invoice')->where('id', $proforma_invoice->id)->update([
            //     'total_before_vat' => $total_before_vat,
            //     'total_vat' => $total_vat,
            //     'total_invoice' => $total_invoice,
            // ]);
            DB::commit();
            Session::forget('invoice_details');
            return redirect()->route('proforma_invoice.index')->with('success', 'Saved!');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('ProformaInvoice Save Error ' . $th->getMessage());
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function edit($proformaInvoiceId)
    {
        Session::forget('invoice_details');
        $data['responsibility'] = SiteHelpers::getUserRole();
        $data['proforma_invoice_header'] = ProformaInvoiceModel::getProformaInvoice($proformaInvoiceId)->first();
        $data['proforma_invoice_details'] = ProformaInvoiceDetailModel::getProformaInvoiceDetails($proformaInvoiceId)->get();
        $data['companies'] = MasterModel::company_data();
        $data['addresses'] = MasterModel::get_address($data['proforma_invoice_header']['client_id']);
        $data['pics'] = MasterModel::get_pic($data['proforma_invoice_header']['client_id']);
        $data['currency']       = MasterModel::currency();
        $data['containers'] = BookingModel::get_container($data['proforma_invoice_header']['t_booking_id']);
        $data['goods'] = BookingModel::get_commodity($data['proforma_invoice_header']['t_booking_id']);
        $data['charges'] = MasterModel::charge();

        return view('proforma_invoice.edit_proforma_invoice')->with($data);
    }

    public function view($proformaInvoiceId)
    {
        $data['header'] = ProformaInvoiceModel::getProformaInvoice($proformaInvoiceId)->first();
        $data['details'] = ProformaInvoiceDetailModel::getProformaInvoiceDetails($proformaInvoiceId)->get();
        $data['companies'] = MasterModel::company_data();
        $data['addresses'] = MasterModel::get_address($data['header']['client_id']);
        $data['pics'] = MasterModel::get_pic($data['header']['client_id']);
        $data['currency']       = MasterModel::currency();
        $data['containers'] = BookingModel::get_container($data['header']['t_booking_id']);
        $data['goods'] = BookingModel::get_commodity($data['header']['t_booking_id']);

        return view('proforma_invoice.view_proforma_invoice')->with($data);
    }

    public function delete($proformaInvoiceId)
    {
        DB::beginTransaction();
        try {
            $loop = ProformaInvoiceDetailModel::where('proforma_invoice_id', $proformaInvoiceId)->get();
            foreach ($loop as $key => $v) {
                InvoiceDetailModel::where('pfi_detail_id', $v->id)->update([
                    'pfi_detail_id' => 0
                ]);
            }
            ProformaInvoiceDetailModel::where('proforma_invoice_id', $proformaInvoiceId)->delete();
            ProformaInvoiceModel::find($proformaInvoiceId)->delete();

            DB::commit();

            return redirect()->route('proforma_invoice.index')->with('success', 'Deleted!');
        } catch (\Throwable $th) {
            DB::rollBack();

            Log::error("delete ProformaInvoice Error {$th->getMessage()}");
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function syncProformaInvoiceDetail(Request $request)
    {
        $result = [];
        // DB::beginTransaction();
        try {
            $proforma_details = ProformaInvoiceDetailModel::where('proforma_invoice_id', $request->proforma_invoice_id)->get();
            // dd($request->all(), $proforma_details);
            $total_before_vat = 0;
            $total_vat = 0;
            $total_pph23 = 0;
            $total_invoice = 0;
            foreach ($proforma_details as $key => $proforma_detail) {
                if ($proforma_detail->id_invoice_detail != null || $proforma_detail->id_invoice_detail != '') {
                    $id_invoice_dtl_arr = explode(',', $proforma_detail->id_invoice_detail);
                    // dd($id_invoice_dtl_arr, $proforma_detail->id_invoice_detail, $proforma_detail->id);

                    $cost = 0;
                    $sell = 0;
                    $cost_val = 0;
                    $sell_val = 0;
                    $vat = 0;
                    $pph23 = 0;
                    $subtotal = 0;
                    foreach ($id_invoice_dtl_arr as $id_invoice_dtl) {
                        $invoice_dtl = InvoiceDetailModel::find($id_invoice_dtl);
                        $cost += $invoice_dtl->cost;
                        $sell += $invoice_dtl->sell;
                        $cost_val += $invoice_dtl->cost_val;
                        $sell_val += $invoice_dtl->sell_val;
                        $vat += $invoice_dtl->vat;
                        $pph23 += $invoice_dtl->pph23;
                        $subtotal += $invoice_dtl->subtotal;
                    }

                }
                $proforma_detail->cost = $cost;
                $proforma_detail->sell = $sell;
                $proforma_detail->cost_val = $cost_val;
                $proforma_detail->sell_val = $sell_val;
                $proforma_detail->vat = $vat;
                $proforma_detail->pph23 = $pph23;
                $proforma_detail->subtotal = $subtotal;
                $proforma_detail->created_by = Auth::user()->name;
                $proforma_detail->created_on = date('Y-m-d h:i:s');
                $proforma_detail->save();

                $total_before_vat += $sell_val;
                $total_vat += $vat;
                $total_pph23 += $pph23;
                $total_invoice += $subtotal;

            }
            DB::table('t_proforma_invoice')->where('id', $request->proforma_invoice_id)->update([
                'total_before_vat' => $total_before_vat,
                'total_vat' => $total_vat,
                'pph23' => $total_pph23,
                'total_invoice' => $total_invoice,
            ]);

            DB::commit();
            $result['status'] = 'success';
            $result['message'] = 'Sync success, please refresh this page!';

            return $result;
        } catch (\Throwable $th) {
            DB::rollBack();
            $result['status'] = 'failed';
            $result['message'] = $th->getMessage();

            Log::error("Sync Proforma Invoice Error {$th->getMessage()}");
            Log::error($th->getTraceAsString());
        }
    }
}
