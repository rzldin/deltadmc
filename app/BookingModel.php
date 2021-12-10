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
                ->groupBy('a.booking_no')->get();
    }

    public static function getAllBokingHasProforma()
    {
        return DB::table('t_booking AS b')
            ->join('t_proforma_invoice AS pi', 'pi.t_booking_id', '=', 'b.id')
            ->select('b.*');
    }

    public static function get_bookingDetail($id)
    {
        return DB::select("SELECT a.*, b.quote_no, b.quote_date, b.shipment_by, c.legal_doc_flag, d.loaded_type FROM t_booking a LEFT JOIN t_quote b ON a.t_quote_id = b.id LEFT JOIN t_mcompany c ON a.shipper_id = c.id LEFT JOIN t_mloaded_type d ON b.t_mloaded_type_id = d.id  WHERE a.id='".$id."'");
    }

    public static function get_commodity($id)
    {
        return DB::select("SELECT a.*, b.uom_code as code_b, c.uom_code as code_c, d.uom_code as code_d, e.uom_code as code_e FROM t_bcommodity a LEFT JOIN t_muom b ON a.uom_comm = b.id LEFT JOIN t_muom c ON a.uom_packages = c.id LEFT JOIN t_muom d ON a.weight_uom = d.id LEFT JOIN t_muom e ON a.volume_uom = e.id WHERE a.t_booking_id='".$id."'");
    }

    public static function get_packages($id)
    {
        return DB::select("SELECT a.*, b.uom_code as code_b FROM t_bpackages a LEFT JOIN t_muom b ON a.qty_uom = b.id WHERE a.t_booking_id='".$id."'");
    }

    public static function get_container($id)
    {
        return DB::select("SELECT a.*, b.loaded_type, c.container_type, d.uom_code, e.booking_no FROM t_bcontainer a LEFT JOIN t_mloaded_type b ON a.t_mloaded_type_id = b.id LEFT JOIN t_mcontainer_type c ON a.t_mcontainer_type_id = c.id LEFT JOIN t_muom d ON a.vgm_uom = d.id LEFT JOIN t_booking e ON a.t_booking_id = e.id WHERE a.t_booking_id='".$id."'");
    }

    public static function get_document($id)
    {
        return DB::select("SELECT a.*, b.name FROM t_bdocument a LEFT JOIN t_mdoc_type b ON a.t_mdoc_type_id = b.id WHERE a.t_booking_id='".$id."'");
    }

    public static function getRoadCons($id)
    {
        return DB::select("SELECT a.*, b.type, c.vehicle_no FROM t_broad_cons a LEFT JOIN t_mvehicle_type b ON a.t_mvehicle_type_id = b.id LEFT JOIN t_mvehicle c ON a.t_mvehicle_id = c.id WHERE a.t_booking_id ='".$id."'");
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
        return DB::select("SELECT a.*, c.name as charge_name, d.code as code_cur, i.proforma_invoice_no from t_bcharges_dtl a
            LEFT JOIN t_booking b ON a.t_booking_id = b.id
            LEFT JOIN t_mcharge_code c ON a.t_mcharge_code_id = c.id
            LEFT JOIN t_mcurrency d ON a.currency = d.id
            LEFT JOIN t_proforma_invoice i ON i.id = a.t_invoice_id
            LEFT JOIN t_proforma_invoice i2 ON i2.id = a.t_invoice_cost_id
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
            ->select('a.*', 'b.quote_no', 'b.quote_date', 'b.shipment_by', 'c.client_name as company_c', 'd.address as address_c', 'e.name as pic_c', 'f.client_name as company_f', 'f.legal_doc_flag as legal_f', 'f.client_code as code_company_f', 'g.address as address_f', 'h.name as pic_f', 'i.client_name as company_i', 'j.address as address_i', 'k.name as pic_i', 'i.client_code as code_company_i', 'l.client_name as company_l', 'm.address as address_l', 'n.name as pic_l', 'o.client_name as company_o', 'p.address as address_o', 'q.name as pic_o', 'r.client_name as company_r', 's.address as address_r', 't.name as pic_r', 'u.client_name as company_u', 'v.address as address_u', 'w.name as pic_u', 'tmdoc.name as name_doc', 'carrier.name as name_carrier', 'tm.port_name as port1','tm3.port_name as port2', 'tm2.port_name as port3', 'tmc.freight_charge as charge_name', 'tmin.incoterns_code', 'tmi.name as issued')
            ->where('a.id', '=', $id)->first();
    }
}
