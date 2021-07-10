<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class BookingModel extends Model
{
    public static function get_bookingDetail($id)
    {
        return DB::select("SELECT a.*, b.quote_no, b.quote_date, b.activity, b.shipment_by FROM t_booking a LEFT JOIN t_quote b ON a.t_quote_id = b.id WHERE a.id='".$id."'");
    }
}
