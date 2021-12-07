<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KasMasuk extends Model
{
    protected $table = 't_kas_masuk';
    protected $guarded = [];
    public $timestamps = false;

    public static function getAllKasMasuk()
    {
        return KasMasuk::from('t_kas_masuk AS km')
            ->join('t_maccount AS a', 'a.id', '=', 'km.account_id')
            ->leftJoin('t_mcompany AS c', 'c.id', '=', 'km.client_id')
            ->select('km.*', 'a.account_number', 'a.account_name', 'c.client_code', 'c.client_name');
    }

    public static function findKasMasuk($id)
    {
        return KasMasuk::find($id);
    }

    public static function saveKasMasuk($request)
    {
        return KasMasuk::updateOrCreate(
            ['id' => $request['id']],
            $request
        );
    }
}
