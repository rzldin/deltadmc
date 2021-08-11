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
        $data = BookingModel::get_booking();
        return view('booking.list_booking', compact('data'));
    }

    public function edit_booking($id)
    {
        $data['quote']          = BookingModel::get_bookingDetail($id)[0];
        $data['doc']            = MasterModel::get_doc();
        $data['company']        = MasterModel::company_data();
        $data['inco']           = MasterModel::incoterms_get();
        $data['uom']            = MasterModel::uom();
        $data['container']      = MasterModel::container_get();
        $data['loaded']         = MasterModel::loaded_get();
        $data['vehicle_type']   = MasterModel::vehicleType_get();
        $data['vehicle']        = MasterModel::vehicle();
        $data['schedule']       = MasterModel::schedule_get();

        return view('booking.edit_booking')->with($data);
    }

    public function header_booking($id)
    {
        $quote                  = QuotationModel::get_detailQuote($id);
        $shipping               = QuotationModel::get_quoteShipping($quote->quote_no);
        $obj_merge              = (object) array_merge((array)$quote, (array("nomination_flag"=>0)), (array("carrier_id"=>$shipping[0]->t_mcarrier_id)));
        $data['quote']          = $obj_merge;
        $data['shipping']       = $shipping;
        return view('booking.header_booking')->with($data);
        
    }

    public function nomination()
    {   
        $data['doc']            = MasterModel::get_doc();
        $data['company']        = MasterModel::company_data();
        $data['cust_addr']      = DB::table('t_maddress')->get();
        $data['cust_pic']       = DB::table('t_mpic')->get();
        $data['carrier']        = MasterModel::carrier();
        $data['port']           = MasterModel::port();
        $data['currency']       = MasterModel::currency();
        $data['freight']        = MasterModel::freight_get();
        $data['mbl_issued']     = MasterModel::get_mbl_issued();
        $data['inco']           = MasterModel::incoterms_get();
        return view('booking.nomination')->with($data);
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
        $data['cust_addr']      = DB::table('t_maddress')->where('t_mcompany_id', $quote->customer_id)->get();
        $data['cust_pic']       = DB::table('t_mpic')->where('t_mcompany_id', $quote->customer_id)->get();
        return view('booking.view_header_export')->with($data);
    }

    public static function header_import($quote)
    {
        $data['quote']          = $quote;
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
        $address = MasterModel::get_address($request['id']);
        $pic = MasterModel::get_pic($request['id']);
        $table2 = MasterModel::company_get($request['id']);
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
        echo json_encode([$table, $table1, $table2]);
    }

    public function booking_doAdd(Request $request)
    {
        if($request->legal_doc == "on"){
            DB::table('t_mcompany')
            ->where('id', $request->shipper)
            ->update(['legal_doc_flag' => 1]);
        }

        if($request->quote_no == 'Nomination'){
            $nomination_flag = 1;
        }else{
            $nomination_flag = 0;
        }

        #Doc Date
        if($request->doc_date != null){
            $doc_date = Carbon::parse($request->doc_date);
        }else{
            $doc_date = null;
        }

        #Igm Date
        if($request->igm_date != null){
            $igm_date = Carbon::parse($request->igm_date);
        }else{
            $igm_date = null;
        }

        #Mbl Date
        if($request->mbl_date != null){
            $mbl_date = Carbon::parse($request->mbl_date);
        }else{
            $mbl_date = null;
        }

        #Hbl Date
        if($request->hbl_date != null){
            $hbl_date = Carbon::parse($request->hbl_date);
        }else{
            $hbl_date = null;
        }

        try{
            $user = Auth::user()->name;
            $tanggal = Carbon::now();
            $id =   DB::table('t_booking')->insertGetId([
                        't_quote_id'            => $request->id_quote,
                        'booking_no'            => $request->booking_no,
                        'booking_date'          => Carbon::parse($request->booking_date),
                        'version_no'            => $request->version_no,
                        'activity'              => $request->activity,
                        'nomination_flag'       => $nomination_flag,
                        't_mdoc_type_id'        => $request->doctype,
                        'custom_doc_no'         => $request->doc_no,
                        'custom_doc_date'       => $doc_date,
                        'igm_no'                => $request->igm_number,
                        'igm_date'              => $igm_date,
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
                        'flight_number'         => $request->voyage,
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
                        'stuffing_place'        => $request->pos,
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
                        'mbl_date'              => $mbl_date,
                        'valuta_mbl'            => $request->valuta_mbl,
                        'hbl_shipper'           => $request->shipper_hbl,
                        'hbl_consignee'         => $request->cons_hbl,
                        'hbl_not_party'         => $request->notify_hbl,
                        'hbl_no'                => $request->hbl_number,
                        'hbl_date'              => $hbl_date,
                        'valuta_hbl'            => $request->valuta_hbl,
                        't_mbl_issued_id'       => $request->mbl_issued,
                        'total_commodity'       => $request->total_commo,
                        'total_package'         => $request->total_package,
                        'total_container'       => $request->total_container,
                        'created_by'            => $user,
                        'created_on'            => $tanggal
                    ]);
            return redirect('booking/edit_booking/'.$id)->with('status', 'Successfully added');
        } catch (\Exception $e) {
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
                $tabel .= '<a href="javascript:;" class="btn btn-xs btn-circle btn-primary'
                        . '" onclick="editDetailCom('.$row->uom_comm.','.$row->uom_packages.','.$row->weight_uom.','.$row->volume_uom.','.$no.');" style="margin-top:5px" id="btnEditCom_'.$no.'"> '
                        . '<i class="fa fa-edit"></i> Edit &nbsp; </a>';
                $tabel .= '<a href="javascript:;" class="btn btn-xs btn-circle btn-success'
                        . '" onclick="updateDetailCom('.$row->id.','.$no.');" style="margin-top:5px; display:none" id="btnUpdateCom_'.$no.'"> '
                        . '<i class="fa fa-save"></i> Update </a>';
                $tabel .= '<a href="javascript:;" class="btn btn-xs btn-circle btn-danger'
                        . '" onclick="hapusDetailCom('.$row->id.');" style="margin-top:5px"> '
                        . '<i class="fa fa-trash"></i> Delete </a>';
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
                't_booking_id'      => $request->booking,
                'position_no'       => $p,
                'desc'              => $request->merk,
                'qty'               => $request->qty,
                'qty_uom'           => $request->unit,
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
                $tabel .= '<td class="text-left"><label id="lbl_merk_'.$no.'">'.$row->desc.'</label><input type="text" id="merk_'.$no.'" name="merk" class="form-control" value="'.$row->desc.'" style="display:none"></td>';
                $tabel .= '<td class="text-left"><label id="lbl_qtyx_'.$no.'">'.$row->qty.'</label>';
                $tabel .= '<input type="text" id="qtyx_'.$no.'" name="qtyx" class="form-control" value="'.$row->qty.'" style="display:none"></td>';
                $tabel .= '<td class="text-center"><label id="lbl_unit_'.$no.'">'.$row->code_b.'</label>';
                    $tabel .= '<select id="unit_'.$no.'" name="unit" class="form-control select2bs44" ';
                    $tabel .= 'data-placeholder="Pilih..." style="margin-bottom:5px; display:none" >';
                    $tabel .= '<option value=""></option>';
                    $tabel .= '</select>';
                $tabel .= '</td>';
                $tabel .= '<td style="text-align:center;">';
                $tabel .= '<a href="javascript:;" class="btn btn-xs btn-circle btn-primary'
                        . '" onclick="editDetailPckg('.$row->qty_uom.','.$no.');" style="margin-top:5px" id="btnEditPckg_'.$no.'"> '
                        . '<i class="fa fa-edit"></i> Edit &nbsp; </a>';
                $tabel .= '<a href="javascript:;" class="btn btn-xs btn-circle btn-success'
                        . '" onclick="updateDetailPckg('.$row->id.','.$no.');" style="margin-top:5px; display:none" id="btnUpdatePckg_'.$no.'"> '
                        . '<i class="fa fa-save"></i> Update </a>';
                $tabel .= '<a href="javascript:;" class="btn btn-xs btn-circle btn-danger'
                        . '" onclick="hapusDetailPckg('.$row->id.');" style="margin-top:5px"> '
                        . '<i class="fa fa-trash"></i> Delete </a>';
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
                'desc'              => $request->merk,
                'qty'               => $request->qty,
                'qty_uom'           => $request->unit,
            ]);

            $return_data = 'sukses';
        } catch (\Exception $e) {
            $return_data = $e->getMessage();
        }

        header('Content-Type: application/json');
        echo json_encode($return_data);
    }


    public function addContainer(Request $request)
    {
        try {
            $user = Auth::user()->name;
            $tanggal = Carbon::now();
            DB::table('t_bcontainer')->insert([
                't_booking_id'          => $request->booking,
                'container_no'          => $request->con_numb,
                'size'                  => $request->size,
                't_mloaded_type_id'     => $request->loaded,
                't_mcontainer_type_id'  => $request->container,
                'seal_no'               => $request->seal_no,
                'vgm'                   => $request->vgm,
                'vgm_uom'               => $request->vgm_uom,
                'responsible_party'     => $request->resp_party,
                'authorized_person'     => $request->auth_person,
                'method_of_weighing'    => $request->mow,
                'weighing_party'        => $request->w_party,
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
                $tabel .= '<td class="text-left"><label id="lbl_con_numb_'.$no.'">'.$row->container_no.'</label><input type="text" id="con_numb_'.$no.'" name="con_numb" class="form-control" value="'.$row->container_no.'" style="display:none"></td>';
                $tabel .= '<td class="text-left"><label id="lbl_size_'.$no.'">'.$row->size.'</label>';
                $tabel .= '<input type="text" id="size_'.$no.'" name="size" class="form-control" value="'.$row->size.'" style="display:none"></td>';
                $tabel .= '<td class="text-center"><label id="lbl_loaded_'.$no.'">'.$row->loaded_type.'</label>';
                    $tabel .= '<select id="loaded_'.$no.'" name="loaded" class="form-control select2bs44" ';
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
                $tabel .= '<a href="javascript:;" class="btn btn-xs btn-circle btn-primary'
                        . '" onclick="editDetailCon('.$row->t_mloaded_type_id.','.$row->t_mcontainer_type_id.','.$no.');" style="margin-top:5px" id="btnEditCon_'.$no.'"> '
                        . '<i class="fa fa-edit"></i> Edit &nbsp; </a>';
                $tabel .= '<a href="javascript:;" class="btn btn-xs btn-circle btn-success'
                        . '" onclick="updateDetailCon('.$row->id.','.$no.');" style="margin-top:5px; display:none" id="btnUpdateCon_'.$no.'"> '
                        . '<i class="fa fa-save"></i> Update </a>';
                $tabel .= '<a href="javascript:;" class="btn btn-xs btn-circle btn-danger'
                        . '" onclick="hapusDetailCon('.$row->id.');" style="margin-top:5px"> '
                        . '<i class="fa fa-trash"></i> Delete </a>';
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
                'container_no'          => $request->con_numb,
                'size'                  => $request->size,
                't_mloaded_type_id'     => $request->loaded,
                't_mcontainer_type_id'  => $request->container,
                'seal_no'               => $request->seal_no,
                'vgm'                   => $request->vgm,
                'vgm_uom'               => $request->vgm_uom,
                'responsible_party'     => $request->resp_party,
                'authorized_person'     => $request->auth_person,
                'method_of_weighing'    => $request->mow,
                'weighing_party'        => $request->w_party,
            ]);

            $return_data = 'sukses';
        } catch (\Exception $e) {
            $return_data = $e->getMessage();
        }

        header('Content-Type: application/json');
        echo json_encode($return_data);
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
                'doc_date'          => Carbon::parse($request->date),
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
                    $date = Carbon::parse($row->doc_date)->format('m/d/Y');
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
                $tabel .= '<input type="date" class="form-control" name="doc_date" id="doc_date_'.$no.'" value="'.$date.'" style="display:none">';
                $tabel .= '</td>';
                $tabel .= '<td style="text-align:center;">';
                $tabel .= '<a href="javascript:;" class="btn btn-xs btn-circle btn-primary'
                        . '" onclick="editDetailDoc('.$row->t_mdoc_type_id.','.$no.');" style="margin-top:5px" id="btnEditDoc_'.$no.'"> '
                        . '<i class="fa fa-edit"></i> Edit &nbsp; </a>';
                $tabel .= '<a href="javascript:;" class="btn btn-xs btn-circle btn-success'
                        . '" onclick="updateDetailDoc('.$row->id.','.$no.');" style="margin-top:5px; display:none" id="btnUpdateDoc_'.$no.'"> '
                        . '<i class="fa fa-save"></i> Update </a>';
                $tabel .= '<a href="javascript:;" class="btn btn-xs btn-circle btn-danger'
                        . '" onclick="hapusDetailDoc('.$row->id.');" style="margin-top:5px"> '
                        . '<i class="fa fa-trash"></i> Delete </a>';
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
                'doc_date'          => Carbon::parse($request->date)
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
        $data = BookingModel::get_bookingDetail($id);
        $quote = $data[0];
        return view('booking.new_version', compact('quote'));
    }

    public function doUpdate(Request $request)
    {
        try {
            DB::table('t_booking')
            ->where('id', $request->id_booking)
            ->update([
                'booking_no'            => $request->booking_no,
                'booking_date'          =>  Carbon::parse($request->booking_date),
                't_mdoc_type_id'        => $request->doctype,
                'custom_doc_no'         => $request->doc_no,
                'custom_doc_date'       => Carbon::parse($request->doc_date),
                'igm_no'                => $request->igm_number,
                'igm_date'              => Carbon::parse($request->igm_date),
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
                'flight_number'         => $request->voyage,
                'eta_date'              => Carbon::parse($request->eta),
                'etd_date'              => Carbon::parse($request->etd),
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
                'total_commodity'       => $request->total_commo,
                'total_package'         => $request->total_package,
                'total_container'       => $request->total_container,
            ]);

            return redirect('booking/list')->with('status', 'Successfully Updated');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
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
                't_mvehicle_id'         => $request->vehicle_no,
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
                $tabel .= '<a href="javascript:;" class="btn btn-xs btn-circle btn-primary'
                        . '" onclick="editDetailRoad('.$row->id.');" style="margin-top:5px" id="btnEditPckg_'.$no.'"> '
                        . '<i class="fa fa-edit"></i> Edit &nbsp; </a>';
                $tabel .= '<a href="javascript:;" class="btn btn-xs btn-circle btn-danger'
                        . '" onclick="hapusDetailRoad('.$row->id.');" style="margin-top:5px"> '
                        . '<i class="fa fa-trash"></i> Delete </a>';
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
                't_mvehicle_id'         => $request->vehicle_no,
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
                'date'                  => Carbon::parse($request->date),
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
                $tabel .= '<a href="javascript:;" class="btn btn-xs btn-circle btn-primary'
                        . '" onclick="editDetailSch('.$row->id.');" style="margin-top:5px"> '
                        . '<i class="fa fa-edit"></i> Edit &nbsp; </a>';
                $tabel .= '<a href="javascript:;" class="btn btn-xs btn-circle btn-danger'
                        . '" onclick="hapusDetailSch('.$row->id.');" style="margin-top:5px"> '
                        . '<i class="fa fa-trash"></i> Delete </a>';
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
                'date'                  => Carbon::parse($request->date),
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
        $shipping   = QuotationModel::get_quoteShipping($request->quote_no);
        $dtlQuote   = QuotationModel::get_quoteDetail($request->quote_no);
       
        $user       = Auth::user()->name;
        $tanggal    = Carbon::now();
        $shp = $shipping[0];
        $cek = DB::table('t_bcharges_dtl')->where('t_booking_id', $request->id)->get();
        $no = 1;

        if(count($cek) == 0 && count($dtlQuote) > 0){
            foreach($dtlQuote as $row)
            {

                try {
                    DB::table('t_bcharges_dtl')
                    ->insert([
                        't_booking_id'          => $request->id,
                        'position_no'           => $no++,
                        't_mcharge_code_id'     => $row->t_mcharge_code_id,
                        'desc'                  => $shp->name_carrier,
                        'reimburse_flag'        => $row->reimburse_flag,
                        'currency'              => $row->t_mcurrency_id,
                        'rate'                  => $row->rate,
                        'cost'                  => $row->cost,
                        'sell'                  => $row->sell,
                        'qty'                   => $row->qty,
                        'cost_val'              => $row->qty * $row->cost_val,
                        'sell_val'              => $row->qty * $row->sell_val,
                        'vat'                   => $row->vat,
                        'subtotal'              => ($row->qty * $row->sell_val)+$row->vat,
                        'routing'               => $shp->routing,
                        'transit_time'          => $shp->transit_time,
                        'created_by'            => $user,
                        'created_on'            => $tanggal
                    ]);
                    $return_data = 'sukses';
                } catch (\Exception $e) {
                    $return_data = $e->getMessage();
                }
            }
        }

        $tabel = "";
        $tabel1 = "";
        $no = 2;
        $data       = BookingModel::getChargesDetail($request->id);
        $company    = MasterModel::company_data();
        $total = 0;
        $total2 = 0;
        $amount = 0;
        $amount2 = 0;
        $a = 1;
        $b = 2;
        //dd($data);
        foreach($data as $row)
            {
                if($row->reimburse_flag == 1){
                    $style = 'checked';
                }else{
                    $style = '';
                }

                $total = ($row->qty * $row->cost_val);
                $total2 += ($row->qty * $row->sell_val);
                $amount = ($total * $row->rate) + $row->vat;
                $amount2 += ($total2 * $row->rate) + $row->vat;

                // Cost
                $tabel .= '<tr>';
                $tabel .= '<td><input type="checkbox" name="cek_cost" value="'.$row->id.'"  id="cekx_'.$no.'"></td>';
                $tabel .= '<td>'.($no-1).'</td>';
                $tabel .= '<td class="text-left">'.$row->charge_name.'</td>';
                $tabel .= '<td class="text-left">'.$row->desc.' | Routing: '.$row->routing.' | Transit time : '.$row->transit_time.'</td>';
                $tabel .= '<td class="text-center"><input type="checkbox" name="reimburs" style="width:50px;" id="reimburs_'.$no.'" '.$style.'></td>';
                $tabel .= '<td class="text-left">'.$row->qty.'</td>';
                $tabel .= '<td class="text-left">'.$row->code_cur.'</td>';
                $tabel .= '<td class="text-right">'.number_format($row->cost_val,2,',','.').'</td>';
                $tabel .= '<td class="text-right">'.number_format(($row->qty * $row->cost_val),2,',','.').'</td>';
                $tabel .= '<td class="text-right">'.number_format($row->rate,2,',','.').'</td>';
                $tabel .= '<td class="text-right">'.number_format($row->vat,2,',','.').'</td>';
                $tabel .= '<td class="text-right">'.number_format($amount,2,',','.').'</td>';
                if($row->paid_to == null){
                    //$tabel .= '<td class="text-left"><input type="text" name="paid_to" id="paid_to_'.$no.'" placeholder="Paid to..." class="form-control"></td>';
                    $tabel .= '<td>';
                    $tabel .= '<select id="paid_to_'.$no.'" name="paid_to" class="form-control select2bs44"';
                    foreach($company as $item){
                        $tabel .= '<option value="'.$item->client_name.'">'.$item->client_code.'</option>';
                    }
                    $tabel .= '</select>';
                    $tabel .= '</td>';
                    $displayx = '';
                }else{
                    $tabel .= '<td class="text-left">'.$row->paid_to.'</td>';
                    $displayx = 'display:none';
                }
                
                $tabel .= '<td class="text-left"></td>';
                $tabel .= '<td>';
                $tabel .= '<a href="javascript:;" class="btn btn-xs btn-success'
                        . '" onclick="updateDetailSell('.$row->id.', '.$no.','.$a.');" style="'.$displayx.'"> '
                        . '<i class="fa fa-save"></i></a>';
                $tabel .= '<a href="javascript:;" style="margin-left:2px;" class="btn btn-xs btn-danger'
                        . '" onclick="hapusDetailSch('.$row->id.');"> '
                        . '<i class="fa fa-trash"></i></a>';
                $tabel .= '</td>';
                $tabel .= '</tr>';

                // Sell
                $tabel1 .= '<tr>';
                $tabel1 .= '<td><input type="checkbox" name="cek_sell" value="'.$row->id.'"  id="cekxx_'.$no.'"></td>';
                $tabel1 .= '<td>'.($no-1).'</td>';
                $tabel1 .= '<td class="text-left">'.$row->charge_name.'</td>';
                $tabel1 .= '<td class="text-left">'.$row->desc.' | Routing: '.$row->routing.' | Transit time : '.$row->transit_time.'</td>';
                $tabel1 .= '<td class="text-center"><input type="checkbox" name="reimburs" style="width:50px;" id="reimburs_'.$no.'" '.$style.'></td>';
                $tabel1 .= '<td class="text-left">'.$row->qty.'</td>';
                $tabel1 .= '<td class="text-left">'.$row->code_cur.'</td>';
                $tabel1 .= '<td class="text-right">'.number_format($row->sell_val,2,',','.').'</td>';
                $tabel1 .= '<td class="text-right">'.number_format($total2,2,',','.').'</td>';
                $tabel1 .= '<td class="text-right">'.number_format($row->rate,2,',','.').'</td>';
                $tabel1 .= '<td class="text-right">'.number_format($row->vat,2,',','.').'</td>';
                $tabel1 .= '<td class="text-right">'.number_format($amount2,2,',','.').'</td>';
                if($row->bill_to == null){
                    //$tabel1 .= '<td class="text-left"><input type="text" name="bill_to" id="bill_to_'.$no.'" placeholder="Bill to..." class="form-control"></td>';
                    $tabel1 .= '<td>';
                    $tabel1 .= '<select id="bill_to_'.$no.'" name="bill_to" class="form-control select2bs44" ';
                    $tabel1 .= 'data-placeholder="Pilih..." style="margin-bottom:5px;>';
                    $tabel1 .= '<option value="">--Select Company--</option>';
                    foreach($company as $item){
                        $tabel1 .= '<option value="'.$item->client_name.'">'.$item->client_code.'</option>';
                    }
                    $tabel1 .= '</select>';
                    $tabel1 .= '</td>';
                    $display = '';
                }else{
                    $tabel1 .= '<td class="text-left">'.$row->bill_to.'</td>';
                    $display = 'display:none';
                }


                $tabel1 .= '<td class="text-left"></td>';
                $tabel1 .= '<td>';
                $tabel1 .= '<a href="javascript:;" class="btn btn-xs btn-circle btn-success'
                        . '" onclick="updateDetailSell('.$row->id.', '.$no.', '.$b.');" style="margin-top:5px;'.$display.'"> '
                        . '<i class="fa fa-save"></i> Update &nbsp; </a>';
                $tabel1 .= '<a href="javascript:;" class="btn btn-xs btn-circle btn-danger'
                        . '" onclick="hapusDetailSell('.$row->id.');" style="margin-top:5px"> '
                        . '<i class="fa fa-trash"></i> Delete </a>';
                $tabel1 .= '</td>';
                $tabel1 .= '</tr>';
                $no++;
            }

        header('Content-Type: application/json');
        echo json_encode([$tabel, $tabel1]);
    }

    public function updateSell(Request $request)
    {
        try {
            if($request->v == 1){
                DB::table('t_bcharges_dtl')
                ->where('id', $request->id)
                ->update([
                    'paid_to'   => $request->paid_to
                ]);
            }else{
                DB::table('t_bcharges_dtl')
                ->where('id', $request->id)
                ->update([
                    'bill_to'   => $request->bill_to
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
        if(count($quote) == 1){
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
                    ->leftJoin('t_mport AS tm', 'a.pol_id', '=', 'tm.id')
                    ->leftJoin('t_mport AS tm2', 'a.pod_id', '=', 'tm2.id')
                    ->leftJoin('t_mport AS tm3', 'a.pot_id', '=', 'tm3.id')
                    ->leftJoin('t_mfreight_charges AS tmc', 'a.t_mfreight_charges_id', '=', 'tmc.id')
                    ->leftJoin('t_mincoterms AS tmin', 'a.t_mincoterms_id', '=', 'tmin.id')
                    ->leftjoin('t_mbl_issued AS tmi', 'a.t_mbl_issued_id', '=', 'tmi.id')
                    ->select('a.*', 'b.quote_no', 'b.quote_date', 'b.shipment_by', 'c.client_name as company_c', 'd.address as address_c', 'e.name as pic_c', 'f.client_name as company_f', 'f.legal_doc_flag as legal_f', 'g.address as address_f', 'h.name as pic_f', 'i.client_name as company_i', 'j.address as address_i', 'k.name as pic_i', 'l.client_name as company_l', 'm.address as address_l', 'n.name as pic_l', 'o.client_name as company_o', 'p.address as address_o', 'q.name as pic_o', 'r.client_name as company_r', 's.address as address_r', 't.name as pic_r', 'u.client_name as company_u', 'v.address as address_u', 'w.name as pic_u', 'tmdoc.name as name_doc', 'carrier.name as name_carrier', 'tm.port_name as port1','tm3.port_name as port2', 'tm2.port_name as port3', 'tmc.freight_charge as charge_name', 'tmin.incoterns_code', 'tmi.name as issued')
                    ->where([['a.booking_no', '=', $request->booking_no], ['a.version_no', '=', $request->version]])->first();
        
        $profit     = QuotationModel::get_quoteProfit($booking->quote_no);
        $quoteDtl   = QuotationModel::get_quoteDetail($booking->quote_no);
        $schedule   = BookingModel::getSchedule($booking->id);
        $roadCons   = BookingModel::getRoadCons($booking->id);
        $document   = BookingModel::get_document($booking->id);
        $container  = BookingModel::get_container($booking->id);
        $packages   = BookingModel::get_packages($booking->id);
        $commodity  = BookingModel::get_commodity($booking->id);
        
        $data['booking']    = $booking;
        $data['profit']     = $profit;
        $data['quoteDtl']   = $quoteDtl;
        $data['schedule']   = $schedule;
        $data['roadCons']   = $roadCons;
        $data['doc']        = $document;
        $data['container']  = $container;
        $data['packages']   = $packages;
        $data['commodity']  = $commodity;

        return view('booking.view_booking')->with($data);
    }

    public function approved(Request $request)
    {
        try {
            DB::table('t_booking')
            ->where('id', $request->id)
            ->update([
                'status'            => 1,
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
        $profit     = QuotationModel::get_quoteProfit($booking->quote_no);
        $quoteDtl   = QuotationModel::get_quoteDetail($booking->quote_no);
        $schedule   = BookingModel::getSchedule($booking->id);
        $roadCons   = BookingModel::getRoadCons($booking->id);
        $document   = BookingModel::get_document($booking->id);
        $container  = BookingModel::get_container($booking->id);
        $packages   = BookingModel::get_packages($booking->id);
        $commodity  = BookingModel::get_commodity($booking->id);

        $user = Auth::user()->name;
        $tanggal = Carbon::now();
        
        try {
        # Insert Booking
        $id =   DB::table('t_booking')->insertGetId([
            'version_no'            => $booking->version_no,
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
            'mbl_no'                => $booking->mbl_no,
            'valuta_mbl'            => $booking->valuta_mbl,
            'hbl_shipper'           => $booking->hbl_shipper,
            'hbl_consignee'         => $booking->hbl_consignee,
            'hbl_not_party'         => $booking->hbl_not_party,
            'hbl_no'                => $booking->hbl_no,
            'valuta_hbl'            => $booking->valuta_hbl,
            't_mbl_issued_id'       => $booking->t_mbl_issued_id,
            'total_commodity'       => $booking->total_commodity,
            'total_package'         => $booking->total_package,
            'total_container'       => $booking->total_container,
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

        return redirect('booking/edit_booking/'.$id)->with('status', 'Successfully Copy');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
            //return $e->getMessage();
        }
    }

}
