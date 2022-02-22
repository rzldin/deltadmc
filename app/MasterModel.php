<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MasterModel extends Model
{
    public static function users()
    {
        return DB::table('users')->leftJoin('t_mmatrix','users.id','=','t_mmatrix.t_muser_id')
                ->leftJoin('t_mresponsibility','t_mmatrix.t_mresponsibility_id','=','t_mresponsibility.id')
                ->select('users.*','t_mmatrix.t_mresponsibility_id as role_id','t_mresponsibility.responsibility_name as role_name')->orderBy('name')->get();
    }

    public static function users_get($id)
    {
        return DB::table('users')->leftJoin('t_mmatrix','users.id','=','t_mmatrix.t_muser_id')
                ->where('users.id', $id)->select('users.*','t_mmatrix.t_mresponsibility_id as role_id')->first();
    }

    public static function cek_username($name)
    {
        return DB::select("SELECT * from users where username ='".$name."'");
    }

    public static function country()
    {
        return DB::table('t_mcountry')->orderBy('country_name')->get();
    }

    public static function check_country_code($code)
    {
        return DB::select("Select * from t_mcountry where country_code ='".$code."'");
    }

    public static function country_get($id)
    {
        return DB::table('t_mcountry')->where('id', $id)->first();
    }

    public static function carrier()
    {
        return DB::select("SELECT a.*, b.country_name FROM t_mcarrier a LEFT JOIN t_mcountry b ON a.t_mcountry_id = b.id ORDER BY a.name ");
    }

    public static function check_carrier_code($code)
    {
        return DB::select("Select * from t_mcarrier where code ='".$code."'");
    }

    public static function carrier_get($id)
    {
        return DB::table('t_mcarrier')->where('id', $id)->first();
    }

    public static function charge()
    {
        return DB::table('t_mcharge_code')->orderBy('name')->get();
    }

    public static function check_charge_code($code)
    {
        return DB::select("Select * from t_mcharge_code where code ='".$code."'");
    }

    public static function charge_get($id)
    {
        return DB::table('t_mcharge_code')->where('id', $id)->first();
    }

    public static function vehicle()
    {
        return DB::select("SELECT a.*, b.type, c.client_name FROM t_mvehicle a LEFT JOIN t_mvehicle_type b ON a.t_mvehicle_type_id = b.id LEFT JOIN t_mcompany c ON a.t_mcompany_id = c.id");
    }

    public static function vehicle_get($id)
    {
        return DB::table('t_mvehicle')->where('id', $id)->first();
    }

    public static function company()
    {
        return DB::select("SELECT a.*, b.address_type, b.address, b.city, b.postal_code, b.postal_code, b.province, c.pic_desc, c.name as name_pic, c.phone1, c.phone2, c.fax as fax_pic, c.email as email_pic, d.country_code, d.country_name, d.country_phone_code FROM t_mcompany a LEFT JOIN t_maddress b ON a.id = b.t_mcompany_id LEFT JOIN t_mpic c ON a.id = c.t_mcompany_id LEFT JOIN t_mcountry d ON d.id = b.t_mcountry_id ORDER BY a.client_name");
    }

    public static function vendor()
    {
        return DB::table('t_mcompany')->orderBy('client_name')->get();
    }

    public static function company_data()
    {
        return DB::table('t_mcompany')->where('active_flag', 1)->orderBy('client_name')->get();
    }

    public static function company_data_full()
    {
        return DB::table('t_mcompany')->orderBy('client_name')->get();
    }

    public static function company_get($id)
    {
        return DB::table('t_mcompany')->where('id', $id)->first();
    }

    public static function company_detail_get($id)
    {
        return DB::select("SELECT
            c.*, ap.account_name as account_payable_name, ap.account_number as account_payable_number,
            ar.account_name as account_receivable_name, ar.account_number as account_receivable_number, u.name as user_name
            FROM t_mcompany c
            LEFT JOIN t_maccount ap ON c.account_payable_id = ap.id
            LEFT JOIN t_maccount ar ON c.account_receivable_id = ar.id
            LEFT JOIN users u ON c.sales_by = u.id
            WHERE c.id='".$id."'");
    }


    public static function company_loadDetail($id)
    {
        return DB::select("SELECT a.*, b.client_name, c.country_name FROM t_maddress a LEFT JOIN t_mcompany b ON b.id = a.t_mcountry_id LEFT JOIN t_mcountry c ON c.id = a.t_mcountry_id WHERE a.t_mcompany_id ='".$id."'");
    }
    public static function type_vehicle()
    {
        return DB::table('t_mvehicle_type')->orderBy('type')->get();
    }

    public static function port()
    {
        return DB::select("SELECT a.*, b.country_name FROM t_mport a LEFT JOIN t_mcountry b ON a.t_mcountry_id = b.id ORDER BY a.port_name");
    }

    public static function port_filter()
    {
        return DB::select("SELECT a.*, b.country_name FROM t_mport a LEFT JOIN t_mcountry b ON a.t_mcountry_id = b.id ORDER BY a.port_name");
    }

    public static function check_port_code($code)
    {
        return DB::select("Select * from t_mport where port_code ='".$code."'");
    }

    public static function port_get($id)
    {
        return DB::table('t_mport')->where('id', $id)->first();
    }

    public static function get_port($type)
    {
        return DB::select("SELECT a.*, b.country_name FROM t_mport a LEFT JOIN t_mcountry b ON a.t_mcountry_id = b.id WHERE a.port_type='".$type."' ORDER BY a.port_name");
    }

    public static function currency()
    {
        return DB::table('t_mcurrency')->orderBy('name')->get();
    }

    public static function check_currency_code($code)
    {
        return DB::select("Select * from t_mcurrency where code ='".$code."'");
    }

    public static function currency_get($id)
    {
        return DB::table('t_mcurrency')->where('id', $id)->first();
    }

    public static function get_currency_by_code($code)
    {
        return DB::table('t_mcurrency')->where('code', $code);
    }

    public static function account_get()
    {
        return DB::table('t_maccount')->select('t_maccount.*', 't_mcurrency.code')
                ->leftJoin('t_mcurrency','t_mcurrency.id','=','t_maccount.t_mcurrency_id')
                ->orderBy('account_number')->get();
    }

    public static function loaded_get()
    {
        return DB::table('t_mloaded_type')->orderBy('loaded_type')->get();
    }

    public static function loaded_get_detail($id)
    {
        return DB::table('t_mloaded_type')->where('id', $id)->first();
    }

    public static function freight_get()
    {
        return DB::table('t_mfreight_charges')->orderBy('freight_charge')->get();
    }

    public static function freight_get_detail($id)
    {
        return DB::table('t_mfreight_charges')->where('id', $id)->first();
    }

    public static function incoterms_get()
    {
        return DB::table('t_mincoterms')->orderBy('incoterns_code')->get();
    }

    public static function incoterms_get_detail($id)
    {
        return DB::table('t_mincoterms')->where('id', $id)->first();
    }

    public static function container_get()
    {
        return DB::table('t_mcontainer_type')->get();
    }

    public static function container_get_detail($id)
    {
        return DB::table('t_mcontainer_type')->where('id', $id)->first();
    }

    public static function service_get()
    {
        return DB::table('t_mservice_type')->get();
    }

    public static function service_get_detail($id)
    {
        return DB::table('t_mservice_type')->where('id', $id)->first();
    }

    public static function vehicleType_get()
    {
        return DB::table('t_mvehicle_type')->get();
    }

    public static function vehicleType_get_detail($id)
    {
        return DB::table('t_mvehicle_type')->where('id', $id)->first();
    }

    public static function schedule_get()
    {
        return DB::table('t_mschedule_type')->get();
    }

    public static function account_get_detail($id)
    {
        return DB::table('t_maccount')->where('id', $id)->first();
    }

    public static function schedule_get_detail($id)
    {
        return DB::table('t_mschedule_type')->where('id', $id)->first();
    }

    public static function segment_get()
    {
        return DB::table('t_macc_segment')->orderBy('segment_name')->get();
    }

    public static function parent_account_get()
    {
        return DB::table('t_maccount')->where('parent_account', null)->orderBy('account_name')->get();
    }

    public static function bank_account()
    {
        return DB::table('t_maccount')->whereBetween('parent_account', ['1-1000', '1-1100'])->orderBy('account_name')->get();
    }

    public static function bank_basedon_currency($id){
        return DB::table('t_maccount')->whereBetween('parent_account', ['1-1000', '1-1100'])->where('t_mcurrency_id',$id)->orderBy('account_name')->get();
    }

    public static function charge_group()
    {
        return DB::table('t_mcharge_group')->get();
    }

    public static function check_charge_group_name($name)
    {
        return DB::select("Select * from t_mcharge_group where name ='".$name."'");
    }

    public static function charge_group_get($id)
    {
        return DB::table('t_mcharge_group')->where('id', $id)->first();
    }

    public static function uom()
    {
        return DB::table('t_muom')->get();
    }

    public static function check_uom_code($code)
    {
        return DB::select("Select * from t_muom where uom_code ='".$code."'");
    }

    public static function charge_uom_get($id)
    {
        return DB::table('t_muom')->where('id', $id)->first();
    }

    public static function get_pic($id)
    {
        return DB::select("SELECT * from t_mpic where t_mcompany_id ='".$id."'");
    }

    public static function get_address($id)
    {
        return DB::select("SELECT * from t_maddress where t_mcompany_id ='".$id."' order by address_type <> 'UTAMA' ASC, address_type ASC");
    }

    public static function get_doc()
    {
        return DB::table('t_mdoc_type')->get();
    }

    public static function get_mbl_issued()
    {
        return DB::table('t_mbl_issued')->get();
    }

    public static function getKasAccount()
    {
        return DB::table('t_maccount')->whereBetween('parent_account', ['1-1000', '1-1100']);
    }

    public static function findAccountByAccountNumber($accountNumber)
    {
        return DB::table('t_maccount')->where('account_number', $accountNumber);
    }

    public static function findAccountByAccountName($accountName)
    {
        return DB::table('t_maccount')->where('account_name', 'LIKE', "%{$accountName}%");
    }

    public static function getUserRole($userId)
    {
        return DB::table('t_mmatrix AS m')
            ->leftJoin('t_mresponsibility AS r', 'r.id', '=', 'm.t_mresponsibility_id')
            ->select('m.*', 'r.responsibility_name')
            ->where('m.t_muser_id', $userId);
    }

    public static function roles(){
        return DB::table('t_mresponsibility')->where('active_flag',1)->get();
    }

    public static function acc_type()
    {
        return DB::table('t_macc_type')->get();
    }

    public static function acc_type_get($id)
    {
        return DB::table('t_macc_type')->where('id', $id)->first();
    }
}
