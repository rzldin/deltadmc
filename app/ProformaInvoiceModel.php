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
            ->leftJoin('t_invoice AS i', 'i.t_proforma_invoice_id', '=', 't_proforma_invoice.id')
            ->leftJoin('t_mcompany AS b', 't_proforma_invoice.client_id', '=', 'b.id')
            ->leftJoin('t_mcompany AS c', 'a.consignee_id', '=', 'c.id')
            ->leftJoin('t_mcompany AS d', 'a.shipper_id', '=', 'd.id')
            ->select('t_proforma_invoice.*', DB::raw('COALESCE(i.id, 0) AS invoice_id'), 'a.booking_no', 'a.booking_date', 'a.activity', 'b.client_name as company_b', 'c.client_name as company_c', 'd.client_name as company_d');
    }

    public static function getProformaInvoice($id)
    {
        return ProformaInvoiceModel::leftJoin('t_mport as pol', 'pol.id', '=', 't_proforma_invoice.pol_id')
            ->leftJoin('t_mport as pod', 'pod.id', '=', 't_proforma_invoice.pod_id')
            ->leftJoin('t_booking as b', 'b.id', '=', 't_proforma_invoice.t_booking_id')
            ->leftJoin('t_bcharges_dtl AS chrg', 'chrg.t_invoice_id', '=', 't_proforma_invoice.id')
            ->leftJoin('t_quote_shipg_dtl AS shp', 'shp.t_invoice_id', '=', 't_proforma_invoice.id')
            ->select('t_proforma_invoice.*', 'b.activity', 'pol.port_name as pol_name', 'pod.port_name as pod_name', DB::raw('COALESCE(chrg.invoice_type, shp.invoice_type) AS invoice_type'))
            ->where('t_proforma_invoice.id', $id);
    }

    public static function saveProformaInvoice($request)
    {
        return ProformaInvoiceModel::updateOrCreate(
            ['id' => $request['id']],
            [
                't_booking_id' => $request['t_booking_id'],
                'activity' => $request['activity'],
                'client_id' => $request['client_id'],
                'client_addr_id' => $request['client_addr_id'],
                'client_pic_id' => $request['client_pic_id'],
                'proforma_invoice_no' => $request['proforma_invoice_no'],
                'truck_no' => $request['truck_no'],
                'proforma_invoice_date' => $request['proforma_invoice_date'],
                'reimburse_flag' => $request['reimburse_flag'],
                'debit_note_flag' => $request['debit_note_flag'],
                'credit_note_flag' => $request['credit_note_flag'] ,
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
