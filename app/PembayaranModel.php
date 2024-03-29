<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PembayaranModel extends Model
{
    //
    protected $table = 't_pembayaran';
    protected $guarded = [];
    public $timestamps = false;

    public static function getAllPembayaranByJenis($jenis)
    {
        return PembayaranModel::from('t_pembayaran as p')
            ->leftJoin('t_journals as j', 'j.pembayaran_id', '=', 'p.id')
            ->leftJoin('t_mcompany AS b', 'p.id_company', '=', 'b.id')
            ->select('p.*', 'b.client_name', DB::raw('COALESCE(j.id, 0) journal_id'), DB::raw('(select count(id) from t_pembayaran_detail where id_pmb = p.id) jumlah'))
            ->where('p.jenis_pmb', $jenis);
    }

    public static function get_list_detail($id)
    {
        return DB::select("
            Select pd.*, c.code, COALESCE(ei.external_invoice_no, i.invoice_no) as invoice_no, COALESCE(ei.external_invoice_date, i.invoice_date) as invoice_date from t_pembayaran_detail as pd
            left join t_external_invoice ei on pd.jenis_pmb = 0 and pd.id_invoice = ei.id
            left join t_invoice i on pd.jenis_pmb = 1 and pd.id_invoice = i.id
            left join t_mcurrency c on c.id = pd.currency_id
            where pd.id_pmb = ".$id);
    }

    public static function get_list_hutang($id,$idp,$curr)
    {
        return DB::select("
            Select i.*, (select count(id) from t_pembayaran_detail where id_invoice = i.id and jenis_pmb = 1 and deposit_id = 0 and id_pmb =".$idp.")as count
            from t_invoice as i
            where tipe_inv = 1 and flag_bayar in (0,2) and i.client_id = ".$id." and i.currency=".$curr);
    }

    public static function get_detail($id){
        return DB::table('t_pembayaran_detail as pd')
            ->leftJoin('t_invoice AS i', 'pd.id_invoice', '=', 'i.id')
            ->where('pd.id', $id)->select('pd.*', 'i.invoice_no', 'i.invoice_date', 'i.invoice_bayar', 'i.total_invoice');
    }

    public static function get_list_piutang($id,$idp, $currency_id)
    {
        return DB::select("
            Select i.*, c.code, c.name, (select count(id) from t_pembayaran_detail where id_invoice = i.id and jenis_pmb = 0 and id_pmb =".$idp.")as count
            from t_external_invoice as i
            join t_mcurrency as c on c.id = i.currency
            where flag_bayar in (0,2) and i.currency = {$currency_id} and i.client_id = ".$id);
    }

    public static function get_detail_piutang($id){
        return DB::table('t_pembayaran_detail as pd')
            ->leftJoin('t_external_invoice AS i', 'pd.id_invoice', '=', 'i.id')
            ->where('pd.id', $id)->select('pd.*', 'i.external_invoice_no', 'i.external_invoice_date', 'i.invoice_bayar', 'i.total_invoice');
    }

    public static function getAllDetailsByIdPmb($id_pmb)
    {
        return DB::table('t_pembayaran_detas as pd')->where('id_pmb', $id_pmb);
    }

    public static function get_list_pmb_invoice($id)
    {
        return DB::select("
            Select pd.*, i.pph23, i.invoice_no from t_pembayaran_detail pd
            left join t_invoice i on pd.id_invoice = i.id
            where pd.id_pmb = ".$id);
    }

    public static function get_list_pmb_invoice_piutang($id)
    {
        return DB::select("
            Select i.* from t_pembayaran_detail pd
            left join t_external_invoice i on pd.id_invoice = i.id
            where pd.id_pmb = ".$id);
    }
}
