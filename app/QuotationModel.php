<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class QuotationModel extends Model
{
    public static function getQuote()
    {
        return DB::select("SELECT max(a.id) as id, a.quote_no, max(a.version_no) as version_no, max(a.quote_date) as quote_date, max(a.activity) as activity, max(a.shipment_by) as shipment_by, max(b.client_name) as client_name, max(c.name) as name_pic, max(d.loaded_type) as loaded_type, max(a.status) as status, max(a.created_on) as create_quote FROM t_quote a LEFT JOIN t_mcompany b ON a.customer_id = b.id LEFT JOIN t_mpic c ON a.t_mpic_id = c.id LEFT JOIN t_mloaded_type d ON a.t_mloaded_type_id = d.id GROUP BY a.quote_no");
    }

    public static function get_quoteProfit($quote_no)
    {
       return DB::table('t_quote_profit')
                ->leftJoin('t_quote_shipg_dtl', 't_quote_profit.t_quote_ship_dtl_id', '=', 't_quote_shipg_dtl.id')
                ->leftJoin('t_mcarrier', 't_mcarrier.id', '=', 't_quote_shipg_dtl.t_mcarrier_id')
                ->leftJoin('t_mcurrency', 't_mcurrency.id', '=', 't_quote_shipg_dtl.t_mcurrency_id')
                ->leftJoin('t_quote', 't_quote.id', '=', 't_quote_profit.t_quote_id')
                ->select('t_quote_profit.*', 't_mcarrier.code as carrier_code', 't_quote_shipg_dtl.routing', 't_quote_shipg_dtl.transit_time', 't_mcurrency.code as code_currency')
                ->where('t_quote.quote_no', $quote_no)->get();
    }

    public static function get_quoteDetail($quote_no)
    {
        return DB::table('t_quote_dtl')
                ->leftJoin('t_mcharge_code', 't_mcharge_code.id', '=', 't_quote_dtl.t_mcharge_code_id')
                ->leftJoin('t_quote', 't_quote.id', '=', 't_quote_dtl.t_quote_id')
                ->leftJoin('t_mcurrency', 't_mcurrency.id', '=', 't_quote_dtl.t_mcurrency_id')
                ->select('t_quote_dtl.*', 't_mcharge_code.name as name_charge', 't_mcurrency.code as code_currency', 't_mcharge_code.name as name_charge')
                ->where('t_quote.quote_no', $quote_no)->get();
    }

    public static function get_quoteDetailx($id)
    {
        return DB::table('t_quote_dtl')
                ->leftJoin('t_mcharge_code', 't_mcharge_code.id', '=', 't_quote_dtl.t_mcharge_code_id')
                ->leftJoin('t_quote', 't_quote.id', '=', 't_quote_dtl.t_quote_id')
                ->leftJoin('t_mcurrency', 't_mcurrency.id', '=', 't_quote_dtl.t_mcurrency_id')
                ->select('t_quote_dtl.*', 't_mcharge_code.name as name_charge', 't_mcurrency.code as code_currency', 't_mcharge_code.name as name_charge')
                ->where('t_quote_dtl.t_quote_id', $id)->get();
    }

    public static function get_quoteShipping($quote_no)
    {
        return DB::table('t_quote_shipg_dtl')
                ->leftJoin('t_mcarrier', 't_mcarrier.id', '=', 't_quote_shipg_dtl.t_mcarrier_id')
                ->leftJoin('t_quote', 't_quote.id', '=', 't_quote_shipg_dtl.t_quote_id')
                ->leftJoin('t_mcurrency', 't_mcurrency.id', '=', 't_quote_shipg_dtl.t_mcurrency_id')
                ->select('t_quote_shipg_dtl.*', 't_mcarrier.name as name_carrier', 't_mcurrency.code as code_currency')
                ->where('t_quote.quote_no', $quote_no)->get();
    }

    public static function get_quoteDimension($id)
    {
        return DB::table('t_quote_dimension')
                ->leftJoin('t_muom', 't_quote_dimension.height_uom_id', '=', 't_muom.id')
                ->select('t_quote_dimension.*', 't_muom.uom_code', 't_quote_dimension.length as le_dimen')
                ->where('t_quote_dimension.t_quote_id', $id)->get();
    }

    public static function get_detailQuote($id)
    {
        return DB::table('t_quote')
                ->leftJoin('t_mcompany', 't_quote.customer_id', '=', 't_mcompany.id')
                ->leftJoin('t_mloaded_type', 't_quote.t_mloaded_type_id', '=', 't_mloaded_type.id')
                ->leftJoin('t_mpic', 't_quote.t_mpic_id', '=', 't_mpic.id')
                ->leftJoin('t_mport', 't_quote.from_id', '=', 't_mport.id')
                ->leftJoin('t_muom', 't_quote.weight_uom_id', '=', 't_muom.id')
                ->select('t_quote.*', 't_mcompany.client_name', 't_mloaded_type.loaded_type', 't_mpic.name as name_pic','t_mport.port_name', 't_muom.uom_code', 't_mpic.id as id_pic')
                ->where('t_quote.id', $id)->first();
    }

    public static function getShippingDetail($id)
    {
        return DB::table('t_quote_shipg_dtl')->where('id', $id)->first();
    }

    public static function getCurrencyCode($id)
    {
        return DB::table('t_mcurrency')->where('id', $id)->first();
    }

    public static function getDetailQuote($id)
    {
        return DB::table('t_quote_dtl')->where('id', $id)->first();
    }


}
