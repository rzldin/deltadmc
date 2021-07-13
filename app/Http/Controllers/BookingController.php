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
        $data['quote']          = $quote;
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

    public static function edit_header_domestic($quote)
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
        $data['cust_addr']      = DB::table('t_maddress')->where('t_mcompany_id', $quote->client_id)->get();
        $data['cust_pic']       = DB::table('t_mpic')->where('t_mcompany_id', $quote->client_id)->get();
        return view('booking.edit_header_domestic')->with($data);
    }

    public static function edit_header_export($quote)
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
        $data['cust_addr']      = DB::table('t_maddress')->where('t_mcompany_id', $quote->client_id)->get();
        $data['cust_pic']       = DB::table('t_mpic')->where('t_mcompany_id', $quote->client_id)->get();
        return view('booking.edit_header_export')->with($data);
    }

    public static function edit_header_import($quote)
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
            echo json_encode($tabel);
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
            echo json_encode($tabel);
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
                if($row->vgm != null){
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
            echo json_encode($tabel);
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
                $tabel .= '<td class="text-center"><label id="lbl_doc_date_'.$no.'">'.Carbon::parse($row->doc_date)->format('d/m/Y').'</label>';
                $tabel .= '<input type="date" class="form-control" name="doc_date" id="doc_date_'.$no.'" value="'.Carbon::parse($row->doc_date)->format('d/m/Y').'" style="display:none">';
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
        return view();
    }

    public function doUpdate(Request $request)
    {
        try {
            DB::table('t_booking')
            ->where('id', $request->id_booking)
            ->update([
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


}
