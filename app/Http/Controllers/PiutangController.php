<?php

namespace App\Http\Controllers;

use App\BookingModel;
use App\ExternalInvoice;
use App\MasterModel;
use Illuminate\Http\Request;

class PiutangController extends Controller
{
    public function index(Request $request)
    {
        $data['search']['client_id'] = $request->client_id;
        $data['search']['booking_id'] = $request->booking_id;
        $data['search']['invoice_type'] = $request->invoice_type;
        $data['companies'] = MasterModel::company_data();
        $data['bookings'] = BookingModel::getAllBokingHasProforma()->get();
        $data['acc_receivables'] = ExternalInvoice::listAccountReceivables($data['search']['client_id'], $data['search']['booking_id'], $data['search']['invoice_type'], null)->get();

        return view('piutang.list_piutang')->with($data);
    }
}
