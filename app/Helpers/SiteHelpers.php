<?php

namespace App\Helpers;

use App\MasterModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SiteHelpers {

    public static function main_menu(){

        $id = Auth::user()->id;

        $main_menu = DB::table('t_maccess_control')
        ->join('t_mapps_menu', 't_mapps_menu.id', '=', 't_maccess_control.t_mapps_menu_id')
        ->join('t_mresponsibility', 't_mresponsibility.id', '=', 't_maccess_control.t_mresponsibility_id')
        ->join('t_mmatrix', 't_mmatrix.t_mresponsibility_id', '=', 't_maccess_control.t_mresponsibility_id')
        ->select('t_mapps_menu.*')
        ->where('t_mmatrix.t_muser_id', $id)
        ->where('t_mapps_menu.apps_menu_level', 'main menu')->get();

        return $main_menu;
    }

    public static function sub_menu(){

        $id = Auth::user()->id;


        $sub_menu = DB::table('t_maccess_control')
        ->join('t_mapps_menu', 't_mapps_menu.id', '=', 't_maccess_control.t_mapps_menu_id')
        ->join('t_mresponsibility', 't_mresponsibility.id', '=', 't_maccess_control.t_mresponsibility_id')
        ->join('t_mmatrix', 't_mmatrix.t_mresponsibility_id', '=', 't_maccess_control.t_mresponsibility_id')
        ->select('t_mapps_menu.*')
        ->where('t_mmatrix.t_muser_id', $id)
        ->where('t_mapps_menu.apps_menu_level', 'sub menu')
        ->orderBy('t_mapps_menu.apps_menu_name', 'asc')->get();

        return $sub_menu;
    }

    public static function getUserRole()
    {
        $user_id = Auth::user()->id;

        $responsibility = MasterModel::getUserRole($user_id)->first();

        return $responsibility;
    }

}
