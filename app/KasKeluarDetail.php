<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KasKeluarDetail extends Model
{
    protected $table = 't_kas_keluar_detatils';
    protected $guarded = [];
    public $timestamps = false;

    public static function getAllKasKeluarDetail($kasKeluarId)
    {
        return KasKeluarDetail::from('t_kas_keluar_detatils AS kkd')
            ->join('t_maccount AS a', 'a.id', '=', 'kkd.account_id')
            ->select('kkd.*', 'a.account_number', 'a.account_name')
            ->where('kas_keluar_id', $kasKeluarId);
    }

    public static function saveKasKeluarDetail($request)
    {
        return KasKeluarDetail::updateOrCreate(
            ['id' => $request['id']],
            $request
        );
    }
}
