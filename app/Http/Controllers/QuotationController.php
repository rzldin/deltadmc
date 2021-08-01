<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\QuotationModel;
use App\MasterModel;
use Carbon\Carbon;
use DB;

class QuotationController extends Controller
{
    public function index()
    {
        $data = QuotationModel::getQuote();
        return view('quotation.list_quote', compact('data'));
    }

    public function quote_add(Request $request)
    {
        $version = $request->segment(3);
        $loaded = MasterModel::loaded_get();
        $company = MasterModel::company_data();
        $inco = MasterModel::incoterms_get();
        $port = MasterModel::port();
        $uom = MasterModel::uom();
        return view('quotation.quote_add', compact('company', 'inco', 'port', 'uom', 'version', 'loaded'));
    }

    public function get_pic(Request $request)
    {
        $table = '';
        $data = MasterModel::get_pic($request['id']);
        $table .= '<option value="">-- Select PIC --</option>';
        foreach($data as $d)
        {
            $table .= '<option value="'.$d->id.'">'.$d->name.'</option>';
        }

        header('Content-Type: application/json');
        echo json_encode($table);
    }

    public function get_customer()
    {
        $table = '';
        $data = MasterModel::company_data();
        $table .= '<option value="">-- Select Customer --</option>';
        foreach($data as $d)
        {
            $table .= '<option value="'.$d->id.'">'.$d->client_name.'</option>';
        }

        header('Content-Type: application/json');
        echo json_encode($table);
    }

    public function quote_doAdd(Request $request)
    {
        if($request->hazard == 'on'){
            $h = 1;
        }else{
            $h = 0;
        }

        if($request->final == 'on'){
            $f = 1;
        }else{
            $f = 0;
        }

        if($request->delivery == 'on'){
            $del = 1;
        }else{
            $del = 0;
        }
        
        if($request->custom == 'on'){
            $custom = 1;
        }else{
            $custom = 0;
        }

        if($request->fumigation == 'on'){
            $fumi = 1;
        }else{
            $fumi = 0;
        }

        if($request->goods == 'on'){
            $goods = 1;
        }else{
            $goods = 0;
        }
        

        try {
            $user = Auth::user()->name;
            $tanggal = Carbon::now();
            $id = DB::table('t_quote')->insertGetId([
                    'quote_no'              => $request->quote_no,
                    'version_no'            => $request->version,
                    'quote_date'            => Carbon::parse($request->date),
                    'customer_id'           => $request->customer,
                    'activity'              => $request->activity,
                    't_mloaded_type_id'     => $request->loaded,
                    't_mpic_id'             => $request->pic,
                    'shipment_by'           => $request->shipment,
                    'terms'                 => $request->terms,
                    'from_text'             => $request->from,
                    'from_id'               => $request->form_id,
                    'to_text'               => $request->to,
                    'to_id'                 => $request->to_id,
                    'commodity'             => $request->commodity,
                    'pieces'                => $request->pieces,
                    'weight'                => $request->weight,
                    'weight_uom_id'         => $request->uom_weight,
                    'volume'                => $request->volume,
                    'volume_uom_id'         => $request->uom_volume,
                    'final_flag'            => $f,
                    'hazardous_flag'        => $h,
                    'hazardous_info'        => $request->hazard_txt,
                    'additional_info'       => $request->additional,
                    'pickup_delivery_flag'  => $del,
                    'custom_flag'           => $custom,
                    'fumigation_flag'       => $fumi,
                    'stackable_flag'        => $goods,
                    'created_by'            => $user,
                    'created_on'            => $tanggal
                ]);

            return redirect('quotation/quote_edit/'.$id)->with('status', 'Successfully added');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }

    public function quote_edit($id)
    {       
        $quote = QuotationModel::get_detailQuote($id);
        
        $data['loaded'] = MasterModel::loaded_get();
        $data['company'] = MasterModel::company_data();
        $data['inco'] = MasterModel::incoterms_get();
        $data['port'] = MasterModel::port();
        $data['uom'] = MasterModel::uom();
        $data['charge'] = MasterModel::charge();
        $data['carrier'] = MasterModel::carrier();
        $data['currency'] = MasterModel::currency();
        $data['volume_uom'] = DB::table('t_muom')->where('id', $quote->volume_uom_id)->first();
        $data['quote'] = $quote;
        return view('quotation.quote_edit')->with($data);
    }

    public function quote_new($id)
    {       
        $quote = QuotationModel::get_detailQuote($id);
        
        $data['loaded'] = MasterModel::loaded_get();
        $data['company'] = MasterModel::company_data();
        $data['inco'] = MasterModel::incoterms_get();
        $data['port'] = MasterModel::port();
        $data['uom'] = MasterModel::uom();
        $data['charge'] = MasterModel::charge();
        $data['carrier'] = MasterModel::carrier();
        $data['currency'] = MasterModel::currency();
        $data['volume_uom'] = DB::table('t_muom')->where('id', $quote->volume_uom_id)->first();
        $data['quote'] = $quote;
        $data['old_id'] = $id; 
        return view('quotation.quote_new_version')->with($data);
    }

    public function quote_approved(Request $request)
    {
        try {
            DB::table('t_quote')
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

    public function cek_version(Request $request)
    {
        $quote = DB::select("SELECT * FROM t_quote WHERE quote_no = '".$request->quote_no."'");
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
        
        $quote = DB::select("SELECT * FROM t_quote WHERE quote_no = '".$request->quote_no."'");

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

    public function quote_getView(Request $request)
    {
        $quote = DB::table('t_quote')
                ->leftJoin('t_mcompany', 't_quote.customer_id', '=', 't_mcompany.id')
                ->leftJoin('t_mloaded_type', 't_quote.t_mloaded_type_id', '=', 't_mloaded_type.id')
                ->leftJoin('t_mpic', 't_quote.t_mpic_id', '=', 't_mpic.id')
                ->leftJoin('t_mport', 't_quote.from_id', '=', 't_mport.id')
                ->leftJoin('t_muom', 't_quote.weight_uom_id', '=', 't_muom.id')
                ->leftJoin('t_mincoterms', 't_quote.terms', '=', 't_mincoterms.id')
                ->select('t_quote.*', 't_mcompany.client_name', 't_mloaded_type.loaded_type', 't_mpic.name as name_pic','t_mport.port_name', 't_muom.uom_code', 't_mpic.id as id_pic', 't_mincoterms.incoterns_code')
                ->where([
                        ['t_quote.quote_no', '=', $request->quote_no],
                        ['t_quote.version_no', '=', $request->version],
                    ])->first();

        $dimension  = QuotationModel::get_quoteDimension($quote->id);;
        $shipping   = QuotationModel::get_quoteShipping($quote->id);
        $quoteDtl   = QuotationModel::get_quoteDetail($quote->id);
        $profit     = QuotationModel::get_quoteProfit($quote->id);

        $data['loaded']     = MasterModel::loaded_get();
        $data['uom']        = MasterModel::uom();
        $data['quote']      = $quote;
        $data['dimension']  = $dimension;
        $data['shipping']   = $shipping;
        $data['quoteDtl']   = $quoteDtl;
        $data['profit']     = $profit;

        return view('quotation.quote_view')->with($data);
    }

    public function quote_addDimension(Request $request)
    {
        $cek = DB::table('t_quote_dimension')->where('t_quote_id', $request->quote)->orderBy('created_on', 'desc')->first();
        if($cek == null){
            $p = 1;
        }else{
            $p = $cek->position_no + 1;
        }
        try {
            $user = Auth::user()->name;
            $tanggal = Carbon::now();
            DB::table('t_quote_dimension')->insert([
                't_quote_id'        => $request->quote,
                'position_no'       => $p,
                'length'            => $request->length,
                'width'             => $request->width,
                'height'            => $request->height,
                'height_uom_id'     => $request->height_uom,
                'wight'             => $request->wight,
                'pieces'            => $request->pieces,
                'wight_uom_id'      => $request->wight_uom,
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

    public function quote_loadDimension(Request $request)
    {
        $tabel = "";
        $no = 2;
        $data = QuotationModel::get_quoteDimension($request['id']);
        
            foreach($data as $row)
            {
                $wight_uom = DB::table('t_muom')->where('id', $row->wight_uom_id)->first();
                $tabel .= '<tr>';
                $tabel .= '<td class="text-right">'.($no-1).'</td>';
                $tabel .= '<td class="text-right"><label id="lbl_length_'.$no.'">'.$row->le_dimen.'</label><input type="text" id="length_'.$no.'" name="length" class="form-control" value="'.$row->le_dimen.'" style="display:none"></td>';
                $tabel .= '<td class="text-right"><label id="lbl_width_'.$no.'">'.$row->width.'</label>';
                $tabel .= '<input type="text" id="width_'.$no.'" name="width" class="form-control" value="'.$row->width.'" style="display:none"></td>';
                $tabel .= '<td class="text-right"><label id="lbl_height_'.$no.'">'.$row->height.'</label>';
                $tabel .= '<input type="text" id="height_'.$no.'" name="height" class="form-control" '
                    . ' value="'.$row->height.'" style="display:none"></td>';
                $tabel .= '<td class="text-center"><label id="lbl_height_uom_'.$no.'">'.$row->uom_code.'</label>';
                    $tabel .= '<select id="height_uom_'.$no.'" name="height_uom" class="form-control select2bs44" ';
                    $tabel .= 'data-placeholder="Pilih..." style="margin-bottom:5px; display:none" >';
                    $tabel .= '<option value=""></option>';
                    $tabel .= '</select>';
                $tabel .= '</td>';
                $tabel .= '<td class="text-right"><label id="lbl_pieces_'.$no.'">'.$row->pieces.'</label>';
                $tabel .= '<input type="text" id="pieces_'.$no.'" name="pieces" class="form-control" '
                    . ' value="'.$row->pieces.'" style="display:none">';
                $tabel .= '</td>';
                $tabel .= '<td class="text-right"><label id="lbl_wight_'.$no.'">'.$row->wight.'</label>';
                $tabel .= '<input type="text" id="wight_'.$no.'" name="wight" class="form-control" '
                    . ' value="'.$row->wight.'" style="display:none">';
                $tabel .= '</td>';
                $tabel .= '<td class="text-center"><label id="lbl_wight_uom_'.$no.'">'.$wight_uom->uom_code.'</label>';
                    $tabel .= '<select id="wight_uom_'.$no.'" name="wight_uom" class="form-control select2bs44" ';
                    $tabel .= 'data-placeholder="Pilih..." style="margin-bottom:5px; display:none" >';
                    $tabel .= '<option value=""></option>';
                    $tabel .= '</select>';
                $tabel .= '</td>';
                
                $tabel .= '<td style="text-align:center;">';
                $tabel .= '<a href="javascript:;" class="btn btn-xs btn-circle btn-primary'
                        . '" onclick="editDetaild('.$row->height_uom_id.','.$row->wight_uom_id.','.$no.');" style="margin-top:5px" id="btnEditd_'.$no.'"> '
                        . '<i class="fa fa-edit"></i> Edit &nbsp; </a>';
                $tabel .= '<a href="javascript:;" class="btn btn-xs btn-circle btn-success'
                        . '" onclick="updateDetaild('.$row->id.','.$no.');" style="margin-top:5px; display:none" id="btnUpdated_'.$no.'"> '
                        . '<i class="fa fa-save"></i> Update </a>';
                $tabel .= '<a href="javascript:;" class="btn btn-xs btn-circle btn-danger'
                        . '" onclick="hapusDetaild('.$row->id.');" style="margin-top:5px"> '
                        . '<i class="fa fa-trash"></i> Delete </a>';
                $tabel .= '</td>';
                $tabel .= '</tr>';
                $no++;
            }

            header('Content-Type: application/json');
            echo json_encode($tabel);
    }


    public function quote_deleteDimension(Request $request)
    {
        try {
            DB::table('t_quote_dimension')->where('id', $request['id'])->delete();

            $return_data = 'sukses';
        } catch (\Exception $e) {
            $return_data = $e->getMessage();
        }

        header('Content-Type: application/json');
        echo json_encode($return_data);
    }

    public function uom_getAll()
    {
        $data = MasterModel::uom();
        return json_encode($data);
    }

    public function quote_updateDimension(Request $request)
    {
        try {
            DB::table('t_quote_dimension')
            ->where('id', $request->id)
            ->update([
                'length'            => $request->length,
                'width'             => $request->width,
                'height'            => $request->height,
                'height_uom_id'     => $request->height_uom,
                'wight'             => $request->wight,
                'pieces'            => $request->pieces,
                'wight_uom_id'      => $request->wight_uom
            ]);

            $return_data = 'sukses';
        } catch (\Exception $e) {
            $return_data = $e->getMessage();
        }

        header('Content-Type: application/json');
        echo json_encode($return_data);
    }

    public function quote_addShipping(Request $request)
    {
        $cek = DB::table('t_quote_shipg_dtl')->where('t_quote_id', $request->quote)->orderBy('created_on', 'desc')->first();
        if($cek == null){
            $p = 1;
        }else{
            $p = $cek->position_no + 1;
        }
        try {
            $user = Auth::user()->name;
            $tanggal = Carbon::now();
            DB::table('t_quote_shipg_dtl')->insert([
                't_quote_id'        => $request->quote,
                'position_no'       => $p,
                't_mcarrier_id'     => $request->carrier,
                'routing'           => $request->routing,
                'transit_time'      => $request->transit,
                'truck_size'        => $request->truck_size,
                't_mcurrency_id'    => $request->currency,
                'rate'              => $request->rate,
                'cost'              => $request->cost,
                'sell'              => $request->sell,
                'qty'               => $request->qty,
                'cost_val'          => str_replace(',','', $request->cost_val),
                'sell_val'          => str_replace(',','', $request->sell_val),
                'vat'               => $request->vat,
                'subtotal'          => str_replace(',','', $request->total),
                'notes'             => $request->note,
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


    public function quote_loadShipping(Request $request)
    {
        $tabel = "";
        $no = 2;
        $data = QuotationModel::get_quoteShipping($request['quote_no']);
        $quote = QuotationModel::get_detailQuote($request['id']);

        if(count($data) > 0){

            foreach($data as $row)
            {
                $tabel .= '<tr>';
                $tabel .= '<td class="text-right">'.($no-1).'</td>';
                if($quote->shipment_by == 'LAND'){
                    $tabel .= '<td>'.$row->truck_size.'</td>';     
                }else{
                    $tabel .= '<td>'.$row->name_carrier.'</td>';
                    $tabel .= '<td>'.$row->routing.'</td>';
                    $tabel .= '<td class="text-right">'.$row->transit_time.'</td>';
                }
                $tabel .= '<td>'.$row->code_currency.'</td>';
                $tabel .= '<td class="text-right">'.number_format($row->rate,2,',','.').'</td>';
                $tabel .= '<td class="text-right">'.number_format($row->cost,2,',','.').'</td>';
                $tabel .= '<td class="text-right">'.number_format($row->sell,2,',','.').'</td>';
                $tabel .= '<td class="text-right">'.$row->qty.'</td>';
                $tabel .= '<td class="text-right">'.number_format($row->cost_val,2,',','.').'</td>';
                $tabel .= '<td class="text-right">'.number_format($row->sell_val,2,',','.').'</td>';
                $tabel .= '<td class="text-right">'.number_format($row->vat,2,',','.').'</td>';
                $tabel .= '<td class="text-right">'.number_format($row->subtotal,2,',','.').'</td>';
                $tabel .= '<td>'.$row->notes.'</td>';
                $tabel .= '<td style="text-align:center;">';
                $tabel .= '<a href="javascript:;" class="btn btn-xs btn-circle btn-primary'
                        . '" onclick="editDetails('.$row->id.');" style="margin-top:5px">'
                        . '<i class="fa fa-edit"></i> Edit</a>';
                $tabel .= '<a href="javascript:;" class="btn btn-xs btn-circle btn-danger'
                        . '" onclick="hapusDetails('.$row->id.');" style="margin-top:5px"> '
                        . '<i class="fa fa-trash"></i> Del&nbsp;&nbsp;</a>';
                $tabel .= '</td>';
                $tabel .= '</tr>';
                $no++;
            }
        }else{
            if($quote->shipment_by == 'LAND'){
                $colspan = '13';
            }else{
                $colspan = '15';
            }
            $tabel .= '<tr>';
                $tabel .= '<td class="text-center" colspan='.$colspan.'>Not Available data.';
                $tabel .= '</td>';
            $tabel .= '</td>';
        }
        

            header('Content-Type: application/json');
            echo json_encode($tabel);
    }

    public function quote_deleteShipping(Request $request)
    {
        try {
            DB::table('t_quote_shipg_dtl')->where('id', $request['id'])->delete();

            $return_data = 'sukses';
        } catch (\Exception $e) {
            $return_data = $e->getMessage();
        }

        header('Content-Type: application/json');
        echo json_encode($return_data);
    }

    public function quote_getDetailShipping(Request $request)
    { 
        $data = QuotationModel::getShippingDetail($request->id);
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function quote_updateShipping(Request $request)
    {
        try {
            DB::table('t_quote_shipg_dtl')
            ->where('id', $request->id)
            ->update([
                't_mcarrier_id'     => $request->carrier,
                'routing'           => $request->routing,
                'transit_time'      => $request->transit,
                'truck_size'        => $request->truck_size,
                't_mcurrency_id'    => $request->currency,
                'rate'              => $request->rate,
                'cost'              => $request->cost,
                'sell'              => $request->sell,
                'qty'               => $request->qty,
                'cost_val'          => str_replace(',','', $request->cost_val),
                'sell_val'          => str_replace(',','', $request->sell_val),
                'vat'               => $request->vat,
                'subtotal'          => str_replace(',','', $request->total),
                'notes'             => $request->note
            ]);

            $return_data = 'sukses';
        } catch (\Exception $e) {
            $return_data = $e->getMessage();
        }

        header('Content-Type: application/json');
        echo json_encode($return_data);
    }

    public function quote_addDetail(Request $request)
    {
        $cek = DB::table('t_quote_dtl')->where('t_quote_id', $request->quote)->orderBy('created_on', 'desc')->first();
        if($cek == null){
            $p = 1;
        }else{
            $p = $cek->position_no + 1;
        }

        if($request->reimburs == 1){
            $r = 1;
        }else{
            $r = 0;
        }

        // try {
        $user = Auth::user()->name;
        $tanggal = Carbon::now();
        DB::table('t_quote_dtl')->insert([
            't_quote_id'        => $request->quote,
            'position_no'       => $p,
            't_mcharge_code_id' => $request->charge,
            'desc'              => $request->desc,
            'reimburse_flag'    => $r,
            't_mcurrency_id'    => $request->currency,
            'rate'              => $request->rate,
            'cost'              => $request->cost,
            'sell'              => $request->sell,
            'qty'               => $request->qty,
            'cost_val'          => str_replace(',', '', $request->cost_val),
            'sell_val'          => str_replace(',','', $request->sell_val),
            'vat'               => $request->vat,
            'subtotal'          => str_replace(',','', $request->total),
            'notes'             => $request->note,
            'created_by'        => $user,
            'created_on'        => $tanggal
        ]);

        $data[] = DB::select("SELECT a.* FROM t_quote_dtl a LEFT JOIN t_quote b ON a.t_quote_id = b.id WHERE b.quote_no = '".$request->quote_no."'");

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

        $data = DB::select("SELECT a.* FROM t_quote_shipg_dtl a LEFT JOIN t_quote b ON a.t_quote_id = b.id WHERE b.quote_no = '".$request->quote_no."'");
        if(count($detail) > 1){
            foreach($data as $shipping){
                $profit = ($shipping->sell_val + $sellV) - ($shipping->cost_val + $costV);
                $totalSell = $shipping->sell_val + $sellV;
                $user = Auth::user()->name;
                $tanggal = Carbon::now();
                    try {
                        DB::table('t_quote_profit')->where('t_quote_ship_dtl_id', $shipping->id)
                        ->update([
                            't_mcurrency_id'        => $shipping->t_mcurrency_id,
                            'total_cost'            => $shipping->cost_val + $costV,
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
                $profit = ($shipping->sell_val + $sellV) - ($shipping->cost_val + $costV);
                $totalSell = $shipping->sell_val + $sellV;
                $user = Auth::user()->name;
                $tanggal = Carbon::now();
                    try {
                        DB::table('t_quote_profit')->insert([
                            't_quote_id'            => $shipping->t_quote_id,
                            't_quote_ship_dtl_id'   => $shipping->id,
                            't_mcurrency_id'        => $shipping->t_mcurrency_id,
                            'total_cost'            => $shipping->cost_val + $costV,
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

    public function quote_loadDetail(Request $request)
    {
        $tabel = "";
        $no = 2;
        $data = QuotationModel::get_quoteDetail($request['id']);

            if(count($data) > 0)
            {
                foreach($data as $row)
                {
                    $tabel .= '<tr>';
                    $tabel .= '<td class="text-right">'.($no-1).'</td>';
                    $tabel .= '<td class="text-right">'.$row->name_charge.'</td>';
                    $tabel .= '<td class="text-right">'.$row->desc.'</td>';
                    if($row->reimburse_flag == 1){
                        $tabel .= '<td class="text-center"><input type="checkbox" class="form_control" id="reimburs_'.$no.'" checked onchange="reims('.$no.')"></td>';
                        $tabel .= '<input type="hidden" name="reimbursxx" id="reimbursx_'.$no.'" value="">';
                    }else{
                        $tabel .= '<td class="text-center"><input type="checkbox" class="form_control" id="reimburs_'.$no.'" onchange="reims('.$no.')"></td>';
                        $tabel .= '<input type="hidden" name="reimbursxx" id="reimbursx_'.$no.'" value="">';
                    }
                    $tabel .= '<td class="text-center">'.$row->code_currency.'</td>';
                    $tabel .= '<td class="text-right">'.number_format($row->rate,2,',','.').'</td>';
                    $tabel .= '<td class="text-right">'.number_format($row->cost,2,',','.').'</td>';
                    $tabel .= '<td class="text-right">'.number_format($row->sell,2,',','.').'</td>';
                    $tabel .= '<td class="text-right">'.$row->qty.'</td>';
                    $tabel .= '<td class="text-right">'.number_format($row->cost_val,2,',','.').'</td>';
                    $tabel .= '<td class="text-right">'.number_format($row->sell_val,2,',','.').'</td>';
                    $tabel .= '<td class="text-right">'.number_format($row->vat,2,',','.').'</td>';
                    $tabel .= '<td class="text-right">'.number_format($row->subtotal,2,',','.').'</td>';
                    $tabel .= '<td class="text-right">'.$row->notes.'</td>';
                    $tabel .= '<td style="text-align:center;">';
                    $tabel .= '<a href="javascript:;" class="btn btn-xs btn-circle btn-primary'
                            . '" onclick="editDetailx('.$row->id.');" style="margin-top:5px" id="btnEditx_'.$no.'"> '
                            . '<i class="fa fa-edit"></i> Edit</a>';
                    $tabel .= '<a href="javascript:;" class="btn btn-xs btn-circle btn-danger'
                            . '" onclick="hapusDetailx('.$row->id.');" style="margin-top:5px"> '
                            . '<i class="fa fa-trash"></i> Del&nbsp;&nbsp;</a>';
                    $tabel .= '</td>';
                    $tabel .= '</tr>';
                    $no++;
                }

            }else{
                $tabel .= '<td colspan="15" class="text-center">Not Available.</td>';
            }
        

            header('Content-Type: application/json');
            echo json_encode($tabel);
    }

    public function quote_deleteDetail(Request $request)
    {
        try {
            DB::table('t_quote_dtl')->where('id', $request['id'])->delete();

            $return_data = 'sukses';
        } catch (\Exception $e) {
            $return_data = $e->getMessage();
        }

        header('Content-Type: application/json');
        echo json_encode($return_data);
    }

    public function quote_getDetailQ(Request $request)
    { 
        $data = QuotationModel::getDetailQuote($request->id);
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function quote_updateDetail(Request $request)
    {
        if($request->reimburs == 1){
            $r = 1;
        }else{
            $r = 0;
        }

        try {
            DB::table('t_quote_dtl')
            ->where('id', $request->id)
            ->update([
                't_mcharge_code_id' => $request->charge,
                'desc'              => $request->desc,
                'reimburse_flag'    => $r,
                't_mcurrency_id'    => $request->currency,
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

            $return_data = 'sukses';
        } catch (\Exception $e) {
            $return_data = $e->getMessage();
        }

        header('Content-Type: application/json');
        echo json_encode($return_data);
    }

    public function quote_addProfit(Request $request)
    {
        //dd($request->all());
        foreach($request->detail as $d)
        {
            $data[] = DB::select("SELECT * FROM t_quote_dtl WHERE id = '".$d."'");
        }

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
        foreach($request->shipping as $row)
        {
            $data = DB::select("SELECT * FROM t_quote_shipg_dtl WHERE id = '".$row."'");

            foreach($data as $shipping){
                $profit = ($shipping->sell_val + $sellV) - ($shipping->cost_val + $costV);
                $totalSell = $shipping->sell_val + $sellV;
                $user = Auth::user()->name;
                $tanggal = Carbon::now();
                try {
                    DB::table('t_quote_profit')->insert([
                        't_quote_id'            => $shipping->t_quote_id,
                        't_quote_ship_dtl_id'   => $shipping->id,
                        't_mcurrency_id'        => $shipping->t_mcurrency_id,
                        'total_cost'            => $shipping->cost_val + $costV,
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
           
        }

        header('Content-Type: application/json');
        echo json_encode($return_data);
    }


    public function quote_loadProfit(Request $request)
    {
        $tabel = "";
        $no = 2;
        $data = QuotationModel::get_quoteProfit($request->quote_no);
        $quote = QuotationModel::get_detailQuote($request->id);
        
            if(count($data) == 0){
                $tabel .= '<tr><td colspan="7" class="text-center"><strong>Not Available.</strong></td></tr>';
            }else{
                foreach($data as $row)
                {
                    $tabel .= '<tr>';
                    if($quote->shipment_by != 'LAND'){
                        $tabel .= '<td class="text-center"><strong>'.$row->carrier_code.'</strong></td>';
                        $tabel .= '<td class="text-center"><strong>'.$row->routing.'</strong></td>';
                        $tabel .= '<td class="text-center"><strong>'.$row->transit_time.'</strong></td>';
                    }
                    $tabel .= '<td class="text-center"><strong>'.$row->code_currency .' '. number_format($row->total_cost,2,',','.').'</strong></td>';
                    $tabel .= '<td class="text-center"><strong>'.$row->code_currency.' '. number_format($row->total_sell,2,',','.').'</strong></td>';
                    $tabel .= '<td class="text-center"><strong>'.$row->code_currency.' '. number_format($row->total_profit,2,',','.').'</strong></td>';
                    $tabel .= '<td class="text-center"><strong>'.$row->profit_pct.'%</strong></td>';
                    $tabel .= '</tr>';
                    $no++;
                }
            }

            header('Content-Type: application/json');
            echo json_encode($tabel);
    }

    public function quote_doUpdate(Request $request)
    {
        if($request->hazard == 'on'){
            $h = 1;
        }else{
            $h = 0;
        }

        if($request->final == 'on'){
            $f = 1;
        }else{
            $f = 0;
        }

        if($request->delivery == 'on'){
            $del = 1;
        }else{
            $del = 0;
        }
        
        if($request->custom == 'on'){
            $custom = 1;
        }else{
            $custom = 0;
        }

        if($request->fumigation == 'on'){
            $fumi = 1;
        }else{
            $fumi = 0;
        }

        if($request->goods == 'on'){
            $goods = 1;
        }else{
            $goods = 0;
        }

        try {
            DB::table('t_quote')
            ->where('id', $request->id_quote)
            ->update([
                'quote_no'              => $request->quote_no,
                'version_no'            => $request->version,
                'quote_date'            => Carbon::parse($request->date),
                'customer_id'           => $request->customer,
                'activity'              => $request->activity,
                't_mloaded_type_id'     => $request->loaded,
                't_mpic_id'             => $request->pic,
                'shipment_by'           => $request->shipment,
                'terms'                 => $request->terms,
                'from_text'             => $request->from,
                'from_id'               => $request->form_id,
                'to_text'               => $request->to,
                'to_id'                 => $request->to_id,
                'commodity'             => $request->commodity,
                'pieces'                => $request->pieces,
                'weight'                => $request->weight,
                'weight_uom_id'         => $request->uom_weight,
                'volume'                => $request->volume,
                'volume_uom_id'         => $request->uom_volume,
                'final_flag'            => $f,
                'hazardous_flag'        => $h,
                'hazardous_info'        => $request->hazard_txt,
                'additional_info'       => $request->additional,
                'pickup_delivery_flag'  => $del,
                'custom_flag'           => $custom,
                'fumigation_flag'       => $fumi,
                'stackable_flag'        => $goods,
            ]);

            return redirect('quotation/list')->with('status', 'Successfully Updated');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }

    }

}
