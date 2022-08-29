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
        return DB::table('t_deposits')->selectRaw("SUM(CASE WHEN jenis_trx = 0 THEN balance ELSE -balance END) AS saldo")->first();
    }

    public static function getAllDeposits()
    {
        return Deposit::from('t_deposits AS d')
            ->leftJoin('t_mcompany AS c', 'c.id', '=', 'd.company_id')
            ->leftJoin('t_mcurrency AS cc',  'd.currency_id', '=', 'cc.id')
            ->select('d.*', 'c.client_code', 'c.client_name', 'cc.code','cc.name as nama_currency');
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
