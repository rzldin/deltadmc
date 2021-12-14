<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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

    public static function saveJournal($request)
    {
        return Journal::updateOrCreate(
            ['id' => $request['id']],
            $request
        );
    }
}
