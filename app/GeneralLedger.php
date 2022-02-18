<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GeneralLedger extends Model
{
    protected $table = 't_general_ledgers';
    protected $guarded = [];
    public $timestamps = false;

    public static function getAllAccountHasGL()
    {
        // return DB::table('t_maccount AS a')->whereRaw('a.id IN (select distinct account_id from t_general_ledgers tgl )');
        $query = 'SELECT
                    A.id,
                    A.account_number,
                    A.account_name,
                    (SELECT SUM(DEBIT) FROM t_general_ledgers TGL2 WHERE A.ID = TGL2.ACCOUNT_ID GROUP BY TGL2.ACCOUNT_ID) total_debit,
                    (SELECT SUM(CREDIT) FROM t_general_ledgers TGL3 WHERE A.ID = TGL3.ACCOUNT_ID GROUP BY TGL3.ACCOUNT_ID) total_credit,
                    (SELECT SUM(DEBIT) - SUM(CREDIT) FROM t_general_ledgers TGL4 WHERE A.ID = TGL4.ACCOUNT_ID GROUP BY TGL4.ACCOUNT_ID) total_balance
                FROM
                    t_maccount AS A
                WHERE
                    A.ID IN (SELECT DISTINCT ACCOUNT_ID FROM t_general_ledgers TGL )';

        return DB::select($query);
    }

    public static function getAllGLByAccountId($accountId)
    {
        return GeneralLedger::from('t_general_ledgers AS gl')
            ->leftJoin('t_journals AS j', 'j.id', '=', 'gl.journal_id')
            ->select('gl.*', 'j.journal_no', 'j.journal_date')
            ->where('gl.account_id', $accountId)
            ->orderBy('j.journal_date')
            ->orderBy('j.journal_no');
    }

    public static function findALlGLsForRefreshBalance($account_id, $startDate)
    {
        return GeneralLedger::where('account_id', $account_id)->where('gl_date', '>=', $startDate)->orderBy('gl_date');
    }

    public static function saveGL($request)
    {
        return GeneralLedger::updateOrCreate(
            ['id' => $request['id']],
            $request
        );
    }

    public static function updateGL($id, $request)
    {
        return GeneralLedger::find($id)->update($request);
    }
}
