<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Deposit extends Model
{
    protected $table = 't_deposits';
    protected $guarded = [];
    public $timestamps = false;

    public static function findSaldoDeposit()
    {
        return DB::table('t_deposits')
            ->sum('balance');
    }

    public static function getAllDeposits()
    {
        return Deposit::from('t_deposits AS d')
            ->leftJoin('t_mcompany AS c', 'c.id', '=', 'd.company_id')
            ->select('d.*', 'c.client_code', 'c.client_name');
    }

    public static function findDepositByCompanyId($companyId)
    {
        return Deposit::where('company_id', $companyId);
    }

    public static function saveDeposit($request)
    {
        return Deposit::updateOrCreate(
            ['id' => $request['id']],
            $request
        );
    }
}
