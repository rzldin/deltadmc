<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ExternalInvoice extends Model
{
    protected $table = 't_external_invoice';
    protected $guarded = [];
    public $timestamps = false;

    public static function getAllExternalInvoice()
    {
        return ExternalInvoice::join('t_booking AS a', 'a.id', '=', 't_external_invoice.t_booking_id')
            ->leftJoin('t_mcompany AS b', 't_external_invoice.client_id', '=', 'b.id')
            ->leftJoin('t_mcompany AS c', 'a.consignee_id', '=', 'c.id')
            ->leftJoin('t_mcompany AS d', 'a.shipper_id', '=', 'd.id')
            ->select('t_external_invoice.*', 'a.booking_no', 'a.booking_date', 'a.activity', 'b.client_name as company_b', 'c.client_name as company_c', 'd.client_name as company_d');
    }

    public static function getExternalInvoice($id)
    {
        return ExternalInvoice::leftJoin('t_mport as pol', 'pol.id', '=', 't_external_invoice.pol_id')
            ->leftJoin('t_mport as pod', 'pod.id', '=', 't_external_invoice.pod_id')
            ->leftJoin('t_booking as b', 'b.id', '=', 't_external_invoice.t_booking_id')
            ->leftJoin('t_invoice as ti', 'ti.id', '=', 't_external_invoice.t_invoice_id')
            ->leftJoin('t_proforma_invoice as pi', 'pi.id', '=', 'ti.t_proforma_invoice_id')
            ->leftJoin('t_bcharges_dtl AS chrg', 'chrg.t_invoice_id', '=', 'pi.id')
            ->leftJoin('t_quote_shipg_dtl AS shp', 'shp.t_invoice_id', '=', 'pi.id')
            ->select('t_external_invoice.*', 'b.activity', 'pol.port_name as pol_name', 'pod.port_name as pod_name', DB::raw('COALESCE(chrg.invoice_type, shp.invoice_type) AS invoice_type'))
            ->where('t_external_invoice.id', $id);
    }

    public static function saveExternalInvoice($request)
    {
        return ExternalInvoice::updateOrCreate(
            ['id' => $request['id']],
            [
                't_invoice_id' => $request['t_invoice_id'],
                't_booking_id' => $request['t_booking_id'],
                'activity' => $request['activity'],
                'client_id' => $request['client_id'],
                'client_addr_id' => $request['client_addr_id'],
                'client_pic_id' => $request['client_pic_id'],
                'external_invoice_no' => $request['external_invoice_no'],
                'external_invoice_date' => $request['external_invoice_date'],
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

    public static function listAccountReceivables($clientId, $bookingId, $invoiceType, $chargeCode)
    {
        $ars = ExternalInvoice::from('t_external_invoice AS ei')
            ->leftJoin('t_mcompany AS c', 'c.id', '=', 'ei.client_id')
            ->leftJoin('t_invoice AS i', 'i.id', '=', 't_invoice_id')
            ->leftJoin('t_proforma_invoice AS pi', 'pi.id', '=', 'i.t_proforma_invoice_id')
            ->leftJoin('t_booking AS b', 'b.id', '=', 'pi.t_booking_id')
            ->select('ei.*', 'c.client_code', 'c.client_name', 'b.booking_no', 'pi.proforma_invoice_no', 'i.invoice_no', 'ei.external_invoice_no')
            ->where('ei.flag_lunas', '<>', 1);

        if ($clientId != null) $ars->where('ei.client_id', $clientId);
        if ($bookingId != null) $ars->where('b.id', $bookingId);
        if ($invoiceType != null) {
            if ($invoiceType == 'REG') {
                $ars->where('ei.reimburse_flag', '<>', 1);
                $ars->where('ei.debit_note_flag', '<>', 1);
                $ars->where('ei.credit_note_flag', '<>', 1);
            } else if ($invoiceType == 'REM') {
                $ars->where('ei.reimburse_flag', '=', 1);
            } else if ($invoiceType == 'DN') {
                $ars->where('ei.debit_note_flag', '=', 1);
            } else if ($invoiceType == 'CN') {
                $ars->where('ei.credit_note_flag', '=', 1);
            }
        }

        return $ars;
    }
}
