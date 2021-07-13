<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class BookingModel extends Model
{
    public static function get_booking()
    {
        return DB::select("SELECT a.*, b.client_name as company_b, c.client_name as company_c, d.client_name as company_d FROM t_booking a LEFT JOIN t_mcompany b ON a.client_id = b.id LEFT JOIN t_mcompany c ON a.consignee_id = c.id LEFT JOIN t_mcompany d ON a.shipper_id = d.id");
    }

    public static function get_bookingDetail($id)
    {
        return DB::select("SELECT a.*, b.quote_no, b.quote_date, b.shipment_by FROM t_booking a LEFT JOIN t_quote b ON a.t_quote_id = b.id WHERE a.id='".$id."'");
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
        return DB::select("SELECT a.*, b.loaded_type, c.container_type, d.uom_code FROM t_bcontainer a LEFT JOIN t_mloaded_type b ON a.t_mloaded_type_id = b.id LEFT JOIN t_mcontainer_type c ON a.t_mcontainer_type_id = c.id LEFT JOIN t_muom d ON a.vgm_uom = d.id WHERE a.t_booking_id='".$id."'");
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


}
