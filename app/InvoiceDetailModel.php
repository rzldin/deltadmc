<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceDetailModel extends Model
{
    protected $table = 't_invoice_detail';
    protected $guarded = [];
    public $timestamps = false;

    public static function getInvoiceDetails($invoice_id)
    {
        return InvoiceDetailModel::leftJoin('t_mcharge_code AS c', 'c.id', '=', 't_invoice_detail.t_mcharge_code_id')
            ->leftJoin('t_mcurrency AS curr', 'curr.id', '=', 't_invoice_detail.currency')
            ->select('t_invoice_detail.*', 'c.name AS charge_name', 'curr.code AS currency_code')
            ->where('t_invoice_detail.invoice_id', $invoice_id);
    }

    public static function saveInvoiceDetail($request)
    {
        return InvoiceDetailModel::updateOrCreate(
            ['id' => $request['id']],
            $request
        );
    }
}
