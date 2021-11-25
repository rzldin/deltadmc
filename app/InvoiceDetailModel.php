<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceDetailModel extends Model
{
    protected $table = 't_proforma_invoice_detail';
    protected $guarded = [];
    public $timestamps = false;
}
