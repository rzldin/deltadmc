<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProformaInvoiceController extends Controller
{
    public function create()
    {
        return view('proforma_invoice.add_proforma_invoice');
    }
}
