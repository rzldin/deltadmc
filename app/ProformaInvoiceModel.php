<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProformaInvoiceModel extends Model
{
    protected $table = 't_proforma_invoice';
    protected $guarded = [];
    public $timestamps = false;

    public static function saveProformaInvoice($request)
    {
        return ProformaInvoiceModel::updateOrCreate(
            ['id' => $request['id']],
            [
                't_booking_id' => $request['t_booking_id'],
                'client_id' => $request['client_id'],
                'client_addr_id' => $request['client_addr_id'],
                'client_pic_id' => $request['client_pic_id'],
                'proforma_invoice_no' => $request['proforma_invoice_no'],
                'proforma_invoice_date' => $request['proforma_invoice_date'],
                'top' => $request['top'],
                'currency' => $request['currency'],
                'mbl_shipper' => $request['mbl_shipper'],
                'hbl_shipper' => $request['hbl_shipper'],
                'vessel' => $request['vessel'],
                'm_vessel' => $request['m_vessel'],
                'pol_id' => $request['pol_id'],
                'pod_id' => $request['pod_id'],
                'onboard_date' => $request['onboard_date'],
                'rate' => $request['rate'],
                'created_by' => $request['created_by'],
                'created_on' => $request['created_on'],
            ]
        );
    }
}
