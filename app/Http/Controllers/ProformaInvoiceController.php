<?php

namespace App\Http\Controllers;

use App\BookingModel;
use App\MasterModel;
use App\QuotationModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProformaInvoiceController extends Controller
{
    public function create(Request $request)
    {
        // dd($request->all());

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


        $data['booking'] = BookingModel::getDetailBooking($request->t_booking_id); // DB::table('t_booking')->where('id', $request->t_booking_id)->first();
        // $data['cust_addr'] = DB::table('t_maddress')->where('t_mcompany_id', $data['booking']->client_id)->get();
        // $data['cust_pic'] = DB::table('t_mpic')->where('t_mcompany_id', $data['booking']->client_id)->get();


        // foreach ($request->shp_dtl['id'] as $key => $shp_dtl_id) {
        //     // dd($shp_dtl);
        //     $data['shippings'][$key]   = QuotationModel::get_quoteShippingById($shp_dtl_id);
        //     $data['shipping_dtl_id'][$key] = $shp_dtl_id;
        // }

        // dd($request->chrg_dtl);
        // foreach ($request->chrg_dtl['id'] as $key => $chrg_dtl_id) {
        //     // dd($chrg_dtl);
        //     $data['quotes'][$key]      = BookingModel::getChargesDetailById($chrg_dtl_id);
        //     $data['chrg_dtl_id'][$key] = $chrg_dtl_id;
        //     // foreach ($chrg_dtl['id'] as $id) {
        //     // }
        // }
        $data['bill_to_id'] = $request->cek_bill_to[0];
        $data['companies'] = MasterModel::company_data();
        $data['addresses'] = MasterModel::get_address($data['bill_to_id']);
        $data['pics'] = MasterModel::get_pic($data['bill_to_id']);
        $data['currency']       = MasterModel::currency();
        $data['containers'] = BookingModel::get_container($request->t_booking_id);
        $data['goods'] = BookingModel::get_commodity($request->t_booking_id);
        // dd($data);
        return view('proforma_invoice.add_proforma_invoice')->with($data);
    }

    public function loadSellCost(Request $request)
    {
        // dd($request->all());
        $shp_dtl_id = [];
        $chrg_dtl_id = [];

        if (isset($request->shipping_dtl_id)) $shp_dtl_id = $request->shipping_dtl_id;
        if (isset($request->chrg_dtl_id)) $chrg_dtl_id = $request->chrg_dtl_id;

        $tabel1     = "";
        $tabel2     = "";
        $no         = 1;
        // $data       = BookingModel::getChargesDetail($request->id);
        $data       = BookingModel::getChargesDetailUsingInId($chrg_dtl_id);
        $company    = MasterModel::company_data();
        $booking    = DB::table('t_booking')->where('id', $request->id)->first();
        // $shipping   = QuotationModel::get_quoteShipping($booking->t_quote_id);
        $shipping   = QuotationModel::get_quoteShippingInId($shp_dtl_id);
        $quote      = QuotationModel::get_detailQuote($booking->t_quote_id);
        // $quote      = BookingModel::getChargesDetailUsingInId($request->chrg_dtl_id);
        $total      = 0;
        $total2     = 0;
        $amount     = 0;
        $amount2    = 0;
        $a          = 1;
        $b          = 2;
        // dd($quote);
        $amountShip = 0;
        $totalAmount    = 0;
        $totalAmount2   = 0;
        foreach ($shipping as $shp) {
            $amountShip = (($shp->qty * $shp->sell_val) * $shp->rate) + $shp->vat;
            $tabel1 .= '<tr>';
            $tabel1 .= '<td>' . ($no) . '</td>';
            if ($quote->shipment_by == 'LAND') {
                $tabel1 .= '<td>' . $shp->truck_size . '</td>';
            } else {
                $tabel1 .= '<td>' . $shp->name_carrier . '</td>';
            }
            $tabel1 .= '<td class="text-left">' . $shp->notes . ' | Routing: ' . $shp->routing . ' | Transit time : ' . $shp->transit_time . '</td>';
            $tabel1 .= '<td class="text-center"><input type="checkbox" name="reimburs" style="width:50px;" id="reimburs_' . $no . '"></td>';
            $tabel1 .= '<td class="text-left">' . $shp->qty . '</td>';
            $tabel1 .= '<td class="text-left">' . $shp->code_currency . '</td>';
            $tabel1 .= '<td class="text-right">' . number_format($shp->sell_val, 2, ',', '.') . '</td>';
            $tabel1 .= '<td class="text-right">' . number_format(($shp->qty * $shp->sell_val), 2, ',', '.') . '</td>';
            $tabel1 .= '<td class="text-right">' . number_format($shp->rate, 2, ',', '.') . '</td>';
            $tabel1 .= '<td class="text-right">' . number_format($shp->vat, 2, ',', '.') . '</td>';
            $tabel1 .= '<td class="text-right">' . number_format($amountShip, 2, ',', '.') . '</td>';

            $tabel1 .= '<td class="text-left"></td>';
            // $tabel1 .= '<td>';
            // $tabel1 .= '</td>';
            $tabel1 .= '</tr>';
            $totalAmount2 += $amountShip;
            $no++;
        }

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
            $tabel1 .= '<td>' . ($no) . '</td>';
            $tabel1 .= '<td class="text-left">' . $row->charge_name . '</td>';
            $tabel1 .= '<td class="text-left">' . $row->desc . ' | Routing: ' . $row->routing . ' | Transit time : ' . $row->transit_time . '</td>';
            $tabel1 .= '<td class="text-center"><input type="checkbox" name="reimburs" style="width:50px;" id="reimburs_' . $no . '" ' . $style . '></td>';
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

        foreach ($shipping as $profit) {
            $totalCost = $totalAmount + (($profit->qty * $profit->cost_val) * $profit->rate) + $profit->vat;
            $totalSell = $totalAmount2 + (($profit->qty * $profit->sell_val) * $profit->rate) + $profit->vat;
            $profitAll = $totalSell - $totalCost;
            $profitPct = ($profitAll * 100) / $totalSell;
            $tabel2 .= '<tr>';
            if ($quote->shipment_by != 'LAND') {
                $tabel2 .= '<td class="text-center"><strong>' . $profit->carrier_code . '</strong></td>';
                $tabel2 .= '<td class="text-center"><strong>' . $profit->routing . '</strong></td>';
                $tabel2 .= '<td class="text-center"><strong>' . $profit->transit_time . '</strong></td>';
            }
            $tabel2 .= '<td class="text-center"><strong>' . number_format($totalCost, 2, ',', '.') . '</strong></td>';
            $tabel2 .= '<td class="text-center"><strong>' . number_format($totalSell, 2, ',', '.') . '</strong></td>';
            $tabel2 .= '<td class="text-center"><strong>' . number_format($profitAll, 2, ',', '.') . '</strong></td>';
            $tabel2 .= '<td class="text-center"><strong>' . number_format($profitPct, 2) . '%</strong></td>';
            $tabel2 .= '</tr>';
            $no++;
        }


        header('Content-Type: application/json');
        echo json_encode([$tabel1, $tabel2]);
    }

    public function save(Request $request)
    {

    }
}
