<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class InvoiceDetailModel extends Model
{
    protected $table = 't_invoice_detail';
    protected $guarded = [];
    public $timestamps = false;

    public static function getInvoiceDetails($invoice_id)
    {
        return InvoiceDetailModel::leftJoin('t_mcharge_code AS c', 'c.id', '=', 't_invoice_detail.t_mcharge_code_id')
            ->leftJoin('t_mcurrency AS curr', 'curr.id', '=', 't_invoice_detail.currency')
            ->select('t_invoice_detail.*', 'c.name AS charge_name', 'curr.code AS currency_code', DB::raw('0 is_merge'))
            ->where('t_invoice_detail.invoice_id', $invoice_id);
    }

    public static function getInvoiceDetailsInId($id)
    {
        return InvoiceDetailModel::leftJoin('t_mcharge_code AS c', 'c.id', '=', 't_invoice_detail.t_mcharge_code_id')
            ->leftJoin('t_mcurrency AS curr', 'curr.id', '=', 't_invoice_detail.currency')
            ->select('t_invoice_detail.*', 'c.name AS charge_name', 'curr.code AS currency_code')
            ->whereIn('t_invoice_detail.id', $id);
    }

    public static function findInvoiceDetailByChargeId($invoice_id)
    {
        return InvoiceDetailModel::where('invoice_id', $invoice_id);
    }

    public static function saveInvoiceDetail($request)
    {
        return InvoiceDetailModel::updateOrCreate(
            ['id' => $request['id']],
            $request
        );
    }

    public static function findHeader($id){
        return InvoiceDetailModel::leftJoin('t_invoice as ti', 'ti.id', '=', 't_invoice_detail.invoice_id')
            ->select('ti.id as id_inv','ti.t_booking_id','ti.total_before_vat','ti.total_vat','ti.pph23 as total_pph23','ti.ppn1 as total_ppn1','ti.total_invoice','ti.tipe_inv','t_invoice_detail.*')->where('t_invoice_detail.id', $id)->first();
    }
}
