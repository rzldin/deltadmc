<?php

namespace App\Http\Controllers;

use App\BookingModel;
use App\InvoiceDetailModel;
use App\InvoiceModel;
use App\MasterModel;
use App\QuotationModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = InvoiceModel::getAllInvoice()->get();
        return view('invoice.list_invoice', compact('invoices'));
    }

    public function create(Request $request)
    {
        $data['error']          = (isset($_GET['error']) ? 1 : 0);
        $data['errorMsg']       = (isset($_GET['errorMsg']) ? $_GET['errorMsg'] : '');

        $rules = [
            't_booking_id' => 'required',
            'cek_sell_chrg' => 'required',
            'cek_bill_to' => 'required',
        ];

        $validatorMsg = [
            't_booking_id.required' => 'Booking ID can not be null!',
            'cek_sell_chrg.required' => 'Please choose at least 1 item!',
            'cek_bill_to.required' => 'Please choose Bill To field!',
        ];

        $validator = Validator::make($request->all(), $rules, $validatorMsg);
        if ($validator->fails()) {
            // $errorMsg = '';
            // foreach ($validator->errors()->messages() as $err) {
            //     foreach ($err as $msg) {
            //         $errorMsg .= $msg . "<br>";
            //     }
            // }
            // $previousUrl = parse_url(app('url')->previous());

            // return redirect()->to($previousUrl['path'] . '?' . http_build_query(['error' => '1', 'errorMsg' => $errorMsg]));

            return redirect()->back()->with('errorForm', $validator->errors()->messages());
        }

        if (isset($request->cek_bill_to)) {
            foreach ($request->cek_bill_to as $key => $bill_to) {
                if ($bill_to == '' || $bill_to == null) {
                    // cek kalau bill to pada tabel sell kosong
                    $previousUrl = parse_url(app('url')->previous());

                    return redirect()->to($previousUrl['path'] . '?' . http_build_query(['error' => '1', 'errorMsg' => 'Please fill Bill To field']));
                } else if (($key > 0) && $bill_to != $request->cek_bill_to[$key - 1]) {
                    // cek kalau bill to antara row 1 dengan row sebelumnya berbeda
                    $previousUrl = parse_url(app('url')->previous());
                    return redirect()->to($previousUrl['path'] . '?' . http_build_query(['error' => '1', 'errorMsg' => 'Bill to not match']));
                }
            }
        }

        $data['shipping_dtl_id'] = [];
        $data['chrg_dtl_id'] = [];

        if (isset($request->cek_sell_shp)) {
            foreach ($request->cek_sell_shp as $key => $shp_dtl_id) {
                $data['shipping_dtl_id'][$key] = $shp_dtl_id;
            }
        }

        if (isset($request->cek_sell_chrg)) {
            foreach ($request->cek_sell_chrg as $key => $chrg_dtl_id) {
                $data['chrg_dtl_id'][$key] = $chrg_dtl_id;
            }
        }

        $data['bill_to_id'] = $request->cek_bill_to[0];
        $data['booking'] = BookingModel::getDetailBooking($request->t_booking_id);
        $data['reimburse'] = null;
        $data['companies'] = MasterModel::company_get($request->cek_bill_to[0]);
        $data['addresses'] = MasterModel::get_address($request->cek_bill_to[0]);
        $data['pics'] = MasterModel::get_pic($request->cek_bill_to[0]);
        $data['currency'] = MasterModel::currency();
        $data['containers'] = BookingModel::get_container($request->t_booking_id);
        $data['goods'] = BookingModel::get_commodity($request->t_booking_id);
        $data['tipe_inv'] = 'sell';
        return view('invoice.add_invoice')->with($data);
    }

    public function create_cost(Request $request)
    {
        $data['error']          = (isset($_GET['error']) ? 1 : 0);
        $data['errorMsg']       = (isset($_GET['errorMsg']) ? $_GET['errorMsg'] : '');

        $rules = [
            't_booking_id' => 'required',
            'cek_cost_chrg' => 'required',
            'cek_paid_to' => 'required',
        ];

        $validatorMsg = [
            't_booking_id.required' => 'Booking ID can not be null!',
            'cek_cost_chrg.required' => 'Please choose at least 1 item!',
            'cek_paid_to.required' => 'Please choose Paid To field!',
        ];

        $validator = Validator::make($request->all(), $rules, $validatorMsg);
        if ($validator->fails()) {
            $errorMsg = '';
            foreach ($validator->errors()->messages() as $err) {
                foreach ($err as $msg) {
                    $errorMsg .= $msg . "<br>";
                }
            }
            $previousUrl = parse_url(app('url')->previous());

            return redirect()->to($previousUrl['path'] . '?' . http_build_query(['error' => '1', 'errorMsg' => $errorMsg]));
        }

        if (isset($request->cek_paid_to)) {
            foreach ($request->cek_paid_to as $key => $paid_to) {
                if ($paid_to == '' || $paid_to == null) {
                    // cek kalau bill to pada tabel sell kosong
                    $previousUrl = parse_url(app('url')->previous());

                    return redirect()->to($previousUrl['path'] . '?' . http_build_query(['error' => '1', 'errorMsg' => 'Please fill Bill To field']));
                } else if (($key > 0) && $paid_to != $request->cek_paid_to[$key - 1]) {
                    // cek kalau bill to antara row 1 dengan row sebelumnya berbeda
                    $previousUrl = parse_url(app('url')->previous());
                    return redirect()->to($previousUrl['path'] . '?' . http_build_query(['error' => '1', 'errorMsg' => 'Bill to not match']));
                }
            }
        }

        $data['shipping_dtl_id'] = [];
        $data['chrg_dtl_id'] = [];

        if (isset($request->cek_cost_shp)) {
            foreach ($request->cek_cost_shp as $key => $shp_dtl_id) {
                $data['shipping_dtl_id'][$key] = $shp_dtl_id;
            }
        }

        if (isset($request->cek_cost_chrg)) {
            foreach ($request->cek_cost_chrg as $key => $chrg_dtl_id) {
                $data['chrg_dtl_id'][$key] = $chrg_dtl_id;
            }
        }

        $data['paid_to_id'] = $request->cek_paid_to[0];
        $data['booking'] = BookingModel::getDetailBooking($request->t_booking_id);
        $data['companies'] = MasterModel::company_get($request->cek_paid_to[0]);
        $data['addresses'] = MasterModel::get_address($request->cek_paid_to[0]);
        $data['pics'] = MasterModel::get_pic($request->cek_paid_to[0]);
        $data['currency'] = MasterModel::currency();
        $data['containers'] = BookingModel::get_container($request->t_booking_id);
        $data['goods'] = BookingModel::get_commodity($request->t_booking_id);
        $data['tipe_inv'] = 'cost';
        return view('invoice.add_invoice_cost')->with($data);
    }

    public function loadSellCost(Request $request)
    {

        $shp_dtl_id = [];
        $chrg_dtl_id = [];

        if (isset($request->shipping_dtl_id)) $shp_dtl_id = $request->shipping_dtl_id;
        if (isset($request->chrg_dtl_id)) $chrg_dtl_id = $request->chrg_dtl_id;

        $tabel1     = "";
        $tabel2     = "";
        $no         = 1;

        $booking    = DB::table('t_booking')->where('id', $request->id)->first();
        // $shipping   = QuotationModel::get_quoteShipping($booking->t_quote_id);
        $shipping   = QuotationModel::get_quoteShippingInId($shp_dtl_id);
        $quote      = QuotationModel::get_detailQuote($booking->t_quote_id);
        // $quote      = BookingModel::getChargesDetailUsingInId($request->chrg_dtl_id);
        $total      = 0;
        $total2     = 0;
        $amount     = 0;
        $amount2    = 0;
        // dd($quote);
        $totalAmount    = 0;
        $totalAmount2   = 0;

        // $data       = BookingModel::getChargesDetail($request->id);
        if($request->tipe_inv=='sell'){
            if(isset($request->shipping_dtl_id)){
                $data   = QuotationModel::get_quoteShippingInId($shp_dtl_id);
                foreach ($data as $row) {
                    // if ($row->reimburse_flag == 1) {
                    //     $style = 'checked';
                    // } else {
                    //     $style = '';
                    // }
                    $style = '';

                    $total = ($row->qty * $row->cost_val);
                    $total2 = ($row->qty * $row->sell_val);
                    $amount = ($total * $row->rate) + $row->vat;
                    $amount2 = ($total2 * $row->rate) + $row->vat;

                    // Sell
                    $tabel1 .= '<tr>';
                    $tabel1 .= '<td>';
                    $tabel1 .= ($no);
                    $tabel1 .= '<input type="hidden" name="cek_sell_shp[]" value="'.$row->id.'" />';
                    $tabel1 .= '<input type="hidden" name="cek_bill_to[]" value="'.$booking->client_id.'" />';
                    $tabel1 .= '</td>';
                    if ($quote->shipment_by == 'LAND') {
                        $tabel1 .= '<td>' . $row->truck_size . ($request->invoice_type == 'REM' ? ' (Reimburse)' : '').'</td>';
                    } else {
                        $tabel1 .= '<td>' . $row->name_carrier . ($request->invoice_type == 'REM' ? ' (Reimburse)' : '').'</td>';
                    }
                    $tabel1 .= '<td class="text-left">'.$row->notes.' | Routing: '.$row->routing.' | Transit time : '.$row->transit_time.'</td>';
                    $tabel1 .= '<td class="text-center"><input type="checkbox" name="reimburs" style="width:50px;" id="reimburs_' . $no . '" ' . $style . ' onclick="return false;" '.($request->invoice_type == 'REM' ? 'checked' : '').'></td>';
                    $tabel1 .= '<td class="text-left">' . $row->qty . '</td>';
                    $tabel1 .= '<td class="text-left">' . $row->code_currency . '</td>';
                    $tabel1 .= '<td class="text-right">' . number_format($row->sell_val, 2, ',', '.') . '</td>';
                    $tabel1 .= '<td class="text-right">' . number_format(($row->qty * $row->sell_val), 2, ',', '.') . '</td>';
                    $tabel1 .= '<td class="text-right">' . number_format($row->rate, 2, ',', '.') . '</td>';
                    $tabel1 .= '<td class="text-right">' . number_format($row->vat, 2, ',', '.') . '</td>';
                    $tabel1 .= '<td class="text-right">' . number_format($amount, 2, ',', '.') . '</td>';
                    $tabel1 .= '<td class="text-left"></td>';
                    $tabel1 .= '</tr>';
                    $no++;

                    $totalAmount    += $amount;
                    $totalAmount2   += $amount2;
                }
            }

            if(isset($request->chrg_dtl_id)){
                $data   = BookingModel::getChargesDetailUsingInId($chrg_dtl_id);
                foreach ($data as $row) {
                    if ($row->reimburse_flag == 1) {
                        $style = 'checked';
                    } else {
                        $style = '';
                    }

                    $total = ($row->qty * $row->cost_val);
                    $total2 = ($row->qty * $row->sell_val);
                    $amount = ($total * $row->rate) + $row->vat;
                    $amount2 = ($total2 * $row->rate) + $row->vat;

                    $tabel1 .= '<tr>';
                    $tabel1 .= '<td>';
                    $tabel1 .= ($no);
                    $tabel1 .= '<input type="hidden" name="cek_sell_chrg[]" value="'.$row->id.'" />';
                    $tabel1 .= '<input type="hidden" name="cek_bill_to[]" value="'.$row->bill_to_id.'" />';
                    $tabel1 .= '</td>';
                    $tabel1 .= '<td class="text-left">' . $row->charge_name . ($request->invoice_type == 'REM' ? ' (Reimburse)' : '') . '</td>';
                    $tabel1 .= '<td class="text-left">' . $row->desc . ' | Routing: ' . $row->routing . ' | Transit time : ' . $row->transit_time . '</td>';
                    $tabel1 .= '<td class="text-center"><input type="checkbox" name="reimburs" style="width:50px;" id="reimburs_' . $no . '" ' . $style . ' onclick="return false;" '.($request->invoice_type == 'REM' ? 'checked' : '').'></td>';
                    $tabel1 .= '<td class="text-left">' . $row->qty . '</td>';
                    $tabel1 .= '<td class="text-left">' . $row->code_cur . '</td>';
                    $tabel1 .= '<td class="text-right">' . number_format($row->sell_val, 2, ',', '.') . '</td>';
                    $tabel1 .= '<td class="text-right">' . number_format(($row->qty * $row->sell_val), 2, ',', '.') . '</td>';
                    $tabel1 .= '<td class="text-right">' . number_format($row->rate, 2, ',', '.') . '</td>';
                    $tabel1 .= '<td class="text-right">' . number_format($row->vat, 2, ',', '.') . '</td>';
                    $tabel1 .= '<td class="text-right">' . number_format($amount2, 2, ',', '.') . '</td>';
                    $tabel1 .= '<td class="text-left"></td>';
                    $tabel1 .= '</tr>';
                    $no++;

                    $totalAmount    += $amount;
                    $totalAmount2   += $amount2;
                }

                $tabel1 .= '<tr>';
                $tabel1 .= '<td colspan="10" class="text-right">Total</td>';
                $tabel1 .= '<td class="text-right">' . number_format($totalAmount2, 2, ',', '.') . '</td>';
                $tabel1 .= '<td colspan="1"></td>';
                $tabel1 .= '</tr>';
            }
        }else{

            if(isset($request->shipping_dtl_id)){
                $data   = BookingModel::getChargesDetailUsingInId($shp_dtl_id);
                foreach ($data as $row) {
                    if ($row->reimburse_flag == 1) {
                        $style = 'checked';
                    } else {
                        $style = '';
                    }

                    $total = ($row->qty * $row->cost_val);
                    $total2 = ($row->qty * $row->sell_val);
                    $amount = ($total * $row->rate) + $row->vat;
                    $amount2 = ($total2 * $row->rate) + $row->vat;

                    // Sell
                    $tabel1 .= '<tr>';
                    $tabel1 .= '<td>';
                    $tabel1 .= ($no);
                    $tabel1 .= '<input type="hidden" name="cek_cost_shp[]" value="'.$row->id.'" />';
                    $tabel1 .= '<input type="hidden" name="cek_bill_to[]" value="'.$row->bill_to_id.'" />';
                    $tabel1 .= '</td>';
                    $tabel1 .= '<td class="text-left">' . $row->charge_name . '</td>';
                    $tabel1 .= '<td class="text-left">' . $row->desc . ' | Routing: ' . $row->routing . ' | Transit time : ' . $row->transit_time . '</td>';
                    $tabel1 .= '<td class="text-center"><input type="checkbox" name="reimburs" style="width:50px;" id="reimburs_' . $no . '" ' . $style . ' onclick="return false;"></td>';
                    $tabel1 .= '<td class="text-left">' . $row->qty . '</td>';
                    $tabel1 .= '<td class="text-left">' . $row->code_cur . '</td>';
                    $tabel1 .= '<td class="text-right">' . number_format($row->cost_val, 2, ',', '.') . '</td>';
                    $tabel1 .= '<td class="text-right">' . number_format(($row->qty * $row->cost_val), 2, ',', '.') . '</td>';
                    $tabel1 .= '<td class="text-right">' . number_format($row->rate, 2, ',', '.') . '</td>';
                    $tabel1 .= '<td class="text-right">' . number_format($row->vat, 2, ',', '.') . '</td>';
                    $tabel1 .= '<td class="text-right">' . number_format($amount, 2, ',', '.') . '</td>';
                    $tabel1 .= '<td class="text-left"></td>';
                    $tabel1 .= '</tr>';
                    $no++;

                    $totalAmount    += $amount;
                    $totalAmount2   += $amount2;
                }
            }

            if(isset($request->chrg_dtl_id)){
                $data   = BookingModel::getChargesDetailUsingInId($chrg_dtl_id);
                foreach ($data as $row) {
                    if ($row->reimburse_flag == 1) {
                        $style = 'checked';
                    } else {
                        $style = '';
                    }

                    $total = ($row->qty * $row->cost_val);
                    $total2 = ($row->qty * $row->sell_val);
                    $amount = ($total * $row->rate) + $row->vat;
                    $amount2 = ($total2 * $row->rate) + $row->vat;

                    // Sell
                    $tabel1 .= '<tr>';
                    $tabel1 .= '<td>';
                    $tabel1 .= ($no);
                    $tabel1 .= '<input type="hidden" name="cek_cost_chrg[]" value="'.$row->id.'" />';
                    $tabel1 .= '<input type="hidden" name="cek_bill_to[]" value="'.$row->bill_to_id.'" />';
                    $tabel1 .= '</td>';
                    $tabel1 .= '<td class="text-left">' . $row->charge_name . '</td>';
                    $tabel1 .= '<td class="text-left">' . $row->desc . ' | Routing: ' . $row->routing . ' | Transit time : ' . $row->transit_time . '</td>';
                    $tabel1 .= '<td class="text-center"><input type="checkbox" name="reimburs" style="width:50px;" id="reimburs_' . $no . '" ' . $style . ' onclick="return false;"></td>';
                    $tabel1 .= '<td class="text-left">' . $row->qty . '</td>';
                    $tabel1 .= '<td class="text-left">' . $row->code_cur . '</td>';
                    $tabel1 .= '<td class="text-right">' . number_format($row->cost_val, 2, ',', '.') . '</td>';
                    $tabel1 .= '<td class="text-right">' . number_format(($row->qty * $row->cost_val), 2, ',', '.') . '</td>';
                    $tabel1 .= '<td class="text-right">' . number_format($row->rate, 2, ',', '.') . '</td>';
                    $tabel1 .= '<td class="text-right">' . number_format($row->vat, 2, ',', '.') . '</td>';
                    $tabel1 .= '<td class="text-right">' . number_format($amount2, 2, ',', '.') . '</td>';
                    $tabel1 .= '<td class="text-left"></td>';
                    $tabel1 .= '</tr>';
                    $no++;

                    $totalAmount    += $amount;
                    $totalAmount2   += $amount2;
                }

                $tabel1 .= '<tr>';
                $tabel1 .= '<td colspan="10" class="text-right">Total</td>';
                $tabel1 .= '<td class="text-right">' . number_format($totalAmount2, 2, ',', '.') . '</td>';
                $tabel1 .= '<td colspan="1"></td>';
                $tabel1 .= '</tr>';

            }
        }

        header('Content-Type: application/json');
        echo json_encode([$tabel1, $tabel2]);
    }

    public function save(Request $request)
    {
        $rules = [
            'client_id' => 'required',
            'invoice_no' => 'required|unique:t_invoice',
            'invoice_date' => 'required',
            'currency' => 'required',
            // 'pol_id' => 'required',
            // 'pod_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->with('errorForm', $validator->errors()->messages());
        }

        try {
            DB::beginTransaction();

            $total_before_vat = 0;
            $total_vat = 0;
            $total_invoice = 0;

            $param = $request->all();
            $param['invoice_date'] = date('Y-m-d', strtotime($request->invoice_date));
            $param['onboard_date'] = date('Y-m-d', strtotime($request->onboard_date));
            $param['reimburse_flag'] = (($request->invoice_type == 'REM') ? 1 : 0);
            $param['debit_note_flag'] = (($request->invoice_type == 'DN') ? 1 : 0);
            $param['credit_note_flag'] = (($request->invoice_type == 'CN') ? 1 : 0);
            $param['rate'] = 1;
            $param['created_by'] = Auth::user()->name;
            $param['created_on'] = date('Y-m-d h:i:s');

            $invoice = InvoiceModel::saveInvoice($param);
            // dd($invoice);
            $paramDetail['id'] = '';
            $paramDetail['invoice_id'] = $invoice->id;
            // if (isset($request->cek_sell_shp)) {
            //     foreach ($request->cek_sell_shp as $key => $shp_dtl_id) {
            //         $shp_dtl   = QuotationModel::get_quoteShippingById($shp_dtl_id);
            //         $paramDetail['desc'] = $shp_dtl->notes.' | Routing: '.$shp_dtl->routing.' | Transit time : '.$shp_dtl->transit_time;
            //         $paramDetail['currency'] = $request->currency;
            //         $paramDetail['reimburse_flag'] = (($request->invoice_type == 'REM') ? 1 : 0);
            //         $paramDetail['rate'] = 1;
            //         $paramDetail['cost'] = $shp_dtl->cost;
            //         $paramDetail['sell'] = $shp_dtl->sell;
            //         $paramDetail['qty'] = $shp_dtl->qty;
            //         $paramDetail['cost_val'] = $shp_dtl->cost_val;
            //         $paramDetail['sell_val'] = $shp_dtl->sell_val;
            //         $paramDetail['subtotal'] = $shp_dtl->subtotal;
            //         $paramDetail['created_by'] = Auth::user()->name;
            //         $paramDetail['created_on'] = date('Y-m-d h:i:s');

            //         InvoiceDetailModel::saveInvoiceDetail($paramDetail);

            //         $shpDtlParam['id'] = $shp_dtl_id;
            //         $shpDtlParam['t_invoice_id'] = $invoice->id;
            //         $shpDtlParam['invoice_type'] = $request->invoice_type;
            //         $shpDtlParam['created_by'] = Auth::user()->name;
            //         $shpDtlParam['created_on'] = date('Y-m-d h:i:s');
            //         QuotationModel::saveShipDetail($shpDtlParam);
            //     }
            // }

            if (isset($request->cek_sell_chrg)) {
                foreach ($request->cek_sell_chrg as $key => $chrg_dtl_id) {
                    $chrg_dtl       = BookingModel::getChargesDetailById($chrg_dtl_id);
                    $paramDetail['t_mcharge_code_id'] = $chrg_dtl->t_mcharge_code_id;
                    $paramDetail['desc'] = $chrg_dtl->desc;
                    $paramDetail['currency'] = $request->currency;
                    $paramDetail['reimburse_flag'] = (($request->invoice_type == 'REM') ? 1 : 0);
                    $paramDetail['rate'] = 1;
                    $paramDetail['cost'] = $chrg_dtl->cost;
                    $paramDetail['sell'] = $chrg_dtl->sell;
                    $paramDetail['qty'] = $chrg_dtl->qty;
                    $paramDetail['cost_val'] = $chrg_dtl->cost_val;
                    $paramDetail['sell_val'] = $chrg_dtl->sell_val;
                    $paramDetail['vat'] = $chrg_dtl->vat;
                    $paramDetail['subtotal'] = $chrg_dtl->subtotal;
                    $paramDetail['routing'] = $chrg_dtl->routing;
                    $paramDetail['transit_time'] = $chrg_dtl->transit_time;
                    $paramDetail['created_by'] = Auth::user()->name;
                    $paramDetail['created_on'] = date('Y-m-d h:i:s');

                    InvoiceDetailModel::saveInvoiceDetail($paramDetail);

                    $chrgDtlParam['id'] = $chrg_dtl_id;
                    $chrgDtlParam['t_invoice_id'] = $invoice->id;
                    $chrgDtlParam['invoice_type'] = $request->invoice_type;
                    $chrgDtlParam['created_by'] = Auth::user()->name;
                    $chrgDtlParam['created_on'] = date('Y-m-d h:i:s');
                    QuotationModel::saveChargeDetail($chrgDtlParam);

                    $total_before_vat += $chrg_dtl->sell_val;
                    $total_vat += $chrg_dtl->vat;
                    $total_invoice += $chrg_dtl->subtotal;
                }
            }

            DB::table('t_invoice')->where('id', $invoice->id)->update([
                'total_before_vat' => $total_before_vat,
                'total_vat' => $total_vat,
                'total_invoice' => $total_invoice,
            ]);
            DB::commit();
            return redirect()->route('booking.edit', ['id' => $request->t_booking_id])->with('success', 'Invoice Created!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function save_cost(Request $request)
    {
        $rules = [
            'client_id' => 'required',
            'invoice_no' => 'required|unique:t_invoice',
            'invoice_date' => 'required',
            'currency' => 'required',
            'pol_id' => 'required',
            'pod_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            // $errorMsg = '';
            // foreach ($validator->errors()->messages() as $err) {
            //     foreach ($err as $msg) {
            //         $errorMsg .= $msg . "<br>";
            //     }
            // }
            // $previousUrl = parse_url(app('url')->previous());

            // $errorParam = [
            //     'error' => '1',
            //     'errorMsg' => $errorMsg,
            //     '_token' => $request->_token,
            //     't_booking_id' => $request->t_booking_id,
            //     'cek_paid_to' => $request->cek_paid_to,
            // ];

            // if (isset($request->cek_cost_shp)) $errorParam['cek_cost_shp'] = $request->cek_cost_shp;
            // if (isset($request->cek_cost_chrg)) $errorParam['cek_cost_chrg'] = $request->cek_cost_chrg;
            // $url = $previousUrl['path'] . '?' . http_build_query($errorParam);

            // return redirect()->to($previousUrl);
            return redirect()->back()->with('errorForm', $validator->errors()->messages());
        }

        try {
            DB::beginTransaction();

            $param = $request->all();

            DB::table('t_booking')->where('id',$request->t_booking_id)->update([
                'flag_invoice' => 1
            ]);

            $invoice_id = DB::table('t_invoice')->insertGetId([
                    'tipe_inv' => 1,
                    // 't_proforma_invoice_id' => 0,
                    't_booking_id'=> $request->t_booking_id,
                    'activity' => $request->activity,
                    'client_id' => $request->client_id,
                    'client_addr_id' => $request->client_addr_id,
                    'client_pic_id' => $request->client_pic_id,
                    'invoice_no' => $request->invoice_no,
                    'invoice_date' => date('Y-m-d', strtotime($request->invoice_date)),
                    'onboard_date' => date('Y-m-d', strtotime($request->onboard_date)),
                    'reimburse_flag' => (($request->invoice_type == 'REM') ? 1 : 0),
                    'debit_note_flag' => (($request->invoice_type == 'DN') ? 1 : 0),
                    'credit_note_flag' => (($request->invoice_type == 'CN') ? 1 : 0),
                    'top' => $request->top,
                    'currency' => $request->currency,
                    'mbl_shipper' => $request->mbl_shipper,
                    'hbl_shipper' => $request->hbl_shipper,
                    'vessel' => $request->vessel,
                    'm_vessel' => $request->m_vessel,
                    'pol_id' => $request->pol_id,
                    'pod_id' => $request->pod_id,
                    'onboard_date' => $request->onboard_date,
                    'rate' => 1,
                    'created_by' => Auth::user()->name,
                    'created_on' => date('Y-m-d h:i:s')
                ]
            );

            $pno = 0;
            $total_before_vat = 0;
            $total_vat = 0;
            $total_sub = 0;
            // if (isset($request->cek_cost_shp)) {
            //     foreach ($request->cek_cost_shp as $key => $shp_dtl_id) {
            //         $shp_dtl   = QuotationModel::get_quoteShippingById($shp_dtl_id);
            //         $sub_total = ($shp_dtl->qty * $shp_dtl->sell_val)+$shp_dtl->vat;
            //         DB::table('t_invoice_detail')->insert([
            //                 'invoice_id'     => $invoice_id,
            //                 'position_no'    => $pno++,//Position
            //                 'desc'           => $shp_dtl->notes.' | Routing: '.$shp_dtl->routing.' | Transit time : '.$shp_dtl->transit_time,
            //                 'reimburse_flag' => $shp_dtl->reimburse_flag,
            //                 'currency'       => $request->currency,
            //                 'rate'           => $shp_dtl->rate,
            //                 'cost'           => $shp_dtl->cost,
            //                 'sell'           => $shp_dtl->sell,
            //                 'qty'            => $shp_dtl->qty,
            //                 'cost_val'       => $shp_dtl->cost_val,
            //                 'sell_val'       => $shp_dtl->sell_val,
            //                 'vat'            => $shp_dtl->vat,
            //                 'subtotal'       => $sub_total,
            //                 'created_by'     => Auth::user()->name,
            //                 'created_on'     => date('Y-m-d h:i:s')
            //             ]
            //         );

            //         $shpDtlParam['id'] = $shp_dtl_id;
            //         $shpDtlParam['t_invoice_cost_id'] = $invoice_id;
            //         // $shpDtlParam['invoice_type'] = $request->invoice_type;
            //         $shpDtlParam['created_by'] = Auth::user()->name;
            //         $shpDtlParam['created_on'] = date('Y-m-d h:i:s');
            //         QuotationModel::saveShipDetail($shpDtlParam);
            //         $total_sub += $sub_total;
            //     }
            // }

            if (isset($request->cek_cost_chrg)) {
                foreach ($request->cek_cost_chrg as $key => $chrg_dtl_id) {
                    $chrg_dtl = BookingModel::getChargesDetailById($chrg_dtl_id);
                    $sub_total = ($chrg_dtl->qty * $chrg_dtl->sell_val)+$chrg_dtl->vat;
                    DB::table('t_invoice_detail')->insert([
                            'invoice_id'     => $invoice_id,
                            't_mcharge_code_id' => $chrg_dtl->t_mcharge_code_id,
                            'position_no'    => $pno++,//Position
                            'desc'           => $chrg_dtl->desc,
                            'reimburse_flag' => $chrg_dtl->reimburse_flag,
                            'currency'       => $request->currency,
                            'rate'           => $chrg_dtl->rate,
                            'cost'           => $chrg_dtl->cost,
                            'sell'           => $chrg_dtl->sell,
                            'qty'            => $chrg_dtl->qty,
                            'cost_val'       => $chrg_dtl->cost_val,
                            'sell_val'       => $chrg_dtl->sell_val,
                            'vat'            => $chrg_dtl->vat,
                            'subtotal'       => $sub_total,
                            'routing'        => $chrg_dtl->routing,
                            'transit_time'   => $chrg_dtl->transit_time,
                            'created_by'     => Auth::user()->name,
                            'created_on'     => date('Y-m-d h:i:s')
                        ]
                    );

                    $chrgDtlParam['id'] = $chrg_dtl_id;
                    $chrgDtlParam['t_invoice_cost_id'] = $invoice_id;
                    // $chrgDtlParam['invoice_type'] = $request->invoice_type;
                    $chrgDtlParam['created_by'] = Auth::user()->name;
                    $chrgDtlParam['created_on'] = date('Y-m-d h:i:s');
                    QuotationModel::saveChargeDetail($chrgDtlParam);
                    $total_before_vat += $chrg_dtl->sell_val;
                    $total_vat += $chrg_dtl->vat;
                    $total_sub += $sub_total;
                }
            }

            DB::table('t_invoice')->where('id', $invoice_id)->update([
                'total_before_vat' => $total_before_vat,
                'total_vat' => $total_vat,
                'total_invoice' => $total_sub
            ]);
            DB::commit();
            return redirect()->route('invoice.index')->with('success', 'Saved!');
        } catch (\Throwable $th) {
            DB::rollBack();
            // $errorMsg = $th->getMessage();
            // print_r($errorMsg);die();
            // $previousUrl = parse_url(app('url')->previous());

            // $errorParam = [
            //     'error' => '1',
            //     'errorMsg' => $errorMsg,
            //     '_token' => $request->_token,
            //     't_booking_id' => $request->t_booking_id,
            //     'cek_paid_to' => $request->cek_paid_to,
            // ];

            // if (isset($request->cek_cost_shp)) $errorParam['cek_cost_shp'] = $request->cek_cost_shp;
            // if (isset($request->cek_cost_chrg)) $errorParam['cek_cost_chrg'] = $request->cek_cost_chrg;
            // $url = $previousUrl['path'] . '?' . http_build_query($errorParam);

            // return redirect()->to($url);
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function view($id)
    {
        $data['header'] = InvoiceModel::getInvoice($id)->first();
        $data['details'] = InvoiceDetailModel::getInvoiceDetails($id)->get();
        $data['companies'] = MasterModel::company_data();
        $data['addresses'] = MasterModel::get_address($data['header']->client_id);
        $data['pics'] = MasterModel::get_pic($data['header']->client_id);
        $data['currency']       = MasterModel::currency();
        $data['containers'] = BookingModel::get_container($data['header']->t_booking_id);
        $data['goods'] = BookingModel::get_commodity($data['header']->t_booking_id);

        return view('invoice.view_invoice')->with($data);
    }
}
