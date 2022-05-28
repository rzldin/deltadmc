<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProformaInvoiceModel extends Model
{
    protected $table = 't_proforma_invoice';
    protected $guarded = [];
    public $timestamps = false;

    public static function getAllProformaInvoice()
    {
        return ProformaInvoiceModel::join('t_booking AS a', 'a.id', '=', 't_proforma_invoice.t_booking_id')
            ->leftJoin('t_external_invoice AS ei', 'ei.t_proforma_invoice_id', '=', 't_proforma_invoice.id')
            ->leftJoin('t_mcompany AS b', 't_proforma_invoice.client_id', '=', 'b.id')
            ->leftJoin('t_mcompany AS c', 'a.consignee_id', '=', 'c.id')
            ->leftJoin('t_mcompany AS d', 'a.shipper_id', '=', 'd.id')
            ->select('t_proforma_invoice.*', DB::raw('COALESCE(ei.flag_bayar, 0) flag_bayar_external, COALESCE(ei.id, 0) AS t_external_invoice_id, COALESCE(ei.flag_bayar, 0) flag_bayar_external'), 'a.booking_no', 'a.booking_date', 'a.activity', 'b.client_name as company_b', 'c.client_name as company_c', 'd.client_name as company_d');
    }

    public static function getProformaInvoice($id)
    {
        return ProformaInvoiceModel::leftJoin('t_external_invoice as ei', 'ei.t_proforma_invoice_id', '=', 't_proforma_invoice.id')
            ->leftJoin('t_booking as b', 'b.id', '=', 't_proforma_invoice.t_booking_id')
            ->leftJoin('t_mport as pol', 'pol.id', '=', 'b.pol_id')
            ->leftJoin('t_mport as pod', 'pod.id', '=', 'b.pod_id')
            ->select('t_proforma_invoice.*', 'b.activity', 'pol.port_name as pol_name', 'pod.port_name as pod_name','b.mbl_no','b.hbl_no','b.mbl_shipper', DB::raw('COALESCE(ei.id, 0) external_invoice_id'))
            ->where('t_proforma_invoice.id', $id);
    }

    public static function saveProformaInvoice($request)
    {
        return ProformaInvoiceModel::updateOrCreate(
            ['id' => $request['id']],
            $request
        );
    }
}
