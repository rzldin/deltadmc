<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class FinanceModel extends Model
{
    public static function getQuote()
    {
        return DB::select("SELECT max(a.id) as id, a.quote_no, max(a.version_no) as version_no, max(a.quote_date) as quote_date, max(a.activity) as activity, max(a.shipment_by) as shipment_by, max(b.client_name) as client_name, max(c.name) as name_pic, max(d.loaded_type) as loaded_type, max(a.status) as status, max(a.created_on) as create_quote FROM t_quote a LEFT JOIN t_mcompany b ON a.customer_id = b.id LEFT JOIN t_mpic c ON a.t_mpic_id = c.id LEFT JOIN t_mloaded_type d ON a.t_mloaded_type_id = d.id GROUP BY a.quote_no");
    }
}
