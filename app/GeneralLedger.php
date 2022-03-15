<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GeneralLedger extends Model
{
    protected $table = 't_general_ledgers';
    protected $guarded = [];
    public $timestamps = false;

    public static function getAllAccountHasGL($currency_id)
    {
        // return DB::table('t_maccount AS a')->whereRaw('a.id IN (select distinct account_id from t_general_ledgers tgl )');
        $query = "SELECT
                    A.id,
                    A.account_number,
                    A.account_name,
                    (SELECT code FROM t_mcurrency tm WHERE tm.id = {$currency_id}) currency_code,
                    (SELECT SUM(DEBIT) FROM t_general_ledgers TGL2 WHERE A.ID = TGL2.ACCOUNT_ID AND TGL2.currency_id = {$currency_id} GROUP BY TGL2.ACCOUNT_ID) total_debit,
                    (SELECT SUM(CREDIT) FROM t_general_ledgers TGL3 WHERE A.ID = TGL3.ACCOUNT_ID AND TGL3.currency_id = {$currency_id} GROUP BY TGL3.ACCOUNT_ID) total_credit,
                    (SELECT SUM(DEBIT) - SUM(CREDIT) FROM t_general_ledgers TGL4 WHERE A.ID = TGL4.ACCOUNT_ID AND TGL4.currency_id = {$currency_id} GROUP BY TGL4.ACCOUNT_ID) total_balance
                FROM
                    t_maccount AS A
                WHERE
                    A.ID IN (SELECT DISTINCT ACCOUNT_ID FROM t_general_ledgers TGL WHERE TGL.currency_id = {$currency_id} )
                ORDER BY
                    A.account_number";

        return DB::select($query);
    }

    public static function getAllAccountHasGLWithPeriod($currency_id, $start_date, $end_date)
    {
        // return DB::table('t_maccount AS a')->whereRaw('a.id IN (select distinct account_id from t_general_ledgers tgl )');
        $query = "SELECT
                    A.id,
                    A.account_number,
                    A.account_name,
                    (SELECT code FROM t_mcurrency tm WHERE tm.id = {$currency_id}) currency_code,
                    (SELECT SUM(DEBIT) FROM t_general_ledgers TGL2 WHERE A.ID = TGL2.ACCOUNT_ID AND TGL2.currency_id = {$currency_id} AND TGL2.gl_date BETWEEN '{$start_date}' AND '{$end_date}' GROUP BY TGL2.ACCOUNT_ID) total_debit,
                    (SELECT SUM(CREDIT) FROM t_general_ledgers TGL3 WHERE A.ID = TGL3.ACCOUNT_ID AND TGL3.currency_id = {$currency_id} AND TGL3.gl_date BETWEEN '{$start_date}' AND '{$end_date}' GROUP BY TGL3.ACCOUNT_ID) total_credit,
                    (SELECT SUM(DEBIT) - SUM(CREDIT) FROM t_general_ledgers TGL4 WHERE A.ID = TGL4.ACCOUNT_ID AND TGL4.currency_id = {$currency_id} AND TGL4.gl_date BETWEEN '{$start_date}' AND '{$end_date}' GROUP BY TGL4.ACCOUNT_ID) total_balance,
                    COALESCE((SELECT SUM(DEBIT) - SUM(CREDIT) FROM t_general_ledgers TGL5 WHERE A.ID = TGL5.ACCOUNT_ID AND TGL5.currency_id = {$currency_id} AND TGL5.gl_date < '{$start_date}' GROUP BY TGL5.ACCOUNT_ID), 0) start_balance
                FROM
                    t_maccount AS A
                WHERE
                    A.ID IN (SELECT DISTINCT ACCOUNT_ID FROM t_general_ledgers TGL WHERE TGL.currency_id = {$currency_id} )
                ORDER BY
                    A.account_number";

        return DB::select($query);
    }

    public static function getParentAccount()
    {
        $query = "SELECT * FROM t_maccount tm WHERE isnull(tm.parent_account)";

        return DB::select($query);
    }

    public static function getParentAccountTrialBalance($currency_id, $start_date, $end_date)
    {
        $query = "SELECT
                    A.id,
                    A.account_number,
                    A.account_name,
                    (SELECT code FROM t_mcurrency tm WHERE tm.id = {$currency_id}) currency_code,
                    (SELECT SUM(DEBIT) FROM t_general_ledgers TGL2 WHERE A.ID = TGL2.ACCOUNT_ID AND TGL2.currency_id = {$currency_id} AND TGL2.gl_date BETWEEN '{$start_date}' AND '{$end_date}' GROUP BY TGL2.ACCOUNT_ID) total_debit,
                    (SELECT SUM(CREDIT) FROM t_general_ledgers TGL3 WHERE A.ID = TGL3.ACCOUNT_ID AND TGL3.currency_id = {$currency_id} AND TGL3.gl_date BETWEEN '{$start_date}' AND '{$end_date}' GROUP BY TGL3.ACCOUNT_ID) total_credit,
                    (SELECT SUM(DEBIT) - SUM(CREDIT) FROM t_general_ledgers TGL4 WHERE A.ID = TGL4.ACCOUNT_ID AND TGL4.currency_id = {$currency_id} AND TGL4.gl_date BETWEEN '{$start_date}' AND '{$end_date}' GROUP BY TGL4.ACCOUNT_ID) total_balance,
                    COALESCE((SELECT SUM(DEBIT) - SUM(CREDIT) FROM t_general_ledgers TGL5 WHERE A.ID = TGL5.ACCOUNT_ID AND TGL5.currency_id = {$currency_id} AND TGL5.gl_date < '{$start_date}' GROUP BY TGL5.ACCOUNT_ID), 0) start_balance
                FROM
                    t_maccount AS A
                WHERE
                    ISNULL(A.parent_account)
                ORDER BY
                    A.account_number";

        return DB::select($query);
    }

    public static function getChildAccountTrialBalance($currency_id, $start_date, $end_date, $account_number)
    {
        $query = "SELECT
                    A.id,
                    A.account_number,
                    A.account_name,
                    (SELECT code FROM t_mcurrency tm WHERE tm.id = {$currency_id}) currency_code,
                    (SELECT SUM(DEBIT) FROM t_general_ledgers TGL2 WHERE A.ID = TGL2.ACCOUNT_ID AND TGL2.currency_id = {$currency_id} AND TGL2.gl_date BETWEEN '{$start_date}' AND '{$end_date}' GROUP BY TGL2.ACCOUNT_ID) total_debit,
                    (SELECT SUM(CREDIT) FROM t_general_ledgers TGL3 WHERE A.ID = TGL3.ACCOUNT_ID AND TGL3.currency_id = {$currency_id} AND TGL3.gl_date BETWEEN '{$start_date}' AND '{$end_date}' GROUP BY TGL3.ACCOUNT_ID) total_credit,
                    (SELECT SUM(DEBIT) - SUM(CREDIT) FROM t_general_ledgers TGL4 WHERE A.ID = TGL4.ACCOUNT_ID AND TGL4.currency_id = {$currency_id} AND TGL4.gl_date BETWEEN '{$start_date}' AND '{$end_date}' GROUP BY TGL4.ACCOUNT_ID) total_balance,
                    COALESCE((SELECT SUM(DEBIT) - SUM(CREDIT) FROM t_general_ledgers TGL5 WHERE A.ID = TGL5.ACCOUNT_ID AND TGL5.currency_id = {$currency_id} AND TGL5.gl_date < '{$start_date}' GROUP BY TGL5.ACCOUNT_ID), 0) start_balance
                FROM
                    t_maccount AS A
                WHERE
                    A.parent_account = '{$account_number}'
                ORDER BY
                    A.account_number";

        return DB::select($query);
    }

    public static function getStartingBalance($account_id, $date)
    {
        return DB::table('t_general_ledgers')->whereRaw("account_id = {$account_id} AND gl_date < '{$date}'")->groupBy('account_id')->sum('balance');
    }

    public static function getAllGLByAccountId($accountId, $currencyId)
    {
        return GeneralLedger::from('t_general_ledgers AS gl')
            ->leftJoin('t_journals AS j', 'j.id', '=', 'gl.journal_id')
            ->select('gl.*', 'j.journal_no', 'j.journal_date')
            ->where('gl.account_id', $accountId)
            ->where('gl.currency_id', $currencyId)
            ->orderBy('j.journal_date')
            ->orderBy('j.journal_no');
    }

    public static function getAllGLByAccountIdWithPeriod($accountId, $currencyId, $startDate, $endDate)
    {
        return GeneralLedger::from('t_general_ledgers AS gl')
            ->leftJoin('t_journals AS j', 'j.id', '=', 'gl.journal_id')
            ->join('t_maccount AS a', 'a.id', '=', 'gl.account_id')
            ->select('gl.*', 'j.journal_no', 'j.journal_date', 'a.account_number', 'a.account_name', DB::raw("(SELECT tm.code FROM t_mcurrency tm WHERE tm.id = {$currencyId}) currency_code"))
            ->where('gl.account_id', $accountId)
            ->where('gl.currency_id', $currencyId)
            ->whereRaw("gl.gl_date BETWEEN '{$startDate}' AND '{$endDate}'")
            ->orderBy('j.journal_date')
            ->orderBy('j.journal_no');
    }

    public static function findALlGLsForRefreshBalance($account_id, $currencyId, $startDate)
    {
        return GeneralLedger::where('account_id', $account_id)->where('currency_id', $currencyId)->where('gl_date', '>=', $startDate)->orderBy('gl_date');
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
