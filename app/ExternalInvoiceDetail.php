<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExternalInvoiceDetail extends Model
{
    protected $table = 't_external_invoice_detail';
    protected $guarded = [];
    public $timestamps = false;

    public static function getExternalInvoiceDetails($external_invoice_id)
    {
        return ExternalInvoiceDetail::leftJoin('t_mcharge_code AS c', 'c.id', '=', 't_external_invoice_detail.t_mcharge_code_id')
            ->leftJoin('t_mcurrency AS curr', 'curr.id', '=', 't_external_invoice_detail.currency')
            ->select('t_external_invoice_detail.*', 'c.name AS charge_name', 'curr.code AS currency_code')
            ->where('t_external_invoice_detail.external_invoice_id', $external_invoice_id);
    }

    public static function saveExternalInvoiceDetail($request)
    {
        return ExternalInvoiceDetail::updateOrCreate(
            ['id' => $request['id']],
            $request
        );
    }
}
