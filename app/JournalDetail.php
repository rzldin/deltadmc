<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JournalDetail extends Model
{
    protected $table = 't_journal_details';
    protected $guarded = [];
    public $timestamps = false;

    public static function findAllJournalDetails($journalId)
    {
        return JournalDetail::from('t_journal_details AS jd')
            ->leftJoin('t_maccount AS a', 'a.id', '=', 'jd.account_id')
            ->select('jd.*', 'a.account_number', 'a.account_name')
            ->where('jd.journal_id', $journalId);
    }

    public static function saveJournalDetail($request)
    {
        return JournalDetail::updateOrCreate(
            ['id' => $request['id']],
            $request
        );
    }

    public static function deleteJournalDetailByJournalId($journalId)
    {
        JournalDetail::where('journal_id', $journalId)->delete();
    }
}
