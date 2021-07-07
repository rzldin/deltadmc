<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class QuotationModel extends Model
{
    public static function getQuote()
    {
        return DB::select("SELECT max(a.id) as id, a.quote_no, max(a.version_no) as version_no, max(a.quote_date) as quote_date, max(a.activity) as activity, max(a.shipment_by) as shipment_by, max(b.client_name) as client_name, max(c.name) as name_pic, max(d.loaded_type) as loaded_type, max(a.status) as status FROM t_quote a LEFT JOIN t_mcompany b ON a.customer_id = b.id LEFT JOIN t_mpic c ON a.t_mpic_id = c.id LEFT JOIN t_mloaded_type d ON a.t_mloaded_type_id = d.id GROUP BY a.quote_no");
    }

    public static function get_quoteProfit($id)
    {
       return DB::table('t_quote_profit')
                ->leftJoin('t_quote_shipg_dtl', 't_quote_profit.t_quote_ship_dtl_id', '=', 't_quote_shipg_dtl.id')
                ->leftJoin('t_mcarrier', 't_mcarrier.id', '=', 't_quote_shipg_dtl.t_mcarrier_id')
                ->leftJoin('t_mcurrency', 't_mcurrency.id', '=', 't_quote_shipg_dtl.t_mcurrency_id')
                ->leftJoin('t_quote', 't_quote.id', '=', 't_quote_profit.t_quote_id')
                ->select('t_quote_profit.*', 't_mcarrier.code as carrier_code', 't_quote_shipg_dtl.routing', 't_quote_shipg_dtl.transit_time', 't_mcurrency.code as code_currency')
                ->where('t_quote_profit.t_quote_id', $id)->get();
    }

    public static function get_quoteDetail($id)
    {
        return DB::table('t_quote_dtl')
                ->leftJoin('t_mcharge_code', 't_mcharge_code.id', '=', 't_quote_dtl.t_mcharge_code_id')
                ->leftJoin('t_quote', 't_quote.id', '=', 't_quote_dtl.t_quote_id')
                ->leftJoin('t_mcurrency', 't_mcurrency.id', '=', 't_quote_dtl.t_mcurrency_id')
                ->select('t_quote_dtl.*', 't_mcharge_code.code', 't_mcurrency.code as code_currency')
                ->where('t_quote_dtl.t_quote_id', $id)->get();
    }

    public static function get_quoteShipping($id)
    {
        return DB::table('t_quote_shipg_dtl')
                ->leftJoin('t_mcarrier', 't_mcarrier.id', '=', 't_quote_shipg_dtl.t_mcarrier_id')
                ->leftJoin('t_quote', 't_quote.id', '=', 't_quote_shipg_dtl.t_quote_id')
                ->leftJoin('t_mcurrency', 't_mcurrency.id', '=', 't_quote_shipg_dtl.t_mcurrency_id')
                ->select('t_quote_shipg_dtl.*', 't_mcarrier.code', 't_mcurrency.code as code_currency')
                ->where('t_quote_shipg_dtl.t_quote_id', $id)->get();
    }

    public static function get_quoteDimension($id)
    {
        return DB::table('t_quote_dimension')
                ->leftJoin('t_muom', 't_quote_dimension.height_uom_id', '=', 't_muom.id')
                ->select('t_quote_dimension.*', 't_muom.uom_code', 't_quote_dimension.length as le_dimen')
                ->where('t_quote_dimension.t_quote_id', $id)->get();
    }


}
