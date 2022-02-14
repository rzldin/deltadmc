<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DepositDetail extends Model
{
    protected $table = 't_deposit_details';
    protected $guarded = [];
    public $timestamps = false;

    public static function saveDepositDetail($request)
    {
        return DepositDetail::updateOrCreate(
            ['id' => $request['id']],
            $request
        );
    }

    public static function getListDeposit($company_id)
    {
        return DB::table('t_deposit_details AS dd')
            ->join('t_journals AS j', 'j.id', '=', 'dd.journal_id')
            ->select('j.journal_no', 'dd.journal_id', DB::raw('SUM(dd.amount) amount'))
            ->whereRaw("deposit_id = (SELECT deposit_id FROM t_deposits WHERE company_id = {$company_id})")
            ->groupBy('dd.journal_id')
            ->havingRaw('SUM(dd.amount) > 0');
    }
}
