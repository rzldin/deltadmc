<?php

namespace App\Http\Controllers;

use App\BookingModel;
use App\ExternalInvoice;
use App\ExternalInvoiceDetail;
use App\InvoiceDetailModel;
use App\InvoiceModel;
use App\MasterModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ExternalInvoiceController extends Controller
{
    public function index()
    {
        $external_invoices = ExternalInvoice::getAllExternalInvoice()->get();
        return view('external_invoice.list_external_invoice', compact('external_invoices'));
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

        return view('external_invoice.add_external_invoice')->with($data);
    }

    public function loadDetail(Request $request)
    {
        // Session::forget('invoice_details');
        $html = '';

        $details = Session::get('invoice_details');
        if ($details == []) {
            $data = InvoiceDetailModel::getInvoiceDetails($request->invoice_id)->get();

            foreach ($data as $key => $detail) {
                $newItem = [
                    // 'key' => $key,
                    't_mcharge_code_id' => $detail['t_mcharge_code_id'],
                    'charge_name' => $detail['charge_name'],
                    'desc' => $detail['desc'],
                    'reimburse_flag' => $detail['reimburse_flag'],
                    'qty' => $detail['qty'],
                    'currency' => $detail['currency'],
                    'currency_code' => $detail['currency_code'],
                    'sell_val' => $detail['sell_val'],
                    'total' => ($detail['qty'] * $detail['sell_val']),
                    'rate' => $detail['rate'],
                    'vat' => $detail['vat'],
                    'subtotal' => $detail['subtotal'],
                    'note' => $detail['note'],
                ];
                // push data dari db ke dalam session invoice_details
                Session::push('invoice_details', $newItem);
            }
        }
        $details = Session::get('invoice_details');
        // dd($details);
        if ($details != []) {
            foreach ($details as $key => $detail) {
                if ($detail['reimburse_flag'] == 1) {
                    $style = 'checked';
                } else {
                    $style = '';
                }
                $html .= '<tr>';
                $html .= '<td><input type="checkbox" name="detail_id" id="detail_id_'.$key.'" value="'.$key.'"/></td>';
                $html .= '<td>';
                $html .= ($key + 1);
                $html .= '</td>';
                $html .= '<td class="text-left">' . $detail['charge_name'] . '</td>';
                $html .= '<td class="text-left">' . $detail['desc'] . '</td>';
                $html .= '<td class="text-center"><input type="checkbox" name="reimburs" style="width:50px;" id="reimburs_' . ($key + 1) . '" onclick="return false;" '.($request->invoice_type == 'REM' ? 'checked' : '').'></td>';
                $html .= '<td class="text-left">' . $detail['qty'] . '</td>';
                $html .= '<td class="text-left">' . $detail['currency_code'] . '</td>';
                $html .= '<td class="text-right">' . number_format($detail['sell_val'], 2, ',', '.') . '</td>';
                $html .= '<td class="text-right">' . number_format(($detail['qty'] * $detail['sell_val']), 2, ',', '.') . '</td>';
                $html .= '<td class="text-right">' . number_format($detail['rate'], 2, ',', '.') . '</td>';
                $html .= '<td class="text-right">' . number_format($detail['vat'], 2, ',', '.') . '</td>';
                $html .= '<td class="text-right">' . number_format($detail['subtotal'], 2, ',', '.') . '</td>';
                $html .= '<td class="text-left"></td>';
            }
        }

        return $html;
    }

    public function loadDetailBefore(Request $request)
    {
        $html = '';
        $key = $request->id;
        // var key adalah array dari id / key yang akan di delete
        // ex : $key = [0,3];
        $total = 0;
        $vat = 0;
        $roe = 0;
        $amount = 0;

        $grand_total = 0;
        $total_amount = 0;
        // $details = InvoiceDetailModel::getInvoiceDetailsInId($request->id)->get();
        $details = Session::get('invoice_details');
        if ($details != []) {
            // loop array key untuk mendapatkan data details yang index / key nya sesuai dengan var key
            // ex : hanya mengambil data details yang index nya 0 dan 3 // $details[3][field_name]
            foreach ($key as $index => $id) {
                $total = ($details[$id]['qty'] * $details[$id]['sell_val']);
                $amount = ($total * $details[$id]['rate']) + $details[$id]['vat'];
                $grand_total += $total;
                $total_amount += $amount;
                $roe = $details[$id]['rate'];
                $vat = $details[$id]['vat'];
                // $total += ($detail['qty'] * $detail['sell_val']);
                if ($details[$id]['reimburse_flag'] == 1) {
                    $style = 'checked';
                } else {
                    $style = '';
                }
                $html .= '<tr>';
                $html .= '<td>';
                // id / key disimpan ke array input untuk diambil dari jquery di depan
                $html .= '<input type="hidden" name="id_to_delete[]" id="id_to_delete_'.$id.'" value="'.$id.'"/>';
                $html .= ($index + 1);
                $html .= '</td>';
                $html .= '<td class="text-left">' . $details[$id]['charge_name'] . '</td>';
                $html .= '<td class="text-left">' . $details[$id]['desc'] . '</td>';
                $html .= '<td class="text-center"><input type="checkbox" name="reimburs" style="width:50px;" id="reimburs_' . ($index + 1) . '" onclick="return false;" '.($request->invoice_type == 'REM' ? 'checked' : '').'></td>';
                $html .= '<td class="text-left">' . $details[$id]['qty'] . '</td>';
                $html .= '<td class="text-left">' . $details[$id]['currency_code'] . '</td>';
                $html .= '<td class="text-right">' . number_format($details[$id]['sell_val'], 2, ',', '.') . '</td>';
                $html .= '<td class="text-right">' . number_format(($details[$id]['qty'] * $details[$id]['sell_val']), 2, ',', '.') . '</td>';
                $html .= '<td class="text-right">' . number_format($details[$id]['rate'], 2, ',', '.') . '</td>';
                $html .= '<td class="text-right">' . number_format($details[$id]['vat'], 2, ',', '.') . '</td>';
                $html .= '<td class="text-right">' . number_format($details[$id]['subtotal'], 2, ',', '.') . '</td>';
                $html .= '<td class="text-left"></td>';

            }
            $html .= '<tr>';
            $html .= '<td colspan="12">';
            $vat = (10/100) * $grand_total;
            $html .= '<input type="hidden" name="roe_before" id="roe_before" value="'.$roe.'"/>';
            $html .= '<input type="hidden" name="total_before" id="total_before" value="'.$grand_total.'"/>';
            $html .= '<input type="hidden" name="amount_before" id="amount_before" value="'.$total_amount.'"/>';
            $html .= '<input type="hidden" name="vat_before" id="vat_before" value="'.$vat.'"/>';
            $html .= '</td>';
            $html .= '</tr>';
        }

        return $html;
    }

    public function loadDetailAfter(Request $request)
    {
        $html = '';

        $details = Session::get('invoice_detail_after');

        if ($details != []) {
            foreach ($details as $key => $detail) {
                if ($detail['reimburse_flag'] == 1) {
                    $style = 'checked';
                } else {
                    $style = '';
                }
                $html .= '<tr>';
                $html .= '<td>';
                $html .= ($key + 1);
                $html .= '</td>';
                $html .= '<td class="text-left">' . $detail['charge_name'] . '</td>';
                $html .= '<td class="text-left">' . $detail['desc'] . '</td>';
                $html .= '<td class="text-center"><input type="checkbox" name="reimburs" style="width:50px;" id="reimburs_' . ($key + 1) . '" ' . $style . '></td>';
                $html .= '<td class="text-left">' . $detail['qty'] . '</td>';
                $html .= '<td class="text-left">' . $detail['currency_code'] . '</td>';
                $html .= '<td class="text-right">' . number_format($detail['sell_val'], 2, ',', '.') . '</td>';
                $html .= '<td class="text-right">' . number_format(($detail['qty'] * $detail['sell_val']), 2, ',', '.') . '</td>';
                $html .= '<td class="text-right">' . number_format($detail['rate'], 2, ',', '.') . '</td>';
                $html .= '<td class="text-right">' . number_format($detail['vat'], 2, ',', '.') . '</td>';
                $html .= '<td class="text-right">' . number_format($detail['subtotal'], 2, ',', '.') . '</td>';
                $html .= '<td class="text-left"></td>';
                $html .= '<td style="text-align:center;">';
                        $html .= '<a href="javascript:;" class="btn btn-xs btn-primary'
                                . '" onclick="editDetailx();" id="btnEditx_'.$detail['id'].'"> '
                                . '<i class="fa fa-edit"></i></a>';
                        $html .= '<a href="javascript:;" class="btn btn-xs btn-danger'
                                . '" onclick="hapusDetailx();" style="margin-left:2px"> '
                                . '<i class="fa fa-trash"></i></a>';
                        $html .= '</td>';
            }
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
            't_mcharge_code_id' => $request->t_mcharge_code_id,
            'charge_name' => $request->t_mcharge_code_name,
            'desc' => $request->desc,
            'reimburse_flag' => $request->reimburse_flag,
            'qty' => $request->unit,
            'currency' => $request->currency_id,
            'currency_code' => $request->currency_code,
            'sell_val' => $request->rate,
            'total' => $request->total,
            'rate' => $request->roe,
            'vat' => $request->vat,
            'subtotal' => $request->amount,
            'note' => $request->note,
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
        // dd($request->all());
        $rules = [
            'client_id' => 'required',
            'external_invoice_no' => 'required|unique:t_external_invoice',
            'external_invoice_date' => 'required',
            'currency' => 'required',
            'pol_id' => 'required',
            'pod_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->with('errorForm', $validator->errors()->messages());
        }

        try {
            DB::beginTransaction();

            $param = $request->all();
            $param['external_invoice_date'] = date('Y-m-d', strtotime($request->external_invoice_date));
            $param['onboard_date'] = date('Y-m-d', strtotime($request->onboard_date));
            $param['reimburse_flag'] = (($request->invoice_type == 'REM') ? 1 : 0);
            $param['debit_note_flag'] = (($request->invoice_type == 'DN') ? 1 : 0);
            $param['credit_note_flag'] = (($request->invoice_type == 'CN') ? 1 : 0);
            // $param['rate'] = 1;
            $param['created_by'] = Auth::user()->name;
            $param['created_on'] = date('Y-m-d h:i:s');

            $invoice = ExternalInvoice::saveExternalInvoice($param);

            $details = $request->session()->get('invoice_details');
            // dd($details);
            foreach ($details as $key => $detail) {
                // dd($invoice->id);
                $paramDetail['id'] = 0;
                $paramDetail['external_invoice_id'] = $invoice->id;
                $paramDetail['t_mcharge_code_id'] = $detail['t_mcharge_code_id'];
                $paramDetail['reimburse_flag'] = (($request->invoice_type == 'REM') ? 1 : 0);
                $paramDetail['desc'] = $detail['desc'];
                $paramDetail['currency'] = $request['currency'];
                $paramDetail['rate'] = $request['rate'];
                $paramDetail['cost'] = 0;
                $paramDetail['sell'] = 0;
                $paramDetail['qty'] = $detail['qty'];
                $paramDetail['cost_val'] = 0;
                $paramDetail['sell_val'] = $detail['sell_val'];
                $paramDetail['vat'] = $detail['vat'];
                $paramDetail['subtotal'] = $detail['subtotal'];
                $paramDetail['routing'] = '';
                $paramDetail['transit_time'] = '';
                $paramDetail['created_by'] = Auth::user()->name;
                $paramDetail['created_on'] = date('Y-m-d h:i:s');

                ExternalInvoiceDetail::saveExternalInvoiceDetail($paramDetail);
            }

            DB::commit();

            return redirect()->route('external_invoice.index')->with('success', 'Saved!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function view($externalInvoiceId)
    {
        $data['header'] = ExternalInvoice::getExternalInvoice($externalInvoiceId)->first();
        $data['details'] = ExternalInvoiceDetail::getExternalInvoiceDetails($externalInvoiceId)->get();
        $data['companies'] = MasterModel::company_data();
        $data['addresses'] = MasterModel::get_address($data['header']['client_id']);
        $data['pics'] = MasterModel::get_pic($data['header']['client_id']);
        $data['currency']       = MasterModel::currency();
        $data['containers'] = BookingModel::get_container($data['header']['t_booking_id']);
        $data['goods'] = BookingModel::get_commodity($data['header']['t_booking_id']);

        return view('external_invoice.view_external_invoice')->with($data);
    }
}
