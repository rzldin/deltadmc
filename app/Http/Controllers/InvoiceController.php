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
}
