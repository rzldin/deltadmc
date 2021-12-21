<?php

namespace App\Http\Controllers;

use App\BookingModel;
use App\ExternalInvoice;
use App\ExternalInvoiceDetail;
use App\MasterModel;
use App\ProformaInvoiceDetailModel;
use App\ProformaInvoiceModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ExternalInvoiceController extends Controller
{
    public function index()
    {
        $external_invoices = ExternalInvoice::getAllExternalInvoice()->get();
        return view('external_invoice.list_external_invoice', compact('external_invoices'));
    }

    public function create($proformaInvoiceId)
    {
        $data['proforma_invoice_header'] = ProformaInvoiceModel::getProformaInvoice($proformaInvoiceId)->first();
        $data['proforma_invoice_details'] = ProformaInvoiceDetailModel::getProformaInvoiceDetails($proformaInvoiceId)->get();
        $data['companies'] = MasterModel::company_data();
        $data['addresses'] = MasterModel::get_address($data['proforma_invoice_header']['client_id']);
        $data['pics'] = MasterModel::get_pic($data['proforma_invoice_header']['client_id']);
        $data['currency']       = MasterModel::currency();
        $data['containers'] = BookingModel::get_container($data['proforma_invoice_header']['t_booking_id']);
        $data['goods'] = BookingModel::get_commodity($data['proforma_invoice_header']['t_booking_id']);
        $data['charges'] = MasterModel::charge();

        return view('external_invoice.add_external_invoice')->with($data);
    }

    public function save(Request $request)
    {
        // dd($request->all());
        $rules = [
            'client_id' => 'required',
            'external_invoice_no' => 'required|unique:t_external_invoice',
            'external_invoice_date' => 'required',
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
            $total_invoice = 0;
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

                $total_invoice += $detail['subtotal'];
                ExternalInvoiceDetail::saveExternalInvoiceDetail($paramDetail);
            }

            DB::table('t_external_invoice')->where('id', $invoice->id)->update([
                'total_invoice' => $total_invoice
            ]);
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
