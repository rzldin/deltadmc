<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KasMasukDetail extends Model
{
    protected $table = 't_kas_masuk_details';
    protected $guarded = [];
    public $timestamps = false;

    public static function getAllKasMasukDetail($kasMasukId)
    {
        return KasMasukDetail::from('t_kas_masuk_details AS kmd')
            ->join('t_maccount AS a', 'a.id', '=', 'kmd.account_id')
            ->select('kmd.*', 'a.account_number', 'a.account_name')
            ->where('kas_masuk_id', $kasMasukId);
    }

    public static function saveKasMasukDetail($request)
    {
        return KasMasukDetail::updateOrCreate(
            ['id' => $request['id']],
            $request
        );
    }
}
