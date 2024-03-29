<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\SiteHelpers;
use App\QuotationModel;
use App\MasterModel;
use App\BookingModel;
use Carbon\Carbon;
use DB;
use PDF;

class BookingController extends Controller
{
    public function index()
    {
        if(isset($_GET['status'])){
            $data['list'] = BookingModel::get_booking_status($_GET['status']);
        }else{
            $data['list'] = BookingModel::get_booking();
        }
        return view('booking.list_booking', $data);
    }

    public function edit_booking($id)
    {
        $data['responsibility'] = SiteHelpers::getUserRole();
        $data['booking']        = BookingModel::get_booking_header($id);
        $data['quote']          = BookingModel::get_bookingDetail($id)[0];
        if($data['booking']->status != 9){
            $data['doc']            = MasterModel::get_doc();
            $data['loaded']         = MasterModel::loaded_get();
            $data['loadedc']        = MasterModel::loadedc_get();
            $data['company']        = MasterModel::company_data();
            $data['inco']           = MasterModel::incoterms_get();
            $data['uom']            = MasterModel::uom();
            $data['container']      = MasterModel::container_get();
            $data['vehicle_type']   = MasterModel::vehicleType_get();
            $data['vehicle']        = MasterModel::vehicle();
            $data['schedule']       = MasterModel::schedule_get();
            $data['error']          = (isset($_GET['error']) ? 1 : 0);
            $data['errorMsg']       = (isset($_GET['errorMsg']) ? $_GET['errorMsg'] : '');
            $data['success']        = (isset($_GET['success']) ? 1 : 0);
            $data['successMsg']     = (isset($_GET['successMsg']) ? $_GET['successMsg'] : '');
            $data['charge']         = MasterModel::charge();
            $data['currency']       = MasterModel::currency();
            $data['list_account']   = MasterModel::account_get();
            $data['list_country']   = MasterModel::country();
            $data['user'] = MasterModel::users_get(Auth::user()->id);
            $sales = DB::table('t_mmatrix')
            ->leftJoin('users', 't_mmatrix.t_muser_id', '=', 'users.id')
            ->leftJoin('t_mresponsibility', 't_mmatrix.t_mresponsibility_id', '=', 't_mresponsibility.id')
            ->select('users.name as user_name', 'users.id as user_id')
            ->where('t_mresponsibility.responsibility_name', ['Administrator', 'Sales'])
            ->where('t_mmatrix.active_flag', '1')->get();
            $data['list_sales']     = $sales;

            return view('booking.edit_booking')->with($data);
        }else{
            return view('booking.booking_cancel')->with($data);
        }
    }

    public function header_booking($id)
    {
        $sales = DB::table('t_mmatrix')
        ->leftJoin('users', 't_mmatrix.t_muser_id', '=', 'users.id')
        ->leftJoin('t_mresponsibility', 't_mmatrix.t_mresponsibility_id', '=', 't_mresponsibility.id')
        ->select('users.name as user_name', 'users.id as user_id')
        ->where('t_mresponsibility.responsibility_name', ['Administrator', 'Sales'])
        ->where('t_mmatrix.active_flag', '1')->get();

        $quote                  = QuotationModel::get_detailQuote($id);
        $shipping               = QuotationModel::get_quoteShipping($id);
        $obj_merge              = (object) array_merge((array)$quote, (array("nomination_flag"=>0)), (array("carrier_id"=>$shipping[0]->t_mcarrier_id)));
        $data['quote']          = $obj_merge;
        $data['shipping']       = $shipping;
        $data['list_account']   = MasterModel::account_get();
        $data['list_country']   = MasterModel::country();
        $data['list_sales']     = $sales;
        return view('booking.header_booking')->with($data);
    }

    public function nomination()
    {
        $data['doc']            = MasterModel::get_doc();
        $data['loaded']         = MasterModel::loaded_get();
        $data['company']        = MasterModel::company_data();
        $data['cust_addr']      = DB::table('t_maddress')->get();
        $data['cust_pic']       = DB::table('t_mpic')->get();
        $data['carrier']        = MasterModel::carrier();
        $data['currency']       = MasterModel::currency();
        $data['freight']        = MasterModel::freight_get();
        $data['mbl_issued']     = MasterModel::get_mbl_issued();
        $data['inco']           = MasterModel::incoterms_get();
        return view('booking.nomination')->with($data);
    }

    public static function header_domestic($quote)
    {
        $data['quote']          = $quote;
        $data['loaded']         = MasterModel::loaded_get();
        $data['doc']            = MasterModel::get_doc();
        $data['company']        = MasterModel::company_data();
        $data['inco']           = MasterModel::incoterms_get();
        $data['mbl_issued']     = MasterModel::get_mbl_issued();
        $data['currency']       = MasterModel::currency();
        $data['freight']        = MasterModel::freight_get();
        $data['port']           = MasterModel::port();
        $data['carrier']        = MasterModel::carrier();
        $data['cust_addr']      = DB::table('t_maddress')->where('t_mcompany_id', $quote->customer_id)->get();
        $data['cust_pic']       = DB::table('t_mpic')->where('t_mcompany_id', $quote->customer_id)->get();
        return view('booking.view_header_domestic')->with($data);
    }

    public static function header_export($quote)
    {
        $data['quote']          = $quote;
        $data['loaded']         = MasterModel::loaded_get();
        $data['doc']            = MasterModel::get_doc();
        $data['company']        = MasterModel::company_data();
        $data['inco']           = MasterModel::incoterms_get();
        $data['mbl_issued']     = MasterModel::get_mbl_issued();
        $data['currency']       = MasterModel::currency();
        $data['freight']        = MasterModel::freight_get();
        $data['port']           = MasterModel::port();
        $data['carrier']        = MasterModel::carrier();
        $data['cust_addr']      = DB::table('t_maddress')->where('t_mcompany_id', $quote->customer_id)->get();
        $data['cust_pic']       = DB::table('t_mpic')->where('t_mcompany_id', $quote->customer_id)->get();
        return view('booking.view_header_export')->with($data);
    }

    public static function header_import($quote)
    {
        $data['quote']          = $quote;
        $data['loaded']         = MasterModel::loaded_get();
        $data['loadedc']        = MasterModel::loadedc_get();
        $data['doc']            = MasterModel::get_doc();
        $data['company']        = MasterModel::company_data();
        $data['inco']           = MasterModel::incoterms_get();
        $data['mbl_issued']     = MasterModel::get_mbl_issued();
        $data['currency']       = MasterModel::currency();
        $data['carrier']        = MasterModel::carrier();
        $data['freight']        = MasterModel::freight_get();
        $data['port']           = MasterModel::port();
        $data['cust_addr']      = DB::table('t_maddress')->where('t_mcompany_id', $quote->customer_id)->get();
        $data['cust_pic']       = DB::table('t_mpic')->where('t_mcompany_id', $quote->customer_id)->get();
        return view('booking.view_header_import')->with($data);
    }

    public static function edit_header_domestic($quote,$verse)
    {
        $data['quote']          = $quote;
        $data['loaded']         = MasterModel::loaded_get();
        $data['loadedc']        = MasterModel::loadedc_get();
        $data['doc']            = MasterModel::get_doc();
        $data['company']        = MasterModel::company_data();
        $data['inco']           = MasterModel::incoterms_get();
        $data['mbl_issued']     = MasterModel::get_mbl_issued();
        $data['currency']       = MasterModel::currency();
        $data['freight']        = MasterModel::freight_get();
        $data['port']           = MasterModel::port();
        $data['carrier']        = MasterModel::carrier();
        $data['verse']          = $verse;
        $data['cust_addr']      = DB::table('t_maddress')->where('t_mcompany_id', $quote->client_id)->get();
        $data['cust_pic']       = DB::table('t_mpic')->where('t_mcompany_id', $quote->client_id)->get();
        return view('booking.edit_header_domestic')->with($data);
    }

    public static function edit_header_export($quote, $verse)
    {
        $data['quote']          = $quote;
        $data['loaded']         = MasterModel::loaded_get();
        $data['loadedc']        = MasterModel::loadedc_get();
        $data['doc']            = MasterModel::get_doc();
        $data['company']        = MasterModel::company_data();
        $data['inco']           = MasterModel::incoterms_get();
        $data['mbl_issued']     = MasterModel::get_mbl_issued();
        $data['currency']       = MasterModel::currency();
        $data['freight']        = MasterModel::freight_get();
        $data['port']           = MasterModel::port();
        $data['carrier']        = MasterModel::carrier();
        $data['verse']          = $verse;
        $data['cust_addr']      = DB::table('t_maddress')->where('t_mcompany_id', $quote->client_id)->get();
        $data['cust_pic']       = DB::table('t_mpic')->where('t_mcompany_id', $quote->client_id)->get();
        return view('booking.edit_header_export')->with($data);
    }

    public static function edit_header_import($quote, $verse)
    {
        $data['quote']          = $quote;
        $data['loaded']         = MasterModel::loaded_get();
        $data['loadedc']        = MasterModel::loadedc_get();
        $data['doc']            = MasterModel::get_doc();
        $data['company']        = MasterModel::company_data();
        $data['inco']           = MasterModel::incoterms_get();
        $data['mbl_issued']     = MasterModel::get_mbl_issued();
        $data['currency']       = MasterModel::currency();
        $data['freight']        = MasterModel::freight_get();
        $data['port']           = MasterModel::port();
        $data['carrier']        = MasterModel::carrier();
        $data['verse']          = $verse;
        $data['cust_addr']      = DB::table('t_maddress')->where('t_mcompany_id', $quote->client_id)->get();
        $data['cust_pic']       = DB::table('t_mpic')->where('t_mcompany_id', $quote->client_id)->get();
        return view('booking.edit_header_import')->with($data);
    }

    public function booking_detail(Request $request)
    {
        $table = '';
        $table1 = '';
        $address = MasterModel::get_address($request->id);
        $pic = MasterModel::get_pic($request->id);
        $table2 = MasterModel::company_get($request->id);

        foreach($address as $addr)
        {
            if($request->addr_id == $addr->id){
                $status = 'selected';
            }else{
                $status = '';
            }

            $table .= '<option value="'.$addr->id.'"'.$status.'>'.$addr->address.'</option>';
        }

        foreach($pic as $p)
        {
            if($request->pic_id == $p->id){
                $status = 'selected';
            }else{
                $status = '';
            }

            $table1 .= '<option value="'.$p->id.'"'.$status.'>'.$p->name.'</option>';
        }

        header('Content-Type: application/json');
        echo json_encode([$table, $table1, $table2]);
    }

    public function booking_loadCarrier(Request $request)
    {
        $table = '';
        $table1 = '';
        $carrier = MasterModel::carrier();

        foreach($carrier as $val)
        {
            if($request->carrier_id == $val->id){
                $status = 'selected';
            }else{
                $status = '';
            }

            $table .= '<option value="'.$val->id.'"'.$status.'>'.$val->name.'</option>';
        }

        header('Content-Type: application/json');
        echo json_encode([$table]);
    }

    public function booking_doAdd(Request $request)
    {
        // dd($request->all());
        if($request->id_quote !== null){
            $shipping   = QuotationModel::get_quoteShipping($request->id_quote);
            $dtlQuote   = QuotationModel::get_quoteDetail($request->id_quote);
            $shp = $shipping[0];
        }

        $no = 1;

        if($request->quote_no == 'Nomination'){
            $nomination_flag = 1;
            if($request->activity == 'export'){
                $request->posx = $request->posx_export;
                $request->dogs = $request->dogs_export;
                $request->stuf_date = $request->stuf_date_export;
            }else if($request->activity == 'domestic'){
                $request->posx = $request->posx_domestic;
                $request->dogs = $request->dogs_domestic;
                $request->stuf_date = $request->stuf_date_domestic;
            }
        }else{
            $nomination_flag = 0;
        }

        #Doc Date
        if($request->doc_date != null){
            $doc_date = Carbon::createFromFormat('d/m/Y', $request->doc_date)->format('Y-m-d');
        }else{
            $doc_date = null;
        }

        #Igm Date
        if($request->igm_date != null){
            $igm_date = Carbon::createFromFormat('d/m/Y', $request->igm_date)->format('Y-m-d');
        }else{
            $igm_date = null;
        }

        #Mbl Date
        if($request->mbl_date != null){
            $mbl_date = Carbon::createFromFormat('d/m/Y', $request->mbl_date)->format('Y-m-d');
        }else{
            $mbl_date = null;
        }

        #Hbl Date
        if($request->hbl_date != null){
            $hbl_date = Carbon::createFromFormat('d/m/Y', $request->hbl_date)->format('Y-m-d');
        }else{
            $hbl_date = null;
        }

        if($request->stuf_date !== null){
            $stuf_date = Carbon::createFromFormat('d/m/Y', $request->stuf_date)->format('Y-m-d');
        }else{
            $stuf_date = null;
        }

        if($request->eta_date !== null){
            $eta_date = Carbon::createFromFormat('d/m/Y', $request->eta_date)->format('Y-m-d');
        }else{
            $eta_date = null;
        }

        if($request->etd_date !== null){
            $etd_date = Carbon::createFromFormat('d/m/Y', $request->etd_date)->format('Y-m-d');
        }else{
            $etd_date = null;
        }

        DB::beginTransaction();
        try{
            $user = Auth::user()->name;
            $tanggal = Carbon::now();
            $id =   DB::table('t_booking')->insertGetId([
                        't_quote_id'            => $request->id_quote,
                        'booking_no'            => $request->booking_no,
                        'nomor_si'              => $request->nomor_si,
                        'booking_date'          => Carbon::createFromFormat('d/m/Y', $request->booking_date)->format('Y-m-d'),
                        'version_no'            => $request->version_no,
                        'activity'              => $request->activity,
                        'shipment_by'           => $request->shipment_by,
                        'nomination_flag'       => $nomination_flag,
                        't_mdoc_type_id'        => $request->doctype,
                        't_mloaded_type_id'     => $request->t_mloaded_type_id,
                        'custom_doc_no'         => $request->doc_no,
                        'custom_doc_date'       => $doc_date,
                        'igm_no'                => $request->igm_number,
                        'igm_date'              => $igm_date,
                        'custom_pos'            => $request->pos,
                        'custom_subpos'         => $request->sub_pos,
                        'client_id'             => $request->customer_add,
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
                        'also_nf_id'            => $request->also_notify_party,
                        'also_nf_addr_id'       => $request->also_not_addr,
                        'also_nf_pic_id'        => $request->also_not_pic,
                        'mbl_also_notify_party' => $request->mbl_also_notify_party,
                        'hbl_also_notify_party' => $request->hbl_also_notify_party,
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
                        'flight_number'         => $request->voyage,
                        'carrier_id_2'          => $request->carrier_2,
                        'flight_number_2'       => $request->voyage_2,
                        'carrier_id_3'          => $request->carrier_3,
                        'flight_number_3'       => $request->voyage_3,
                        'conn_vessel'           => $request->conn_vessel,
                        'eta_date'              => $eta_date,
                        'etd_date'              => $etd_date,
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
                        'stuffing_date'         => $stuf_date,
                        'stuffing_place'        => $request->posx,
                        'delivery_of_goods'     => $request->dogs,
                        'valuta_comm'           => $request->valuta_com,
                        'value_comm'            => $request->value_commodity,
                        'rates_comm'            => $request->exchange_rate,
                        'exchange_valuta_comm'  => $request->exchange_valuta,
                        'remarks'               => $request->remarks,
                        'mbl_shipper'           => $request->shipper_mbl,
                        'mbl_consignee'         => $request->cons_mbl,
                        'mbl_desc'              => $request->desc_mbl,
                        'mbl_not_party'         => $request->notify_mbl,
                        'mbl_desc'              => $request->desc_mbl,
                        'mbl_no'                => $request->mbl_number,
                        'mbl_date'              => $mbl_date,
                        'mbl_marks_nos'         => $request->mbl_marks_nos,
                        'valuta_mbl'            => $request->valuta_mbl,
                        'hbl_shipper'           => $request->shipper_hbl,
                        'hbl_consignee'         => $request->cons_hbl,
                        'hbl_not_party'         => $request->notify_hbl,
                        'hbl_no'                => $request->hbl_number,
                        'hbl_desc'              => $request->desc_hbl,
                        'hbl_date'              => $hbl_date,
                        'hbl_marks_nos'         => $request->hbl_marks_nos,
                        'delivery_agent_detail' => $request->delivery_agent_detail,
                        'valuta_hbl'            => $request->valuta_hbl,
                        't_mbl_issued_id'       => $request->mbl_issued,
                        't_hbl_issued_id'       => $request->hbl_issued,
                        'total_commodity'       => $request->total_commo,
                        'total_package'         => $request->total_package,
                        'total_container'       => $request->total_container,
                        't_mcloaded_type_id'    => $request->loadedc,
                        'created_by'            => $user,
                        'created_on'            => $tanggal
                    ]);

                    if($request->id_quote !== null){
                        if($shp->shipment_by == 'SEA'){
                            $t_mcharge_code_id = 5;
                        }elseif($shp->shipment_by == 'AIR'){
                            $t_mcharge_code_id = 7;
                        }else{
                            $t_mcharge_code_id = 1;
                        }

                        #Insert Charges Detail
                        $ship = DB::table('t_bcharges_dtl')
                            ->insertGetId([
                                't_booking_id'          => $id,
                                'position_no'           => $no++,
                                't_mcharge_code_id'     => $t_mcharge_code_id,
                                't_mcarrier_id'         => $shp->t_mcarrier_id,
                                // 'desc'                  => $shp->name_carrier,
                                'desc'                  => $shp->notes.' | Routing: '.$shp->routing.' | Transit time : '.$shp->transit_time,
                                'reimburse_flag'        => 0,
                                'currency'              => $shp->t_mcurrency_id,
                                'rate'                  => $shp->rate,
                                'cost'                  => $shp->cost,
                                'sell'                  => $shp->sell,
                                'qty'                   => $shp->qty,
                                'cost_val'              => $shp->cost_val,
                                'sell_val'              => $shp->sell_val,
                                'vat'                   => $shp->vat,
                                'subtotal'              => ($shp->qty * $shp->sell_val)+$shp->vat,
                                'routing'               => $shp->routing,
                                'transit_time'          => $shp->transit_time,
                                'flag_shp'              => 1, // Flag bedain kalau ini dari shipping
                                'created_by'            => $user,
                                'created_on'            => $tanggal
                            ]);


                        $total = ($shp->qty * $shp->cost);
                        $total2 = ($shp->qty * $shp->sell);
                        $amount = ($total * $shp->rate) + $shp->vat;
                        $amount2 = ($total2 * $shp->rate) + $shp->vat;
                        $totalCost = $amount + (($shp->qty * $shp->cost) * $shp->rate) + $shp->vat;
                        $totalSell = $amount2 + (($shp->qty * $shp->sell) * $shp->rate) + $shp->vat;

                        foreach($dtlQuote as $row)
                        {
                            DB::table('t_bcharges_dtl')
                            ->insert([
                                't_booking_id'          => $id,
                                'position_no'           => $no++,
                                't_mcharge_code_id'     => $row->t_mcharge_code_id,
                                // 'desc'                  => $shp->name_carrier,
                                'desc'                  => $row->desc,
                                'reimburse_flag'        => $row->reimburse_flag,
                                'currency'              => $row->t_mcurrency_id,
                                'rate'                  => $row->rate,
                                'cost'                  => $row->cost,
                                'sell'                  => $row->sell,
                                'qty'                   => $row->qty,
                                'cost_val'              => $row->cost_val,
                                'sell_val'              => $row->sell_val,
                                'vat'                   => $row->vat,
                                'subtotal'              => ($row->qty * $row->sell_val)+$row->vat,
                                'routing'               => $shp->routing,
                                'transit_time'          => $shp->transit_time,
                                'created_by'            => $user,
                                'created_on'            => $tanggal
                            ]);

                            $total = ($row->qty * $row->cost);
                            $total2 = ($row->qty * $row->sell);
                            $amount = ($total * $row->rate) + $row->vat;
                            $amount2 = ($total2 * $row->rate) + $row->vat;
                            $totalCost += $amount + (($row->qty * $row->cost) * $row->rate) + $row->vat;
                            $totalSell += $amount2 + (($row->qty * $row->sell) * $row->rate) + $shp->vat;

                        }
                        $currency = $shp->t_mcurrency_id;
                        $profitAll = $totalSell - $totalCost;
                        $profitPct = ($profitAll*100)/$totalSell;
                    }else{
                        $ship = 0;
                        $currency = 0;
                        $totalCost = 0;
                        $totalSell = 0;
                        $profitAll = 0;
                        $profitPct = 0;
                    }

            DB::table('t_booking_profit')->insert([
                't_booking_id' => $id,
                't_bcharges_id' => $ship,
                't_mcurrency_id' => $currency,
                'total_cost' => $totalCost,
                'total_sell' => $totalSell,
                'total_profit' => $profitAll,
                'profit_pct' => $profitPct,
                'created_by' => $user,
                'created_on' => $tanggal
            ]);
            DB::commit();
            return redirect('booking/edit_booking/'.$id)->with('status', 'Successfully added');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }

    public function booking_doAddVersion(Request $request)
    {
        DB::beginTransaction();
        $shipping   = QuotationModel::get_quoteShipping($request->id_quote);
        // $dtlQuote   = QuotationModel::get_quoteDetail($request->id_quote);
        $shp = $shipping[0];
        $no = 1;

        if($request->quote_no == 'Nomination'){
            $nomination_flag = 1;
        }else{
            $nomination_flag = 0;
        }

        #Doc Date
        if($request->doc_date != null){
            $doc_date = Carbon::createFromFormat('d/m/Y', $request->doc_date)->format('Y-m-d');
        }else{
            $doc_date = null;
        }

        #Igm Date
        if($request->igm_date != null){
            $igm_date = Carbon::createFromFormat('d/m/Y', $request->igm_date)->format('Y-m-d');
        }else{
            $igm_date = null;
        }

        #Mbl Date
        if($request->mbl_date != null){
            $mbl_date = Carbon::createFromFormat('d/m/Y', $request->mbl_date)->format('Y-m-d');
        }else{
            $mbl_date = null;
        }

        #Hbl Date
        if($request->hbl_date != null){
            $hbl_date = Carbon::createFromFormat('d/m/Y', $request->hbl_date)->format('Y-m-d');
        }else{
            $hbl_date = null;
        }

        if($request->stuf_date !== null){
            $stuf_date = Carbon::createFromFormat('d/m/Y', $request->stuf_date)->format('Y-m-d');
        }else{
            $stuf_date = null;
        }

        if($request->eta !== null){
            $eta_date = Carbon::createFromFormat('d/m/Y', $request->eta)->format('Y-m-d');
        }else{
            $eta_date = null;
        }

        if($request->etd !== null){
            $etd_date = Carbon::createFromFormat('d/m/Y', $request->etd)->format('Y-m-d');
        }else{
            $etd_date = null;
        }

        try{
            $user = Auth::user()->name;
            $tanggal = Carbon::now();
            $id =   DB::table('t_booking')->insertGetId([
                        't_quote_id'            => $request->id_quote,
                        'booking_no'            => $request->booking_no,
                        'nomor_si'              => $request->nomor_si,
                        'booking_date'          => Carbon::createFromFormat('d/m/Y', $request->booking_date)->format('Y-m-d'),
                        'version_no'            => $request->version_no,
                        'activity'              => $request->activity,
                        'shipment_by'           => $request->shipment_by,
                        'nomination_flag'       => $nomination_flag,
                        't_mdoc_type_id'        => $request->doctype,
                        'custom_doc_no'         => $request->doc_no,
                        'custom_doc_date'       => $doc_date,
                        'igm_no'                => $request->igm_number,
                        'igm_date'              => $igm_date,
                        'custom_pos'            => $request->pos,
                        'custom_subpos'         => $request->sub_pos,
                        'client_id'             => $request->customer_add,
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
                        'also_nf_id'            => $request->also_notify_party,
                        'also_nf_addr_id'       => $request->also_not_addr,
                        'also_nf_pic_id'        => $request->also_not_pic,
                        'mbl_also_notify_party' => $request->mbl_also_notify_party,
                        'hbl_also_notify_party' => $request->hbl_also_notify_party,
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
                        'flight_number'         => $request->voyage,
                        'carrier_id_2'          => $request->carrier_2,
                        'flight_number_2'       => $request->voyage_2,
                        'carrier_id_3'          => $request->carrier_3,
                        'flight_number_3'       => $request->voyage_3,
                        'conn_vessel'           => $request->conn_vessel,
                        'eta_date'              => $eta_date,
                        'etd_date'              => $etd_date,
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
                        'stuffing_date'         => $stuf_date,
                        'stuffing_place'        => $request->posx,
                        'delivery_of_goods'     => $request->dogs,
                        'valuta_comm'           => $request->valuta_com,
                        'value_comm'            => $request->value_commodity,
                        'rates_comm'            => $request->exchange_rate,
                        'exchange_valuta_comm'  => $request->exchange_valuta,
                        'remarks'               => $request->remarks,
                        'mbl_shipper'           => $request->shipper_mbl,
                        'mbl_consignee'         => $request->cons_mbl,
                        'mbl_desc'              => $request->desc_mbl,
                        'mbl_not_party'         => $request->notify_mbl,
                        'mbl_desc'              => $request->desc_mbl,
                        'mbl_no'                => $request->mbl_number,
                        'mbl_date'              => $mbl_date,
                        'mbl_marks_nos'         => $request->mbl_marks_nos,
                        'valuta_mbl'            => $request->valuta_mbl,
                        'hbl_shipper'           => $request->shipper_hbl,
                        'hbl_consignee'         => $request->cons_hbl,
                        'hbl_not_party'         => $request->notify_hbl,
                        'hbl_no'                => $request->hbl_number,
                        'hbl_desc'              => $request->desc_hbl,
                        'hbl_date'              => $hbl_date,
                        'hbl_marks_nos'         => $request->hbl_marks_nos,
                        'delivery_agent_detail' => $request->delivery_agent_detail,
                        'trucking_company'      => $request->trucking_company,
                        'jenis'                 => $request->jenis,
                        'valuta_hbl'            => $request->valuta_hbl,
                        't_mbl_issued_id'       => $request->mbl_issued,
                        't_hbl_issued_id'       => $request->hbl_issued,
                        'total_commodity'       => $request->total_commo,
                        'total_package'         => $request->total_package,
                        'total_container'       => $request->total_container,
                        't_mcloaded_type_id'    => $request->loadedc,
                        'created_by'            => $user,
                        'created_on'            => $tanggal
                    ]);


                    #Insert Commodity
                    $commodity  = BookingModel::get_commodity($request->booking_idx);

                    foreach($commodity as $row)
                    {
                        DB::table('t_bcommodity')
                        ->insert([
                            't_booking_id'      => $id,
                            'position_no'       => $row->position_no,
                            'hs_code'           => $row->hs_code,
                            'desc'              => $row->desc,
                            'origin'            => $row->origin,
                            'qty_comm'          => $row->qty_comm,
                            'uom_comm'          => $row->uom_comm,
                            'qty_packages'      => $row->qty_packages,
                            'uom_packages'      => $row->uom_packages,
                            'weight'            => $row->weight,
                            'weight_uom'        => $row->weight_uom,
                            'netto'             => $row->netto,
                            'volume'            => $row->volume,
                            'volume_uom'        => $row->volume_uom,
                            'created_by'        => $user,
                            'created_on'        => $tanggal
                        ]);
                    }

                    #Insert Packages
                    $packages   = BookingModel::get_packages($request->booking_idx);

                    foreach($packages as $row)
                    {
                        DB::table('t_bpackages')
                        ->insert([
                            't_booking_id'      => $id,
                            'position_no'       => $row->position_no,
                            'desc'              => $row->desc,
                            'qty'               => $row->qty,
                            'qty_uom'           => $row->qty_uom,
                            'created_by'        => $user,
                            'created_on'        => $tanggal
                        ]);
                    }

                    #Insert Container
                    $container  = BookingModel::get_container($request->booking_idx);

                    foreach($container as $row)
                    {
                        DB::table('t_bcontainer')
                        ->insert([
                            't_booking_id'          => $id,
                            'container_no'          => $row->container_no,
                            'size'                  => $row->size,
                            't_mloaded_type_id'     => $row->t_mloaded_type_id,
                            't_mcontainer_type_id'  => $row->t_mcontainer_type_id,
                            'seal_no'               => $row->seal_no,
                            'vgm'                   => $row->vgm,
                            'vgm_uom'               => $row->vgm_uom,
                            'responsible_party'     => $row->responsible_party,
                            'authorized_person'     => $row->authorized_person,
                            'method_of_weighing'    => $row->method_of_weighing,
                            'weighing_party'        => $row->weighing_party,
                            'created_by'            => $user,
                            'created_on'            => $tanggal
                        ]);
                    }

                    #Insert Doc
                    $doc        = BookingModel::get_document($request->booking_idx);

                    foreach($doc as $row)

                    {
                        DB::table('t_bdocument')
                        ->insert([
                            't_booking_id'          => $id,
                            't_mdoc_type_id'        => $row->t_mdoc_type_id,
                            'doc_no'                => $row->doc_no,
                            'doc_date'              => $doc_date,
                            'created_by'            => $user,
                            'created_on'            => $tanggal
                        ]);
                    }

                    #Insert Road Cons
                    $roadCons   = BookingModel::getRoadCons($request->booking_idx);

                    foreach($roadCons as $row)
                    {
                        DB::table('t_broad_cons')->insert([
                            't_booking_id'          => $id,
                            'no_sj'                 => $row->no_sj,
                            't_mvehicle_type_id'    => $row->t_mvehicle_type_id,
                            't_mvehicle_id'         => $row->t_mvehicle_id,
                            'driver'                => $row->driver,
                            'driver_phone'          => $row->driver_phone,
                            'pickup_addr'           => $row->pickup_addr,
                            'delivery_addr'         => $row->delivery_addr,
                            'notes'                 => $row->notes,
                            'created_by'            => $user,
                            'created_on'            => $tanggal
                        ]);
                    }

                    #Insert Schedule
                    $schedule   = BookingModel::getSchedule($request->booking_idx);

                    foreach($schedule as $row)
                    {
                        DB::table('t_bschedule')->insert([
                            't_booking_id'          => $id,
                            't_mschedule_type_id'   => $row->t_mschedule_type_id,
                            'position_no'           => $row->position_no,
                            'desc'                  => $row->desc,
                            'date'                  => Carbon::parse($row->date),
                            'notes'                 => $row->notes,
                            'created_by'            => $user,
                            'created_on'            => $tanggal
                        ]);
                    }

                    #Insert TBL Charges Detail
                    $sellCost   = BookingModel::getChargesDetail($request->booking_idx);

                    foreach($sellCost as $row)
                    {
                        //Detail yg lama diganti id booking baru, tapi insert data lama ke id booking lama. Biar detail nya gaberubah di invoice.
                        DB::table('t_bcharges_dtl')->where('id', $row->id)->update([
                            't_booking_id' => $id
                        ]);
                        DB::table('t_bcharges_dtl')
                        ->insert([
                            't_booking_id'          => $request->booking_idx,
                            'position_no'           => $row->position_no,
                            't_mcharge_code_id'     => $row->t_mcharge_code_id,
                            'desc'                  => $row->desc,
                            'reimburse_flag'        => $row->reimburse_flag,
                            'currency'              => $row->currency,
                            'rate'                  => $row->rate,
                            'cost'                  => $row->cost,
                            'sell'                  => $row->sell,
                            'qty'                   => $row->qty,
                            'cost_val'              => $row->cost_val,
                            'sell_val'              => $row->sell_val,
                            'vat'                   => $row->vat,
                            'subtotal'              => $row->subtotal,
                            'routing'               => $row->routing,
                            'transit_time'          => $row->transit_time,
                            't_mcarrier_id'         => $row->t_mcarrier_id,
                            'notes'                 => $row->notes,
                            'paid_to'               => $row->paid_to,
                            'paid_to_id'            => $row->paid_to_id,
                            'bill_to'               => $row->bill_to,
                            'bill_to_id'            => $row->bill_to_id,
                            'created_by'            => $user,
                            'created_on'            => $tanggal
                        ]);
                    }

                    //update invoice ke id booking baru. booking lama hanya untuk cek history aja
                    DB::table('t_invoice')->where('t_booking_id', $request->booking_idx)->update([
                        't_booking_id' => $id
                    ]);

                    DB::table('t_proforma_invoice')->where('t_booking_id', $request->booking_idx)->update([
                        't_booking_id' => $id
                    ]);

                    DB::table('t_external_invoice')->where('t_booking_id', $request->booking_idx)->update([
                        't_booking_id' => $id
                    ]);

                    DB::table('t_booking')->where('id', $request->booking_idx)->update([
                        'status' => 9,//Status sudah ada versi diatasnya,jadi gaboleh di edit lagi versi sebelumnya, hanya buat histori
                        'updated_by'            => $user,
                        'updated_at'            => $tanggal
                    ]);
            DB::commit();
            return redirect('booking/edit_booking/'.$id)->with('status', 'Successfully added');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }

    public function addCommodity(Request $request)
    {
        $cek = DB::table('t_bcommodity')->where('t_booking_id', $request->booking)->orderBy('created_on', 'desc')->first();
        if($cek == null){
            $p = 1;
        }else{
            $p = $cek->position_no + 1;
        }
        try {
            $user = Auth::user()->name;
            $tanggal = Carbon::now();
            DB::table('t_bcommodity')->insert([
                't_booking_id'      => $request->booking,
                'position_no'       => $p,
                'hs_code'           => $request->hs_code,
                'desc'              => $request->desc,
                'origin'            => $request->origin,
                'qty_comm'          => $request->qty_com,
                'uom_comm'          => $request->qty_uom,
                'qty_packages'      => $request->qty_packages,
                'uom_packages'      => $request->qty_pckg_uom,
                'weight'            => $request->weight,
                'weight_uom'        => $request->weight_uom,
                'netto'             => $request->netto,
                'volume'            => $request->volume,
                'volume_uom'        => $request->volume_uom,
                'created_by'        => $user,
                'created_on'        => $tanggal
            ]);

            $return_data = 'sukses';
        } catch (\Exception $e) {
            $return_data = $e->getMessage();
        }

        header('Content-Type: application/json');
        echo json_encode($return_data);

    }

    public function loadCommodity(Request $request)
    {
        $tabel = "";
        $no = 2;
        $data = BookingModel::get_commodity($request['id']);
        $totalCom = count($data);

            foreach($data as $row)
            {
                $tabel .= '<tr>';
                $tabel .= '<td class="text-right">'.($no-1).'</td>';
                $tabel .= '<td class="text-right"><label id="lbl_hs_code_'.$no.'">'.$row->hs_code.'</label><input type="text" id="hs_code_'.$no.'" name="hs_code" class="form-control" value="'.$row->hs_code.'" style="display:none"></td>';
                $tabel .= '<td class="text-right"><label id="lbl_desc_'.$no.'">'.$row->desc.'</label>';
                $tabel .= '<input type="text" id="desc_'.$no.'" name="desc" class="form-control" value="'.$row->desc.'" style="display:none"></td>';
                $tabel .= '<td class="text-right"><label id="lbl_origin_'.$no.'">'.$row->origin.'</label>';
                $tabel .= '<input type="text" id="origin_'.$no.'" name="origin" class="form-control" '
                    . ' value="'.$row->origin.'" style="display:none"></td>';
                $tabel .= '<td class="text-center">
                                <div class="row">
                                    <div class="col-md-6">
                                    <label id="lbl_qty_com_'.$no.'">'.$row->qty_comm.'</label>
                                    <input type="text" id="qty_com_'.$no.'" name="qty_com" class="form-control" '
                    . ' value="'.$row->qty_comm.'" style="display:none">
                                    </div>
                                    <div class="col-md-6">
                                    <label id="lbl_qty_uom_'.$no.'">'.$row->code_b.'</label>
                                    ';
                    $tabel .= '<select id="qty_uom_'.$no.'" name="qty_uom" class="form-control select2bs44" ';
                    $tabel .= 'data-placeholder="Pilih..." style="margin-bottom:5px; display:none" >';
                    $tabel .= '<option value=""></option>';
                    $tabel .= '</select>';
                    $tabel .= '</div>';
                $tabel .= '</td>';
                $tabel .= '<td class="text-center">
                                <div class="row">
                                    <div class="col-md-6">
                                    <label id="lbl_qty_packages_'.$no.'">'.$row->qty_packages.'</label>
                                    <input type="text" id="qty_packages_'.$no.'" name="qty_packages" class="form-control" '
                    . ' value="'.$row->qty_packages.'" style="display:none">
                                    </div>
                                    <div class="col-md-6">
                                    <label id="lbl_qty_pckg_uom_'.$no.'">'.$row->code_c.'</label>
                                    ';
                    $tabel .= '<select id="qty_pckg_uom_'.$no.'" name="qty_pckg_uom" class="form-control select2bs44" ';
                    $tabel .= 'data-placeholder="Pilih..." style="margin-bottom:5px; display:none" >';
                    $tabel .= '<option value=""></option>';
                    $tabel .= '</select>';
                    $tabel .= '</div>';
                $tabel .= '</td>';
                $tabel .= '<td class="text-center">
                                <div class="row">
                                    <div class="col-md-6">
                                    <label id="lbl_weight_'.$no.'">'.$row->weight.'</label>
                                    <input type="text" id="weight_'.$no.'" name="weight" class="form-control" '
                    . ' value="'.$row->weight.'" style="display:none">
                                    </div>
                                    <div class="col-md-6">
                                    <label id="lbl_weight_uom_'.$no.'">'.$row->code_d.'</label>
                                    ';
                    $tabel .= '<select id="weight_uom_'.$no.'" name="weight_uom" class="form-control select2bs44" ';
                    $tabel .= 'data-placeholder="Pilih..." style="margin-bottom:5px; display:none" >';
                    $tabel .= '<option value=""></option>';
                    $tabel .= '</select>';
                    $tabel .= '</div>';
                $tabel .= '</td>';
                $tabel .= '<td class="text-right"><label id="lbl_netto_'.$no.'">'.$row->netto.'</label>';
                $tabel .= '<input type="text" id="netto_'.$no.'" name="netto" class="form-control" value="'.$row->netto.'" style="display:none"></td>';
                $tabel .= '<td class="text-center">
                                <div class="row">
                                    <div class="col-md-6">
                                    <label id="lbl_volume_'.$no.'">'.$row->volume.'</label>
                                    <input type="text" id="volume_'.$no.'" name="volume" class="form-control" '
                    . ' value="'.$row->volume.'" style="display:none">
                                    </div>
                                    <div class="col-md-6">
                                    <label id="lbl_volume_uom_'.$no.'">'.$row->code_e.'</label>
                                    ';
                    $tabel .= '<select id="volume_uom_'.$no.'" name="volume_uom" class="form-control select2bs44" ';
                    $tabel .= 'data-placeholder="Pilih..." style="margin-bottom:5px; display:none" >';
                    $tabel .= '<option value=""></option>';
                    $tabel .= '</select>';
                    $tabel .= '</div>';
                $tabel .= '</td>';
                $tabel .= '<td style="text-align:center;">';
                if($request['flag_invoice']==0){
                $tabel .= '<a href="javascript:;" class="btn btn-xs btn-circle btn-primary'
                        . '" onclick="editDetailCom('.$row->uom_comm.','.$row->uom_packages.','.$row->weight_uom.','.$row->volume_uom.','.$no.');" style="margin-top:5px" id="btnEditCom_'.$no.'"> '
                        . '<i class="fa fa-edit"></i> Edit &nbsp; </a>';
                $tabel .= '<a href="javascript:;" class="btn btn-xs btn-circle btn-success'
                        . '" onclick="updateDetailCom('.$row->id.','.$no.');" style="margin-top:5px; display:none" id="btnUpdateCom_'.$no.'"> '
                        . '<i class="fa fa-save"></i> Update </a>';
                $tabel .= '<a href="javascript:;" class="btn btn-xs btn-circle btn-danger'
                        . '" onclick="hapusDetailCom('.$row->id.');" style="margin-top:5px"> '
                        . '<i class="fa fa-trash"></i> Delete </a>';
                }
                $tabel .= '</td>';
                $tabel .= '</tr>';
                $no++;
            }

            header('Content-Type: application/json');
            echo json_encode([$tabel, $totalCom]);
    }

    public function deleteCommodity(Request $request)
    {
        try {
            DB::table('t_bcommodity')->where('id', $request['id'])->delete();

            $return_data = 'sukses';
        } catch (\Exception $e) {
            $return_data = $e->getMessage();
        }

        header('Content-Type: application/json');
        echo json_encode($return_data);
    }

    public function updateCommodity(Request $request)
    {
        try {
            DB::table('t_bcommodity')
            ->where('id', $request->id)
            ->update([
                'hs_code'           => $request->hs_code,
                'desc'              => $request->desc,
                'origin'            => $request->origin,
                'qty_comm'          => $request->qty_com,
                'uom_comm'          => $request->qty_uom,
                'qty_packages'      => $request->qty_packages,
                'uom_packages'      => $request->qty_pckg_uom,
                'weight'            => $request->weight,
                'weight_uom'        => $request->weight_uom,
                'netto'             => $request->netto,
                'volume'            => $request->volume,
                'volume_uom'        => $request->volume_uom,
            ]);

            $return_data = 'sukses';
        } catch (\Exception $e) {
            $return_data = $e->getMessage();
        }

        header('Content-Type: application/json');
        echo json_encode($return_data);
    }


    public function addPackages(Request $request)
    {
        $cek = DB::table('t_bpackages')->where('t_booking_id', $request->booking)->orderBy('created_on', 'desc')->first();
        if($cek == null){
            $p = 1;
        }else{
            $p = $cek->position_no + 1;
        }
        try {
            $user = Auth::user()->name;
            $tanggal = Carbon::now();
            DB::table('t_bpackages')->insert([
                't_booking_id' => $request->booking,
                'position_no'  => $p,
                'pkgs'         => $request->pkgs,
                'ctn'          => $request->ctn,
                'desc'         => $request->merk,
                'qty'          => $request->qty,
                'cbm'          => $request->cbm,
                'keterangan'   => $request->p_ket,
                'created_by'   => $user,
                'created_on'   => $tanggal
            ]);

            $return_data = 'sukses';
        } catch (\Exception $e) {
            $return_data = $e->getMessage();
        }

        header('Content-Type: application/json');
        echo json_encode($return_data);

    }


    public function loadPackages(Request $request)
    {
        $tabel = "";
        $no = 2;
        $data = BookingModel::get_packages($request['id']);
        $totalPackages = count($data);

            foreach($data as $row)
            {
                $tabel .= '<tr>';
                $tabel .= '<td class="text-left">'.($no-1).'</td>';
                $tabel .= '<td class="text-left"><label id="lbl_pkgs_'.$no.'">'.$row->pkgs.'</label><input type="text" id="pkgs_'.$no.'" name="pkgs" class="form-control" value="'.$row->pkgs.'" style="display:none"></td>';
                $tabel .= '<td class="text-left"><label id="lbl_ctn_'.$no.'">'.$row->ctn.'</label><input type="text" id="ctn_'.$no.'" name="ctn" class="form-control" value="'.$row->ctn.'" style="display:none"></td>';
                $tabel .= '<td class="text-left"><label id="lbl_merk_'.$no.'">'.$row->desc.'</label><input type="text" id="merk_'.$no.'" name="merk" class="form-control" value="'.$row->desc.'" style="display:none"></td>';
                $tabel .= '<td class="text-left"><label id="lbl_qtyx_'.$no.'">'.$row->qty.'</label>';
                $tabel .= '<input type="text" id="qtyx_'.$no.'" name="qtyx" class="form-control" value="'.$row->qty.'" style="display:none"></td>';
                $tabel .= '<td class="text-left"><label id="lbl_cbm_'.$no.'">'.$row->cbm.'</label><input type="text" id="cbm_'.$no.'" name="cbm" class="form-control" value="'.$row->cbm.'" style="display:none"></td>';
                $tabel .= '<td class="text-left"><label id="lbl_p_ket_'.$no.'">'.$row->keterangan.'</label><input type="text" id="p_ket_'.$no.'" name="p_ket" class="form-control" value="'.$row->keterangan.'" style="display:none"></td>';
                $tabel .= '<td style="text-align:center;">';
                if($request['flag_invoice']==0){
                $tabel .= '<a href="javascript:;" class="btn btn-xs btn-circle btn-primary'
                        . '" onclick="editDetailPckg('.$no.');" style="margin-top:5px" id="btnEditPckg_'.$no.'"> '
                        . '<i class="fa fa-edit"></i> Edit &nbsp; </a>';
                $tabel .= '<a href="javascript:;" class="btn btn-xs btn-circle btn-success'
                        . '" onclick="updateDetailPckg('.$row->id.','.$no.');" style="margin-top:5px; display:none" id="btnUpdatePckg_'.$no.'"> '
                        . '<i class="fa fa-save"></i> Update </a>';
                $tabel .= '<a href="javascript:;" class="btn btn-xs btn-circle btn-danger'
                        . '" onclick="hapusDetailPckg('.$row->id.');" style="margin-top:5px"> '
                        . '<i class="fa fa-trash"></i> Delete </a>';
                }
                $tabel .= '</td>';
                $tabel .= '</tr>';
                $no++;
            }

            header('Content-Type: application/json');
            echo json_encode([$tabel,$totalPackages]);
    }


    public function deletePackages(Request $request)
    {
        try {
            DB::table('t_bpackages')->where('id', $request['id'])->delete();

            $return_data = 'sukses';
        } catch (\Exception $e) {
            $return_data = $e->getMessage();
        }

        header('Content-Type: application/json');
        echo json_encode($return_data);
    }

    public function updatePackages(Request $request)
    {
        try {
            DB::table('t_bpackages')
            ->where('id', $request->id)
            ->update([
                'pkgs'         => $request->pkgs,
                'ctn'          => $request->ctn,
                'desc'         => $request->merk,
                'qty'          => $request->qty,
                'cbm'          => $request->cbm,
                'keterangan'   => $request->p_ket,
            ]);

            $return_data = 'sukses';
        } catch (\Exception $e) {
            $return_data = $e->getMessage();
        }

        header('Content-Type: application/json');
        echo json_encode($return_data);
    }

    public function getPackages(Request $request){

      $response = DB::table('t_bpackages')->select('*')->where('id', $request->id)->first();

      return response()->json($response);
    }

    public function addContainer(Request $request)
    {
        try {
            $user = Auth::user()->name;
            $tanggal = Carbon::now();
            DB::table('t_bcontainer')->insert([
                't_booking_id'          => $request->booking,
                'con_hs_code'           => $request->con_hs_code,
                'container_no'          => $request->con_numb,
                'size'                  => $request->size,
                't_mloaded_type_id'     => $request->loaded,
                't_mcontainer_type_id'  => $request->container,
                'seal_no'               => $request->seal_no,
                'qty'                   => $request->qty,
                'qty_uom'               => $request->qty_uom,
                'weight'                => $request->weight,
                'weight_uom'            => $request->weight_uom,
                'meas'                  => $request->meas,
                'vgm'                   => $request->vgm,
                'vgm_uom'               => $request->vgm_uom,
                'responsible_party'     => $request->resp_party,
                'authorized_person'     => $request->auth_person,
                'method_of_weighing'    => $request->mow,
                'weighing_party'        => $request->w_party,
                'created_by'            => $user,
                'created_on'            => $tanggal
            ]);

            $return_data['status'] = 'sukses';
            header('Content-Type: application/json');
            echo json_encode($return_data);
        } catch (\Exception $e) {
            $return_data['status'] = 'gagal';
            return response()->json(['error' => $e->getMessage()], 404); 
        }

    }


    public function loadContainer(Request $request)
    {
        $tabel = "";
        $no = 2;
        $data = BookingModel::get_container($request['id']);
        $booking = BookingModel::get_bookingDetail($request['id']);
        $totalContainer = count($data);

            foreach($data as $row)
            {
                $tabel .= '<tr>';
                $tabel .= '<td class="text-left">'.($no-1).'</td>';
                $tabel .= '<td class="text-left"><label id="lbl_con_hs_code_'.$no.'">'.$row->con_hs_code.'</label><input type="text" id="con_hs_code_'.$no.'" name="con_hs_code" class="form-control" value="'.$row->con_hs_code.'" style="display:none"></td>';
                $tabel .= '<td class="text-left"><label id="lbl_con_numb_'.$no.'">'.$row->container_no.'</label><input type="text" id="con_numb_'.$no.'" name="con_numb" class="form-control" value="'.$row->container_no.'" style="display:none"></td>';
                // $tabel .= '<td class="text-left"><label id="lbl_size_'.$no.'">'.$row->size.'</label>';
                // $tabel .= '<input type="text" id="size_'.$no.'" name="size" class="form-control" value="'.$row->size.'" style="display:none"></td>';
                $tabel .= '<td class="text-center"><label id="lbl_loaded_'.$no.'">'.$row->loaded_type.'</label>';
                    $tabel .= '<select id="s_loaded_'.$no.'" name="loaded" class="form-control select2bs44" ';
                    $tabel .= 'data-placeholder="Pilih..." style="margin-bottom:5px; display:none" >';
                    $tabel .= '<option value=""></option>';
                    $tabel .= '</select>';
                $tabel .= '</td>';
                $tabel .= '<td class="text-center"><label id="lbl_container_'.$no.'">'.$row->container_type.'</label>';
                    $tabel .= '<select id="container_'.$no.'" name="container" class="form-control select2bs44" ';
                    $tabel .= 'data-placeholder="Pilih..." style="margin-bottom:5px; display:none" >';
                    $tabel .= '<option value=""></option>';
                    $tabel .= '</select>';
                $tabel .= '</td>';
                $tabel .= '<td class="text-left"><label id="lbl_seal_no_'.$no.'">'.$row->seal_no.'</label><input type="text" id="seal_no_'.$no.'" name="seal_no" class="form-control" value="'.$row->seal_no.'" style="display:none"></td>';
                $tabel .= '<td class="text-center">
                                <div class="row">
                                    <div class="col-md-6">
                                    <label id="lbl_cont_qty_'.$no.'">'.$row->qty.'</label>
                                    <input type="text" id="cont_qty_'.$no.'" name="cont_qty" class="form-control" '
                    . ' value="'.$row->qty.'" style="display:none">
                                    </div>
                                    <div class="col-md-6">
                                    <label id="lbl_cont_qty_uom_'.$no.'">'.$row->code_qty.'</label>
                                    ';
                    $tabel .= '<select id="cont_qty_uom_'.$no.'" name="cont_qty_uom" class="form-control select2bs44" ';
                    $tabel .= 'data-placeholder="Pilih..." style="margin-bottom:5px; display:none" >';
                    $tabel .= '<option value=""></option>';
                    $tabel .= '</select>';
                    $tabel .= '</div>';
                $tabel .= '</td>';
                $tabel .= '<td class="text-center">
                                <div class="row">
                                    <div class="col-md-6">
                                    <label id="lbl_cont_weight_'.$no.'">'.$row->weight.'</label>
                                    <input type="text" id="cont_weight_'.$no.'" name="cont_weight" class="form-control" '
                    . ' value="'.$row->weight.'" style="display:none">
                                    </div>
                                    <div class="col-md-6">
                                    <label id="lbl_cont_weight_uom_'.$no.'">'.$row->code_weight.'</label>
                                    ';
                    $tabel .= '<select id="cont_weight_uom_'.$no.'" name="cont_qty_uom" class="form-control select2bs44" ';
                    $tabel .= 'data-placeholder="Pilih..." style="margin-bottom:5px; display:none" >';
                    $tabel .= '<option value=""></option>';
                    $tabel .= '</select>';
                    $tabel .= '</div>';
                $tabel .= '</td>';
                $tabel .= '<td class="text-center">
                                    <label id="lbl_cont_meas_'.$no.'">'.$row->meas.'</label>
                                    <input type="text" id="cont_meas_'.$no.'" name="cont_meas" class="form-control" '
                    . ' value="'.$row->meas.'" style="display:none">';
                $tabel .= '</td>';
                if($booking[0]->activity == 'export'){
                    $tabel .= '<td class="text-left"><label id="lbl_vgm_'.$no.'">'.$row->vgm.'</label><input type="text" id="vgm_'.$no.'" name="vgm" class="form-control" value="'.$row->vgm.'" style="display:none"></td>';
                    $tabel .= '<td class="text-center"><label id="lbl_vgm_uom_'.$no.'">'.$row->uom_code.'</label>';
                        $tabel .= '<select id="vgm_uom_'.$no.'" name="vgm_uom" class="form-control select2bs44" ';
                        $tabel .= 'data-placeholder="Pilih..." style="margin-bottom:5px; display:none" >';
                        $tabel .= '<option value=""></option>';
                        $tabel .= '</select>';
                    $tabel .= '</td>';
                    $tabel .= '<td class="text-left"><label id="lbl_resp_'.$no.'">'.$row->responsible_party.'</label><input type="text" id="resp_party_'.$no.'" name="resp_party" class="form-control" value="'.$row->responsible_party.'" style="display:none"></td>';
                    $tabel .= '<td class="text-left"><label id="lbl_auth_'.$no.'">'.$row->authorized_person.'</label><input type="text" id="auth_person_'.$no.'" name="auth_person" class="form-control" value="'.$row->authorized_person.'" style="display:none"></td>';
                    $tabel .= '<td class="text-left"><label id="lbl_mow_'.$no.'">'.$row->method_of_weighing.'</label><input type="text" id="mow_'.$no.'" name="mow" class="form-control" value="'.$row->method_of_weighing.'" style="display:none"></td>';
                    $tabel .= '<td class="text-left"><label id="lbl_wparty_'.$no.'">'.$row->weighing_party.'</label><input type="text" id="w_party_'.$no.'" name="w_party" class="form-control" value="'.$row->weighing_party.'" style="display:none"></td>';
                }
                $tabel .= '<td style="text-align:center;">';
                if($request['flag_invoice']==0){
                    $tabel .= '<a href="javascript:;" class="btn btn-xs btn-circle btn-primary'
                            . '" onclick="editDetailCon('.$row->t_mloaded_type_id.','.$row->t_mcontainer_type_id.','.$row->qty_uom.','.$row->weight_uom.','.$row->vgm_uom.','.$no.');" style="margin-top:5px" id="btnEditCon_'.$no.'"> '
                            . '<i class="fa fa-edit"></i></a>';
                    $tabel .= '<a href="javascript:;" class="btn btn-xs btn-circle btn-success'
                            . '" onclick="updateDetailCon('.$row->id.','.$no.');" style="margin-top:5px; display:none" id="btnUpdateCon_'.$no.'"> '
                            . '<i class="fa fa-save"></i></a>';
                    $tabel .= '<a href="javascript:;" class="btn btn-xs btn-circle btn-danger'
                            . '" onclick="hapusDetailCon('.$row->id.');" style="margin-top:5px"> '
                            . '<i class="fa fa-trash"></i></a>';
                }
                $tabel .= '</td>';
                $tabel .= '</tr>';
                $no++;
            }

            header('Content-Type: application/json');
            echo json_encode([$tabel, $totalContainer]);
    }

    public function deleteContainer(Request $request)
    {
        try {
            DB::table('t_bcontainer')->where('id', $request['id'])->delete();

            $return_data = 'sukses';
        } catch (\Exception $e) {
            $return_data = $e->getMessage();
        }

        header('Content-Type: application/json');
        echo json_encode($return_data);
    }

    public function getAll()
    {
        $data   = MasterModel::loaded_get();
        $data1  = MasterModel::container_get();
        $data2  = MasterModel::uom();
        return json_encode([$data, $data1, $data2]);
    }

    public function getDoc()
    {
        $data   = MasterModel::get_doc();
        return json_encode($data);
    }

    public function updateContainer(Request $request)
    {
        try {
            DB::table('t_bcontainer')
            ->where('id', $request->id)
            ->update([
                'con_hs_code'           => $request->con_hs_code,
                'container_no'          => $request->con_numb,
                'size'                  => $request->size,
                't_mloaded_type_id'     => $request->loaded,
                't_mcontainer_type_id'  => $request->container,
                'seal_no'               => $request->seal_no,
                'qty'                   => $request->qty,
                'qty_uom'               => $request->qty_uom,
                'weight'                => $request->weight,
                'weight_uom'            => $request->weight_uom,
                'meas'                => $request->meas,
                'vgm'                   => $request->vgm,
                'vgm_uom'               => $request->vgm_uom,
                'responsible_party'     => $request->resp_party,
                'authorized_person'     => $request->auth_person,
                'method_of_weighing'    => $request->mow,
                'weighing_party'        => $request->w_party,
            ]);

            $return_data['status'] = 'sukses';
            header('Content-Type: application/json');
            echo json_encode($return_data);
        } catch (\Exception $e) {
            $return_data['status'] = 'gagal';
            response()->json(['error' => $e->getMessage()], 404); 
        }
    }


    public function addDoc(Request $request)
    {
        try {
            $user = Auth::user()->name;
            $tanggal = Carbon::now();
            DB::table('t_bdocument')->insert([
                't_booking_id'      => $request->booking,
                't_mdoc_type_id'    => $request->doc,
                'doc_no'            => $request->number,
                'doc_date'          => $request->date,
                'created_by'        => $user,
                'created_on'        => $tanggal
            ]);

            $return_data = 'sukses';
        } catch (\Exception $e) {
            $return_data = $e->getMessage();
        }

        header('Content-Type: application/json');
        echo json_encode($return_data);

    }


    public function loadDoc(Request $request)
    {
        $tabel = "";
        $no = 2;
        $data = BookingModel::get_document($request['id']);

            foreach($data as $row)
            {
                if($row->doc_date != null){
                    $date = Carbon::parse($row->doc_date)->format('d/m/Y');
                }else{
                    $date = '';
                }
                $tabel .= '<tr>';
                $tabel .= '<td class="text-left">'.($no-1).'</td>';
                $tabel .= '<td class="text-left"><label id="lbl_docx_'.$no.'">'.$row->name.'</label>';
                    $tabel .= '<select id="docx_'.$no.'" name="docx" class="form-control select2bs44" ';
                    $tabel .= 'data-placeholder="Pilih..." style="margin-bottom:5px; display:none" >';
                    $tabel .= '<option value=""></option>';
                    $tabel .= '</select>';
                $tabel .= '</td>';
                $tabel .= '<td class="text-left"><label id="lbl_doc_number_'.$no.'">'.$row->doc_no.'</label>';
                $tabel .= '<input type="text" id="doc_number_'.$no.'" name="doc_number" class="form-control" value="'.$row->doc_no.'" style="display:none"></td>';
                $tabel .= '<td class="text-center"><label id="lbl_doc_date_'.$no.'">'.$date.'</label>';
                $tabel .= '<input type="date" class="form-control" name="doc_date" id="doc_date_'.$no.'" value="'.$row->doc_date.'" style="display:none">';
                $tabel .= '</td>';
                $tabel .= '<td style="text-align:center;">';
                if($request['flag_invoice']==0){
                    $tabel .= '<a href="javascript:;" class="btn btn-xs btn-circle btn-primary'
                            . '" onclick="editDetailDoc('.$row->t_mdoc_type_id.','.$no.');" style="margin-top:5px" id="btnEditDoc_'.$no.'"> '
                            . '<i class="fa fa-edit"></i> Edit &nbsp; </a>';
                    $tabel .= '<a href="javascript:;" class="btn btn-xs btn-circle btn-success'
                            . '" onclick="updateDetailDoc('.$row->id.','.$no.');" style="margin-top:5px; display:none" id="btnUpdateDoc_'.$no.'"> '
                            . '<i class="fa fa-save"></i> Update </a>';
                    $tabel .= '<a href="javascript:;" class="btn btn-xs btn-circle btn-danger'
                            . '" onclick="hapusDetailDoc('.$row->id.');" style="margin-top:5px"> '
                            . '<i class="fa fa-trash"></i> Delete </a>';
                }
                $tabel .= '</td>';
                $tabel .= '</tr>';
                $no++;
            }

            header('Content-Type: application/json');
            echo json_encode($tabel);
    }


    public function deleteDoc(Request $request)
    {
        try {
            DB::table('t_bdocument')->where('id', $request['id'])->delete();

            $return_data = 'sukses';
        } catch (\Exception $e) {
            $return_data = $e->getMessage();
        }

        header('Content-Type: application/json');
        echo json_encode($return_data);
    }

    public function updateDoc(Request $request)
    {
        try {
            DB::table('t_bdocument')
            ->where('id', $request->id)
            ->update([
                't_mdoc_type_id'    => $request->doc,
                'doc_no'            => $request->number,
                'doc_date'          => $request->date
            ]);

            $return_data = 'sukses';
        } catch (\Exception $e) {
            $return_data = $e->getMessage();
        }

        header('Content-Type: application/json');
        echo json_encode($return_data);
    }

    public function new_version($id)
    {
        $data       = BookingModel::get_bookingDetail($id);
        $cekVerse   = DB::table('t_booking')->where('booking_no', $data[0]->booking_no)->orderBy('created_on', 'desc')->first();
        $versionNow = $cekVerse->version_no;
        $quote      = $data[0];
        $commodity  = BookingModel::get_commodity($id);
        $packages   = BookingModel::get_packages($id);
        $container  = BookingModel::get_container($id);
        $doc        = BookingModel::get_document($id);
        $roadCons   = BookingModel::getRoadCons($id);
        $schedule   = BookingModel::getSchedule($id);
        $sellCost   = BookingModel::getChargesDetail($id);

        $countCom   = count($commodity);
        $countPack  = count($packages);
        $countCon   = count($container);

        $quote->flag_invoice = 0; // biar ga disabled

        return view('booking.new_version', compact('quote', 'versionNow', 'commodity', 'packages', 'container', 'doc', 'roadCons', 'schedule', 'sellCost', 'countCom', 'countPack', 'countCon'));
    }

    public function doUpdate(Request $request)
    {
        try {
            $doc_date = null;
            $igm_date = null;
            $eta_date = null;
            $etd_date = null;
            $stuf_date = null;
            $mbl_date = null;
            $hbl_date = null;

            if($request->doc_date !== null){
                $doc_date = Carbon::createFromFormat('d/m/Y', $request->doc_date)->format('Y-m-d');
            }

            if($request->igm_date !== null){
                $igm_date = Carbon::createFromFormat('d/m/Y', $request->igm_date)->format('Y-m-d');
            }

            if($request->eta_date !== null){
                $eta_date = Carbon::createFromFormat('d/m/Y', $request->eta_date)->format('Y-m-d');
            }

            if($request->etd_date !== null){
                $etd_date = Carbon::createFromFormat('d/m/Y', $request->etd_date)->format('Y-m-d');
            }

            if($request->stuf_date !== null){
                $stuf_date = Carbon::createFromFormat('d/m/Y', $request->stuf_date)->format('Y-m-d');
            }

            if($request->mbl_date !== null){
                $mbl_date = Carbon::createFromFormat('d/m/Y', $request->mbl_date)->format('Y-m-d');
            }

            if($request->hbl_date !== null){
                $hbl_date = Carbon::createFromFormat('d/m/Y', $request->hbl_date)->format('Y-m-d');
            }

            DB::table('t_booking')
            ->where('id', $request->id_booking)
            ->update([
                'booking_no'            => $request->booking_no,
                'nomor_si'              => $request->nomor_si,
                'booking_date'          => Carbon::createFromFormat('d/m/Y', $request->booking_date)->format('Y-m-d'),
                't_mdoc_type_id'        => $request->doctype,
                'custom_doc_no'         => $request->doc_no,
                'custom_doc_date'       => $doc_date,
                'igm_no'                => $request->igm_number,
                'igm_date'              => $igm_date,
                'custom_pos'            => $request->pos,
                'custom_subpos'         => $request->sub_pos,
                'client_id'             => $request->customer_add,
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
                'also_nf_id'            => $request->also_notify_party,
                'also_nf_addr_id'       => $request->also_not_addr,
                'also_nf_pic_id'        => $request->also_not_pic,
                'mbl_also_notify_party' => $request->mbl_also_notify_party,
                'hbl_also_notify_party' => $request->hbl_also_notify_party,
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
                'flight_number'         => $request->voyage,
                'carrier_id_2'          => $request->carrier_2,
                'flight_number_2'       => $request->voyage_2,
                'carrier_id_3'          => $request->carrier_3,
                'flight_number_3'       => $request->voyage_3,
                'conn_vessel'           => $request->conn_vessel,
                'eta_date'              => $eta_date,
                'etd_date'              => $etd_date,
                'place_origin'          => $request->pfo,
                'place_destination'     => $request->pod,
                'pol_id'                => $request->pol,
                'pol_custom_desc'       => $request->pol_desc,
                'pod_id'                => $request->podisc,
                'pod_custom_desc'       => $request->pod_desc,
                'pot_id'                => $request->pot,
                'final_flag'            => $request->status_final,
                'fumigation_flag'       => $request->fumigation,
                'insurance_flag'        => $request->insurance,
                't_mincoterms_id'       => $request->incoterms,
                't_mfreight_charges_id' => $request->freight_charges,
                'place_payment'         => $request->pop,
                'valuta_payment'        => $request->valuta_payment,
                'value_prepaid'         => $request->vop,
                'value_collect'         => $request->voc,
                'freetime_detention'    => $request->fod,
                'stuffing_date'         => $stuf_date,
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
                'mbl_desc'              => $request->desc_mbl,
                'mbl_no'                => $request->mbl_number,
                'mbl_desc'              => $request->desc_mbl,
                'mbl_date'              => $mbl_date,
                'mbl_marks_nos'         => $request->mbl_marks_nos,
                'valuta_mbl'            => $request->valuta_mbl,
                'hbl_shipper'           => $request->shipper_hbl,
                'hbl_consignee'         => $request->cons_hbl,
                'hbl_not_party'         => $request->notify_hbl,
                'hbl_no'                => $request->hbl_number,
                'hbl_date'              => $hbl_date,
                'hbl_desc'              => $request->desc_hbl,
                'hbl_marks_nos'         => $request->hbl_marks_nos,
                'delivery_agent_detail' => $request->delivery_agent_detail,
                'valuta_hbl'            => $request->valuta_hbl,
                't_mbl_issued_id'       => $request->mbl_issued,
                't_hbl_issued_id'       => $request->hbl_issued,
                'total_commodity'       => $request->total_commo,
                'total_package'         => $request->total_package,
                'total_container'       => $request->total_container,
                't_mcloaded_type_id'    => $request->loadedc,
            ]);

            return redirect('booking/edit_booking/'.$request->id_booking)->with('status', 'Successfully Updated');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }

    public function doUpdate_road(Request $request)
    {
        try {
            DB::table('t_booking')
            ->where('id', $request->id_booking)
            ->update([
                'trucking_company' => $request->trucking_company,
                'jenis'            => $request->jenis,
                'si_data'          => $request->si_data
            ]);

            $return_data = 'sukses';
        } catch (\Exception $e) {
            $return_data = $e->getMessage();
        }

        header('Content-Type: application/json');
        echo json_encode($return_data);
    }

    public function roadCons_doAdd(Request $request)
    {
        try {
            $user = Auth::user()->name;
            $tanggal = Carbon::now();
            DB::table('t_broad_cons')->insert([
                't_booking_id'          => $request->booking_id,
                'no_sj'                 => $request->no_sj,
                't_mvehicle_type_id'    => $request->vehicle_type,
                'nopol'                 => $request->vehicle_no,
                'driver'                => $request->driver,
                'driver_phone'          => $request->driver_ph,
                'pickup_addr'           => $request->pickup_addr,
                'delivery_addr'         => $request->deliv_addr,
                'notes'                 => $request->notes,
                'created_by'            => $user,
                'created_on'            => $tanggal
            ]);

            $return_data = 'sukses';
        } catch (\Exception $e) {
            $return_data = $e->getMessage();
        }

        header('Content-Type: application/json');
        echo json_encode($return_data);
    }

    public function loadRoadCons(Request $request)
    {
        $tabel = "";
        $no = 2;
        $data = BookingModel::getRoadCons($request['id']);

            foreach($data as $row)
            {
                $tabel .= '<tr>';
                $tabel .= '<td class="text-left">'.$row->no_sj.'</td>';
                $tabel .= '<td class="text-left">'.$row->type.'</td>';
                $tabel .= '<td class="text-left">'.$row->vehicle_no.'</td>';
                $tabel .= '<td class="text-">'.$row->driver.'</td>';
                $tabel .= '<td class="text-">'.$row->driver_phone.'</td>';
                $tabel .= '<td class="text-">'.$row->pickup_addr.'</td>';
                $tabel .= '<td class="text-">'.$row->delivery_addr.'</td>';
                $tabel .= '<td class="text-">'.$row->notes.'</td>';
                $tabel .= '<td>';
                if($request['flag_invoice']==0){
                $tabel .= '<a href="javascript:;" class="btn btn-xs btn-circle btn-primary'
                        . '" onclick="editDetailRoad('.$row->id.');" style="margin-top:5px" id="btnEditPckg_'.$no.'"> '
                        . '<i class="fa fa-edit"></i> Edit &nbsp; </a>';
                $tabel .= '<a href="javascript:;" class="btn btn-xs btn-circle btn-danger'
                        . '" onclick="hapusDetailRoad('.$row->id.');" style="margin-top:5px"> '
                        . '<i class="fa fa-trash"></i> Delete </a>';
                }
                $tabel .= '</td>';
                $tabel .= '</tr>';
                $no++;
            }

            header('Content-Type: application/json');
            echo json_encode($tabel);
    }

    public function getRoadCons(Request $request)
    {
        $data = BookingModel::roadConsDetail($request['id']);
        return json_encode($data);
    }

    public function deleteRoadCons(Request $request)
    {
        try {
            DB::table('t_broad_cons')->where('id', $request['id'])->delete();

            $return_data = 'sukses';
        } catch (\Exception $e) {
            $return_data = $e->getMessage();
        }

        header('Content-Type: application/json');
        echo json_encode($return_data);
    }

    public function roadCons_doUpdate(Request $request)
    {
        try {
            DB::table('t_broad_cons')
            ->where('id', $request->id)
            ->update([
                'no_sj'                 => $request->no_sj,
                't_mvehicle_type_id'    => $request->vehicle_type,
                'nopol'                 => $request->vehicle_no,
                'driver'                => $request->driver,
                'driver_phone'          => $request->driver_ph,
                'pickup_addr'           => $request->pickup_addr,
                'delivery_addr'         => $request->deliv_addr,
                'notes'                 => $request->notes,
            ]);

            $return_data = 'sukses';
        } catch (\Exception $e) {
            $return_data = $e->getMessage();
        }

        header('Content-Type: application/json');
        echo json_encode($return_data);
    }


    public function schedule_doAdd(Request $request)
    {
        $cek = DB::table('t_bschedule')->where('t_booking_id', $request->booking_id)->orderBy('created_on', 'desc')->first();
        if($cek == null){
            $p = 1;
        }else{
            $p = $cek->position_no + 1;
        }

        try {
            $user = Auth::user()->name;
            $tanggal = Carbon::now();
            DB::table('t_bschedule')->insert([
                't_booking_id'          => $request->booking_id,
                't_mschedule_type_id'   => $request->schedule,
                'position_no'           => $p,
                'desc'                  => $request->desc,
                'date'                  => $request->date,
                'notes'                 => $request->notes,
                'created_by'            => $user,
                'created_on'            => $tanggal
            ]);

            $return_data = 'sukses';
        } catch (\Exception $e) {
            $return_data = $e->getMessage();
        }

        header('Content-Type: application/json');
        echo json_encode($return_data);
    }


    public function loadSchedule(Request $request)
    {
        $tabel = "";
        $no = 1;
        $data = BookingModel::getSchedule($request['id']);

            foreach($data as $row)
            {
                $tabel .= '<tr>';
                $tabel .= '<td>'.$no++.'</td>';
                $tabel .= '<td class="text-left">'.$row->schedule_type.'</td>';
                $tabel .= '<td class="text-left">'.$row->desc.'</td>';
                $tabel .= '<td class="text-left">'.Carbon::parse($row->date).'</td>';
                $tabel .= '<td class="text-">'.$row->notes.'</td>';
                $tabel .= '<td>';
                if($request['flag_invoice']==0){
                $tabel .= '<a href="javascript:;" class="btn btn-xs btn-circle btn-primary'
                        . '" onclick="editDetailSch('.$row->id.');" style="margin-top:5px"> '
                        . '<i class="fa fa-edit"></i> Edit &nbsp; </a>';
                $tabel .= '<a href="javascript:;" class="btn btn-xs btn-circle btn-danger'
                        . '" onclick="hapusDetailSch('.$row->id.');" style="margin-top:5px"> '
                        . '<i class="fa fa-trash"></i> Delete </a>';
                }
                $tabel .= '</td>';
                $tabel .= '</tr>';
            }

            header('Content-Type: application/json');
            echo json_encode($tabel);
    }

    public function deleteSchedule(Request $request)
    {
        try {
            DB::table('t_bschedule')->where('id', $request['id'])->delete();

            $return_data = 'sukses';
        } catch (\Exception $e) {
            $return_data = $e->getMessage();
        }

        header('Content-Type: application/json');
        echo json_encode($return_data);
    }


    public function getSchedule(Request $request)
    {
        $data = BookingModel::scheduleDetail($request['id']);
        return json_encode($data);
    }

    public function schedule_doUpdate(Request $request)
    {
        try {
            DB::table('t_bschedule')
            ->where('id', $request->id)
            ->update([
                't_mschedule_type_id'   => $request->schedule,
                'desc'                  => $request->desc,
                'date'                  => $request->date,
                'notes'                 => $request->notes,
            ]);

            $return_data = 'sukses';
        } catch (\Exception $e) {
            $return_data = $e->getMessage();
        }

        header('Content-Type: application/json');
        echo json_encode($return_data);
    }

    public function loadSellCost(Request $request)
    {
        $tabel      = "";
        $tabel1     = "";
        $tabel2     = "";
        $no         = 1;
        $data       = BookingModel::getChargesDetail($request->id);
        $company    = MasterModel::company_data();
        $booking    = DB::table('t_booking')->where('id', $request->id)->first();
        // $booking    = BookingModel::getDetailBooking($request->id);
        $shipping   = QuotationModel::get_quoteShipping($booking->t_quote_id);
        // $shipping   = BookingModel::get_quoteProfit($booking->id);
        $quote      = QuotationModel::get_detailQuote($booking->t_quote_id);
        $total      = 0;
        $total2     = 0;
        $amount     = 0;
        $amount2    = 0;
        $a          = 1;
        $b          = 2;

        $totalAmount    = 0;
        $totalAmount2   = 0;
        foreach($data as $row){
            if($row->reimburse_flag == 1){
                $style = 'checked';
            }else{
                $style = '';
            }

            $total = ($row->qty * $row->cost);
            $total2 = ($row->qty * $row->sell);
            $amount = ($total * $row->rate) + $row->vat;
            $amount2 = ($total2 * $row->rate) + $row->vat;

            // Cost
            $tabel .= '<tr>';
            // $tabel .= '<td><input type="checkbox" name="cek_cost[]" value="'.$row->id.'"  id="cekx_'.$noloop.'"></td>';
            $tabel .= '<td>';
            if ($row->t_invoice_cost_id == null) {
                if($row->paid_to != null){
                    $tabel .= '<input type="checkbox" onchange="checkedPaidTo('.$no.')" name="cek_cost_chrg[]" value="'.$row->id.'" id="cekx_'.$no.'">
                    <input type="checkbox" style="display: none;" name="cek_paid_to[]" value="'.$row->paid_to_id.'" id="cek_paid_to_'.$no.'"/>';
                }
            }
            $tabel .=  '</td>';
            $tabel .= '<td>'.($no).'</td>';
            $tabel .= '<td class="text-left">'.$row->charge_name.'</td>';
            $tabel .= '<td class="text-left">'.$row->desc.'</td>';
            $tabel .= '<td class="text-center"><input type="checkbox" name="reimburs" style="width:50px;" id="reimburs_'.$no.'" '.$style.' onclick="return false;" disabled></td>';
            $tabel .= '<td class="text-left">'.(($row->term==0)? '(P) Prepaid':'(C) Collect').'</td>';
            $tabel .= '<td class="text-left">'.$row->qty.'</td>';
            $tabel .= '<td class="text-left">'.$row->code_cur.'</td>';
            $tabel .= '<td class="text-right">'.number_format($row->cost,2,',','.').'</td>';
            $tabel .= '<td class="text-right">'.number_format(($row->qty * $row->cost),2,',','.').'</td>';
            $tabel .= '<td class="text-right">'.number_format($row->rate,2,',','.').'</td>';
            $tabel .= '<td class="text-right">'.number_format($row->cost_adjustment,2,',','.').'</td>';
            $tabel .= '<td class="text-right">'.number_format($amount+$row->cost_adjustment,2,',','.').'</td>';
            if($row->paid_to == null){
                $tabel .= '<td>';
                $tabel .= '<select onchange="fillPaidToName('.$no.')" id="paid_to_'.$no.'" class="form-control select2bs44" data-placeholder="Pilih..." style="margin-bottom:5px;">';
                $tabel .= '<option value="" selected>-- Select Company --</option>';
                foreach($company as $item){
                    $tabel .= '<option value="'.$item->id.'-'.$item->client_name.'">'.$item->client_code.' | '.$item->client_name.'</option>';
                }
                $tabel .= '</select>';
                $tabel .= '</td>';
                $tabel .= '<input type="hidden" id="paid_to_name_'.$no.'"/>';
                $tabel .= '<input type="hidden" id="paid_to_id_'.$no.'"/>';
                $displayx = '';
            }else{
                $tabel .= '<td class="text-left">'.$row->paid_to.'</td>';
                $displayx = 'display:none';
            }

            $tabel .= '<td class="text-left">'.$row->invoice_no_cost.'</td>';
            $tabel .= '<td>';
            $tabel .= '<a href="javascript:;" class="btn btn-xs btn-success'
                    . '" onclick="updateDetailSell('.$row->id.', '.$no.','.$a.');" style="'.$displayx.'"> '
                    . '<i class="fa fa-save"></i></a>';
            $tabel .= '<a href="javascript:;" style="margin-left:2px;" class="btn btn-xs btn-info'
                    . '" onclick="editDetailCF('.$row->id.',\'cost\');"> '
                    . '<i class="fa fa-edit"></i></a>';
            if ($row->t_invoice_cost_id == null && $row->t_invoice_id == null) {
            $tabel .= '<a href="javascript:;" style="margin-left:2px;" class="btn btn-xs btn-danger'
                    . '" onclick="hapusDetailCF('.$row->id.');"> '
                    . '<i class="fa fa-trash"></i></a>';
            }
            $tabel .= '</td>';
            $tabel .= '</tr>';

            // Sell
            $tabel1 .= '<tr>';
            $tabel1 .= '<td>';
            if ($row->t_invoice_id == null) {
                if($row->bill_to != null){
                    $tabel1 .=    '<input type="checkbox" onchange="checkedBillTo('.$no.')" name="cek_sell_chrg[]" value="'.$row->id.'"  id="cekxx_'.$no.'">
                    <input type="checkbox" style="display: none;" name="cek_bill_to[]" value="'.$row->bill_to_id.'" id="cek_bill_to_'.$no.'"/>';
                }
            }
            $tabel .=  '</td>';
            $tabel1 .= '<td>'.$no.'</td>';
            $tabel1 .= '<td class="text-left">'.$row->charge_name.'</td>';
            $tabel1 .= '<td class="text-left">'.$row->desc.'</td>';
            $tabel1 .= '<td class="text-center"><input type="checkbox" name="reimburs" style="width:50px;" id="reimburs_'.$no.'" '.$style.' onclick="return false;" disabled></td>';
            $tabel1 .= '<td class="text-left">'.(($row->term==0)? '(P) Prepaid':'(C) Collect').'</td>';
            $tabel1 .= '<td class="text-left">'.$row->qty.'</td>';
            $tabel1 .= '<td class="text-left">'.$row->code_cur.'</td>';
            $tabel1 .= '<td class="text-right">'.number_format($row->sell,2,',','.').'</td>';
            $tabel1 .= '<td class="text-right">'.number_format(($row->qty * $row->sell),2,',','.').'</td>';
            $tabel1 .= '<td class="text-right">'.number_format($row->rate,2,',','.').'</td>';
            $tabel1 .= '<td class="text-right">'.number_format($row->vat,2,',','.').'</td>';
            $tabel1 .= '<td class="text-right">'.number_format($amount2,2,',','.').'</td>';
            if($row->bill_to == null){
                //$tabel1 .= '<td class="text-left"><input type="text" name="bill_to" id="bill_to_'.$no.'" placeholder="Bill to..." class="form-control"></td>';
                $tabel1 .= '<td>';
                $tabel1 .= '<select onchange="fillBillToName('.$no.')" id="bill_to_'.$no.'" class="form-control select2bs44" ';
                $tabel1 .= 'data-placeholder="Pilih..." style="margin-bottom:5px;">';
                $tabel1 .= '<option value="" selected>-- Select Company --</option>';
                foreach($company as $item){
                    $tabel1 .= '<option value="'.$item->id.'-'.$item->client_name.'">'.$item->client_code.' | '.$item->client_name.'</option>';
                }
                $tabel1 .= '</select>';
                $tabel1 .= '<input type="hidden" id="bill_to_name_'.$no.'"/>';
                $tabel1 .= '<input type="hidden" id="bill_to_id_'.$no.'"/>';
                $tabel1 .= '</td>';
                $display = '';
            }else{
                $tabel1 .= '<td class="text-left">'.$row->bill_to.'</td>';
                $display = 'display:none';
            }


            $tabel1 .= '<td class="text-left"></td>';
            $tabel1 .= '<td class="text-left">'.$row->invoice_type.'</td>';
            $tabel1 .= '<td class="text-left">'.$row->invoice_no.'</td>';
            $tabel1 .= '<td>';
            // if ($row->t_invoice_id == null) {
            if ($row->flag_bayar == null || $row->flag_bayar == '' || $row->flag_bayar == 0) {
                $tabel1 .= '<a href="javascript:;" class="btn btn-xs btn-circle btn-success'
                . '" onclick="updateDetailSell('.$row->id.', '.$no.', '.$b.');" style="'.$display.'"> '
                . '<i class="fa fa-save"></i></a>';
            }

            if ($row->flag_bayar == null || $row->flag_bayar == '' || $row->flag_bayar == 0) {
                $tabel1 .= '<a href="javascript:;" style="margin-left:2px;" class="btn btn-xs btn-info'
                        . '" onclick="editDetailCF('.$row->id.',\'sell\');"> '
                        . '<i class="fa fa-edit"></i></a>';
            }
            if ($row->t_invoice_cost_id == null && $row->t_invoice_id == null) {
                $tabel1 .= '<a href="javascript:;" class="btn btn-xs btn-circle btn-danger'
                . '" onclick="hapusDetailCF('.$row->id.');" style="margin-left:2px;"> '
                . '<i class="fa fa-trash"></i></a>';
            }
            $tabel1 .= '</td>';
            $tabel1 .= '</tr>';
            $no++;

            $totalAmount    += $amount+$row->cost_adjustment;
            $totalAmount2   += $amount2;
        }

        $totalCost = 0;
        $totalSell = 0;
        $profitAll = 0;

        foreach($shipping as $profit)
        {
            $totalCost = $totalAmount;
            $totalSell = $totalAmount2;
            $profitAll = $totalSell - $totalCost;
            $profitPct = ($profitAll*100)/$totalSell;
            $tabel2 .= '<tr>';
                if($quote->shipment_by != 'LAND'){
                    $tabel2 .= '<td class="text-center"><strong>'.$profit->carrier_code.'</strong></td>';
                    $tabel2 .= '<td class="text-center"><strong>'.$profit->routing.'</strong></td>';
                    $tabel2 .= '<td class="text-center"><strong>'.$profit->transit_time.'</strong></td>';
                }
                $tabel2 .= '<td class="text-center"><strong>'. number_format($totalCost,2,',','.') .'</strong></td>';
                $tabel2 .= '<td class="text-center"><strong>'. number_format($totalSell,2,',','.') .'</strong></td>';
                $tabel2 .= '<td class="text-center"><strong>'. number_format($profitAll,2,',','.') .'</strong></td>';
                $tabel2 .= '<td class="text-center"><strong>'. number_format($profitPct,2) .'%</strong></td>';
                $tabel2 .= '</tr>';
                $no++;
        }

        if(empty($data)){
            $tabel .= '<tr><td colspan="10">No Data ...</td></tr>';
            $tabel1 .= '<tr><td colspan="10">No Data ...</td></tr>';
        }
        if(empty($shipping)){
            $tabel2 .= '<tr><td colspan="10">No Data ...</td></tr>';
        }
        header('Content-Type: application/json');
        echo json_encode([$tabel, $tabel1, $tabel2, $no]);
    }

    public function deleteCF(Request $request)
    {
        try {
            DB::table('t_bcharges_dtl')->where('id', $request['id'])->delete();

            $return_data = 'sukses';
        } catch (\Exception $e) {
            $return_data = $e->getMessage();
        }

        header('Content-Type: application/json');
        echo json_encode($return_data);
    }

    public function updateSell(Request $request)
    {
        try {
            if($request->v == 1){
                DB::table('t_bcharges_dtl')
                ->where('id', $request->id)
                ->update([
                    'paid_to'   => $request->paid_to_name,
                    'paid_to_id' => $request->paid_to_id
                ]);
            }else{
                DB::table('t_bcharges_dtl')
                ->where('id', $request->id)
                ->update([
                    'bill_to'   => $request->bill_to_name,
                    'bill_to_id'   => $request->bill_to_id,
                ]);
            }


            $return_data = 'sukses';
        } catch (\Exception $e) {
            $return_data = $e->getMessage();
        }

        header('Content-Type: application/json');
        echo json_encode($return_data);
    }

    public function updateSellshp(Request $request)
    {
        try {
            if($request->v == 1){
                DB::table('t_quote_shipg_dtl')
                ->where('id', $request->id)
                ->update([
                    'paid_to'   => $request->paid_to_name,
                    'paid_to_id' => $request->paid_to_id
                ]);
            }else{
                DB::table('t_quote_shipg_dtl')
                ->where('id', $request->id)
                ->update([
                    'bill_to'   => $request->bill_to_name,
                    'bill_to_id'   => $request->bill_to_id,
                ]);
            }


            $return_data = 'sukses';
        } catch (\Exception $e) {
            $return_data = $e->getMessage();
        }

        header('Content-Type: application/json');
        echo json_encode($return_data);
    }

    public function cek_version(Request $request)
    {
        $quote = DB::select("SELECT * FROM t_booking WHERE booking_no = '".$request->booking_no."'");
        if(count($quote) == 1 || count($quote) == 0){
            $a = true;
        }else{
            $a = false;
        }

        header('Content-Type: application/json');
        echo json_encode($a);
    }

    public function get_version(Request $request)
    {
        $option = '';
        $option1 = '';

        $quote = DB::select("SELECT * FROM t_booking WHERE booking_no = '".$request->booking_no."'");

        foreach($quote as $row)
        {
            if($row->version_no == $request->verse)
            {
                $status = 'selected';
            }else{
                $status = '';
            }

            $option .= '<option value="'.$row->version_no.'" '.$status.'>'.$row->version_no.'</option>';
            $option1 .= '<option value="'.$row->id.'" '.$status.'>'.$row->version_no.'</option>';

        }

        header('Content-Type: application/json');
        echo json_encode([$option,$option1]);
    }


    public function getView(Request $request)
    {
       $booking = DB::table('t_booking As a')
                    ->leftJoin('t_quote AS b', 'a.t_quote_id', '=', 'b.id')
                    ->leftJoin('t_mdoc_type AS tmdoc', 'a.t_mdoc_type_id', '=', 'tmdoc.id')
                    ->leftJoin('t_mcompany AS c', 'a.client_id', '=', 'c.id')
                    ->leftJoin('t_maddress As d', 'a.client_addr_id', '=', 'd.id')
                    ->leftJoin('t_mpic AS e', 'a.client_pic_id', '=', 'e.id')
                    ->leftJoin('t_mcompany AS f', 'a.shipper_id', '=', 'f.id')
                    ->leftJoin('t_maddress As g', 'a.shipper_addr_id', '=', 'g.id')
                    ->leftJoin('t_mpic AS h', 'a.shipper_pic_id', '=', 'h.id')
                    ->leftJoin('t_mcompany AS i', 'a.consignee_id', '=', 'i.id')
                    ->leftJoin('t_maddress As j', 'a.consignee_addr_id', '=', 'j.id')
                    ->leftJoin('t_mpic AS k', 'a.consignee_pic_id', '=', 'k.id')
                    ->leftJoin('t_mcompany AS l', 'a.not_party_id', '=', 'l.id')
                    ->leftJoin('t_maddress As m', 'a.not_party_addr_id', '=', 'm.id')
                    ->leftJoin('t_mpic AS n', 'a.not_party_pic_id', '=', 'n.id')
                    ->leftJoin('t_mcompany AS o', 'a.agent_id', '=', 'o.id')
                    ->leftJoin('t_maddress As p', 'a.agent_addr_id', '=', 'p.id')
                    ->leftJoin('t_mpic AS q', 'a.agent_pic_id', '=', 'q.id')
                    ->leftJoin('t_mcompany AS r', 'a.shipping_line_id', '=', 'r.id')
                    ->leftJoin('t_maddress As s', 'a.shpline_addr_id', '=', 's.id')
                    ->leftJoin('t_mpic AS t', 'a.shpline_pic_id', '=', 't.id')
                    ->leftJoin('t_mcompany AS u', 'a.vendor_id', '=', 'u.id')
                    ->leftJoin('t_maddress As v', 'a.vendor_addr_id', '=', 'v.id')
                    ->leftJoin('t_mpic AS w', 'a.vendor_pic_id', '=', 'w.id')
                    ->leftJoin('t_mcarrier AS carrier', 'a.carrier_id', '=', 'carrier.id')
                    ->leftJoin('t_mcarrier AS carrier_2', 'a.carrier_id_2', '=', 'carrier_2.id')
                    ->leftJoin('t_mcarrier AS carrier_3', 'a.carrier_id_3', '=', 'carrier_3.id')
                    ->leftJoin('t_mport AS tm', 'a.pol_id', '=', 'tm.id')
                    ->leftJoin('t_mport AS tm2', 'a.pod_id', '=', 'tm2.id')
                    ->leftJoin('t_mport AS tm3', 'a.pot_id', '=', 'tm3.id')
                    ->leftJoin('t_mfreight_charges AS tmc', 'a.t_mfreight_charges_id', '=', 'tmc.id')
                    ->leftJoin('t_mincoterms AS tmin', 'a.t_mincoterms_id', '=', 'tmin.id')
                    ->leftjoin('t_mbl_issued AS tmi', 'a.t_mbl_issued_id', '=', 'tmi.id')
                    ->leftJoin('t_muom AS tmuom', 'a.valuta_comm', '=', 'tmuom.id')
                    ->leftJoin('t_muom AS tmuom2', 'a.exchange_valuta_comm', '=', 'tmuom2.id')
                    ->leftjoin('t_mcurrency AS tmuom3', 'a.valuta_payment', '=', 'tmuom3.id')
                    ->select('a.*', 'b.quote_no', 'b.quote_date', 'b.shipment_by', 'c.client_name as company_c', 'd.address as address_c', 'e.name as pic_c', 'f.client_name as company_f', 'f.legal_doc_flag as legal_f', 'g.address as address_f', 'h.name as pic_f', 'i.client_name as company_i', 'j.address as address_i', 'k.name as pic_i', 'l.client_name as company_l', 'm.address as address_l', 'n.name as pic_l', 'o.client_name as company_o', 'p.address as address_o', 'q.name as pic_o', 'r.client_name as company_r', 's.address as address_r', 't.name as pic_r', 'u.client_name as company_u', 'v.address as address_u', 'w.name as pic_u', 'tmdoc.name as name_doc', 'carrier.name as name_carrier', 'carrier_2.name as name_carrier_2', 'carrier_3.name as name_carrier_3', 'tm.port_name as port1','tm3.port_name as port2', 'tm2.port_name as port3', 'tmc.freight_charge as charge_name', 'tmin.incoterns_code', 'tmi.name as issued', 'tmuom.uom_code as valuta_code', 'tmuom2.uom_code as exchange_code', 'tmuom3.code as valuta_payment_code')
                    ->where([['a.booking_no', '=', $request->booking_no], ['a.version_no', '=', $request->version]])->first();

        $profit     = QuotationModel::get_quoteProfit($booking->quote_no);
        //$quoteDtl   = QuotationModel::get_quoteDetail($booking->quote_no);
        $quoteDtl   = BookingModel::getChargesDetail($booking->id);
        $schedule   = BookingModel::getSchedule($booking->id);
        $roadCons   = BookingModel::getRoadCons($booking->id);
        $document   = BookingModel::get_document($booking->id);
        $container  = BookingModel::get_container($booking->id);
        $packages   = BookingModel::get_packages($booking->id);
        $commodity  = BookingModel::get_commodity($booking->id);
        $shipping   = QuotationModel::get_quoteShipping($booking->t_quote_id);
        $quote      = QuotationModel::get_detailQuote($booking->t_quote_id);


        $data['booking']    = $booking;
        $data['profit']     = $profit;
        $data['quoteDtl']   = $quoteDtl;
        $data['schedule']   = $schedule;
        $data['roadCons']   = $roadCons;
        $data['doc']        = $document;
        $data['container']  = $container;
        $data['packages']   = $packages;
        $data['commodity']  = $commodity;
        $data['shipping']   = $shipping;
        $data['quote']      = $quote;

        return view('booking.view_booking')->with($data);
    }

    public function approved(Request $request)
    {
        try {
            DB::table('t_booking')
            ->where('id', $request->id)
            ->update([
                'status' => 1,
            ]);

            $return_data = 'sukses';
            $request->session()->flash('status', 'Approved!');
        } catch (\Exception $e) {
            $return_data = $e->getMessage();
        }

        header('Content-Type: application/json');
        echo json_encode($return_data);
    }

    public function copy_booking($id)
    {
        $booking = DB::table('t_booking AS a')
                        ->leftJoin('t_quote AS b', 'a.t_quote_id', '=', 'b.id')
                        ->select('a.*', 'b.quote_no')
                        ->where('a.id', $id)->first();
        $profit     = QuotationModel::get_quoteProfit($booking->t_quote_id);
        $quoteDtl   = QuotationModel::get_quoteDetail($booking->t_quote_id);
        $schedule   = BookingModel::getSchedule($booking->id);
        $roadCons   = BookingModel::getRoadCons($booking->id);
        $document   = BookingModel::get_document($booking->id);
        $container  = BookingModel::get_container($booking->id);
        $packages   = BookingModel::get_packages($booking->id);
        $commodity  = BookingModel::get_commodity($booking->id);
        $sellcost   = BookingModel::getChargesDetail($booking->id);

        $user = Auth::user()->name;
        $tanggal = Carbon::now();

        try {
        # Insert Booking
        $id =   DB::table('t_booking')->insertGetId([
            't_quote_id'            => $booking->t_quote_id,
            'booking_date'          => Carbon::createFromFormat('d/m/Y', $booking->booking_date)->format('Y-m-d'),
            'version_no'            => 1,
            'activity'              => $booking->activity,
            'nomination_flag'       => $booking->nomination_flag,
            'copy_booking'          => $booking->booking_no,
            't_mdoc_type_id'        => $booking->t_mdoc_type_id,
            'custom_doc_no'         => $booking->custom_doc_no,
            'igm_no'                => $booking->igm_no,
            'custom_pos'            => $booking->custom_pos,
            'custom_subpos'         => $booking->custom_subpos,
            'client_id'             => $booking->client_id,
            'client_addr_id'        => $booking->client_addr_id,
            'client_pic_id'         => $booking->client_pic_id,
            'shipper_id'            => $booking->shipper_id,
            'shipper_addr_id'       => $booking->shipper_addr_id,
            'shipper_pic_id'        => $booking->shipper_pic_id,
            'consignee_id'          => $booking->consignee_id,
            'consignee_addr_id'     => $booking->consignee_addr_id,
            'consignee_pic_id'      => $booking->consignee_pic_id,
            'not_party_id'          => $booking->not_party_id,
            'not_party_addr_id'     => $booking->not_party_addr_id,
            'not_party_pic_id'      => $booking->not_party_pic_id,
            'also_nf_id'            => $booking->also_notify_party,
            'also_nf_addr_id'       => $booking->also_not_addr,
            'also_nf_pic_id'        => $booking->also_not_pic,
            'mbl_also_notify_party' => $booking->mbl_also_notify_party,
            'hbl_also_notify_party' => $booking->hbl_also_notify_party,
            'agent_id'              => $booking->agent_id,
            'agent_addr_id'         => $booking->agent_addr_id,
            'agent_pic_id'          => $booking->agent_pic_id,
            'shipping_line_id'      => $booking->shipping_line_id,
            'shpline_addr_id'       => $booking->shpline_addr_id,
            'shpline_pic_id'        => $booking->shpline_pic_id,
            'vendor_id'             => $booking->vendor_id,
            'vendor_addr_id'        => $booking->vendor_addr_id,
            'vendor_pic_id'         => $booking->vendor_pic_id,
            'carrier_id'            => $booking->carrier_id,
            'flight_number'         => $booking->flight_number,
            'carrier_id_2'          => $booking->carrier_id_2,
            'flight_number_2'       => $booking->flight_number_2,
            'carrier_id_3'          => $booking->carrier_id_3,
            'flight_number_3'       => $booking->flight_number_3,
            'conn_vessel'           => $booking->conn_vessel,
            'place_origin'          => $booking->place_origin,
            'place_destination'     => $booking->place_destination,
            'pol_id'                => $booking->pol_id,
            'pol_custom_desc'       => $booking->pol_custom_desc,
            'pod_id'                => $booking->pod_id,
            'pod_custom_desc'       => $booking->pod_custom_desc,
            'pot_id'                => $booking->pot_id,
            'fumigation_flag'       => $booking->fumigation_flag,
            'insurance_flag'        => $booking->insurance_flag,
            't_mincoterms_id'       => $booking->t_mincoterms_id,
            't_mfreight_charges_id' => $booking->t_mfreight_charges_id,
            'place_payment'         => $booking->place_payment,
            'valuta_payment'        => $booking->valuta_payment,
            'value_prepaid'         => $booking->value_prepaid,
            'value_collect'         => $booking->value_collect,
            'freetime_detention'    => $booking->freetime_detention,
            'stuffing_place'        => $booking->stuffing_place,
            'delivery_of_goods'     => $booking->delivery_of_goods,
            'valuta_comm'           => $booking->valuta_comm,
            'value_comm'            => $booking->value_comm,
            'rates_comm'            => $booking->rates_comm,
            'exchange_valuta_comm'  => $booking->exchange_valuta_comm,
            'remarks'               => $booking->remarks,
            'mbl_shipper'           => $booking->mbl_shipper,
            'mbl_consignee'         => $booking->mbl_consignee,
            'mbl_not_party'         => $booking->mbl_not_party,
            'mbl_desc'              => $booking->desc_mbl,
            'mbl_no'                => $booking->mbl_no,
            'mbl_marks_nos'         => $booking->mbl_marks_nos,
            'valuta_mbl'            => $booking->valuta_mbl,
            'hbl_shipper'           => $booking->hbl_shipper,
            'hbl_consignee'         => $booking->hbl_consignee,
            'hbl_not_party'         => $booking->hbl_not_party,
            'hbl_desc'              => $booking->desc_hbl,
            'hbl_marks_nos'         => $booking->hbl_marks_nos,
            'delivery_agent_detail' => $booking->delivery_agent_detail,
            'trucking_company'      => $booking->trucking_company,
            'jenis'                 => $booking->jenis,
            'hbl_no'                => $booking->hbl_no,
            'valuta_hbl'            => $booking->valuta_hbl,
            't_mbl_issued_id'       => $booking->t_mbl_issued_id,
            't_hbl_issued_id'       => $booking->hbl_issued,
            'total_commodity'       => $booking->total_commodity,
            'total_package'         => $booking->total_package,
            'total_container'       => $booking->total_container,
            't_mcloaded_type_id'    => $request->loadedc,
            'created_by'            => $user,
            'created_on'            => $tanggal
        ]);

        #Insert Commodity
        foreach($commodity as $commodity){
            DB::table('t_bcommodity')->insert([
                't_booking_id'          => $id,
                'position_no'           => $commodity->position_no,
                'hs_code'               => $commodity->hs_code,
                'desc'                  => $commodity->desc,
                'origin'                => $commodity->origin,
                'qty_comm'              => $commodity->qty_comm,
                'uom_comm'              => $commodity->uom_comm,
                'qty_packages'          => $commodity->qty_packages,
                'uom_packages'          => $commodity->uom_packages,
                'weight'                => $commodity->weight,
                'weight_uom'            => $commodity->weight_uom,
                'netto'                 => $commodity->netto,
                'volume'                => $commodity->volume,
                'volume_uom'            => $commodity->volume_uom,
                'created_by'            => $user,
                'created_on'            => $tanggal
            ]);
        }

        #Insert Packages
        foreach($packages as $packages){
            DB::table('t_bpackages')->insert([
                't_booking_id'          => $id,
                'position_no'           => $packages->position_no,
                'desc'                  => $packages->desc,
                'qty'                   => $packages->qty,
                'qty_uom'               => $packages->qty_uom,
                'created_by'            => $user,
                'created_on'            => $tanggal
            ]);
        }

        #Insert Container
        foreach($container as $container){
            DB::table('t_bcontainer')->insert([
                't_booking_id'          => $id,
                'container_no'          => $container->container_no,
                'size'                  => $container->size,
                't_mloaded_type_id'     => $container->t_mloaded_type_id,
                't_mcontainer_type_id'  => $container->t_mcontainer_type_id,
                'seal_no'               => $container->seal_no,
                'vgm'                   => $container->vgm,
                'vgm_uom'               => $container->vgm_uom,
                'responsible_party'     => $container->responsible_party,
                'authorized_person'     => $container->authorized_person,
                'method_of_weighing'    => $container->method_of_weighing,
                'weighing_party'        => $container->weighing_party,
                'created_by'            => $user,
                'created_on'            => $tanggal
            ]);
        }

        #Insert Document
        foreach($document as $document){
            DB::table('t_bdocument')->insert([
                't_booking_id'          => $id,
                't_mdoc_type_id'        => $document->t_mdoc_type_id,
                'doc_no'                => $document->doc_no,
                'created_by'            => $user,
                'created_on'            => $tanggal
            ]);
        }

        #Insert Road Cons
        foreach($roadCons as $roadCons){
            DB::table('t_broad_cons')->insert([
                't_booking_id'          => $id,
                'no_sj'                 => $roadCons->no_sj,
                't_mvehicle_type_id'    => $roadCons->t_mvehicle_type_id,
                't_mvehicle_id'         => $roadCons->t_mvehicle_id,
                'driver'                => $roadCons->driver,
                'driver_phone'          => $roadCons->driver_phone,
                'pickup_addr'           => $roadCons->pickup_addr,
                'delivery_addr'         => $roadCons->delivery_addr,
                'notes'                 => $roadCons->notes,
                'created_by'            => $user,
                'created_on'            => $tanggal
            ]);
        }

        #Insert Schedule
        foreach($schedule as $schedule){
            DB::table('t_bschedule')->insert([
                't_booking_id'          => $id,
                't_mschedule_type_id'   => $schedule->t_mschedule_type_id,
                'position_no'           => $schedule->position_no,
                'desc'                  => $schedule->desc,
                'notes'                 => $schedule->notes,
                'created_by'            => $user,
                'created_on'            => $tanggal
            ]);
        }

        #Insert ChargesDetail
        foreach($sellcost as $sellcost){
            DB::table('t_bcharges_dtl')->insert([
                't_booking_id'          => $id,
                'position_no'           => $sellcost->position_no,
                't_mcharge_code_id'     => $sellcost->t_mcharge_code_id,
                'desc'                  => $sellcost->desc,
                'reimburse_flag'        => $sellcost->reimburse_flag,
                'currency'              => $sellcost->currency,
                'rate'                  => $sellcost->rate,
                'cost'                  => $sellcost->cost,
                'sell'                  => $sellcost->sell,
                'qty'                   => $sellcost->qty,
                'cost_val'              => $sellcost->cost_val,
                'sell_val'              => $sellcost->sell_val,
                'vat'                   => $sellcost->vat,
                'subtotal'              => $sellcost->subtotal,
                'routing'               => $sellcost->routing,
                'transit_time'          => $sellcost->transit_time,
                'paid_to'               => $sellcost->paid_to,
                'bill_to'               => $sellcost->bill_to,
                'created_by'            => $user,
                'created_on'            => $tanggal
            ]);
        }

        return redirect('booking/edit_booking/'.$id)->with('status', 'Successfully Copy');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }

    public function booking_preview($id)
    {
        $booking                 = DB::table('t_booking')->where('id', $id)->first();
        $data['sell_cost']       = BookingModel::getChargesDetail($id);
        $data['shipping']        = QuotationModel::get_quoteShipping($booking->t_quote_id);
        $data['quote']           = QuotationModel::get_detailQuote($booking->t_quote_id);

        return view('booking.preview')->with($data);
    }

    public function cetak_hbl($id, $hbl1, $hbl2, $op2, $op3)
    {
        /** Get Detail Booking */
        $booking = BookingModel::getDetailBooking($id);

        /** Get Detail Packages */
        $packages = DB::table('t_bpackages AS a')
                    ->leftJoin('t_muom AS b', 'a.qty_uom', '=', 'b.id')
                    ->select('a.*', 'b.uom_code as code')
                    ->where('t_booking_id', $id)->get();

        $comm   = BookingModel::get_commodity($id);

        $cont = BookingModel::get_container_comm($id);

        $pdf = PDF::loadview('booking.cetak_hbl_pdf', [
            'booking' => $booking, 
            'packages' => $packages, 
            'origin' =>$hbl1, 
            'copy' => $hbl2,
            'op2' => $op2,
            'op3' => $op3,
            'container' => $cont,
            'comm' => $comm
        ]);
        return $pdf->stream();
    }


    public function cetak_hawb($id)
    {
        /** Get Detail Booking */
        $booking = BookingModel::getDetailBooking($id);
        $pdf = PDF::loadview('booking.cetak_awb_pdf', ['booking' => $booking]);
        return $pdf->stream();
    }

    public function cetak_vgm($id)
    {
        $data = BookingModel::get_container($id);
        $pdf = PDF::loadview('booking.cetak_vgm_pdf', ['data' => $data])->setPaper('a4', 'landscape');
        return $pdf->stream();
    }

    public function cetak_si_lcl($id,$op1,$op2,$op3,$op4)
    {
        $data   = BookingModel::getDetailBooking($id);
        $comm   = BookingModel::get_commodity($id);
        $cont    = BookingModel::get_container_comm($id);
        $pdf    = PDF::loadview('booking.cetak_si_fcl', [
            'type' => 'lcl',
            'data' => $data, 
            'comm' => $comm, 
            'cont' => $cont,
            'op1' => $op1,
            'op2' => $op2,
            'op3' => $op3,
            'op4' => $op4,
        ]);
        return $pdf->stream();
    }

    public function cetak_si_fcl($id,$op1,$op2,$op3,$op4)
    {
        $data   = BookingModel::getDetailBooking($id);
        $comm   = BookingModel::get_commodity($id);
        $cont   = BookingModel::get_container_comm($id);
        $pdf    = PDF::loadview('booking.cetak_si_fcl', [
            'type' => 'fcl',
            'data' => $data, 
            'comm' => $comm, 
            'cont' => $cont,
            'op1' => $op1,
            'op2' => $op2,
            'op3' => $op3,
            'op4' => $op4,
        ]);
        return $pdf->stream();
    }


    public function cetak_si_air($id,$op1,$op2,$op3,$op4)
    {
        $data   = BookingModel::getDetailBooking($id);
        $pdf    = PDF::loadview('booking.cetak_si_air', ['data' => $data]);
        return $pdf->stream();
    }

    public function cetak_si_trucking_fcl($id,$op1)
    {
        $data   = BookingModel::getDetailBooking($id);
        $comm   = BookingModel::get_commodity($id);
        $cont    = BookingModel::get_container_comm($id);
        $pdf    = PDF::loadview('booking.cetak_si_trucking_fcl', ['type' => 'fcl', 'data' => $data, 'comm' => $comm, 'cont' => $cont, 'op1' => $op1]);
        return $pdf->stream();
    }

    public function cetak_si_trucking_lcl($id,$op1)
    {
        $data   = BookingModel::getDetailBooking($id);
        $comm   = BookingModel::get_commodity($id);
        $cont    = BookingModel::get_container_comm($id);
        $pdf    = PDF::loadview('booking.cetak_si_trucking_fcl', ['type' => 'lcl', 'data' => $data, 'comm' => $comm, 'cont' => $cont, 'op1' => $op1]);
        return $pdf->stream();
    }

    public function cetak_suratJalan($id)
    {
        $data   = BookingModel::getRoadCons($id);
        $barang = BookingModel::get_packages($id);
        $pdf    = PDF::loadview('booking.cetak_suratJalan', ['data' => $data, 'barang' => $barang]);
        return $pdf->stream();
    }

    public function bcharges_addDetail(Request $request)
    {
        $cek = DB::table('t_bcharges_dtl')->where('t_booking_id', $request->booking_id)->orderBy('created_on', 'desc')->first();

        $shp_routing = '';
        $shp_transit_time = '';
        if($request->quote != 0){
            $shipping   = QuotationModel::get_quoteShipping($request->quote);
            $shp = $shipping[0];
            $shp_routing = $shp->routing;
            $shp_transit_time = $shp->transit_time;
        }

        if($cek == null){
            $p = 1;
        }else{
            $p = $cek->position_no + 1;
        }

        if($request->reimburs == 1){
            $r = 1;
            $request->sell = $request->cost;
            $request->sell_val = $request->cost_val;
            $request->total = str_replace(',','', $request->sell_val) * str_replace(',','', $request->qty);
        }else{
            $r = 0;
        }

        // try {
        $user = Auth::user()->name;
        $tanggal = Carbon::now();
        DB::table('t_bcharges_dtl')->insert([
            't_booking_id'      => $request->booking_id,
            'position_no'       => $p,
            't_mcharge_code_id' => $request->charge,
            'desc'              => $request->desc,
            'reimburse_flag'    => $r,
            'currency'          => $request->currency,
            'rate'              => $request->rate,
            'cost'              => $request->cost,
            'sell'              => $request->sell,
            'qty'               => $request->qty,
            'cost_adjustment'   => str_replace(',', '', $request->cost_adjustment),
            'cost_val'          => str_replace(',', '', $request->cost_val),
            'sell_val'          => str_replace(',','', $request->sell_val),
            'vat'               => $request->vat,
            'subtotal'          => str_replace(',','', $request->total),
            'term'              => $request->term,
            'routing'           => $shp_routing,
            'transit_time'      => $shp_transit_time,
            'created_by'        => $user,
            'created_on'        => $tanggal
        ]);

        $data[] = DB::select("SELECT a.* FROM t_bcharges_dtl a LEFT JOIN t_booking b ON a.t_booking_id = b.id WHERE b.id = '".$request->booking_id."'");

        $result = array();
        foreach ($data as $key)
        {
            $result = array_merge($result, $key);
        }

        $detail = $result;

        $totalCost = 0;
        $totalSell = 0;
        foreach($detail as $row)
        {
            $totalCost += $row->cost_val;
            $totalSell += $row->sell_val;
        }

        $costV = $totalCost;
        $sellV = $totalSell;

        #Insert Tabel t_quote_profit
        $data = DB::select("SELECT a.* FROM t_bcharges_dtl a LEFT JOIN t_booking b ON a.t_booking_id = b.id WHERE flag_shp = 1 and b.id = '".$request->booking_id."'");
        if(count($detail) > 1){
            foreach($data as $shipping){
                $totalCost  = $shipping->cost_val + $costV;
                $totalSell  = $shipping->sell_val + $sellV;
                $profit     = $totalSell - $totalCost;
                $user = Auth::user()->name;
                $tanggal = Carbon::now();
                    try {
                        DB::table('t_boking_profit')->where('t_bcharges_id', $shipping->id)
                        ->update([
                            't_mcurrency_id'        => $shipping->t_mcurrency_id,
                            'total_cost'            => $totalCost,
                            'total_sell'            => $totalSell,
                            'total_profit'          => $profit,
                            'profit_pct'            => ($profit*100)/$totalSell,
                            'created_by'            => $user,
                            'created_on'            => $tanggal
                        ]);
                        $return_data = 'sukses';
                    } catch (\Exception $e) {
                        $return_data = $e->getMessage();
                    }
                }
            $return_data = 'sukses';
        }else{
            foreach($data as $shipping){
                $totalCost  = $shipping->cost_val + $costV;
                $totalSell = $shipping->sell_val + $sellV;
                $profit = $totalSell - $totalCost;
                $user = Auth::user()->name;
                $tanggal = Carbon::now();
                    try {
                        DB::table('t_booking_profit')->insert([
                            't_booking_id'          => $request->t_booking_id,
                            't_bcharges_id'         => $shipping->id,
                            't_mcurrency_id'        => $shipping->t_mcurrency_id,
                            'total_cost'            => $totalCost,
                            'total_sell'            => $totalSell,
                            'total_profit'          => $profit,
                            'profit_pct'            => ($profit*100)/$totalSell,
                            'created_by'            => $user,
                            'created_on'            => $tanggal
                        ]);
                        $return_data = 'sukses';
                    } catch (\Exception $e) {
                        $return_data = $e->getMessage();
                    }
                }
            $return_data = 'sukses';
        }

        header('Content-Type: application/json');
        echo json_encode($return_data);
    }

    public function bcharges_updateDetail(Request $request)
    {

        DB::beginTransaction();
        if($request->reimburs == 1){
            $r = 1;
            $request->sell = $request->cost;
            $request->sell_val = $request->cost_val;
            $request->total = str_replace(',','', $request->sell_val) * str_replace(',','', $request->qty);
            $request->cost_adjustment = 0;
        }else{
            $r = 0;
        }

        if($request->jenis_edit=='cost'){
            $client_name = null;
            $client_id = null;
            if(isset($request->name_to)){
                $company = MasterModel::company_get($request->name_to);
                $client_name = $company->client_name;
                $client_id = $request->name_to;
            }

            DB::table('t_bcharges_dtl')
            ->where('id', $request->id)
            ->update([
                't_mcharge_code_id' => $request->charge,
                'desc'              => $request->desc,
                'reimburse_flag'    => $r,
                'currency'    => $request->currency,
                'rate'              => $request->rate,
                'cost'              => $request->cost,
                'sell'              => $request->sell,
                'qty'               => $request->qty,
                'cost_adjustment'   => str_replace(',', '', $request->cost_adjustment),
                'cost_val'          => str_replace(',','', $request->cost_val),
                'sell_val'          => str_replace(',','', $request->sell_val),
                'vat'               => $request->vat,
                'term'              => $request->term,
                'paid_to'           => $client_name,
                'paid_to_id'        => $client_id,
                'subtotal'          => str_replace(',','', $request->total),
                'notes'             => $request->note,
            ]);

        }else if($request->jenis_edit=='sell'){
            $client_name = null;
            $client_id = null;
            if(isset($request->name_to)){
                $company = MasterModel::company_get($request->name_to);
                $client_name = $company->client_name;
                $client_id = $request->name_to;
            }
            DB::table('t_bcharges_dtl')
            ->where('id', $request->id)
            ->update([
                't_mcharge_code_id' => $request->charge,
                'desc'              => $request->desc,
                'reimburse_flag'    => $r,
                'currency'    => $request->currency,
                'rate'              => $request->rate,
                'cost'              => $request->cost,
                'sell'              => $request->sell,
                'qty'               => $request->qty,
                'cost_val'          => str_replace(',','', $request->cost_val),
                'sell_val'          => str_replace(',','', $request->sell_val),
                'vat'               => $request->vat,
                'term'              => $request->term,
                'bill_to'           => $client_name,
                'bill_to_id'        => $client_id,
                'subtotal'          => str_replace(',','', $request->total),
                'notes'             => $request->note,
            ]);
        }else{
            DB::table('t_bcharges_dtl')
            ->where('id', $request->id)
            ->update([
                't_mcharge_code_id' => $request->charge,
                'desc'              => $request->desc,
                'reimburse_flag'    => $r,
                'currency'    => $request->currency,
                'rate'              => $request->rate,
                'cost'              => $request->cost,
                'sell'              => $request->sell,
                'qty'               => $request->qty,
                'cost_val'          => str_replace(',','', $request->cost_val),
                'sell_val'          => str_replace(',','', $request->sell_val),
                'vat'               => $request->vat,
                'subtotal'          => str_replace(',','', $request->total),
                'notes'             => $request->note,
            ]);
        }

        $data[] = DB::select("SELECT a.* FROM t_bcharges_dtl a LEFT JOIN t_booking b ON a.t_booking_id = b.id WHERE b.id = '".$request->id_booking."'");

        $result = array();
        foreach ($data as $key)
        {
            $result = array_merge($result, $key);
        }

        $detail = $result;

        $totalCost = 0;
        $totalSell = 0;
        foreach($detail as $row)
        {
            $totalCost += $row->cost_val;
            $totalSell += $row->sell_val;
        }

        $costV = $totalCost;
        $sellV = $totalSell;

        #Insert Tabel t_quote_profit
        $data = DB::select("SELECT a.* FROM t_bcharges_dtl a LEFT JOIN t_booking b ON a.t_booking_id = b.id WHERE b.id = '".$request->booking_id."'");

        foreach($data as $shipping){
            $totalCost  = $shipping->cost_val + $costV;
            $totalSell  = $shipping->sell_val + $sellV;
            $profit     = $totalSell - $totalCost;
            $user = Auth::user()->name;
            $tanggal = Carbon::now();
                try {
                    DB::table('t_booking_profit')->where('t_bcharges_dtl', $shipping->id)
                    ->update([
                        't_mcurrency_id'        => $shipping->t_mcurrency_id,
                        'total_cost'            => $totalCost,
                        'total_sell'            => $totalSell,
                        'total_profit'          => $profit,
                        'profit_pct'            => ($profit*100)/$totalSell,
                        'created_by'            => $user,
                        'created_on'            => $tanggal
                    ]);
                    $return_data = 'sukses';
                } catch (\Exception $e) {
                    $return_data = $e->getMessage();
                }
        }
        DB::commit();
        $return_data = 'sukses';

        header('Content-Type: application/json');
        echo json_encode($return_data);
    }

    public function booking_cancel(Request $request)
    {
        try {
            $user = Auth::user()->name;
            $tanggal = Carbon::now();
            DB::table('t_booking')->where('id', $request->booking)->update([
                'status'            => 9,
                'updated_by'        => $user,
                'updated_at'        => $tanggal
            ]);

            $return_data = 'sukses';
            return redirect('booking/list')->with('status', 'Successfully Cancelled');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }

    public function booking_cancel_inv(Request $request)
    {
        try {
            $user = Auth::user()->name;
            $tanggal = Carbon::now();
            DB::table('t_booking')->where('id', $request->booking)->update([
                'status'            => 2,//cancel with invoice
                'updated_by'        => $user,
                'updated_at'        => $tanggal
            ]);

            $return_data = 'sukses';
            return redirect('booking/list')->with('status', 'Successfully Cancelled');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }

    public function getPort(Request $request){

      $search = $request->search;

      if($search == '' || strlen($search) < 3){
         $ports = DB::table('t_mport')->select('*')->orderBy('port_name','asc')->limit(5)->get();
      }else{
         $ports = DB::table('t_mport')->select('*')->where('port_name', 'like', '%' .$search . '%')->orderBy('port_name','asc')->get();
      }

      $response = array();
      foreach($ports as $port){
         $response[] = array(
              "id"=>$port->id,
              "text"=>$port->port_name,
         );
      }

      return response()->json($response);
    }


    public function getExistingPort(Request $request){

      $booking_id = $request->booking_id;
      $response = [];

      $data = collect(DB::select('SELECT b.pol_id, b.pot_id, b.pod_id, pol.port_name as pol, pot.port_name as pot, pod.port_name as pod
            FROM t_booking b
                left join t_mport pol on b.pol_id = pol.id
                left join t_mport pot on b.pot_id = pot.id
                left join t_mport pod on b.pod_id = pod.id
            where b.id ='.$booking_id))->first();

      if($data->pol_id>0){
         $response['pol'] = array(
              "id"=>$data->pol_id,
              "text"=>$data->pol,
         );
      }

      if($data->pot_id>0){
         $response['pot'] = array(
              "id"=>$data->pot_id,
              "text"=>$data->pot,
         );
      }

      if($data->pod_id>0){
         $response['pod'] = array(
              "id"=>$data->pod_id,
              "text"=>$data->pod,
         );
      }
      // $response['id'] = [
      //   'pol' => $data->pol_id,
      //   'pot' => $data->pot_id,
      //   'podisc' => $data->pod_id,
      // ];

      return response()->json($response);
    }

    public function update_request(Request $request)
    {
        try {
            $user = Auth::user()->name;
            $tanggal = Carbon::now();
            DB::table('t_booking')
            ->where('id', $request->id_booking)
            ->update([
                'status'            => 8,
                'open_remarks'      => $request->open_remarks,
                'updated_by'        => $user,
                'updated_at'        => $tanggal
            ]);

            return redirect('booking/list')->with('status', 'Successfully Requested');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }

    public function approve_request(Request $request)
    {
        try {
            $user = Auth::user()->name;
            $tanggal = Carbon::now();
            DB::table('t_booking')
            ->where('id', $request->id_booking)
            ->update([
                'status'            => 0,
                'flag_invoice'      => 0,
                'approved_by'        => $user,
                'approved_at'        => $tanggal
            ]);

            return redirect('booking/list')->with('status', 'Successfully Approved');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }

    public function booking_getDetailCharges(Request $request)
    {
        $data = BookingModel::getChargesDetailById($request->id);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
