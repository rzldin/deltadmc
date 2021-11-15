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
}