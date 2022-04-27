<?php

namespace App\Http\Controllers;

use App\BookingModel;
use App\InvoiceDetailModel;
use App\InvoiceModel;
use App\MasterModel;
use App\QuotationModel;
use App\Tax;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $tipe = $request->segment(4);
        if ($tipe == 'piutang') {
            $invoices = InvoiceModel::getInvoiceByType(0)->get();
        } else if ($tipe == 'hutang') {
            $invoices = InvoiceModel::getInvoiceByType(1)->get();
        } else {
            $invoices = InvoiceModel::getAllInvoice()->get();
        }
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

                    return redirect()->back()->with('error', 'Please fill Bill To field');
                    // return redirect()->to($previousUrl['path'] . '?' . http_build_query(['error' => '1', 'errorMsg' => 'Please fill Bill To field']));
                } else if (($key > 0) && $bill_to != $request->cek_bill_to[$key - 1]) {
                    // cek kalau bill to antara row 1 dengan row sebelumnya berbeda
                    $previousUrl = parse_url(app('url')->previous());
                    // return redirect()->to($previousUrl['path'] . '?' . http_build_query(['error' => '1', 'errorMsg' => 'Bill to not match']));
                    return redirect()->back()->with('error', 'Bill to not match');
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

        $is_reimburse = 0;
        $no=0;
        if (isset($request->cek_sell_chrg)) {
            foreach ($request->cek_sell_chrg as $key => $chrg_dtl_id) {
                $data['chrg_dtl_id'][$key] = $chrg_dtl_id;
                $cek = DB::table('t_bcharges_dtl')->where('id', $chrg_dtl_id)->first();
                $is_reimburse += $cek->reimburse_flag;
            }
        }
        if($is_reimburse==0 || $is_reimburse==$no){
            $data['bill_to_id'] = $request->cek_bill_to[0];
            $data['booking'] = BookingModel::getDetailBooking($request->t_booking_id);
            $data['reimburse'] = null;
            $data['companies'] = MasterModel::company_get($request->cek_bill_to[0]);
            $data['addresses'] = MasterModel::get_address($request->cek_bill_to[0]);
            $data['pics'] = MasterModel::get_pic($request->cek_bill_to[0]);
            $data['currency'] = MasterModel::currency();
            $data['containers'] = BookingModel::get_container($request->t_booking_id);
            $data['goods'] = BookingModel::get_commodity($request->t_booking_id);
            $data['list_invoice'] = InvoiceModel::list_invoice_booking($request->t_booking_id, 0, $request->cek_bill_to[0]);
            $data['tipe_inv'] = 'sell';
            $data['taxes'] = Tax::all();
            $data['is_reimburse'] = $is_reimburse;
            return view('invoice.add_invoice')->with($data);
        }else{
            return redirect()->back()->with('error', 'Detail tidak bisa gabungan dari reimburse dan non reimburse');
        }
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
        // if ($validator->fails()) {
        //     $errorMsg = '';
        //     foreach ($validator->errors()->messages() as $err) {
        //         foreach ($err as $msg) {
        //             $errorMsg .= $msg . "<br>";
        //         }
        //     }
        //     $previousUrl = parse_url(app('url')->previous());

        //     return redirect()->to($previousUrl['path'] . '?' . http_build_query(['error' => '1', 'errorMsg' => $errorMsg]));
        // }

        if (isset($request->cek_paid_to)) {
            foreach ($request->cek_paid_to as $key => $paid_to) {
                if ($paid_to == '' || $paid_to == null) {
                    // cek kalau bill to pada tabel sell kosong
                    $previousUrl = parse_url(app('url')->previous());

                    return redirect()->back()->with('error', 'Please fill Bill To field');
                    // return redirect()->to($previousUrl['path'] . '?' . http_build_query(['error' => '1', 'errorMsg' => 'Please fill Bill To field']));
                } else if (($key > 0) && $paid_to != $request->cek_paid_to[$key - 1]) {
                    // cek kalau bill to antara row 1 dengan row sebelumnya berbeda
                    $previousUrl = parse_url(app('url')->previous());
                    // return redirect()->to($previousUrl['path'] . '?' . http_build_query(['error' => '1', 'errorMsg' => 'Bill to not match']));
                    return redirect()->back()->with('error', 'Bill to not match');
                }
            }
        }

        // $data['shipping_dtl_id'] = [];
        $data['chrg_dtl_id'] = [];

        // if (isset($request->cek_cost_shp)) {
        //     foreach ($request->cek_cost_shp as $key => $shp_dtl_id) {
        //         $data['shipping_dtl_id'][$key] = $shp_dtl_id;
        //     }
        // }

        $is_reimburse = 0;
        $no=0;
        if (isset($request->cek_cost_chrg)) {
            foreach ($request->cek_cost_chrg as $key => $chrg_dtl_id) {
                $no++;
                $data['chrg_dtl_id'][$key] = $chrg_dtl_id;
                //check apakah reimburse gabung sama non reimburse
                $cek = DB::table('t_bcharges_dtl')->where('id', $chrg_dtl_id)->first();
                $is_reimburse += $cek->reimburse_flag;
            }
        }
        if($is_reimburse==0 || $is_reimburse==$no){
            $data['paid_to_id'] = $request->cek_paid_to[0];
            $data['booking'] = BookingModel::getDetailBooking($request->t_booking_id);
            $data['companies'] = MasterModel::company_get($request->cek_paid_to[0]);
            $data['addresses'] = MasterModel::get_address($request->cek_paid_to[0]);
            $data['pics'] = MasterModel::get_pic($request->cek_paid_to[0]);
            $data['currency'] = MasterModel::currency();
            $data['containers'] = BookingModel::get_container($request->t_booking_id);
            $data['goods'] = BookingModel::get_commodity($request->t_booking_id);
            $data['list_invoice'] = InvoiceModel::list_invoice_booking($request->t_booking_id, 1, $request->cek_paid_to[0]);
            $data['tipe_inv'] = 'cost';
            $data['taxes'] = Tax::all();
            $data['is_reimburse'] = $is_reimburse;
            return view('invoice.add_invoice_cost')->with($data);
        }else{
            return redirect()->back()->with('error', 'Detail tidak bisa gabungan dari reimburse dan non reimburse');
        }
    }

    public function loadSellCost(Request $request)
    {
        $shp_dtl_id = [];
        $chrg_dtl_id = [];
        $taxes = Tax::all();

        // if (isset($request->shipping_dtl_id)) $shp_dtl_id = $request->shipping_dtl_id;
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
        $total_cost     = 0;
        $total_sell     = 0;
        $totalAmount    = 0;
        $totalAmount2   = 0;

        // $data       = BookingModel::getChargesDetail($request->id);
        if ($request->tipe_inv == 'sell') {
            if (isset($request->shipping_dtl_id)) {
                $data   = QuotationModel::get_quoteShippingInId($shp_dtl_id);
                foreach ($data as $row) {
                    // if ($row->reimburse_flag == 1) {
                    //     $style = 'checked';
                    // } else {
                    //     $style = '';
                    // }
                    $style = '';

                    $total = ($row->qty * $row->cost);
                    $total2 = ($row->qty * $row->sell);
                    // $amount = ($total * $row->rate) + $row->vat;
                    $amount = ($total * $row->rate);
                    // $amount2 = ($total2 * $row->rate) + $row->vat;
                    $amount2 = ($total2 * $row->rate);

                    // Sell
                    $tabel1 .= '<tr>';
                    $tabel1 .= '<td>';
                    $tabel1 .= ($no);
                    $tabel1 .= '<input type="hidden" name="cek_sell_shp[]" value="' . $row->id . '" />';
                    $tabel1 .= '<input type="hidden" name="cek_bill_to[]" value="' . $booking->client_id . '" />';
                    $tabel1 .= '</td>';
                    if ($quote->shipment_by == 'LAND') {
                        $tabel1 .= '<td>' . $row->truck_size . ($request->invoice_type == 'REM' ? ' (Reimburse)' : '') . '</td>';
                    } else {
                        $tabel1 .= '<td>' . $row->name_carrier . ($request->invoice_type == 'REM' ? ' (Reimburse)' : '') . '</td>';
                    }
                    $tabel1 .= '<td class="text-left">' . $row->notes . ' | Routing: ' . $row->routing . ' | Transit time : ' . $row->transit_time . '</td>';
                    $tabel1 .= '<td class="text-center"><input type="checkbox" name="reimburs" style="width:50px;" id="reimburs_' . $no . '" ' . $style . ' onclick="return false;" ' . ($request->invoice_type == 'REM' ? 'checked' : '') . '></td>';
                    $tabel1 .= '<td class="text-left">' . $row->qty . '</td>';
                    $tabel1 .= '<td class="text-left">' . $row->code_currency . '</td>';
                    $tabel1 .= '<td class="text-right">' . number_format($row->sell, 2, '.', ',') . '</td>';
                    $tabel1 .= '<td class="text-right">' . number_format($total, 2, '.', ',') . '</td>';
                    $tabel1 .= '<td class="text-right">' . number_format($row->rate, 2, '.', ',') . '</td>';
                    // $tabel1 .= '<td class="text-right">' . number_format($row->vat, 2, '.', ',') . '</td>';
                    $tabel1 .= '<td class="text-right">' . number_format($amount, 2, '.', ',') . '</td>';
                    $tabel1 .= '<td class="text-left"></td>';
                    $tabel1 .= '</tr>';
                    $no++;

                    $total_cost     += $total;
                    $totalAmount    += $amount;
                    $totalAmount2   += $amount2;
                }
            }

            if (isset($request->chrg_dtl_id)) {
                $data   = BookingModel::getChargesDetailUsingInId($chrg_dtl_id);
                foreach ($data as $row) {
                    if ($row->reimburse_flag == 1) {
                        $style = 'checked';
                    } else {
                        $style = '';
                    }

                    $total = ($row->qty * $row->cost);
                    $total2 = ($row->qty * $row->sell);
                    // $amount = ($total * $row->rate) + $row->vat;
                    $amount = ($total * $row->rate);
                    // $amount2 = ($total2 * $row->rate) + $row->vat;
                    $amount2 = ($total2 * $row->rate);

                    $tabel1 .= '<tr>';
                    $tabel1 .= '<td>';
                    $tabel1 .= ($no);
                    $tabel1 .= '<input type="hidden" name="cek_sell_chrg[]" value="' . $row->id . '" />';
                    $tabel1 .= '<input type="hidden" name="cek_bill_to[]" value="' . $row->bill_to_id . '" />';
                    $tabel1 .= '</td>';
                    $tabel1 .= '<td class="text-left">' . $row->charge_name . ($request->invoice_type == 'REM' ? ' (Reimburse)' : '') . '</td>';
                    $tabel1 .= '<td class="text-left">' . $row->desc . ' | Routing: ' . $row->routing . ' | Transit time : ' . $row->transit_time . '</td>';
                    $tabel1 .= '<td class="text-center"><input type="checkbox" name="reimburs" style="width:50px;" id="reimburs_' . $no . '" ' . $style . ' onclick="return false;" ' . ($request->invoice_type == 'REM' ? 'checked' : '') . '></td>';
                    $tabel1 .= '<td class="text-left">' . $row->qty . '</td>';
                    $tabel1 .= '<td class="text-left">' . $row->code_cur . '</td>';
                    $tabel1 .= '<td class="text-right">' . number_format($row->sell, 2, '.', ',') . '</td>';
                    $tabel1 .= '<td class="text-right">' . number_format($total2, 2, '.', ',') . '</td>';
                    $tabel1 .= '<td class="text-right">' . number_format($row->rate, 2, '.', ',') . '</td>';
                    // $tabel1 .= '<td class="text-right">' . number_format($row->vat, 2, '.', ',') . '</td>';
                    $tabel1 .= '<td class="text-right">' . number_format($amount2, 2, '.', ',') . '</td>';
                    $tabel1 .= '<td class="text-left"></td>';
                    $tabel1 .= '</tr>';
                    $no++;

                    $total_sell     += $total2;
                    $totalAmount    += $amount;
                    $totalAmount2   += $amount2;
                }

                // $tabel1 .= '<tr>';
                // $tabel1 .= '<td colspan="10" class="text-right">Total</td>';
                // $tabel1 .= '<td class="text-right">' . number_format($totalAmount2, 2, '.', ',') . '</td>';
                // $tabel1 .= '<td colspan="1"></td>';
                // $tabel1 .= '</tr>';
            }
            $tabel1 .= "<tr id='row_subtotal'>";
            $tabel1 .= "<td colspan='7' class='text-right'><span id='lbl_subtotal'>Subtotal</span></td>";
            $tabel1 .= "<td class='text-right'>";
            $tabel1 .= "<input type='text' class='form-control' name='total_before_roe' id='total_before_roe' value='" . number_format($total_sell, 2, '.', ',') . "' readonly/>";
            $tabel1 .= "</td>";
            $tabel1 .= "<td class='text-right'></td>";
            $tabel1 .= "<td class='text-right'>";
            $tabel1 .= "<input type='text' class='form-control' name='total_before_vat' id='total_before_vat' value='" . number_format($totalAmount2, 2, '.', ',') . "' readonly/>";
            $tabel1 .= "</td>";
            $tabel1 .= "<td colspan='1'></td>";
            $tabel1 .= "</tr>";
            $tabel1 .= "<tr id='row_ppn' style='display: none;'>";
            $tabel1 .= "<td colspan='9' class='text-right'><span id='lbl_ppn'></span></td>";
            $tabel1 .= "<td class='text-right'>";
            $tabel1 .= "<input type='hidden' class='form-control' name='value_ppn' id='value_ppn' value='0.00' readonly/>";
            $tabel1 .= "<input type='text' class='form-control' name='input_ppn' id='input_ppn' value='0.00' readonly/>";
            $tabel1 .= "</td>";
            $tabel1 .= "<td colspan='1'></td>";
            $tabel1 .= "</tr>";
            $tabel1 .= "<tr id='row_pph23' style='display: none;'>";
            $tabel1 .= "<td colspan='9' class='text-right'><span id='lbl_pph23'></span></td>";
            $tabel1 .= "<td class='text-right'>";
            $tabel1 .= "<input type='hidden' class='form-control' name='value_pph23' id='value_pph23' value='0.00' readonly/>";
            $tabel1 .= "<input type='text' class='form-control' name='input_pph23' id='input_pph23' value='0.00' readonly/>";
            $tabel1 .= "</td>";
            $tabel1 .= "<td colspan='1'></td>";
            $tabel1 .= "</tr>";
            $tabel1 .= '<tr>';
            $tabel1 .= '<td colspan="9" class="text-right">Total</td>';
            $tabel1 .= '<td class="text-right">';
            $tabel1 .= '<input type="text" class="form-control" name="total_invoice" id="total_invoice" value="' . number_format($totalAmount2, 2, '.', ',') . '" readonly/>';
            $tabel1 .= '</td>';
            $tabel1 .= '<td colspan="1"></td>';
            $tabel1 .= '</tr>';
        } else {
            if (isset($request->chrg_dtl_id)) {
                $total_cost_adjustment = 0;
                $data   = BookingModel::getChargesDetailUsingInId($chrg_dtl_id);
                foreach ($data as $row) {
                    if ($row->reimburse_flag == 1) {
                        $style = 'checked';
                    } else {
                        $style = '';
                    }

                    $total = ($row->qty * $row->cost);
                    $total2 = ($row->qty * $row->sell);
                    // $amount = ($total * $row->rate) + $row->vat;
                    $amount = ($total * $row->rate)+$row->cost_adjustment;
                    // $amount2 = ($total2 * $row->rate) + $row->vat;
                    $amount2 = ($total2 * $row->rate);

                    // Sell
                    $tabel1 .= '<tr>';
                    $tabel1 .= '<td>';
                    $tabel1 .= ($no);
                    $tabel1 .= '<input type="hidden" name="cek_cost_chrg['.$no.'][id]" value="' . $row->id . '" />';
                    $tabel1 .= '<input type="hidden" name="cek_bill_to[]" value="' . $row->bill_to_id . '" />';
                    $tabel1 .= '</td>';
                    $tabel1 .= '<td class="text-left">' . $row->charge_name . ($request->invoice_type == 'REM' ? ' (Reimburse)' : '') . '</td>';
                    $tabel1 .= '<td class="text-left">' . $row->desc . ' | Routing: ' . $row->routing . ' | Transit time : ' . $row->transit_time . '</td>';
                    $tabel1 .= '<td class="text-center"><input type="checkbox" name="reimburs" style="width:50px;" id="reimburs_' . $no . '" ' . $style . ' onclick="return false;" ' . ($request->invoice_type == 'REM' ? 'checked' : '') . '></td>';
                    $tabel1 .= '<td class="text-left">' . $row->qty . '</td>';
                    $tabel1 .= '<td class="text-left">' . $row->code_cur . '</td>';
                    $tabel1 .= '<td class="text-right">' . number_format($row->cost, 2, '.', ',') . '</td>';
                    $tabel1 .= '<td class="text-right">' . number_format(($row->qty * $row->cost), 2, '.', ',') . '</td>';
                    $tabel1 .= '<td class="text-right">' . number_format($row->rate, 2, '.', ',') . '</td>';
                    // $tabel1 .= '<td class="text-right">' . number_format($row->vat, 2, '.', ',') . '</td>';
                    $tabel1 .= '<td class="text-right">' . number_format($row->cost_adjustment, 2, '.', ',') . '</td>';
                    $tabel1 .= '<td class="text-right">' . number_format($amount, 2, '.', ',') . '</td>';
                    foreach ($taxes as $tax){
                        $taxvalue[$tax->code] = $amount * $tax->value/100;
                        $tabel1 .= '<td><label id="lbl_'.$tax->code.$no.'" style="display:none;">'.number_format($taxvalue[$tax->code],2,',','.').'</label><br>
                                     <input type="checkbox" name="cek_cost_chrg['.$no.']['.$tax->code.']" class="'.$tax->code.'" id="btn_'.$tax->code.$no.'" onchange="checkedTaxDetail(\''.$tax->code.'\','.$no.',\''.$tax->name.'\','.$tax->value.')" value="'.$taxvalue[$tax->code].'" /></td>';
                    }
                    $tabel1 .= '<td class="text-left"></td>';
                    $tabel1 .= '</tr>';
                    $no++;

                    $total_cost_adjustment += $row->cost_adjustment;
                    $totalAmount    += $amount;
                    $totalAmount2   += $amount2;
                }

                // $tabel1 .= '<tr>';
                // $tabel1 .= '<td colspan="10" class="text-right">Total</td>';
                // $tabel1 .= '<td class="text-right">' . number_format($totalAmount2, 2, '.', ',') . '</td>';
                // $tabel1 .= '<td colspan="1"></td>';
                // $tabel1 .= '</tr>';
            }
            $tabel1 .= "<tr id='row_subtotal'>";
                $tabel1 .= "<td colspan='10' class='text-right'><span id='lbl_subtotal'>Subtotal</span></td>";
                $tabel1 .= "<td class='text-right'>";
                $tabel1 .= number_format($totalAmount, 2, '.', ',');
                $tabel1 .= "<input type='hidden' class='form-control' name='total_before_vat' id='total_before_vat' value='" . number_format($totalAmount, 2, '.', ',') . "' readonly/>";
                $tabel1 .= "</td>";
                $tabel1 .= "<td colspan='4'></td>";
            $tabel1 .= "</tr>";
            foreach ($taxes as $tax){
                $tabel1 .= "<tr id='row_".$tax->code."' style='display: none;'>";
                    $tabel1 .= "<td colspan='10' class='text-right'><span id='lbl_total_".$tax->code."'></span></td>";
                    $tabel1 .= "<td class='text-right'>";
                    // $tabel1 .= "<input type='hidden' class='form-control' name='value_".$tax->code."' id='value_".$tax->code."' value='0.00' readonly/>";
                    $tabel1 .= "<input type='text' class='form-control' name='input_".$tax->code."' id='input_".$tax->code."' value='0.00' readonly/>";
                    $tabel1 .= "</td>";
                    $tabel1 .= "<td colspan='4'></td>";
                $tabel1 .= "</tr>";
            }
            $tabel1 .= '<tr>';
                $tabel1 .= '<td colspan="10" class="text-right">Total</td>';
                $tabel1 .= '<td class="text-right">';
                $tabel1 .= '<input type="hidden" class="form-control" name="total_cost_adjustment" id="total_cost_adjustment" value="'.$total_cost_adjustment.'" readonly/>';
                $tabel1 .= '<label class="total_invoice">'.number_format($totalAmount, 2, '.', ',').'</label>';
                $tabel1 .= '<input type="hidden" class="form-control total_invoice" name="total_invoice" value="' . number_format($totalAmount, 2, '.', ',') . '" readonly/>';
                $tabel1 .= '</td>';
                $tabel1 .= '<td colspan="4"></td>';
            $tabel1 .= '</tr>';
        }


        header('Content-Type: application/json');
        echo json_encode([$tabel1, $tabel2]);
    }

    public function save(Request $request)
    {
        if ($request->create_type == 0) {
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

                DB::table('t_booking')->where('id', $request->t_booking_id)->update([
                    'flag_invoice' => 1
                ]);

                $total_before_vat = 0;
                $total_vat = 0;
                $total_invoice = 0;

                $param = $request->all();
                $param['invoice_date'] = Carbon::createFromFormat('d/m/Y', $request->invoice_date)->format('Y-m-d');
                $param['onboard_date'] = Carbon::createFromFormat('d/m/Y', $request->onboard_date)->format('Y-m-d');
                $param['reimburse_flag'] = (($request->invoice_type == 'REM') ? 1 : 0);
                $param['debit_note_flag'] = (($request->invoice_type == 'DN') ? 1 : 0);
                $param['credit_note_flag'] = (($request->invoice_type == 'CN') ? 1 : 0);
                $param['rate'] = 1;
                $param['total_before_vat'] = str_replace(',', '', $request->total_before_vat);
                $param['total_vat'] = str_replace(',', '', $request->input_ppn);
                $param['pph23'] = str_replace(',', '', $request->input_pph23);
                $param['total_invoice'] = (($request->currency=='IDR')? str_replace(',', '', $request->total_invoice):str_replace(',', '', $request->total_before_roe));
                $param['created_by'] = Auth::user()->name;
                $param['created_on'] = date('Y-m-d h:i:s');
                // dd($request->all(), $param);
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
                        $chrg_dtl = BookingModel::getChargesDetailById($chrg_dtl_id);
                        $vat_dtl = 0;
                        $pph23_dtl = 0;
                        $subtotal = 0;
                        if ($request->value_ppn > 0) {
                            $vat_dtl = $chrg_dtl->sell_val * ($request->value_ppn / 100);
                        }

                        if ($request->value_pph23 > 0) {
                            $pph23_dtl = $chrg_dtl->sell_val * ($request->value_pph23 / 100);
                        }

                        if($request->currency=='IDR'){
                            $subtotal = $chrg_dtl->sell_val + $vat_dtl - $pph23_dtl;
                        }else{
                            $subtotal = $chrg_dtl->sell;
                        }
                        $paramDetail['t_bcharges_id'] = $chrg_dtl->id;
                        $paramDetail['t_mcharge_code_id'] = $chrg_dtl->t_mcharge_code_id;
                        $paramDetail['desc'] = $chrg_dtl->desc;
                        $paramDetail['currency'] = $request->currency;
                        $paramDetail['reimburse_flag'] = (($request->invoice_type == 'REM') ? 1 : 0);
                        $paramDetail['rate'] = 1;
                        $paramDetail['cost'] = $chrg_dtl->cost;
                        $paramDetail['sell'] = $chrg_dtl->sell;
                        $paramDetail['qty'] = $chrg_dtl->qty;
                        $paramDetail['cost_val'] = (($request->currency == 'IDR')? $chrg_dtl->cost_val: $chrg_dtl->cost);
                        $paramDetail['sell_val'] = (($request->currency == 'IDR')? $chrg_dtl->sell_val: $chrg_dtl->sell);
                        $paramDetail['vat'] = $vat_dtl;
                        $paramDetail['pph23'] = $pph23_dtl;
                        $paramDetail['subtotal'] = $subtotal;
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

                        // $total_before_vat += $chrg_dtl->sell_val;
                        // $total_vat += $chrg_dtl->vat;
                        // $total_invoice += $chrg_dtl->subtotal;
                    }
                }

                // DB::table('t_invoice')->where('id', $invoice->id)->update([
                //     'total_before_vat' => $total_before_vat,
                //     'total_vat' => $total_vat,
                //     'total_invoice' => $total_invoice,
                // ]);
                DB::commit();
                return redirect()->route('booking.edit', ['id' => $request->t_booking_id])->with('success', 'Invoice Created!');
            } catch (\Throwable $th) {
                DB::rollBack();
                return redirect()->back()->with('error', $th->getMessage());
            }
        } else {
            try {
                DB::beginTransaction();
                $invoice = InvoiceModel::find($request->create_type);

                $reimburse_type = DB::table('t_bcharges_dtl')->where('t_invoice_id', $invoice->id)->first();
                $invoice_detail = DB::table('t_invoice_detail')->where('invoice_id', $invoice->id)->get();
                $paramDetail['id'] = '';
                $paramDetail['invoice_id'] = $invoice->id;

                if (isset($request->cek_sell_chrg)) {
                    $total_before_vat = 0;
                    $total_vat = 0;
                    $pph23 = 0;
                    $total_invoice = 0;

                    foreach ($invoice_detail as $key => $val) {
                        $total_before_vat += $val->sell_val;
                        $total_vat += $val->vat;
                        $pph23 += $val->pph23;
                        $total_invoice += $val->subtotal;
                    }

                    foreach ($request->cek_sell_chrg as $key => $chrg_dtl_id) {
                        $chrg_dtl = BookingModel::getChargesDetailById($chrg_dtl_id);
                        $vat_dtl = 0;
                        $pph23_dtl = 0;
                        $subtotal = 0;
                        if ($request->value_ppn > 0) {
                            $vat_dtl = $chrg_dtl->sell_val * ($request->value_ppn / 100);
                        }

                        if ($request->value_pph23 > 0) {
                            $pph23_dtl = $chrg_dtl->sell_val * ($request->value_pph23 / 100);
                        }
                        $subtotal = $chrg_dtl->sell_val + $vat_dtl - $pph23_dtl;
                        $paramDetail['t_bcharges_id'] = $chrg_dtl->id;
                        $paramDetail['t_mcharge_code_id'] = $chrg_dtl->t_mcharge_code_id;
                        $paramDetail['desc'] = $chrg_dtl->desc;
                        $paramDetail['currency'] = $invoice->currency;
                        $paramDetail['reimburse_flag'] = (($reimburse_type->invoice_type == 'REM') ? 1 : 0);
                        $paramDetail['rate'] = 1;
                        $paramDetail['cost'] = $chrg_dtl->cost;
                        $paramDetail['sell'] = $chrg_dtl->sell;
                        $paramDetail['qty'] = $chrg_dtl->qty;
                        $paramDetail['cost_val'] = $chrg_dtl->cost_val;
                        $paramDetail['sell_val'] = $chrg_dtl->sell_val;
                        $paramDetail['vat'] = $vat_dtl;
                        $paramDetail['pph23'] = $pph23_dtl;
                        $paramDetail['subtotal'] = $subtotal;
                        $paramDetail['routing'] = $chrg_dtl->routing;
                        $paramDetail['transit_time'] = $chrg_dtl->transit_time;
                        $paramDetail['created_by'] = Auth::user()->name;
                        $paramDetail['created_on'] = date('Y-m-d h:i:s');

                        InvoiceDetailModel::saveInvoiceDetail($paramDetail);

                        $chrgDtlParam['id'] = $chrg_dtl_id;
                        $chrgDtlParam['t_invoice_id'] = $invoice->id;
                        $chrgDtlParam['invoice_type'] = $reimburse_type->invoice_type;
                        $chrgDtlParam['created_by'] = Auth::user()->name;
                        $chrgDtlParam['created_on'] = date('Y-m-d h:i:s');
                        QuotationModel::saveChargeDetail($chrgDtlParam);

                        $total_before_vat += $chrg_dtl->sell_val;
                        $total_vat += $vat_dtl;
                        $pph23 += $pph23_dtl;
                        $total_invoice += $subtotal;
                    }
                }

                DB::table('t_invoice')->where('id', $invoice->id)->update([
                    'total_before_vat' => $total_before_vat,
                    'total_vat' => $total_vat,
                    'pph23' => $pph23,
                    'total_invoice' => $total_invoice,
                ]);
                DB::commit();
                return redirect()->route('booking.edit', ['id' => $request->t_booking_id])->with('success', 'Invoice Merged!');
            } catch (\Throwable $th) {
                DB::rollBack();
                return redirect()->back()->with('error', $th->getMessage());
            }
        }
    }

    public function save_cost(Request $request)
    {
        if ($request->create_type == 0) {
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

                DB::table('t_booking')->where('id', $request->t_booking_id)->update([
                    'flag_invoice' => 1
                ]);

                $invoice_id = DB::table('t_invoice')->insertGetId(
                    [
                        'tipe_inv' => 1,
                        // 't_proforma_invoice_id' => 0,
                        't_booking_id' => $request->t_booking_id,
                        'activity' => $request->activity,
                        'client_id' => $request->client_id,
                        'client_addr_id' => $request->client_addr_id,
                        'client_pic_id' => $request->client_pic_id,
                        'invoice_no' => $request->invoice_no,
                        'invoice_date' => Carbon::createFromFormat('d/m/Y', $request->invoice_date)->format('Y-m-d'),
                        'onboard_date' => Carbon::createFromFormat('d/m/Y', $request->onboard_date)->format('Y-m-d'),
                        'reimburse_flag' => (($request->invoice_type == 'REM') ? 1 : 0),
                        'debit_note_flag' => (($request->invoice_type == 'DN') ? 1 : 0),
                        'credit_note_flag' => (($request->invoice_type == 'CN') ? 1 : 0),
                        'top' => $request->top,
                        'currency' => $request->currency,
                        'rate' => $request->kurs,
                        'mbl_shipper' => $request->mbl_shipper,
                        'hbl_shipper' => $request->hbl_shipper,
                        'vessel' => $request->vessel,
                        'm_vessel' => $request->m_vessel,
                        'pol_id' => $request->pol_id,
                        'pod_id' => $request->pod_id,
                        'onboard_date' => $request->onboard_date,
                        'total_before_vat' => str_replace(',', '', $request->total_before_vat),
                        'total_vat' => str_replace(',', '', $request->input_ppn),
                        'pph23' => str_replace(',', '', $request->input_pph23),
                        'ppn1' => str_replace(',', '', $request->input_ppn1),
                        'total_cost_adjustment' => str_replace(',', '', $request->total_cost_adjustment),
                        'total_invoice' => str_replace(',', '', $request->total_invoice),
                        'created_by' => Auth::user()->name,
                        'created_on' => date('Y-m-d h:i:s')
                    ]
                );

                $pno = 0;
                $total_before_vat = 0;
                $total_vat = 0;
                $total_sub = 0;

                if (isset($request->cek_cost_chrg)) {
                        // print_r($request->cek_cost_chrg);die();
                    foreach ($request->cek_cost_chrg as $key => $chrg) {
                        $chrg_dtl = BookingModel::getChargesDetailById($chrg['id']);
                        $vat_dtl = 0;
                        $pph23_dtl = 0;
                        $ppn1_dtl = 0;
                        $subtotal = $chrg_dtl->cost_val + $chrg_dtl->cost_adjustment;
                        if(isset($chrg['ppn'])){
                            $vat_dtl = $chrg['ppn'];
                        }
                        if(isset($chrg['pph23'])){
                            $pph23_dtl = $chrg['pph23'];
                        }
                        if(isset($chrg['ppn1'])){
                            $ppn1_dtl = $chrg['ppn1'];
                        }
                        // if ($request->value_ppn > 0) {
                        //     $vat_dtl = $subtotal * ($request->value_ppn / 100);
                        // }

                        // if ($request->value_pph23 > 0) {
                        //     $pph23_dtl = $subtotal * ($request->value_pph23 / 100);
                        // }
                        $total = $subtotal + $vat_dtl - $pph23_dtl + $ppn1_dtl;
                        // $sub_total = ($chrg_dtl->qty * $chrg_dtl->cost_val) + $chrg_dtl->vat;
                        DB::table('t_invoice_detail')->insert(
                            [
                                'invoice_id'     => $invoice_id,
                                't_bcharges_id'  => $chrg_dtl->id,
                                't_mcharge_code_id' => $chrg_dtl->t_mcharge_code_id,
                                'position_no'    => $pno++, //Position
                                'desc'           => $chrg_dtl->desc,
                                'reimburse_flag' => $chrg_dtl->reimburse_flag,
                                'currency'       => $request->currency,
                                'rate'           => $chrg_dtl->rate,
                                'cost'           => $chrg_dtl->cost,
                                'sell'           => $chrg_dtl->sell,
                                'qty'            => $chrg_dtl->qty,
                                'cost_adjustment'=> $chrg_dtl->cost_adjustment,
                                'cost_val'       => $chrg_dtl->cost_val,
                                'sell_val'       => $chrg_dtl->sell_val,
                                'vat'            => $vat_dtl,
                                'pph23'          => $pph23_dtl,
                                'ppn1'           => $ppn1_dtl,
                                'subtotal'       => $total,
                                'routing'        => $chrg_dtl->routing,
                                'transit_time'   => $chrg_dtl->transit_time,
                                'created_by'     => Auth::user()->name,
                                'created_on'     => date('Y-m-d h:i:s')
                            ]
                        );

                        $chrgDtlParam['id'] = $chrg['id'];
                        $chrgDtlParam['t_invoice_cost_id'] = $invoice_id;
                        // $chrgDtlParam['invoice_type'] = $request->invoice_type;
                        $chrgDtlParam['created_by'] = Auth::user()->name;
                        $chrgDtlParam['created_on'] = date('Y-m-d h:i:s');
                        QuotationModel::saveChargeDetail($chrgDtlParam);
                    }
                }
                DB::commit();
                return redirect()->route('invoice.index', ['tipe' => 'hutang'])->with('success', 'Saved!');
            } catch (\Throwable $th) {
                DB::rollBack();
                return redirect()->back()->with('error', $th->getMessage());
            }
        } else {
            try {
                DB::beginTransaction();
                $invoice = InvoiceModel::find($request->create_type);
                $total_before_vat = $invoice->total_before_vat + str_replace(',', '', $request->total_before_vat);
                $total_vat = $invoice->total_vat + str_replace(',', '', $request->input_ppn);
                $pph23 = $invoice->pph23 + str_replace(',', '', $request->input_pph23);
                $ppn1 = $invoice->ppn1 + str_replace(',', '', $request->input_ppn1);
                $total_invoice = $invoice->total_invoice + str_replace(',', '', $request->total_invoice);
                $created_by = Auth::user()->name;
                $created_on = date('Y-m-d h:i:s');
                InvoiceModel::where('id', $invoice->id)->update([
                    'rate' => $request->kurs,
                    'total_before_vat' => $total_before_vat,
                    'total_vat' => $total_vat,
                    'pph23' => $pph23,
                    'ppn1' => $ppn1,
                    'total_invoice' => $total_invoice,
                    'created_by' => $created_by,
                    'created_on' => $created_on
                ]);

                $invoice_detail = DB::table('t_bcharges_dtl')->where('t_invoice_cost_id', $invoice->id)->first();
                $paramDetail['id'] = '';
                $paramDetail['invoice_id'] = $invoice->id;

                if (isset($request->cek_cost_chrg)) {
                    foreach ($request->cek_cost_chrg as $key => $chrg) {
                        $chrg_dtl = BookingModel::getChargesDetailById($chrg['id']);
                        $vat_dtl = 0;
                        $pph23_dtl = 0;
                        $ppn1_dtl = 0;
                        $subtotal = $chrg_dtl->cost_val + $chrg_dtl->cost_adjustment;
                        if(isset($chrg['ppn'])){
                            $vat_dtl = $chrg['ppn'];
                        }
                        if(isset($chrg['pph23'])){
                            $pph23_dtl = $chrg['pph23'];
                        }
                        if(isset($chrg['ppn1'])){
                            $ppn1_dtl = $chrg['ppn1'];
                        }
                        // if ($request->value_ppn > 0) {
                        //     $vat_dtl = $subtotal * ($request->value_ppn / 100);
                        // }

                        // if ($request->value_pph23 > 0) {
                        //     $pph23_dtl = $subtotal * ($request->value_pph23 / 100);
                        // }
                        $total = $subtotal + $vat_dtl - $pph23_dtl + $ppn1_dtl;
                        $subtotal = $subtotal + $vat_dtl - $pph23_dtl + $ppn1_dtl;
                        $paramDetail['t_bcharges_id'] = $chrg_dtl->id;
                        $paramDetail['t_mcharge_code_id'] = $chrg_dtl->t_mcharge_code_id;
                        $paramDetail['desc'] = $chrg_dtl->desc;
                        $paramDetail['currency'] = $invoice->currency;
                        $paramDetail['reimburse_flag'] = (($invoice_detail->invoice_type == 'REM') ? 1 : 0);
                        $paramDetail['rate'] = $chrg_dtl->rate;
                        $paramDetail['cost'] = $chrg_dtl->cost;
                        $paramDetail['sell'] = $chrg_dtl->sell;
                        $paramDetail['qty'] = $chrg_dtl->qty;
                        $paramDetail['cost_adjustment'] = $chrg_dtl->cost_adjustment;
                        $paramDetail['cost_val'] = $chrg_dtl->cost_val;
                        $paramDetail['sell_val'] = $chrg_dtl->sell_val;
                        $paramDetail['vat'] = $vat_dtl;
                        $paramDetail['pph23'] = $pph23_dtl;
                        $paramDetail['ppn1'] = $ppn1_dtl;
                        $paramDetail['subtotal'] = $subtotal;
                        $paramDetail['routing'] = $chrg_dtl->routing;
                        $paramDetail['transit_time'] = $chrg_dtl->transit_time;
                        $paramDetail['created_by'] = Auth::user()->name;
                        $paramDetail['created_on'] = date('Y-m-d h:i:s');

                        InvoiceDetailModel::saveInvoiceDetail($paramDetail);

                        $chrgDtlParam['id'] = $chrg['id'];
                        $chrgDtlParam['t_invoice_cost_id'] = $invoice->id;
                        // $chrgDtlParam['invoice_type'] = $request->invoice_type;
                        $chrgDtlParam['created_by'] = Auth::user()->name;
                        $chrgDtlParam['created_on'] = date('Y-m-d h:i:s');
                        QuotationModel::saveChargeDetail($chrgDtlParam);
                    }
                }

                DB::commit();
                return redirect()->route('booking.edit', ['id' => $request->t_booking_id])->with('success', 'Invoice Merged!');
            } catch (\Throwable $th) {
                DB::rollBack();
                return redirect()->back()->with('error', $th->getMessage());
            }
        }
    }

    public function view($id)
    {
        $data['header'] = InvoiceModel::getInvoice($id)->first();
        $data['details'] = InvoiceDetailModel::getInvoiceDetails($id)->get();
        $data['list_bank'] = MasterModel::bank_basedon_currency($data['header']->currency);
        $data['containers'] = BookingModel::get_container($data['header']->t_booking_id);
        $data['goods'] = BookingModel::get_commodity($data['header']->t_booking_id);

        return view('invoice.view_invoice')->with($data);
    }

    public function edit($id)
    {
        $data['header'] = InvoiceModel::getInvoice($id)->first();
        $data['details'] = InvoiceDetailModel::getInvoiceDetails($id)->get();
        $data['companies'] = MasterModel::company_data();
        $data['addresses'] = MasterModel::get_address($data['header']->client_id);
        $data['pics'] = MasterModel::get_pic($data['header']->client_id);
        $data['currency'] = MasterModel::currency();
        $data['containers'] = BookingModel::get_container($data['header']->t_booking_id);
        $data['goods'] = BookingModel::get_commodity($data['header']->t_booking_id);
        if ($data['header']->tipe_inv == 1) {
            return view('invoice.edit_invoice_cost')->with($data);
        } else {
            $data['taxes'] = Tax::all();
            return view('invoice.edit_invoice')->with($data);
        }
    }

    public static function getListInvoiceByCompanyId(Request $request)
    {
        $html = "<option value=''>Silahkan Pilih</option>";

        $invoices = InvoiceModel::getInvoicesByCompanyId($request->company_id)->where('tipe_inv', 1)->orderBy('invoice_no')->get();
        if ($invoices != []) {
            foreach ($invoices as $key => $inv) {
                $html .= "<option value='{$inv->id}'>{$inv->invoice_no}</option>";
            }
        }

        return $html;
    }

    // public function delete(Request $request)
    // {
    //     $rules = [
    //         'id' => 'required',
    //         'tipe_inv' => 'required',
    //         't_booking_id' => 'required',
    //     ];

    //     $validator = Validator::make($request->all(), $rules);
    //     if ($validator->fails()) {
    //         return redirect()->back()->with('errorForm', $validator->errors()->messages());
    //     }

    //     DB::beginTransaction();
    //     try {
    //         $param = $request->all();

    //         DB::table('t_invoice')->where('id',$request->id)->delete();

    //         if (isset($request->cek_cost_chrg)) {
    //             foreach ($request->cek_cost_chrg as $key => $chrg_dtl_id) {
    //                 $chrg_dtl = BookingModel::getChargesDetailById($chrg_dtl_id);
    //                 $sub_total = ($chrg_dtl->qty * $chrg_dtl->sell_val)+$chrg_dtl->vat;
    //                 DB::table('t_invoice_detail')->where('id', $chrg_dtl->t_invoice_cost_id)->delete();

    //                 DB::table('t_bcharges_dtl')->where('id',$chrg_dtl_id)->update([
    //                     't_invoice_cost_id' => null
    //                 ]);
    //             }
    //         }

    //         $jumlah_inv = DB::table('t_invoice')->where('t_booking_id',$request->t_booking_id)->count();
    //         if($jumlah_inv==0){
    //             DB::table('t_booking')->where('id',$request->t_booking_id)->update([
    //                 'flag_invoice' => 0,
    //                 'updated_by' => Auth::user()->name,
    //                 'updated_at' => date('Y-m-d h:i:s')
    //             ]);
    //         }
    //         DB::commit();
    //         return redirect()->route('invoice.index', ['tipe'=>'hutang'])->with('success', 'Invoice have been deleted!');
    //     } catch (\Throwable $th) {
    //         DB::rollBack();
    //         return redirect()->back()->with('error', $th->getMessage());
    //     }
    // }

    public function delete($invoiceId)
    {
        DB::beginTransaction();
        try {
            $invoice = InvoiceModel::find($invoiceId);

            $field = 't_invoice_id';
            if ($invoice->tipe_inv == 1) {
                $field = 't_invoice_cost_id';
            }
            DB::table('t_bcharges_dtl')->where($field, $invoiceId)->update([
                $field => null,
                'invoice_type' => null
            ]);

            InvoiceDetailModel::where('invoice_id', $invoiceId)->delete();

            $invoice->delete();
            
            $count = InvoiceModel::count_inv($invoice->t_booking_id);

            $flag_invoice = 0;
            if ($count > 0) {
                $flag_invoice = 1;
            }

            DB::table('t_booking')->where('id', $invoice->t_booking_id)->update([
                'flag_invoice' => $flag_invoice,
                'updated_by' => Auth::user()->name,
                'updated_at' => date('Y-m-d h:i:s')
            ]);

            DB::commit();

            return redirect()->back()->with('status', 'Invoice Deleted!');
        } catch (\Throwable $th) {
            DB::rollBack();

            Log::error("delete Invoice Error {$th->getMessage()}");

            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function delete_detail($invoiceId)
    {
        DB::beginTransaction();
        try {
            $invoice = InvoiceDetailModel::findHeader($invoiceId);
            $field = 't_invoice_id';
            if ($invoice->tipe_inv == 1) {
                $field = 't_invoice_cost_id';
                DB::table('t_bcharges_dtl')->where('id', $invoice->t_bcharges_id)->update([
                    $field => null
                ]);
            } else {
                DB::table('t_bcharges_dtl')->where('id', $invoice->t_bcharges_id)->update([
                    $field => null,
                    'invoice_type' => null
                ]);
            }

            $count = InvoiceModel::count_inv($invoice->t_booking_id);

            $flag_invoice = 0;
            if ($count > 0) {
                $flag_invoice = 1;
            }

            $detail_val = (($invoice->tipe_inv==0)?$invoice->sell_val:$invoice->cost_val+$invoice->cost_adjustment);

            $total_before_vat = $invoice->total_before_vat - $detail_val;
            $total_vat = $invoice->total_vat - $invoice->vat;
            $pph23 = $invoice->total_pph23 - $invoice->pph23;
            $ppn1 = $invoice->total_ppn1 - $invoice->ppn1;
            $total_invoice = $invoice->total_invoice - $invoice->subtotal;
            DB::table('t_booking')->where('id', $invoice->t_booking_id)->update([
                'flag_invoice' => $flag_invoice,
                'updated_by' => Auth::user()->name,
                'updated_at' => date('Y-m-d h:i:s')
            ]);

            DB::table('t_invoice')->where('id', $invoice->id_inv)->update([
                'total_before_vat' => $total_before_vat,
                'total_vat' => $total_vat,
                'pph23' => $pph23,
                'ppn1' => $ppn1,
                'total_invoice' => $total_invoice,
                'modified_by' => Auth::user()->id,
                'modified_at' => date('Y-m-d h:i:s')
            ]);

            InvoiceDetailModel::where('id', $invoiceId)->delete();

            DB::commit();

            return redirect()->back()->with('status', 'Invoice Deleted!');
        } catch (\Throwable $th) {
            DB::rollBack();

            Log::error("delete Invoice Error {$th->getMessage()}");

            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function getInvoiceHeader(Request $request)
    {
        try {
            $data = DB::table('t_invoice')->where('id', $request['id'])->first();

            $return_data['data'] = $data;
            $return_data['status'] = 'sukses';
        } catch (\Exception $e) {
            $return_data['status'] = 'error';
            $return_data['message'] = $e->getMessage();
        }

        header('Content-Type: application/json');
        echo json_encode($return_data);
    }

    public static function getInvoice($id)
    {
        $invoice = InvoiceModel::find($id);

        return $invoice;
    }

    public function syncInvoiceDetail(Request $request)
    {
        $result = [];

        DB::beginTransaction();
        try {
            $query = InvoiceDetailModel::findInvoiceDetailByChargeId($request->invoice_id)->get();
            if (count($query)) {
                $total_before_vat = 0;
                $total_vat = 0;
                $pph23 = 0;
                $ppn1 = 0;
                $total_invoice = 0;

                foreach ($query as $key => $val) {
                    $chrg = DB::table('t_bcharges_dtl')->where('id', $val->t_bcharges_id)->first();
                    $vat_dtl = 0;
                    $pph23_dtl = 0;
                    $ppn1_dtl = 0;
                    $subtotal = 0;

                    $is_ppn = (($val->vat > 0)? 1:0);
                    $is_pph23 = (($val->pph23 > 0)? 1:0);
                    $is_ppn1 = (($val->ppn1 > 0)? 1:0);

                    $value_ppn = Tax::where('code', 'ppn')->value('value');
                    $value_ppn = ($value_ppn == null ? 0 : $value_ppn);
                    $value_pph23 = Tax::where('code', 'pph23')->value('value');
                    $value_pph23 = ($value_pph23 == null ? 0 : $value_pph23);
                    $value_ppn1 = Tax::where('code', 'ppn1')->value('value');
                    $value_ppn1 = ($value_ppn1 == null ? 0 : $value_ppn1);

                    $cost_adjustment = 0;
                    if($request->type_invoice == 'cost'){
                        $cost_adjustment = $chrg->cost_adjustment;
                    }

                    if ($is_ppn == 1) {
                        if($request->type_invoice == 'sell'){
                            $vat_dtl = $chrg->sell_val * ($value_ppn / 100);
                        }else{
                            $vat_dtl = ($chrg->cost_val+$cost_adjustment) * ($value_ppn / 100);
                        }
                    }

                    if ($is_pph23 == 1) {
                        if($request->type_invoice == 'sell'){
                            $pph23_dtl = $chrg->sell_val * ($value_pph23 / 100);
                        }else{
                            $pph23_dtl = ($chrg->cost_val+$cost_adjustment) * ($value_pph23 / 100);
                        }
                    }

                    if ($is_ppn1 == 1) {
                        if($request->type_invoice == 'sell'){
                            $ppn1_dtl = $chrg->sell_val * ($value_ppn1 / 100);
                        }else{
                            $ppn1_dtl = ($chrg->cost_val+$cost_adjustment) * ($value_ppn1 / 100);
                        }
                    }

                    if($request->type_invoice == 'sell'){
                        $subtotal = $chrg->sell_val + $vat_dtl - $pph23_dtl + $ppn1_dtl;
                    }else{
                        $subtotal = $chrg->cost_val + $cost_adjustment + $vat_dtl - $pph23_dtl + $ppn1_dtl;
                    }

                    if($request->type_invoice == 'sell'){
                        $total_before_vat += $chrg->sell_val;
                    }else{
                        $total_before_vat += $chrg->cost_val + $cost_adjustment;
                    }
                    $total_vat += $vat_dtl;
                    $pph23 += $pph23_dtl;
                    $ppn1 += $ppn1_dtl;
                    $total_invoice += $subtotal;

                    /** sync invoice detail dengan charge dtl */
                    DB::table('t_invoice_detail')->where('id', $val->id)->update([
                        't_mcharge_code_id' => $chrg->t_mcharge_code_id,
                        'desc' => $chrg->desc,
                        'currency' => $chrg->currency,
                        't_mcharge_code_id' => $chrg->t_mcharge_code_id,
                        'rate' => 1,
                        'cost' => $chrg->cost,
                        'sell' => $chrg->sell,
                        'qty' => $chrg->qty,
                        'cost_val' => $chrg->cost_val,
                        'sell_val' => $chrg->sell_val,
                        'vat' => $vat_dtl,
                        'pph23' => $pph23_dtl,
                        'ppn1' => $ppn1_dtl,
                        'cost_adjustment' => $cost_adjustment,
                        'subtotal' => $subtotal,
                        'routing' => $chrg->routing,
                        'transit_time' => $chrg->transit_time,
                        'created_by' => Auth::user()->name,
                        'created_on' => date('Y-m-d h:i:s'),
                    ]);
                }

                DB::table('t_invoice')->where('id', $request->invoice_id)->update([
                    'total_before_vat' => $total_before_vat,
                    'total_vat' => $total_vat,
                    'pph23' => $pph23,
                    'ppn1' => $ppn1,
                    'total_invoice' => $total_invoice,
                    'modified_by' => Auth::user()->id,
                    'modified_at' => date('Y-m-d h:i:s')
                ]);
            }

            DB::commit();
            $result['status'] = 'success';

            return $result;
        } catch (\Throwable $th) {
            DB::rollBack();
            $result['status'] = 'failed';
            $result['message'] = $th->getMessage();

            Log::error("Sync Invoice Error {$th->getMessage()}");
            Log::error($th->getTraceAsString());

            return $result;
        }
    }

    public function print($id)
    {
        $data['header'] = InvoiceModel::getInvoice($id)->first();
        $data['details'] = InvoiceDetailModel::getInvoiceDetails($id)->get();
        $data['list_bank'] = MasterModel::bank_basedon_currency($data['header']->currency);
        $data['containers'] = BookingModel::get_container($data['header']->t_booking_id);
        $data['goods'] = BookingModel::get_commodity($data['header']->t_booking_id);

        return view('invoice.print_invoice')->with($data);
    }
}
