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

    public static function saveJournal($request)
    {
        return Journal::updateOrCreate(
            ['id' => $request['id']],
            $request
        );
    }
}
