<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class InvoiceModel extends Model
{
    protected $table = 't_invoice';
    protected $guarded = [];
    public $timestamps = false;

    public static function getAllInvoice()
    {
        return InvoiceModel::join('t_booking AS a', 'a.id', '=', 't_invoice.t_booking_id')
            ->leftJoin('t_mcompany AS b', 't_invoice.client_id', '=', 'b.id')
            ->leftJoin('t_mcompany AS c', 'a.consignee_id', '=', 'c.id')
            ->leftJoin('t_mcompany AS d', 'a.shipper_id', '=', 'd.id')
            ->leftJoin('t_proforma_invoice AS p', 'p.t_invoice_id', '=', 't_invoice.id')
            ->leftJoin('t_journals AS j', 'j.invoice_id', '=', 't_invoice.id')
            ->select('t_invoice.*', DB::raw('COALESCE(p.id, 0) proforma_invoice_id, COALESCE(j.id, 0) journal_id'), 'a.booking_no', 'a.booking_date', 'a.activity', 'b.client_name as company_b', 'c.client_name as company_c', 'd.client_name as company_d');
    }

    public static function getInvoiceByType($tipe)
    {
        return InvoiceModel::join('t_booking AS a', 'a.id', '=', 't_invoice.t_booking_id')
            ->leftJoin('t_mcompany AS b', 't_invoice.client_id', '=', 'b.id')
            ->leftJoin('t_mcompany AS c', 'a.consignee_id', '=', 'c.id')
            ->leftJoin('t_mcompany AS d', 'a.shipper_id', '=', 'd.id')
            ->leftJoin('t_proforma_invoice AS p', 'p.t_invoice_id', '=', 't_invoice.id')
            ->leftJoin('t_journals AS j', 'j.invoice_id', '=', 't_invoice.id')
            ->where('tipe_inv', $tipe)
            ->select('t_invoice.*', DB::raw('COALESCE(p.id, 0) proforma_invoice_id, COALESCE(j.id, 0) journal_id'), 'a.booking_no', 'a.booking_date', 'a.activity', 'b.client_name as company_b', 'c.client_name as company_c', 'd.client_name as company_d');
    }

    public static function getInvoice($id)
    {
        return InvoiceModel::from('t_invoice AS i')
            ->leftJoin('t_mport as pol', 'pol.id', '=', 'i.pol_id')
            ->leftJoin('t_mport as pod', 'pod.id', '=', 'i.pod_id')
            ->leftJoin('t_booking as b', 'b.id', '=', 'i.t_booking_id')
            ->leftJoin('t_bcharges_dtl AS chrg', 'chrg.t_invoice_id', '=', 'i.id')
            ->leftJoin('t_quote_shipg_dtl AS shp', 'shp.t_invoice_id', '=', 'i.id')
            ->leftJoin('t_mcompany as c', 'i.client_id', '=', 'c.id')
            ->leftJoin('t_maddress as addr', 'i.client_addr_id', '=', 'addr.id')
            ->leftJoin('t_mpic as mp', 'i.client_pic_id', '=', 'mp.id')
            ->leftJoin('t_mcurrency as mc', 'i.currency', '=', 'mc.id')
            ->select('i.*', 'b.activity', 'pol.port_name as pol_name', 'pod.port_name as pod_name', 'c.client_code', 'c.client_name', 'addr.address', 'mp.name as pic_name', 'mc.code as currency_code', 'mc.name as currency_name', DB::raw('COALESCE(chrg.invoice_type, shp.invoice_type) AS invoice_type'))
            ->where('i.id', $id);
    }

    public static function getInvoicesByCompanyId($clientId)
    {
        return InvoiceModel::where('client_id', $clientId);
    }

    public static function saveInvoice($request)
    {
        return InvoiceModel::updateOrCreate(
            ['id' => $request['id']],
            [
                // 't_proforma_invoice_id' => $request['t_proforma_invoice_id'],
                't_booking_id' => $request['t_booking_id'],
                'activity' => $request['activity'],
                'client_id' => $request['client_id'],
                'client_addr_id' => $request['client_addr_id'],
                'client_pic_id' => $request['client_pic_id'],
                'invoice_no' => $request['invoice_no'],
                'truck_no' => $request['truck_no'],
                'invoice_date' => $request['invoice_date'],
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

    public static function listAccountPayables($clientId, $bookingId, $invoiceType, $chargeCode)
    {
        $ars = InvoiceModel::from('t_invoice AS i')
            ->leftJoin('t_mcompany AS c', 'c.id', '=', 'i.client_id')
            ->leftJoin('t_booking AS b', 'b.id', '=', 'i.t_booking_id')
            ->select('i.*', 'c.client_code', 'c.client_name', 'b.booking_no')
            ->where('i.tipe_inv', 1)
            ->where('i.flag_bayar', '<>', 1);

        if ($clientId != null) $ars->where('i.client_id', $clientId);
        if ($bookingId != null) $ars->where('b.id', $bookingId);
        if ($invoiceType != null) {
            if ($invoiceType == 'REG') {
                $ars->where('i.reimburse_flag', '<>', 1);
                $ars->where('i.debit_note_flag', '<>', 1);
                $ars->where('i.credit_note_flag', '<>', 1);
            } else if ($invoiceType == 'REM') {
                $ars->where('i.reimburse_flag', '=', 1);
            } else if ($invoiceType == 'DN') {
                $ars->where('i.debit_note_flag', '=', 1);
            } else if ($invoiceType == 'CN') {
                $ars->where('i.credit_note_flag', '=', 1);
            }
        }

        return $ars;
    }

    public static function count_inv($id){
        InvoiceModel::where('t_booking_id', $id)->count();
    }
}
