<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class PembayaranModel extends Model
{
    //
    protected $table = 't_pembayaran';
    protected $guarded = [];
    public $timestamps = false;

    public static function get_list_detail($id)
    {
        return DB::select("
            Select pd.*, COALESCE(ei.external_invoice_no, i.invoice_no) as invoice_no, COALESCE(ei.external_invoice_date, i.invoice_date) as invoice_date from t_pembayaran_detail as pd
            left join t_external_invoice ei on pd.jenis_pmb = 0 and pd.id_invoice = ei.id
            left join t_invoice i on pd.jenis_pmb = 1 and pd.id_invoice = i.id
            where pd.id_pmb = ".$id);
    }

    public static function get_list_hutang($id,$idp)
    {
        return DB::select("
            Select i.*, (select count(id) from t_pembayaran_detail where id_invoice = i.id and jenis_pmb = 1 and id_pmb =".$idp.")as count from t_invoice as i
            where i.client_id = ".$id);
    }

    public static function get_detail($id){
        return DB::table('t_pembayaran_detail as pd')
            ->leftJoin('t_invoice AS i', 'pd.id_invoice', '=', 'i.id')
            ->where('pd.id', $id)->select('pd.*', 'i.invoice_no', 'i.invoice_date', 'i.invoice_bayar');
    }

    public static function get_list_piutang($id,$idp)
    {
        return DB::select("
            Select i.*, (select count(id) from t_pembayaran_detail where id_invoice = i.id and jenis_pmb = 0 and id_pmb =".$idp.")as count from t_external_invoice as i
            where i.client_id = ".$id);
    }

    public static function get_detail_piutang($id){
        return DB::table('t_pembayaran_detail as pd')
            ->leftJoin('t_external_invoice AS i', 'pd.id_invoice', '=', 'i.id')
            ->where('pd.id', $id)->select('pd.*', 'i.external_invoice_no', 'i.external_invoice_date', 'i.invoice_bayar');
    }
}
