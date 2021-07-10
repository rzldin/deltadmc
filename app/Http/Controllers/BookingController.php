<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\QuotationModel;
use App\MasterModel;
use App\BookingModel;
use Carbon\Carbon;
use DB;

class BookingController extends Controller
{
    public function index()
    {
        return view('booking.list_booking');
    }

    public function add_booking($id)
    {
        $data['quote']  = BookingModel::get_bookingDetail($id)[0];
        $data['doc']    = MasterModel::get_doc();
        $data['company'] = MasterModel::company_data();
        $data['inco'] = MasterModel::incoterms_get();
        return view('booking.add_booking')->with($data);
    }

    public function header_booking($id)
    {
        $quote = QuotationModel::get_detailQuote($id);

        $data['quote']          = $quote;

        return view('booking.header_booking')->with($data);
        
    }

    public static function header_domestic($quote)
    {
        $data['quote']          = $quote;
        $data['doc']            = MasterModel::get_doc();
        $data['company']        = MasterModel::company_data();
        $data['inco']           = MasterModel::incoterms_get();
        $data['mbl_issued']     = MasterModel::get_mbl_issued();
        $data['currency']       = MasterModel::currency();
        $data['freight']        = MasterModel::freight_get();
        $data['port']           = MasterModel::port();
        $data['carrier']        = MasterModel::carrier();
        $data['shipper']        = DB::table('t_mcompany')->where('vendor_flag', 1)->get();
        $data['ppjk']           = DB::table('t_mcompany')->where('ppjk_flag', 1)->get();
        $data['agent']          = DB::table('t_mcompany')->where('agent_flag', 1)->get();
        $data['shipping_line']  = DB::table('t_mcompany')->where('shipping_line_flag', 1)->get();
        $data['vendor']         = DB::table('t_mcompany')->where('vendor_flag', 1)->get();
        $data['cust_addr']      = DB::table('t_maddress')->where('t_mcompany_id', $quote->customer_id)->get();
        $data['cust_pic']       = DB::table('t_mpic')->where('t_mcompany_id', $quote->customer_id)->get();
        return view('booking.view_header_domestic')->with($data);
    }

    public static function header_export($quote)
    {
        $data['quote']          = $quote;
        $data['doc']            = MasterModel::get_doc();
        $data['company']        = MasterModel::company_data();
        $data['inco']           = MasterModel::incoterms_get();
        $data['mbl_issued']     = MasterModel::get_mbl_issued();
        $data['currency']       = MasterModel::currency();
        $data['freight']        = MasterModel::freight_get();
        $data['port']           = MasterModel::port();
        $data['carrier']        = MasterModel::carrier();
        $data['shipper']        = DB::table('t_mcompany')->where('vendor_flag', 1)->get();
        $data['ppjk']           = DB::table('t_mcompany')->where('ppjk_flag', 1)->get();
        $data['agent']          = DB::table('t_mcompany')->where('agent_flag', 1)->get();
        $data['shipping_line']  = DB::table('t_mcompany')->where('shipping_line_flag', 1)->get();
        $data['vendor']         = DB::table('t_mcompany')->where('vendor_flag', 1)->get();
        $data['cust_addr']      = DB::table('t_maddress')->where('t_mcompany_id', $quote->customer_id)->get();
        $data['cust_pic']       = DB::table('t_mpic')->where('t_mcompany_id', $quote->customer_id)->get();
        return view('booking.view_header_export')->with($data);
    }

    public static function header_import($quote)
    {
        $data['quote'] = $quote;
        $data['doc']            = MasterModel::get_doc();
        $data['company']        = MasterModel::company_data();
        $data['inco']           = MasterModel::incoterms_get();
        $data['mbl_issued']     = MasterModel::get_mbl_issued();
        $data['currency']       = MasterModel::currency();
        $data['carrier']        = MasterModel::carrier();
        $data['freight']        = MasterModel::freight_get();
        $data['port']           = MasterModel::port();
        $data['shipper']        = DB::table('t_mcompany')->where('vendor_flag', 1)->get();
        $data['ppjk']           = DB::table('t_mcompany')->where('ppjk_flag', 1)->get();
        $data['agent']          = DB::table('t_mcompany')->where('agent_flag', 1)->get();
        $data['shipping_line']  = DB::table('t_mcompany')->where('shipping_line_flag', 1)->get();
        $data['vendor']         = DB::table('t_mcompany')->where('vendor_flag', 1)->get();
        $data['cust_addr']      = DB::table('t_maddress')->where('t_mcompany_id', $quote->customer_id)->get();
        $data['cust_pic']       = DB::table('t_mpic')->where('t_mcompany_id', $quote->customer_id)->get();
        return view('booking.view_header_import')->with($data);
    }

    public function booking_detail(Request $request)
    {
        $table = '';
        $table1 = '';
        $address = MasterModel::get_address($request['id']);
        $pic = MasterModel::get_pic($request['id']);
        $table .= '<option value="">-- Select Address --</option>';
        $table1 .= '<option value="">-- Select PIC --</option>';

        foreach($address as $addr)
        {
            $table .= '<option value="'.$addr->id.'">'.$addr->address.'</option>';
        }

        foreach($pic as $p)
        {
            $table1 .= '<option value="'.$p->id.'">'.$p->name.'</option>';
        }

        header('Content-Type: application/json');
        echo json_encode([$table, $table1]);
    }

    public function booking_doAdd(Request $request)
    {
        try{
            $user = Auth::user()->name;
            $tanggal = Carbon::now();
            $id =   DB::table('t_booking')->insertGetId([
                        't_quote_id'            => $request->id_quote,
                        'booking_no'            => $request->booking_no,
                        'booking_date'          => Carbon::parse($request->booking_date),
                        'version_no'            => $request->version_no,
                        'activity'              => $request->activity,
                        't_mdoc_type_id'        => $request->doctype,
                        'custom_doc_no'         => $request->doc_no,
                        'custom_doc_date'       => Carbon::parse($request->doc_date),
                        'igm_no'                => $request->igm_number,
                        'igm_date'              => $request->igm_date,
                        'custom_pos'            => $request->pos,
                        'custom_subpos'         => $request->sub_pos,
                        'client_id'             => $request->customer,
                        'client_addr_id'        => $request->customer_addr,
                        'client_pic_id'         => $request->customer_pic,
                        'shipper_id'            => $request->shipper,
                        'shipper_addr_id'       => $request->shipper_addr,
                        'shipper_pic_id'        => $request->shipper_pic,
                        'consignee_id'          => $request->consignee,
                        'consignee_addr_id'     => $request->consignee_addr,
                        'consignee_pic_id'      => $request->consignee_pic,
                        'not_party_id'          => $request->notify_party,
                        'not_party_addr_id'     => $request->not_addr,
                        'not_party_pic_id'      => $request->not_pic,
                        'agent_id'              => $request->agent,
                        'agent_addr_id'         => $request->agent_addr,
                        'agent_pic_id'          => $request->agent_pic,
                        'shipping_line_id'      => $request->shipping_line,
                        'shpline_addr_id'       => $request->shipline_addr,
                        'shpline_pic_id'        => $request->shipline_pic,
                        'vendor_id'             => $request->vendor,
                        'vendor_addr_id'        => $request->vendor_addr,
                        'vendor_pic_id'         => $request->vendor_pic,
                        'carrier_id'            => $request->carrier,
                        'eta_date'              => Carbon::parse($request->eta),
                        'etd_date'              => Carbon::parse($request->etd),
                        'place_origin'          => $request->pfo,
                        'place_destination'     => $request->pod,
                        'pol_id'                => $request->pol,
                        'pol_custom_desc'       => $request->pol_desc,
                        'pod_id'                => $request->podisc,
                        'pod_custom_desc'       => $request->pod_desc,
                        'pot_id'                => $request->pot,
                        'fumigation_flag'       => $request->fumigation,
                        'insurance_flag'        => $request->insurance,
                        't_mincoterms_id'       => $request->incoterms,
                        't_mfreight_charges_id' => $request->freight_charges,
                        'place_payment'         => $request->pop,
                        'valuta_payment'        => $request->valuta_payment,
                        'value_prepaid'         => $request->vop,
                        'value_collect'         => $request->voc,
                        'freetime_detention'    => $request->fod,
                        'stuffing_date'         => Carbon::parse($request->stuf_date),
                        'stuffing_place'        => $request->posx,
                        'delivery_of_goods'     => $request->dogs,
                        'valuta_comm'           => $request->valuta_com,
                        'value_comm'            => $request->value_commodity,
                        'rates_comm'            => $request->exchange_rate,
                        'exchange_valuta_comm'  => $request->exchange_valuta,
                        'remarks'               => $request->remarks,
                        'mbl_shipper'           => $request->shipper_mbl,
                        'mbl_consignee'         => $request->cons_mbl,
                        'mbl_not_party'         => $request->notify_mbl,
                        'mbl_no'                => $request->mbl_number,
                        'mbl_date'              => Carbon::parse($request->mbl_date),
                        'valuta_mbl'            => $request->valuta_mbl,
                        'hbl_shipper'           => $request->shipper_hbl,
                        'hbl_consignee'         => $request->cons_hbl,
                        'hbl_not_party'         => $request->notify_hbl,
                        'hbl_no'                => $request->hbl_number,
                        'hbl_date'              => Carbon::parse($request->hbl_date),
                        'valuta_hbl'            => $request->valuta_hbl,
                        't_mbl_issued_id'       => $request->mbl_issued,
                        'created_by'            => $user,
                        'created_on'            => $tanggal
                    ]);
            return redirect('booking/add_booking/'.$id)->with('status', 'Successfully added');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }
}
