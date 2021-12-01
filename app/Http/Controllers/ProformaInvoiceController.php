<?php

namespace App\Http\Controllers;

use App\BookingModel;
use App\MasterModel;
use App\ProformaInvoiceDetailModel;
use App\ProformaInvoiceModel;
use App\QuotationModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProformaInvoiceController extends Controller
{
    public function index()
    {
        $proforma_invoices = ProformaInvoiceModel::getAllProformaInvoice()->get();
        return view('proforma_invoice.list_proforma_invoice', compact('proforma_invoices'));
    }

    public function create(Request $request)
    {

        $data['error']          = (isset($_GET['error']) ? 1 : 0);
        $data['errorMsg']       = (isset($_GET['errorMsg']) ? $_GET['errorMsg'] : '');

        $rules = [
            't_booking_id' => 'required',
            'cek_sell_shp' => 'required_without:cek_sell_chrg',
            'cek_bill_to' => 'required',
        ];

        $validatorMsg = [
            't_booking_id.required' => 'Booking ID can not be null!',
            'cek_sell_shp.required_without' => 'Please choose at least 1 item!',
            'cek_bill_to.required' => 'Please choose Bill To field!',
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
        $data['companies'] = MasterModel::company_get($request->cek_bill_to[0]);
        $data['addresses'] = MasterModel::get_address($request->cek_bill_to[0]);
        $data['pics'] = MasterModel::get_pic($request->cek_bill_to[0]);
        $data['currency'] = MasterModel::currency();
        $data['containers'] = BookingModel::get_container($request->t_booking_id);
        $data['goods'] = BookingModel::get_commodity($request->t_booking_id);
        return view('proforma_invoice.add_proforma_invoice')->with($data);
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
        $amountShip = 0;
        $totalAmount    = 0;
        $totalAmount2   = 0;

        // $data       = BookingModel::getChargesDetail($request->id);
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
                $tabel1 .= '<input type="hidden" name="cek_sell_chrg[]" value="'.$row->id.'" />';
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
                // $tabel1 .= '<td>';
                // $tabel1 .= '<a href="javascript:;" class="btn btn-xs btn-circle btn-danger'
                //         . '" onclick="hapusDetailSell('.$row->id.');" style="margin-left:2px;"> '
                //         . '<i class="fa fa-trash"></i></a>';
                // $tabel1 .= '</td>';
                $tabel1 .= '</tr>';
                $no++;

                $totalAmount    += $amount;
                $totalAmount2   += $amount2;
            }
        }else{
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
                $tabel1 .= '<input type="hidden" name="cek_sell_chrg[]" value="'.$row->id.'" />';
                $tabel1 .= '<input type="hidden" name="cek_bill_to[]" value="'.$row->bill_to_id.'" />';
                $tabel1 .= '</td>';
                $tabel1 .= '<td class="text-left">' . $row->charge_name . '</td>';
                $tabel1 .= '<td class="text-left">' . $row->desc . ' | Routing: ' . $row->routing . ' | Transit time : ' . $row->transit_time . '</td>';
                $tabel1 .= '<td class="text-center"><input type="checkbox" name="reimburs" style="width:50px;" id="reimburs_' . $no . '" ' . $style . ' onclick="return false;"></td>';
                $tabel1 .= '<td class="text-left">' . $row->qty . '</td>';
                $tabel1 .= '<td class="text-left">' . $row->code_cur . '</td>';
                $tabel1 .= '<td class="text-right">' . number_format($row->sell_val, 2, ',', '.') . '</td>';
                $tabel1 .= '<td class="text-right">' . number_format(($row->qty * $row->sell_val), 2, ',', '.') . '</td>';
                $tabel1 .= '<td class="text-right">' . number_format($row->rate, 2, ',', '.') . '</td>';
                $tabel1 .= '<td class="text-right">' . number_format($row->vat, 2, ',', '.') . '</td>';
                $tabel1 .= '<td class="text-right">' . number_format($amount2, 2, ',', '.') . '</td>';
                $tabel1 .= '<td class="text-left"></td>';
                // $tabel1 .= '<td>';
                // $tabel1 .= '<a href="javascript:;" class="btn btn-xs btn-circle btn-danger'
                //         . '" onclick="hapusDetailSell('.$row->id.');" style="margin-left:2px;"> '
                //         . '<i class="fa fa-trash"></i></a>';
                // $tabel1 .= '</td>';
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

            $totalCost = 0;
            $totalSell = 0;
            $profitAll = 0;
        }

        // foreach ($shipping as $shp) {
        //     $amountShip = (($shp->qty * $shp->cost_val) * $shp->rate) + $shp->vat;
        //     $tabel1 .= '<tr>';
        //     $tabel1 .= '<td>';
        //     $tabel1 .= ($no);
        //     $tabel1 .= '<input type="hidden" name="cek_sell_shp[]" value="'.$shp->id.'" />';
        //     $tabel1 .= '<input type="hidden" name="cek_bill_to[]" value="'.$booking->client_id.'" />';
        //     $tabel1 .= '</td>';
        //     if ($quote->shipment_by == 'LAND') {
        //         $tabel1 .= '<td>' . $shp->truck_size . '</td>';
        //     } else {
        //         $tabel1 .= '<td>' . $shp->name_carrier . '</td>';
        //     }
        //     $tabel1 .= '<td class="text-left">' . $shp->notes . ' | Routing: ' . $shp->routing . ' | Transit time : ' . $shp->transit_time . '</td>';
        //     $tabel1 .= '<td class="text-center"><input type="checkbox" name="reimburs" style="width:50px;" id="reimburs_' . $no . '"></td>';
        //     $tabel1 .= '<td class="text-left">' . $shp->qty . '</td>';
        //     $tabel1 .= '<td class="text-left">' . $shp->code_currency . '</td>';
        //     $tabel1 .= '<td class="text-right">' . number_format($shp->cost_val, 2, ',', '.') . '</td>';
        //     $tabel1 .= '<td class="text-right">' . number_format(($shp->qty * $shp->cost_val), 2, ',', '.') . '</td>';
        //     $tabel1 .= '<td class="text-right">' . number_format($shp->rate, 2, ',', '.') . '</td>';
        //     $tabel1 .= '<td class="text-right">' . number_format($shp->vat, 2, ',', '.') . '</td>';
        //     $tabel1 .= '<td class="text-right">' . number_format($amountShip, 2, ',', '.') . '</td>';

        //     $tabel1 .= '<td class="text-left"></td>';
        //     // $tabel1 .= '<td>';
        //     // $tabel1 .= '</td>';
        //     $tabel1 .= '</tr>';
        //     $totalAmount2 += $amountShip;
        //     $no++;
        // }

        header('Content-Type: application/json');
        echo json_encode([$tabel1, $tabel2]);
    }

    public function save(Request $request)
    {

        $rules = [
            'client_id' => 'required',
            'proforma_invoice_no' => 'required|unique:t_proforma_invoice',
            'proforma_invoice_date' => 'required',
            'currency' => 'required',
            'pol_id' => 'required',
            'pod_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errorMsg = '';
            foreach ($validator->errors()->messages() as $err) {
                foreach ($err as $msg) {
                    $errorMsg .= $msg . "<br>";
                }
            }
            $previousUrl = parse_url(app('url')->previous());

            $errorParam = [
                'error' => '1',
                'errorMsg' => $errorMsg,
                '_token' => $request->_token,
                't_booking_id' => $request->t_booking_id,
                'cek_bill_to' => $request->cek_bill_to,
            ];

            if (isset($request->cek_sell_shp)) $errorParam['cek_sell_shp'] = $request->cek_sell_shp;
            if (isset($request->cek_sell_chrg)) $errorParam['cek_sell_chrg'] = $request->cek_sell_chrg;
            $url = $previousUrl['path'] . '?' . http_build_query($errorParam);

            return redirect()->to($url);
        }

        try {
            DB::beginTransaction();

            $param = $request->all();
            $param['proforma_invoice_date'] = date('Y-m-d', strtotime($request->proforma_invoice_date));
            $param['onboard_date'] = date('Y-m-d', strtotime($request->onboard_date));
            $param['reimburse_flag'] = (($request->invoice_type == 'REM') ? 1 : 0);
            $param['debit_note_flag'] = (($request->invoice_type == 'DN') ? 1 : 0);
            $param['credit_note_flag'] = (($request->invoice_type == 'CN') ? 1 : 0);
            $param['rate'] = 1;
            $param['created_by'] = Auth::user()->name;
            $param['created_on'] = date('Y-m-d h:i:s');

            $proforma = ProformaInvoiceModel::saveProformaInvoice($param);

            $paramDetail['id'] = '';
            $paramDetail['proforma_invoice_id'] = $proforma->id;
            if (isset($request->cek_sell_shp)) {
                foreach ($request->cek_sell_shp as $key => $shp_dtl_id) {
                    $shp_dtl   = QuotationModel::get_quoteShippingById($shp_dtl_id);
                    $paramDetail['desc'] = $shp_dtl->notes.' | Routing: '.$shp_dtl->routing.' | Transit time : '.$shp_dtl->transit_time;
                    $paramDetail['currency'] = $request->currency;
                    $paramDetail['rate'] = 1;
                    $paramDetail['cost'] = $shp_dtl->cost;
                    $paramDetail['sell'] = $shp_dtl->sell;
                    $paramDetail['qty'] = $shp_dtl->qty;
                    $paramDetail['cost_val'] = $shp_dtl->cost_val;
                    $paramDetail['sell_val'] = $shp_dtl->sell_val;
                    $paramDetail['subtotal'] = $shp_dtl->subtotal;
                    $paramDetail['created_by'] = Auth::user()->name;
                    $paramDetail['created_on'] = date('Y-m-d h:i:s');

                    ProformaInvoiceDetailModel::saveProformaInvoiceDetail($paramDetail);

                    $shpDtlParam['id'] = $shp_dtl_id;
                    $shpDtlParam['t_invoice_cost_id'] = $proforma->id;
                    $shpDtlParam['invoice_type'] = $request->invoice_type;
                    $shpDtlParam['created_by'] = Auth::user()->name;
                    $shpDtlParam['created_on'] = date('Y-m-d h:i:s');
                    QuotationModel::saveShipDetail($shpDtlParam);
                }
            }

            if (isset($request->cek_sell_chrg)) {
                foreach ($request->cek_sell_chrg as $key => $chrg_dtl_id) {
                    $chrg_dtl       = BookingModel::getChargesDetailById($chrg_dtl_id);
                    $paramDetail['t_mcharge_code_id'] = $chrg_dtl->t_mcharge_code_id;
                    $paramDetail['desc'] = $chrg_dtl->desc;
                    $paramDetail['currency'] = $request->currency;
                    $paramDetail['rate'] = 1;
                    $paramDetail['cost'] = $chrg_dtl->cost;
                    $paramDetail['sell'] = $chrg_dtl->sell;
                    $paramDetail['qty'] = $chrg_dtl->qty;
                    $paramDetail['cost_val'] = $chrg_dtl->cost_val;
                    $paramDetail['sell_val'] = $chrg_dtl->sell_val;
                    $paramDetail['subtotal'] = $chrg_dtl->subtotal;
                    $paramDetail['routing'] = $chrg_dtl->routing;
                    $paramDetail['transit_time'] = $chrg_dtl->transit_time;
                    $paramDetail['created_by'] = Auth::user()->name;
                    $paramDetail['created_on'] = date('Y-m-d h:i:s');

                    ProformaInvoiceDetailModel::saveProformaInvoiceDetail($paramDetail);

                    $chrgDtlParam['id'] = $chrg_dtl_id;
                    $chrgDtlParam['t_invoice_id'] = $proforma->id;
                    $chrgDtlParam['invoice_type'] = $request->invoice_type;
                    $chrgDtlParam['created_by'] = Auth::user()->name;
                    $chrgDtlParam['created_on'] = date('Y-m-d h:i:s');
                    QuotationModel::saveChargeDetail($chrgDtlParam);
                }
            }
            DB::commit();
            return redirect()->to(route('booking.edit', ['id' => $request->t_booking_id]) . '?' . http_build_query(['success' => '1', 'successMsg' => 'Proforma Invoice Created!']));
        } catch (\Throwable $th) {
            DB::rollBack();
            $errorMsg = $th->getMessage();
            $previousUrl = parse_url(app('url')->previous());

            $errorParam = [
                'error' => '1',
                'errorMsg' => $errorMsg,
                '_token' => $request->_token,
                't_booking_id' => $request->t_booking_id,
                'cek_bill_to' => $request->cek_bill_to,
            ];

            if (isset($request->cek_sell_shp)) $errorParam['cek_sell_shp'] = $request->cek_sell_shp;
            if (isset($request->cek_sell_chrg)) $errorParam['cek_sell_chrg'] = $request->cek_sell_chrg;
            $url = $previousUrl['path'] . '?' . http_build_query($errorParam);

            return redirect()->to($url);
        }
    }

    public function edit($id)
    {
        $data['error']          = (isset($_GET['error']) ? 1 : 0);
        $data['errorMsg']       = (isset($_GET['errorMsg']) ? $_GET['errorMsg'] : '');
        $data['header'] = ProformaInvoiceModel::getProformaInvoice($id)->first();
        $data['details'] = ProformaInvoiceDetailModel::getProformaInvoiceDetails($id)->get();
        $data['companies'] = MasterModel::company_data();
        $data['addresses'] = MasterModel::get_address($data['header']->client_id);
        $data['pics'] = MasterModel::get_pic($data['header']->client_id);
        $data['currency']       = MasterModel::currency();
        $data['containers'] = BookingModel::get_container($data['header']->t_booking_id);
        $data['goods'] = BookingModel::get_commodity($data['header']->t_booking_id);

        return view('proforma_invoice.edit_proforma_invoice')->with($data);
    }

    public function update(Request $request)
    {
        $rules = [
            'client_id' => 'required',
            // 'proforma_invoice_no' => 'required|unique:t_proforma_invoice',
            'proforma_invoice_date' => 'required',
            'currency' => 'required',
            'pol_id' => 'required',
            'pod_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errorMsg = '';
            foreach ($validator->errors()->messages() as $err) {
                foreach ($err as $msg) {
                    $errorMsg .= $msg . "<br>";
                }
            }
            $previousUrl = parse_url(app('url')->previous());

            $errorParam = [
                'error' => '1',
                'errorMsg' => $errorMsg,
                '_token' => $request->_token,
                't_booking_id' => $request->t_booking_id,
            ];

            $url = $previousUrl['path'] . '?' . http_build_query($errorParam);

            return redirect()->to($url);
        }

        try {
            $param = $request->all();
            $param['proforma_invoice_date'] = date('Y-m-d', strtotime($request->proforma_invoice_date));
            $param['onboard_date'] = date('Y-m-d', strtotime($request->onboard_date));
            $param['reimburse_flag'] = (($request->invoice_type == 'REM') ? 1 : 0);
            $param['debit_note_flag'] = (($request->invoice_type == 'DN') ? 1 : 0);
            $param['credit_note_flag'] = (($request->invoice_type == 'CN') ? 1 : 0);
            $param['rate'] = 1;
            $param['created_by'] = Auth::user()->name;
            $param['created_on'] = date('Y-m-d h:i:s');

            $proforma = ProformaInvoiceModel::saveProformaInvoice($param);

            return redirect()->route('proformainvoice.index');
        } catch (\Throwable $th) {
            $errorMsg = $th->getMessage();
            $previousUrl = parse_url(app('url')->previous());

            $errorParam = [
                'error' => '1',
                'errorMsg' => $errorMsg,
                '_token' => $request->_token,
                't_booking_id' => $request->t_booking_id,
            ];
            $url = $previousUrl['path'] . '?' . http_build_query($errorParam);

            return redirect()->to($url);
        }
    }

    public function view($id)
    {
        $data['header'] = ProformaInvoiceModel::getProformaInvoice($id)->first();
        $data['details'] = ProformaInvoiceDetailModel::getProformaInvoiceDetails($id)->get();
        $data['companies'] = MasterModel::company_data();
        $data['addresses'] = MasterModel::get_address($data['header']->client_id);
        $data['pics'] = MasterModel::get_pic($data['header']->client_id);
        $data['currency']       = MasterModel::currency();
        $data['containers'] = BookingModel::get_container($data['header']->t_booking_id);
        $data['goods'] = BookingModel::get_commodity($data['header']->t_booking_id);

        return view('proforma_invoice.view_proforma_invoice')->with($data);
    }

    public function create_cost(Request $request)
    {
        $data['error']          = (isset($_GET['error']) ? 1 : 0);
        $data['errorMsg']       = (isset($_GET['errorMsg']) ? $_GET['errorMsg'] : '');

        $rules = [
            't_booking_id' => 'required',
            'cek_cost_shp' => 'required_without:cek_cost_shp',
            'cek_paid_to' => 'required',
        ];

        $validatorMsg = [
            't_booking_id.required' => 'Booking ID can not be null!',
            'cek_cost_shp.required_without' => 'Please choose at least 1 item!',
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

        $data['booking'] = BookingModel::getDetailBooking($request->t_booking_id);
        $data['companies'] = MasterModel::company_get($request->cek_paid_to[0]);
        $data['addresses'] = MasterModel::get_address($request->cek_paid_to[0]);
        $data['pics'] = MasterModel::get_pic($request->cek_paid_to[0]);
        $data['currency'] = MasterModel::currency();
        $data['containers'] = BookingModel::get_container($request->t_booking_id);
        $data['goods'] = BookingModel::get_commodity($request->t_booking_id);
        return view('proforma_invoice.add_cost_proforma_invoice')->with($data);
    }
}
