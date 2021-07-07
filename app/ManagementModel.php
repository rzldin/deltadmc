<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class ManagementModel extends Model
{
    public static function user_access()
    {
        return DB::table('t_maccess_control')->leftJoin('t_mresponsibility', 't_maccess_control.t_mresponsibility_id','=','t_mresponsibility.id')->leftJoin('t_mapps_menu','t_maccess_control.t_mapps_menu_id','=','t_mapps_menu.id')
        ->select('t_maccess_control.*','t_mresponsibility.responsibility_name','t_mapps_menu.apps_menu_name','t_mapps_menu.apps_menu_level')->where('t_maccess_control.active_flag', '1')->get();
    }

    public static function get_user()
    {
        return DB::table('t_mresponsibility')->orderBy('responsibility_name')->where('active_flag', '1')->get();
    }

    public static function menu()
    {
        return DB::table('t_mapps_menu')->where('active_flag', '1')->get();
    }

    public static function users_access_get($id)
    {
        return DB::table('t_maccess_control')->where('id', $id)->first();
    }
}
