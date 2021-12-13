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
            ->leftJoin('t_external_invoice AS ei', 'ei.t_invoice_id', '=', 't_invoice.id')
            ->select('t_invoice.*', DB::raw('COALESCE(ei.id, 0) external_invoice_id'), 'a.booking_no', 'a.booking_date', 'a.activity', 'b.client_name as company_b', 'c.client_name as company_c', 'd.client_name as company_d');
    }

    public static function getInvoice($id)
    {
        return InvoiceModel::leftJoin('t_mport as pol', 'pol.id', '=', 't_invoice.pol_id')
            ->leftJoin('t_mport as pod', 'pod.id', '=', 't_invoice.pod_id')
            ->leftJoin('t_booking as b', 'b.id', '=', 't_invoice.t_booking_id')
            ->leftJoin('t_proforma_invoice as pi', 'pi.id', '=', 't_invoice.t_proforma_invoice_id')
            ->leftJoin('t_bcharges_dtl AS chrg', 'chrg.t_invoice_id', '=', 'pi.id')
            ->leftJoin('t_quote_shipg_dtl AS shp', 'shp.t_invoice_id', '=', 'pi.id')
            ->select('t_invoice.*', 'b.activity', 'pol.port_name as pol_name', 'pod.port_name as pod_name', DB::raw('COALESCE(chrg.invoice_type, shp.invoice_type) AS invoice_type'))
            ->where('t_invoice.id', $id);
    }

    public static function saveInvoice($request)
    {
        return InvoiceModel::updateOrCreate(
            ['id' => $request['id']],
            [
                't_proforma_invoice_id' => $request['t_proforma_invoice_id'],
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
            ->leftJoin('t_proforma_invoice AS pi', 'pi.id', '=', 'i.t_proforma_invoice_id')
            ->leftJoin('t_booking AS b', 'b.id', '=', 'pi.t_booking_id')
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
}
