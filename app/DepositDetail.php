<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
