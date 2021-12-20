<?php

namespace App\Http\Controllers;

use App\BookingModel;
use App\InvoiceDetailModel;
use App\InvoiceModel;
use App\MasterModel;
use App\ProformaInvoiceDetailModel;
use App\ProformaInvoiceModel;
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
        $data['proforma_header'] = ProformaInvoiceModel::getProformaInvoice($request->id)->first();
        $data['proforma_details'] = ProformaInvoiceDetailModel::getProformaInvoiceDetails($request->id)->get();
        $data['companies'] = MasterModel::company_get($data['proforma_header']['client_id']);
        $data['addresses'] = MasterModel::get_address($data['proforma_header']['client_id']);
        $data['pics'] = MasterModel::get_pic($data['proforma_header']['client_id']);
        $data['bill_to_id'] = $data['proforma_header']['client_id'];
        $data['currency']       = MasterModel::currency();
        $data['containers'] = BookingModel::get_container($data['proforma_header']['t_booking_id']);
        $data['goods'] = BookingModel::get_commodity($data['proforma_header']['t_booking_id']);

        return view('invoice.add_invoice')->with($data);
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

            $param = $request->all();
            $param['tipe_inv'] = 0;
            $param['invoice_date'] = date('Y-m-d', strtotime($request->invoice_date));
            $param['onboard_date'] = date('Y-m-d', strtotime($request->onboard_date));
            $param['reimburse_flag'] = (($request->invoice_type == 'REM') ? 1 : 0);
            $param['debit_note_flag'] = (($request->invoice_type == 'DN') ? 1 : 0);
            $param['credit_note_flag'] = (($request->invoice_type == 'CN') ? 1 : 0);
            // $param['rate'] = 1;
            $param['created_by'] = Auth::user()->name;
            $param['created_on'] = date('Y-m-d h:i:s');

            $invoice = InvoiceModel::saveInvoice($param);

            $total_sub = 0;
            $details = ProformaInvoiceDetailModel::getProformaInvoiceDetails($request->t_proforma_invoice_id)->get();
            foreach ($details as $key => $detail) {
                // dd($invoice->id);
                $paramDetail['id'] = 0;
                $paramDetail['invoice_id'] = $invoice->id;
                $paramDetail['t_mcharge_code_id'] = $detail->t_mcharge_code_id;
                $paramDetail['reimburse_flag'] = (($request->invoice_type == 'REM') ? 1 : 0);
                $paramDetail['desc'] = $detail->desc;
                $paramDetail['currency'] = $request->currency;
                $paramDetail['rate'] = 1;
                $paramDetail['cost'] = $detail->cost;
                $paramDetail['sell'] = $detail->sell;
                $paramDetail['qty'] = $detail->qty;
                $paramDetail['cost_val'] = $detail->cost_val;
                $paramDetail['sell_val'] = $detail->sell_val;
                $paramDetail['subtotal'] = $detail->subtotal;
                $paramDetail['routing'] = $detail->routing;
                $paramDetail['transit_time'] = $detail->transit_time;
                $paramDetail['created_by'] = Auth::user()->name;
                $paramDetail['created_on'] = date('Y-m-d h:i:s');

                InvoiceDetailModel::saveInvoiceDetail($paramDetail);
                $total_sub += $detail->subtotal;
            }

            DB::table('t_invoice')->where('id', $invoice->id)->update([
                'total_invoice' => $total_sub
            ]);

            DB::commit();

            return redirect()->route('invoice.index')->with('success', 'Saved!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function view($id)
    {
        $data['header'] = InvoiceModel::getInvoice($id)->first();
        $data['details'] = InvoiceDetailModel::getInvoiceDetails($id)->get();
        $data['companies'] = MasterModel::company_data();
        $data['addresses'] = MasterModel::get_address($data['header']['client_id']);
        $data['pics'] = MasterModel::get_pic($data['header']['client_id']);
        $data['currency']       = MasterModel::currency();
        $data['containers'] = BookingModel::get_container($data['header']['t_booking_id']);
        $data['goods'] = BookingModel::get_commodity($data['header']['t_booking_id']);

        return view('invoice.view_invoice')->with($data);
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

            $invoice_id = DB::table('t_invoice')->insertGetId([
                    'tipe_inv' => 1,
                    't_proforma_invoice_id' => 0,
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
                    $total_sub += $sub_total;
                }
            }

            DB::table('t_invoice')->where('id', $invoice_id)->update([
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
}
