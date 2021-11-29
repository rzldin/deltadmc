<?php

namespace App\Http\Controllers;

use App\BookingModel;
use App\InvoiceDetailModel;
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
        $invoices = InvoiceModel::getAllInvoice()->get();
        return view('invoice.list_invoice', compact('invoices'));
    }

    public function create(Request $request)
    {
        $data['proforma_header'] = ProformaInvoiceModel::getProformaInvoice($request->id)->first();
        $data['proforma_details'] = ProformaInvoiceDetailModel::getProformaInvoiceDetails($request->id)->get();
        $data['companies'] = MasterModel::company_data();
        $data['addresses'] = MasterModel::get_address($data['proforma_header']['client_id']);
        $data['pics'] = MasterModel::get_pic($data['proforma_header']['client_id']);
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
            $param['invoice_date'] = date('Y-m-d', strtotime($request->invoice_date));
            $param['onboard_date'] = date('Y-m-d', strtotime($request->onboard_date));
            $param['reimburse_flag'] = (($request->invoice_type == 'REM') ? 1 : 0);
            $param['debit_note_flag'] = (($request->invoice_type == 'DN') ? 1 : 0);
            $param['credit_note_flag'] = (($request->invoice_type == 'CN') ? 1 : 0);
            // $param['rate'] = 1;
            $param['created_by'] = Auth::user()->name;
            $param['created_on'] = date('Y-m-d h:i:s');

            $invoice = InvoiceModel::saveInvoice($param);

            $details = ProformaInvoiceDetailModel::getProformaInvoiceDetails($request->t_proforma_invoice_id)->get();
            foreach ($details as $key => $detail) {
                // dd($invoice->id);
                $paramDetail['id'] = 0;
                $paramDetail['invoice_id'] = $invoice->id;
                $paramDetail['t_mcharge_code_id'] = $detail->t_mcharge_code_id;
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
            }

            DB::commit();

            return redirect()->route('invoice.index')->with('success', 'Saved!');
        } catch (\Throwable $th) {
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
}
