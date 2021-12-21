<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProformaInvoiceDetailModel extends Model
{
    protected $table = 't_proforma_invoice_detail';
    protected $guarded = [];
    public $timestamps = false;

    public static function saveProformaInvoiceDetail($request)
    {
        return ProformaInvoiceDetailModel::updateOrCreate(
            ['id' => $request['id']],
            $request
        );
    }

    public static function getProformaInvoiceDetails($proforma_invoice_id)
    {
        return ProformaInvoiceDetailModel::leftJoin('t_mcharge_code AS c', 'c.id', '=', 't_proforma_invoice_detail.t_mcharge_code_id')
            ->leftJoin('t_mcurrency AS curr', 'curr.id', '=', 't_proforma_invoice_detail.currency')
            ->select('t_proforma_invoice_detail.*', 'c.name AS charge_name', 'curr.code AS currency_code')
            ->where('t_proforma_invoice_detail.proforma_invoice_id', $proforma_invoice_id);
    }

    public static function deleteProformaInvoiceDetailsByProformaId($proformaInvoiceId)
    {
        ProformaInvoiceDetailModel::where('proforma_invoice_id', $proformaInvoiceId)->delete();
    }
}
