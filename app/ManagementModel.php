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

    public static function get_data_user()
    {
        return DB::table('users')->orderBy('name', 'asc')->get();
    }

    public static function get_detail_user()
    {
        return DB::table('t_mmatrix')->leftJoin('users', 't_mmatrix.t_muser_id', '=', 'users.id')->leftJoin('t_mresponsibility', 't_mmatrix.t_mresponsibility_id', '=', 't_mresponsibility.id')->select('t_mmatrix.*', 'users.name AS name_user', 't_mresponsibility.responsibility_name AS role')->get();
    }
}
