<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KasTransfer extends Model
{
    protected $table = 't_kas_transfers';
    protected $guarded = [];
    public $timestamps = false;

    public static function getAllKasTransfer()
    {
        return KasTransfer::from('t_kas_transfers AS kt')
            ->join('t_maccount AS fa', 'fa.id', '=', 'kt.from_account_id')
            ->join('t_maccount AS ta', 'ta.id', '=', 'kt.to_account_id')
            ->select('kt.*', 'fa.account_number AS from_account_number', 'fa.account_name AS from_account_name', 'ta.account_number AS to_account_number', 'ta.account_name AS to_account_name');
    }

    public static function saveKasTransfer($request)
    {
        return KasTransfer::updateOrCreate(
            ['id' => $request['id']],
            $request
        );
    }
}
