<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Journal extends Model
{
    protected $table = 't_journals';
    protected $guarded = [];
    public $timestamps = false;

    public static function findMaxTransactionGroupId()
    {
        return Journal::max('transaction_group_id');
    }

    public static function findAllJournals()
    {
        return Journal::from('t_journals AS j')
            ->leftJoin('t_mcurrency AS c', 'c.id', '=', 'j.currency_id')
            ->select('j.*', 'c.code AS currency_code', 'c.name AS currency_name');
    }

    public static function findJournal($journalId)
    {
        return Journal::from('t_journals AS j')
            ->leftJoin('t_mcompany AS c', 'c.id', '=', 'j.company_id')
            ->leftJoin('t_invoice AS id', 'id.id', '=', 'j.invoice_id_deposit')
            ->leftJoin('t_external_invoice AS eid', 'eid.id', '=', 'j.external_invoice_id_deposit')
            ->select('j.*', 'c.client_code', 'c.client_name', DB::raw('COALESCE(id.invoice_no, eid.external_invoice_no) invoice_no_deposit'))
            ->where('j.id', $journalId);
    }

    public static function saveJournal($request)
    {
        return Journal::updateOrCreate(
            ['id' => $request['id']],
            $request
        );
    }
}
