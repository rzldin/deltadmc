<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\QuotationModel;
use App\MasterModel;

class BookingController extends Controller
{
    public function index()
    {
        return view('booking.list_booking');
    }

    public function add_booking($id)
    {
        $quote = QuotationModel::get_detailQuote($id);

        $data['quote']  = $quote;
        $data['doc']    = MasterModel::get_doc();
        $data['company'] = MasterModel::company_data();
        $data['inco'] = MasterModel::incoterms_get();
        return view('booking.add_booking')->with($data);
    }
}
