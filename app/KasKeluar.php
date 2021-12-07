<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KasKeluar extends Model
{
    protected $table = 't_kas_keluar';
    protected $guarded = [];
    public $timestamps = false;

    public static function getAllKasKeluar()
    {
        return KasKeluar::from('t_kas_keluar AS kk')
            ->join('t_maccount AS a', 'a.id', '=', 'kk.account_id')
            ->leftJoin('t_mcompany AS c', 'c.id', '=', 'kk.client_id')
            ->select('kk.*', 'a.account_number', 'a.account_name', 'c.client_code', 'c.client_name');
    }

    public static function findKasKeluar($id)
    {
        return KasKeluar::find($id);
    }

    public static function saveKasKeluar($request)
    {
        return KasKeluar::updateOrCreate(
            ['id' => $request['id']],
            $request
        );
    }
}
