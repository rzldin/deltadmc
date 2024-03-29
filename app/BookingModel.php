<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class BookingModel extends Model
{
    public static function get_booking()
    {
        return DB::table('t_booking AS a')
                ->leftJoin('t_mcompany AS b', 'a.client_id', '=', 'b.id')
                ->leftJoin('t_mcompany AS c', 'a.consignee_id', '=', 'c.id')
                ->leftJoin('t_mcompany AS d', 'a.shipper_id', '=', 'd.id')
                ->select('a.*', 'b.client_name as company_b', 'c.client_name as company_c', 'd.client_name as company_d')
                ->where('a.status', '!=', 9)
                ->whereRaw('a.id in (SELECT MAX(id) FROM t_booking GROUP BY booking_no)')
                ->groupBy('a.booking_no')->get();
    }

    public static function get_booking_status($status)
    {
        return DB::table('t_booking AS a')
                ->leftJoin('t_mcompany AS b', 'a.client_id', '=', 'b.id')
                ->leftJoin('t_mcompany AS c', 'a.consignee_id', '=', 'c.id')
                ->leftJoin('t_mcompany AS d', 'a.shipper_id', '=', 'd.id')
                ->select('a.*', 'b.client_name as company_b', 'c.client_name as company_c', 'd.client_name as company_d')
                ->where('a.status', $status)
                ->whereRaw('a.id in (SELECT MAX(id) FROM t_booking GROUP BY booking_no)')
                ->groupBy('a.booking_no')->get();
    }

    public static function get_booking_header($id){
        return DB::table('t_booking AS a')
                ->leftJoin('t_quote AS q', 'a.t_quote_id', '=', 'q.id')
                ->leftJoin('t_mcompany AS b', 'a.client_id', '=', 'b.id')
                ->leftJoin('t_mcompany AS c', 'a.consignee_id', '=', 'c.id')
                ->leftJoin('t_mcompany AS d', 'a.shipper_id', '=', 'd.id')
                ->leftJoin('t_mloaded_type AS e', 'a.t_mloaded_type_id', '=', 'e.id')
                ->select('a.*', 'b.client_name as company_b', 'c.client_name as company_c', 'd.client_name as company_d', 'e.loaded_type', 'q.quote_no', 'q.quote_date')
                ->where('a.id', $id)
                ->groupBy('a.booking_no')->first();
    }

    public static function getAllBokingHasProforma()
    {
        return DB::table('t_booking AS b')
            ->join('t_proforma_invoice AS pi', 'pi.t_booking_id', '=', 'b.id')
            ->select('b.*');
    }

    public static function get_bookingDetail($id)
    {
        return DB::select("SELECT a.*, b.quote_no, b.quote_date, b.shipment_by, c.legal_doc_flag, d.loaded_type
            FROM t_booking a
            LEFT JOIN t_quote b ON a.t_quote_id = b.id
            LEFT JOIN t_mcompany c ON a.shipper_id = c.id
            LEFT JOIN t_mloaded_type d ON b.t_mloaded_type_id = d.id
            WHERE a.id='".$id."'");
    }

    public static function get_quoteProfit($id)
    {
        return DB::table('t_bcharges_dtl')
                ->leftJoin('t_mcarrier', 't_mcarrier.id', '=', 't_bcharges_dtl.t_mcarrier_id')
                ->leftJoin('t_booking', 't_booking.id', '=', 't_bcharges_dtl.t_booking_id')
                ->leftJoin('t_mcurrency', 't_mcurrency.id', '=', 't_bcharges_dtl.currency')
                ->leftJoin('t_invoice', 't_invoice.id', '=', 't_bcharges_dtl.t_invoice_id')
                ->select('t_bcharges_dtl.*', 't_mcarrier.name as name_carrier', 't_mcurrency.code as code_currency', 't_mcarrier.code as carrier_code', 't_invoice.invoice_no', 't_booking.shipment_by')
                ->where('t_bcharges_dtl.t_booking_id', $id)->get();
    }

    public static function get_commodity($id)
    {
        return DB::select("SELECT a.*, b.uom_code as code_b, c.uom_code as code_c, d.uom_code as code_d, e.uom_code as code_e 
            FROM t_bcommodity a 
                LEFT JOIN t_muom b ON a.uom_comm = b.id 
                LEFT JOIN t_muom c ON a.uom_packages = c.id 
                LEFT JOIN t_muom d ON a.weight_uom = d.id 
                LEFT JOIN t_muom e ON a.volume_uom = e.id 
                WHERE a.t_booking_id=".$id);
    }

    public static function get_packages($id)
    {
        return DB::select("SELECT a.*, b.uom_code as code_b FROM t_bpackages a LEFT JOIN t_muom b ON a.qty_uom = b.id WHERE a.t_booking_id='".$id."'");
    }

    public static function get_container($id)
    {
        return DB::select("SELECT a.*, b.loaded_type, c.container_type, d.uom_code, e.uom_code as code_qty, f.uom_code as code_weight,
                 g.booking_no
            FROM t_bcontainer a 
                LEFT JOIN t_mloaded_type b ON a.t_mloaded_type_id = b.id 
                LEFT JOIN t_mcontainer_type c ON a.t_mcontainer_type_id = c.id 
                LEFT JOIN t_muom d ON a.vgm_uom = d.id 
                LEFT JOIN t_muom e ON a.qty_uom = e.id 
                LEFT JOIN t_muom f ON a.weight_uom = f.id 
                LEFT JOIN t_booking g ON a.t_booking_id = g.id 
            WHERE a.t_booking_id='".$id."'");
    }

    public static function get_container_comm($id)
    {
        return DB::select("SELECT a.*, b.loaded_type, c.container_type, d.uom_code, e.uom_code as code_qty, 
                f.uom_code as code_weight, g.booking_no, COALESCE(cc.volume,'0') AS volume, h.uom_code as volume_code,
                COALESCE(cc.netto,'0') AS netto 
            FROM t_bcontainer a 
                LEFT JOIN t_mloaded_type b ON a.t_mloaded_type_id = b.id 
                LEFT JOIN t_mcontainer_type c ON a.t_mcontainer_type_id = c.id 
                LEFT JOIN t_muom d ON a.vgm_uom = d.id 
                LEFT JOIN t_muom e ON a.qty_uom = e.id 
                LEFT JOIN t_muom f ON a.weight_uom = f.id 
                LEFT JOIN t_booking g ON a.t_booking_id = g.id 
                LEFT JOIN t_bcommodity cc ON a.con_hs_code = cc.hs_code and cc.t_booking_id = g.id
                LEFT JOIN t_muom h ON cc.volume_uom = h.id
            WHERE a.t_booking_id='".$id."'");
    }

    public static function get_document($id)
    {
        return DB::select("SELECT a.*, b.name FROM t_bdocument a LEFT JOIN t_mdoc_type b ON a.t_mdoc_type_id = b.id WHERE a.t_booking_id='".$id."'");
    }

    public static function getRoadCons($id)
    {
        return DB::select("SELECT a.*, b.type, COALESCE(a.nopol,c.vehicle_no) as vehicle_no FROM t_broad_cons a 
            LEFT JOIN t_mvehicle_type b ON a.t_mvehicle_type_id = b.id 
            LEFT JOIN t_mvehicle c ON a.t_mvehicle_id = c.id WHERE a.t_booking_id ='".$id."'");
    }

    public static function roadConsDetail($id)
    {
        return DB::table('t_broad_cons')->where('id', $id)->first();
    }

    public static function getSchedule($id)
    {
        return DB::select("SELECT a.*, b.schedule_type FROM t_bschedule a LEFT JOIN t_mschedule_type b ON a.t_mschedule_type_id = b.id WHERE a.t_booking_id ='".$id."'");
    }

    public static function scheduleDetail($id)
    {
        return DB::table('t_bschedule')->where('id', $id)->first();
    }

    public static function getChargesDetail($id)
    {
        return DB::select("SELECT a.*, c.name as charge_name, d.code as code_cur, i.invoice_no, ii.invoice_no as invoice_no_cost, i3.flag_bayar, ii.flag_bayar AS flag_bayar_cost  from t_bcharges_dtl a
            LEFT JOIN t_booking b ON a.t_booking_id = b.id
            LEFT JOIN t_mcharge_code c ON a.t_mcharge_code_id = c.id
            LEFT JOIN t_mcurrency d ON a.currency = d.id
            LEFT JOIN t_invoice i ON i.id = a.t_invoice_id
            LEFT JOIN t_proforma_invoice i2 ON i.id = i2.t_invoice_id
            LEFT JOIN t_external_invoice i3 ON i2.id = i3.t_proforma_invoice_id
            Left JOIN t_invoice ii ON ii.id = a.t_invoice_cost_id
        WHERE a.t_booking_id='".$id."'");
    }

    public static function getChargesDetailById($id)
    {
        return DB::table('t_bcharges_dtl as a')
            ->select("a.*", "c.name as charge_name", "d.code as code_cur")
            ->leftJoin('t_booking as b', 'a.t_booking_id', '=', 'b.id')
            ->leftJoin('t_mcharge_code as c', 'a.t_mcharge_code_id', '=', 'c.id')
            ->LeftJoin('t_mcurrency as d', 'a.currency', '=', 'd.id')
            ->where('a.id', $id)->first();
    }

    public static function getChargesDetailUsingInId($id)
    {
        return DB::table('t_bcharges_dtl as a')
            ->select("a.*", "c.name as charge_name", "d.code as code_cur")
            ->leftJoin('t_booking as b', 'a.t_booking_id', '=', 'b.id')
            ->leftJoin('t_mcharge_code as c', 'a.t_mcharge_code_id', '=', 'c.id')
            ->LeftJoin('t_mcurrency as d', 'a.currency', '=', 'd.id')
            ->whereIn('a.id', $id)->get();
    }

    public static function getDetailBooking($id)
    {
        return DB::table('t_booking As a')
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

            ->leftJoin('t_mcompany AS anp_c', 'a.also_nf_id', '=', 'anp_c.id')
            ->leftJoin('t_maddress As anp_a', 'a.also_nf_addr_id', '=', 'anp_a.id')
            ->leftJoin('t_mpic AS anp_p', 'a.also_nf_pic_id', '=', 'anp_p.id')

            ->leftJoin('t_mcompany AS o', 'a.agent_id', '=', 'o.id')
            ->leftJoin('t_maddress As p', 'a.agent_addr_id', '=', 'p.id')
            ->leftJoin('t_mpic AS q', 'a.agent_pic_id', '=', 'q.id')

            ->leftJoin('t_mcompany AS r', 'a.shipping_line_id', '=', 'r.id')
            ->leftJoin('t_maddress As s', 'a.shpline_addr_id', '=', 's.id')
            ->leftJoin('t_mpic AS t', 'a.shpline_pic_id', '=', 't.id')

            ->leftJoin('t_mcompany AS u', 'a.vendor_id', '=', 'u.id')
            ->leftJoin('t_maddress As v', 'a.vendor_addr_id', '=', 'v.id')
            ->leftJoin('t_mpic AS w', 'a.vendor_pic_id', '=', 'w.id')

            ->leftJoin('t_mcompany AS trc', 'a.trucking_company', '=', 'trc.id')

            ->leftJoin('t_mcarrier AS carrier', 'a.carrier_id', '=', 'carrier.id')
            ->leftJoin('t_mcarrier AS carrier_2', 'a.carrier_id_2', '=', 'carrier_2.id')
            ->leftJoin('t_mcarrier AS carrier_3', 'a.carrier_id_3', '=', 'carrier_3.id')

            ->leftJoin('t_mport AS tm', 'a.pol_id', '=', 'tm.id')
            ->leftJoin('t_mport AS tm2', 'a.pod_id', '=', 'tm2.id')
            ->leftJoin('t_mport AS tm3', 'a.pot_id', '=', 'tm3.id')

            ->leftJoin('t_mfreight_charges AS tmc', 'a.t_mfreight_charges_id', '=', 'tmc.id')
            ->leftJoin('t_mincoterms AS tmin', 'a.t_mincoterms_id', '=', 'tmin.id')
            ->leftjoin('t_mbl_issued AS tmi', 'a.t_mbl_issued_id', '=', 'tmi.id')
            ->leftjoin('t_mbl_issued AS tmi2', 'a.t_hbl_issued_id', '=', 'tmi2.id')
            ->leftJoin('t_mloaded_type AS lt', 'a.t_mloaded_type_id', '=', 'lt.id')
            ->leftJoin('t_mloaded_type AS ltc', 'a.t_mcloaded_type_id', '=', 'ltc.id')
            ->select('a.*', 'b.quote_no', 'b.quote_date', 'b.shipment_by', 'c.client_name as company_c', 'd.address as address_c', 'e.name as pic_c', 'f.client_name as company_f', 'f.legal_doc_flag as legal_f', 'f.client_code as code_company_f', 'g.address as address_f', 'h.name as pic_f', 'i.client_name as company_i', 'j.address as address_i', 'k.name as pic_i', 'i.client_code as code_company_i', 'l.client_name as company_l', 'm.address as address_l', 'n.name as pic_l', 'o.client_name as company_o', 'p.address as address_o', 'q.name as pic_o', 'r.client_name as company_r', 's.address as address_r', 't.name as pic_r', 'u.client_name as company_u', 'v.address as address_u', 'w.name as pic_u', 'tmdoc.name as name_doc', 'tm.port_name as port1','tm3.port_name as port2', 'tm2.port_name as port3', 'tmc.freight_charge as charge_name', 'tmin.incoterns_code', 'tmi.name as issued', 'tmi.desc as issued_desc', 'tmi2.desc as hbl_issued_desc',
                'carrier.name as name_carrier', 'carrier_2.name as name_carrier_2', 'carrier_3.name as name_carrier_3',
                'anp_c.client_name as company_anp', 'anp_a.address as address_anp', 'anp_p.name as pic_anp', 'lt.loaded_type','ltc.loaded_type as loadedc_type','trc.client_name as trc_name'
            )
            ->where('a.id', '=', $id)->first();
    }
}
