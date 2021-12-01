<?php

namespace App\Http\Controllers;

use App\BookingModel;
use App\InvoiceModel;
use App\MasterModel;
use App\ProformaInvoiceDetailModel;
use App\ProformaInvoiceModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    public function index()
    {
        # code...
    }

    public function create(Request $request)
    {
        // dd($request->all());
        $data['error']          = (isset($_GET['error']) ? 1 : 0);
        $data['errorMsg']       = (isset($_GET['errorMsg']) ? $_GET['errorMsg'] : '');

        // $rules = [
        //     't_booking_id' => 'required',
        //     'cek_sell_shp' => 'required_without:cek_sell_chrg',
        //     'cek_bill_to' => 'required',
        // ];

        // $validatorMsg = [
        //     't_booking_id.required' => 'Booking ID can not be null!',
        //     'cek_sell_shp.required_without' => 'Please choose at least 1 item!',
        //     'cek_bill_to.required' => 'Please choose Bill To field!',
        // ];

        // $validator = Validator::make($request->all(), $rules, $validatorMsg);
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

        $data['header'] = ProformaInvoiceModel::getProformaInvoice($request->id)->first();
        // $data['header']['t_proformainvoice_id'] = $request->id;
        // unset($data['header']['id']);
        $data['details'] = ProformaInvoiceDetailModel::getProformaInvoiceDetails($data['header']['t_proformainvoice_id'])->get();
        $data['companies'] = MasterModel::company_data();
        $data['addresses'] = MasterModel::get_address($data['header']['client_id']);
        $data['pics'] = MasterModel::get_pic($data['header']['client_id']);
        $data['currency']       = MasterModel::currency();
        $data['containers'] = BookingModel::get_container($data['header']['t_booking_id']);
        $data['goods'] = BookingModel::get_commodity($data['header']['t_booking_id']);

        // dd($data['header']);
        return view('invoice.add')->with($data);
    }

    public function save(Request $request)
    {
        // dd($request->all());
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
                't_proforma_invoice_id' => $request->t_proforma_invoice_id,
            ];

            $url = $previousUrl['path'] . '?' . http_build_query($errorParam);

            return redirect()->to($url);
        }

        try {
            DB::beginTransaction();

            $param = $request->all();
            $param['created_by'] = Auth::user()->name;
            $param['created_on'] = date('Y-m-d h:i:s');

            $invoice = InvoiceModel::saveInvoice($param);

            foreach ($request->detail as $key => $detail) {
                # code...
            }

        } catch (\Throwable $th) {
            $errorMsg = $th->getMessage();
            $previousUrl = parse_url(app('url')->previous());

            $errorParam = [
                'error' => '1',
                'errorMsg' => $errorMsg,
                '_token' => $request->_token,
                't_proforma_invoice_id' => $request->t_proforma_invoice_id,
            ];
            $url = $previousUrl['path'] . '?' . http_build_query($errorParam);

            return redirect()->to($url);
        }
    }

    public function save_cost(Request $request)
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

            if (isset($request->cek_cost_shp)) $errorParam['cek_cost_shp'] = $request->cek_cost_shp;
            if (isset($request->cek_cost_chrg)) $errorParam['cek_cost_chrg'] = $request->cek_cost_chrg;
            $url = $previousUrl['path'] . '?' . http_build_query($errorParam);

            return redirect()->to($url);
        }

        try {
            DB::beginTransaction();

            $param = $request->all();
            $invoice_id = DB::table('t_invoice_detail')->insertGetId([
                    'tipe_inv' => 1,
                    't_proforoma_invoice_id' => 0,
                    't_booking_id' => $request->t_booking_id,
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

            $paramDetail['id'] = '';
            $pno = 0;
            if (isset($request->cek_cost_shp)) {
                foreach ($request->cek_cost_shp as $key => $shp_dtl_id) {
                    $shp_dtl   = QuotationModel::get_quoteShippingById($shp_dtl_id);
                    DB::table('t_invoice_detail')->insert([
                            'invoice_id'     => $invoice_id,
                            'position_no'    => $pno++,//Position
                            't_booking_id'   => $id,
                            'position_no'    => $no++,
                            'desc'           => $shp_dtl->name_carrier,
                            'reimburse_flag' => $shp_dtl->reimburse_flag,
                            'currency'       => $shp_dtl->t_mcurrency_id,
                            'rate'           => $shp_dtl->rate,
                            'cost'           => $shp_dtl->cost,
                            'sell'           => $shp_dtl->sell,
                            'qty'            => $shp_dtl->qty,
                            'cost_val'       => $shp_dtl->cost_val,
                            'sell_val'       => $shp_dtl->sell_val,
                            'vat'            => $shp_dtl->vat,
                            'subtotal'       => ($shp_dtl->qty * $shp_dtl->sell_val)+$shp_dtl->vat,
                            'routing'        => $shp->routing,
                            'transit_time'   => $shp->transit_time,
                            'created_by'     => Auth::user()->name,
                            'created_on'     => date('Y-m-d h:i:s')
                        ]
                    );

                    $shpDtlParam['id'] = $shp_dtl_id;
                    $shpDtlParam['t_invoice_cost_id'] = $invoice_id;
                    // $shpDtlParam['invoice_type'] = $request->invoice_type;
                    $shpDtlParam['created_by'] = Auth::user()->name;
                    $shpDtlParam['created_on'] = date('Y-m-d h:i:s');
                    QuotationModel::saveShipDetail($shpDtlParam);
                }
            }

            if (isset($request->cek_sell_chrg)) {
                foreach ($request->cek_sell_chrg as $key => $chrg_dtl_id) {
                    $chrg_dtl       = BookingModel::getChargesDetailById($chrg_dtl_id);
                    // $paramDetail['t_mcharge_code_id'] = $chrg_dtl->t_mcharge_code_id;
                    DB::table('t_invoice_detail')->insert([
                            'invoice_id'     => $invoice_id,
                            'position_no'    => $pno++,//Position
                            't_booking_id'   => $id,
                            'position_no'    => $no++,
                            'desc'           => $chrg_dtl->name_carrier,
                            'reimburse_flag' => $chrg_dtl->reimburse_flag,
                            'currency'       => $chrg_dtl->t_mcurrency_id,
                            'rate'           => $chrg_dtl->rate,
                            'cost'           => $chrg_dtl->cost,
                            'sell'           => $chrg_dtl->sell,
                            'qty'            => $chrg_dtl->qty,
                            'cost_val'       => $chrg_dtl->cost_val,
                            'sell_val'       => $chrg_dtl->sell_val,
                            'vat'            => $chrg_dtl->vat,
                            'subtotal'       => ($chrg_dtl->qty * $chrg_dtl->sell_val)+$chrg_dtl->vat,
                            'routing'        => $shp->routing,
                            'transit_time'   => $shp->transit_time,
                            'created_by'     => Auth::user()->name,
                            'created_on'     => date('Y-m-d h:i:s')
                        ]
                    );

                    ProformaInvoiceDetailModel::saveProformaInvoiceDetail($paramDetail);

                    $chrgDtlParam['id'] = $chrg_dtl_id;
                    $chrgDtlParam['t_invoice_cost_id'] = $invoice_id;
                    // $chrgDtlParam['invoice_type'] = $request->invoice_type;
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
}
