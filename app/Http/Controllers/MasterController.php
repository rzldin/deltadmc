<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Carbon\Carbon;
use App\MasterModel;

class MasterController extends Controller
{

    /** Country */
    public function country()
    {
        $data['list_data'] = MasterModel::country();

        return view('master.country')->with($data);
    }

    public function country_doAdd(Request $request)
    {
        try {
            $user = Auth::user()->name;
            $tanggal = Carbon::now();
            DB::table('t_mcountry')->insert([
                'country_code'          => strtoupper($request->country_code),
                'country_phone_code'    => $request->country_phone_code,
                'country_name'          => strtoupper($request->country_name),
                'created_by'            => $user,
                'created_on'            => $tanggal
            ]);

            return redirect()->route('master.country')->with('status', 'Successfully added');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }

    public function country_doEdit(Request $request)
    {
        try {
            DB::table('t_mcountry')
            ->where('id', $request->id)
            ->update([
                'country_code'          => strtoupper($request->country_code),
                'country_phone_code'    => $request->country_phone_code,
                'country_name'          => strtoupper($request->country_name)
            ]);

            return redirect()->route('master.country')->with('status', 'Successfully updated');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }

    public function cek_country_code(Request $request)
    {
        $data = MasterModel::check_country_code($request['data']);
        $return_data = ($data) ? "duplicate" : "success" ;
        echo $return_data;
    }

    public function country_get(Request $request)
    {
        $data = MasterModel::country_get($request['id']);
        return json_encode($data);
    }

    public function get_all_country()
    {
        $data = MasterModel::country();
        return json_encode($data);
    }

    public function country_delete($id)
    {
        try {
            DB::table('t_mcountry')->where('id', $id)->delete();

            #Delete Address Company
            DB::table('t_maddress')->where('t_mcompany_id', $id)->delete();

            #Delete PIC Company
            DB::table('t_mpic')->where('t_mcompany_id', $id)->delete();

            return redirect()->route('master.country')->with('status', 'Successfully deleted');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }


    /** Carrier */
    public function carrier()
    {
        $data['list_data'] = MasterModel::carrier();
        $data['list_country'] = MasterModel::country();
        return view('master.carrier')->with($data);
    }

    public function carrier_doAdd(Request $request)
    {

        if($request->status == 'on'){
            $status = 1;
        }else{
            $status = 0;
        }

        try {
            $user = Auth::user()->name;
            $tanggal = Carbon::now();
            DB::table('t_mcarrier')->insert([
                'code'                  => $request->code,
                'name'                  => $request->name,
                't_mcountry_id'         => $request->flag,
                'lloyds_code'           => $request->llyods,
                'active_flag'           => $status,
                'created_by'            => $user,
                'created_on'            => $tanggal
            ]);

            return redirect()->route('master.carrier')->with('status', 'Successfully added');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }

    public function carrier_doEdit(Request $request)
    {
        if($request->status == null){
            $status = 0;
        }else{
            $status = 1;
        }
        try {
            $user = Auth::user()->name;
            $tanggal = Carbon::now();
            DB::table('t_mcarrier')
            ->where('id', $request->id)
            ->update([
                'code'                  => $request->code,
                'name'                  => $request->name,
                't_mcountry_id'         => $request->flag,
                'lloyds_code'           => $request->llyods,
                'active_flag'           => $status,
                'updated_by'            => $user,
                'updated_on'            => $tanggal
            ]);

            return redirect()->route('master.carrier')->with('status', 'Successfully updated');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }

    public function cek_carrier_code(Request $request)
    {
        $data = MasterModel::check_carrier_code($request['data']);
        $return_data = ($data) ? "duplicate" : "success" ;
        echo $return_data;
    }

    public function carrier_get(Request $request)
    {
        $data = MasterModel::carrier_get($request['id']);
        return json_encode($data);
    }

    public function carrier_delete($id)
    {
        try {
            DB::table('t_mcarrier')->where('id', $id)->delete();

            return redirect()->route('master.carrier')->with('status', 'Successfully deleted');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }

    /** Charge */
    public function charge()
    {
        $data['list_data'] = MasterModel::charge();
        $data['list_charge'] = MasterModel::charge_group();
        return view('master.charge')->with($data);
    }

    public function charge_doAdd(Request $request)
    {
        if($request->status == 'on'){
            $status = 1;
        }else{
            $status = 0;
        }

        try {
            $user = Auth::user()->name;
            $tanggal = Carbon::now();
            DB::table('t_mcharge_code')->insert([
                'code'                  => $request->code,
                'name'                  => $request->name,
                't_mcharge_group_id'    => $request->charge_group,
                'active_flag'           => $status,
                'created_by'            => $user,
                'created_on'            => $tanggal
            ]);

            return redirect()->route('master.charge')->with('status', 'Successfully added');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }

    public function charge_doEdit(Request $request)
    {
        if($request->status == null){
            $status = 0;
        }else{
            $status = 1;
        }

        try {
            $user = Auth::user()->name;
            $tanggal = Carbon::now();
            DB::table('t_mcharge_code')
            ->where('id', $request->id)
            ->update([
                'code'                  => $request->code,
                'name'                  => $request->name,
                't_mcharge_group_id'    => $request->charge_group,
                'active_flag'           => $status,
                'updated_by'            => $user,
                'updated_on'            => $tanggal
            ]);

            return redirect()->route('master.charge')->with('status', 'Successfully updated');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }

    public function cek_charge_code(Request $request)
    {
        $data = MasterModel::check_charge_code($request['data']);
        $return_data = ($data) ? "duplicate" : "success" ;
        echo $return_data;
    }

    public function charge_get(Request $request)
    {
        $data = MasterModel::charge_get($request['id']);
        return json_encode($data);
    }

    public function charge_delete($id)
    {
        try {
            DB::table('t_mcharge_code')->where('id', $id)->delete();

            return redirect()->route('master.charge')->with('status', 'Successfully deleted');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }

    /** Vehicle */
    public function vehicle()
    {
        $data['list_data'] = MasterModel::vehicle();
        $data['list_vendor'] = MasterModel::vendor();
        $data['list_type_vehicle'] = MasterModel::type_vehicle();
        return view('master.vehicle')->with($data);
    }

    public function vehicle_doAdd(Request $request)
    {
        if($request->status == 'on'){
            $status = 1;
        }else{
            $status = 0;
        }

        try {
            $user = Auth::user()->name;
            $tanggal = Carbon::now();
            DB::table('t_mvehicle')->insert([
                't_mvehicle_type_id'    => $request->type,
                'vehicle_no'            => $request->nopol,
                't_mcompany_id'         => $request->vendor,
                'shipment_type'         => $request->shipment,
                'active_flag'           => $status,
                'created_by'            => $user,
                'created_on'            => $tanggal
            ]);

            return redirect()->route('master.vehicle')->with('status', 'Successfully added');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }

    public function vehicle_doEdit(Request $request)
    {
        if($request->status == null){
            $status = 0;
        }else{
            $status = 1;
        }
        
        try {
            $user = Auth::user()->name;
            $tanggal = Carbon::now();
            DB::table('t_mvehicle')
            ->where('id', $request->id)
            ->update([
                't_mvehicle_type_id'    => $request->type,
                'vehicle_no'            => $request->nopol,
                't_mcompany_id'         => $request->vendor,
                'shipment_type'         => $request->shipment,
                'active_flag'           => $status,
                'created_by'            => $user,
                'created_on'            => $tanggal
            ]);

            return redirect()->route('master.vehicle')->with('status', 'Successfully updated');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }

    public function cek_vehicle_code(Request $request)
    {
        $data = MasterModel::check_vehicle_code($request['data']);
        $return_data = ($data) ? "duplicate" : "success" ;
        echo $return_data;
    }

    public function vehicle_get(Request $request)
    {
        $data = MasterModel::vehicle_get($request['id']);
        return json_encode($data);
    }

    public function vehicle_delete($id)
    {
        try {
            DB::table('t_mvehicle')->where('id', $id)->delete();

            return redirect()->route('master.vehicle')->with('status', 'Successfully deleted');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }

    /** Port */
    public function port()
    {
        $data['list_data'] = MasterModel::port();
        $data['list_country'] = MasterModel::country();
        return view('master.port')->with($data);
    }

    public function port_doAdd(Request $request)
    {
        if($request->status == 'on'){
            $status = 1;
        }else{
            $status = 0;
        }

        try {
            $user = Auth::user()->name;
            $tanggal = Carbon::now();
            DB::table('t_mport')->insert([
                'port_code'             => $request->port,
                'port_name'             => $request->port_name,
                'port_type'             => $request->port_type,
                't_mcountry_id'         => $request->country,
                'province'              => $request->province,
                'city'                  => $request->city,
                'postal_code'           => $request->postal_code,
                'address'               => $request->address,
                'active_flag'           => $status,
                'created_by'            => $user,
                'created_on'            => $tanggal
            ]);

            return redirect()->route('master.port')->with('status', 'Successfully added');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }

    public function port_doEdit(Request $request)
    {
        if($request->status == null){
            $status = 0;
        }else{
            $status = 1;
        }
        
        try {
            $user = Auth::user()->name;
            $tanggal = Carbon::now();
            DB::table('t_mport')
            ->where('id', $request->id)
            ->update([
                'port_code'             => $request->port,
                'port_name'             => $request->port_name,
                'port_type'             => $request->port_type,
                't_mcountry_id'         => $request->country,
                'province'              => $request->province,
                'city'                  => $request->city,
                'postal_code'           => $request->postal_code,
                'address'               => $request->address,
                'active_flag'           => $status,
                'updated_by'            => $user,
                'updated_on'            => $tanggal
            ]);

            return redirect()->route('master.port')->with('status', 'Successfully updated');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }

    public function cek_port_code(Request $request)
    {
        $data = MasterModel::check_port_code($request['data']);
        $return_data = ($data) ? "duplicate" : "success" ;
        echo $return_data;
    }

    public function port_get(Request $request)
    {
        $data = MasterModel::port_get($request['id']);
        return json_encode($data);
    }

    public function port_delete($id)
    {
        try {
            DB::table('t_mport')->where('id', $id)->delete();

            return redirect()->route('master.port')->with('status', 'Successfully deleted');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }

    /** Currency */
    public function currency()
    {
        $data['list_data'] = MasterModel::currency();
        return view('master.currency')->with($data);
    }

    public function currency_doAdd(Request $request)
    {
        if($request->status == 'on'){
            $status = 1;
        }else{
            $status = 0;
        }

        try {
            $user = Auth::user()->name;
            $tanggal = Carbon::now();
            DB::table('t_mcurrency')->insert([
                'code'             => $request->code,
                'name'             => $request->name,
                'desc'             => $request->desc,
                'active_flag'      => $status,
                'created_by'       => $user,
                'created_on'       => $tanggal
            ]);

            return redirect()->route('master.currency')->with('status', 'Successfully added');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }

    public function currency_doEdit(Request $request)
    {
        if($request->status == null){
            $status = 0;
        }else{
            $status = 1;
        }
        
        try {
            $user = Auth::user()->name;
            $tanggal = Carbon::now();
            DB::table('t_mcurrency')
            ->where('id', $request->id)
            ->update([
                'code'             => $request->code,
                'name'             => $request->name,
                'desc'             => $request->desc,
                'active_flag'      => $status,
                'updated_by'       => $user,
                'updated_on'       => $tanggal
            ]);

            return redirect()->route('master.currency')->with('status', 'Successfully updated');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }

    public function cek_currency_code(Request $request)
    {
        $data = MasterModel::check_currency_code($request['data']);
        $return_data = ($data) ? "duplicate" : "success" ;
        echo $return_data;
    }

    public function currency_get(Request $request)
    {
        $data = MasterModel::currency_get($request['id']);
        return json_encode($data);
    }

    public function currency_delete($id)
    {
        try {
            DB::table('t_mcurrency')->where('id', $id)->delete();

            return redirect()->route('master.currency')->with('status', 'Successfully deleted');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }

    /** Company */
    public function company()
    {
        $data['list_data'] = MasterModel::company_data();
        return view('master.company')->with($data);
    }

    public function company_add()
    {
        $sales = DB::table('t_mmatrix')
        ->leftJoin('users', 't_mmatrix.t_muser_id', '=', 'users.id')
        ->leftJoin('t_mresponsibility', 't_mmatrix.t_mresponsibility_id', '=', 't_mresponsibility.id')
        ->select('users.name as user_name', 'users.id as user_id')
        ->where('t_mresponsibility.responsibility_name', ['Administrator', 'Sales'])
        ->where('t_mmatrix.active_flag', '1')->get();
        $data['list_account'] = MasterModel::account_get();
        $data['list_country'] = MasterModel::country();
        $data['list_sales'] = $sales;
        return view('master.company_add')->with($data);
    }

    public function company_doAdd(Request $request)
    {
        #Get Status Value
        if($request->legal_doc == 1){
            $legal_doc = 1;
        }else{
            $legal_doc = 0;
        }

        if($request->status == 1){
            $status = 1;
        }else{
            $status = 0;
        }

        #Get Customer Value
        if($request->customer == 1){
            $cust = 1;
        }else{
            $cust = 0;
        }

        #Get Vendor Value
        if($request->vendor == 1){
            $ven = 1;
        }else{
            $ven = 0;
        }

        #Get Buyer Value
        if($request->buyer == 1){
            $buyer = 1;
        }else{
            $buyer = 0;
        }

        #Get Seller Value
        if($request->seller == 1){
            $seller = 1;
        }else{
            $seller = 0;
        }

        #Get Shipper Value
        if($request->shipper == 1){
            $shipper = 1;
        } else {
            $shipper = 0;
        }

        #Get agent Value
        if($request->agent == 1){
            $agent = 1;
        }else{
            $agent = 0;
        }

        #Get PPJK Value
        if($request->ppjk == 1){
            $ppjk = 1;
        }else{
            $ppjk = 0;
        }

        try {
            $user = Auth::user()->name;
            $tanggal = Carbon::now();
            $id = DB::table('t_mcompany')->insertGetId([
                    'client_code'           => $request->client_code,
                    'client_name'           => $request->client_name,
                    'npwp'                  => $request->npwp,
                    't_maccount_id'         => $request->account,
                    'sales_by'              => $request->sales,
                    'legal_doc_flag'        => $legal_doc,
                    'customer_flag'         => $cust,
                    'vendor_flag'           => $ven,
                    'buyer_flag'            => $buyer,
                    'seller_flag'           => $seller,
                    'shipping_line_flag'    => $shipper,
                    'agent_flag'            => $agent,
                    'ppjk_flag'             => $ppjk,
                    'active_flag'           => $status,
                    'created_by'            => $user,
                    'created_on'            => $tanggal
                ]);

            return redirect('master/company_edit/'.$id)->with('status', 'Successfully added');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }

    public function company_edit($id)
    {
        $sales = DB::table('t_mmatrix')
        ->leftJoin('users', 't_mmatrix.t_muser_id', '=', 'users.id')
        ->leftJoin('t_mresponsibility', 't_mmatrix.t_mresponsibility_id', '=', 't_mresponsibility.id')
        ->select('users.name as user_name', 'users.id as user_id')
        ->where('t_mresponsibility.responsibility_name', ['Administrator', 'Sales'])
        ->where('t_mmatrix.active_flag', '1')->get();
        $data['list_account'] = MasterModel::account_get();
        $data['list_country'] = MasterModel::country();
        $data['list_sales'] = $sales;
        $data['company'] = MasterModel::company_get($id);
        return view('master.company_edit')->with($data);
    }

    public function company_view($id)
    {
        $pic = DB::table('t_mpic')
                    ->leftJoin('t_mcompany','t_mcompany.id', '=', 't_mpic.t_mcompany_id')
                    ->select('t_mpic.*', 't_mcompany.client_name')
                    ->where('t_mpic.t_mcompany_id', $id)->get();

        $address = DB::table('t_maddress')
                    ->leftJoin('t_mcompany','t_mcompany.id', '=', 't_maddress.t_mcompany_id')
                    ->leftJoin('t_mcountry', 't_mcountry.id', '=', 't_maddress.t_mcountry_id')
                    ->select('t_maddress.*', 't_mcompany.client_name', 't_mcountry.country_name')
                    ->where('t_maddress.t_mcompany_id', $id)->get();

        $company = DB::table('t_mcompany')
                    ->leftJoin('users', 't_mcompany.sales_by', '=', 'users.id')
                    ->leftJoin('t_maccount', 't_mcompany.t_maccount_id', '=', 't_maccount.id')
                    ->select('t_mcompany.*', 'users.name as user_name', 't_maccount.account_name')
                    ->where('t_mcompany.id', $id)->first();

        $data['company'] = $company;
        $data['pic'] = $pic;
        $data['address'] = $address;

        return view('master.company_view')->with($data);
    }

    public function company_delete($id)
    {
        try {
            DB::table('t_mcompany')->where('id', $id)->delete();
            
            #Delete Tabel t_maddress
            DB::table('t_maddress')->where('t_mcompany_id', $id)->delete();
            #Delete Tabel t_mpic
            DB::table('t_mpic')->where('t_mcompany_id', $id)->delete();

            return redirect()->route('master.company')->with('status', 'Successfully deleted');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }

    public function company_doUpdate(Request $request)
    {

         #Get Legal Doc Value
        if($request->legal_doc == 1){
            $legal_doc = 1;
        }else{
            $legal_doc = 0;
        }

        #Get Status Value
        if($request->status == 1){
            $status = 1;
        }else{
            $status = 0;
        }

        #Get Customer Value
        if($request->customer == 1){
            $cust = 1;
        }else{
            $cust = 0;
        }

        #Get Vendor Value
        if($request->vendor == 1){
            $ven = 1;
        }else{
            $ven = 0;
        }

        #Get Buyer Value
        if($request->buyer == 1){
            $buyer = 1;
        }else{
            $buyer = 0;
        }

        #Get Seller Value
        if($request->seller == 1){
            $seller = 1;
        }else{
            $seller = 0;
        }

        #Get Shipper Value
        if($request->shipper == 1){
            $shipper = 1;
        } else {
            $shipper = 0;
        }

        #Get agent Value
        if($request->agent == 1){
            $agent = 1;
        }else{
            $agent = 0;
        }

        #Get PPJK Value
        if($request->ppjk == 1){
            $ppjk = 1;
        }else{
            $ppjk = 0;
        }

        try {
            $user = Auth::user()->name;
            $tanggal = Carbon::now();
            DB::table('t_mcompany')->where('id', $request->id)->update([
                'client_code'           => $request->client_code,
                'client_name'           => $request->client_name,
                'npwp'                  => $request->npwp,
                't_maccount_id'         => $request->account,
                'sales_by'              => $request->sales,
                'legal_doc_flag'        => $legal_doc,
                'customer_flag'         => $cust,
                'vendor_flag'           => $ven,
                'buyer_flag'            => $buyer,
                'seller_flag'           => $seller,
                'shipping_line_flag'    => $shipper,
                'agent_flag'            => $agent,
                'ppjk_flag'             => $ppjk,
                'active_flag'           => $status,
                'updated_by'            => $user,
                'updated_on'            => $tanggal
            ]);

                return redirect()->route('master.company')->with('status', 'Successfully updated');
            } catch (\Exception $e) {
                return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
            }
    }

    public function company_addAddress(Request $request)
    {
        if($request->status == 1){
            $status = 1;
        }else{
            $status = 0;
        }
        try {
            $user = Auth::user()->name;
            $tanggal = Carbon::now();
            DB::table('t_maddress')->insert([
                't_mcompany_id'     => $request->company,
                'address_type'      => $request->address_type,
                't_mcountry_id'     => $request->country,
                'city'              => $request->city,
                'postal_code'       => $request->postal_code,
                'province'          => $request->province,
                'address'           => $request->address,
                'active_flag'       => $status,
                'created_by'        => $user,
                'created_on'        => $tanggal
            ]);

            $return_data = 'sukses';
        } catch (\Exception $e) {
            $return_data = $e->getMessage();
        }

        header('Content-Type: application/json');
        echo json_encode($return_data);

    }

    public function company_loadDetail(Request $request)
    {        
        $tbl =  DB::table('t_maddress')
                    ->leftJoin('t_mcompany','t_mcompany.id', '=', 't_maddress.t_mcompany_id')
                    ->leftJoin('t_mcountry', 't_mcountry.id', '=', 't_maddress.t_mcountry_id')
                    ->select('t_maddress.*', 't_mcompany.client_name', 't_mcountry.country_name')
                    ->where('t_maddress.t_mcompany_id', $request['id'])->get();

        header('Content-Type: application/json');
        echo json_encode($tbl); 
    }

    public function company_deleteAddress(Request $request)
    {
        try {
            DB::table('t_maddress')->where('id', $request['id'])->delete();

            $return_data = 'sukses';
        } catch (\Exception $e) {
            $return_data = $e->getMessage();
        }

        header('Content-Type: application/json');
        echo json_encode($return_data);
    }

    public function company_updateAddress(Request $request)
    {
        if($request->status == null){
            $status = 0;
        }else{
            $status = 1;
        }
        
        try {
            $user = Auth::user()->name;
            $tanggal = Carbon::now();
            DB::table('t_maddress')
            ->where('id', $request->id)
            ->update([
                'address_type'      => $request->address_type,
                't_mcountry_id'     => $request->country,
                'city'              => $request->city,
                'postal_code'       => $request->postal_code,
                'province'          => $request->province,
                'address'           => $request->address,
                'active_flag'       => $status,
                'updated_by'        => $user,
                'updated_on'        => $tanggal
            ]);

            $return_data = 'sukses';
        } catch (\Exception $e) {
            $return_data = $e->getMessage();
        }

        header('Content-Type: application/json');
        echo json_encode($return_data);
    }

    public function company_addPic(Request $request)
    {
        if($request->status == 1){
            $status = 1;
        }else{
            $status = 0;
        }
        try {
            $user = Auth::user()->name;
            $tanggal = Carbon::now();
            DB::table('t_mpic')->insert([
                't_mcompany_id'     => $request->company,
                'pic_desc'          => $request->desc,
                'name'              => $request->pic_name,
                'phone1'            => $request->phone1,
                'phone2'            => $request->phone2,
                'fax'               => $request->fax,
                'email'             => $request->email,
                'active_flag'       => $status,
                'created_by'        => $user,
                'created_on'        => $tanggal
            ]);

            $return_data = 'sukses';
        } catch (\Exception $e) {
            $return_data = $e->getMessage();
        }

        header('Content-Type: application/json');
        echo json_encode($return_data);

    }

    public function company_loadDetailPic(Request $request)
    {        
        $tbl =  DB::table('t_mpic')
                    ->leftJoin('t_mcompany','t_mcompany.id', '=', 't_mpic.t_mcompany_id')
                    ->select('t_mpic.*', 't_mcompany.client_name')
                    ->where('t_mpic.t_mcompany_id', $request['id'])->get();

        header('Content-Type: application/json');
        echo json_encode($tbl); 
    }

    public function company_deletePic(Request $request)
    {
        try {
            DB::table('t_mpic')->where('id', $request['id'])->delete();

            $return_data = 'sukses';
        } catch (\Exception $e) {
            $return_data = $e->getMessage();
        }

        header('Content-Type: application/json');
        echo json_encode($return_data);
    }

    public function company_updatePic(Request $request)
    {
        if($request->status == null){
            $status = 0;
        }else{
            $status = 1;
        }
        
        try {
            $user = Auth::user()->name;
            $tanggal = Carbon::now();
            DB::table('t_mpic')
            ->where('id', $request->id)
            ->update([
                'pic_desc'          => $request->desc,
                'name'              => $request->name,
                'phone1'            => $request->phone1,
                'phone2'            => $request->phone2,
                'fax'               => $request->fax,
                'email'             => $request->email,
                'active_flag'       => $status,
                'updated_by'        => $user,
                'updated_on'        => $tanggal
            ]);

            $return_data = 'sukses';
        } catch (\Exception $e) {
            $return_data = $e->getMessage();
        }

        header('Content-Type: application/json');
        echo json_encode($return_data);
    }


    /** Users */
    public function user()
    {
        $data['list_data'] = MasterModel::users();
        $data['list_country'] = MasterModel::country();
        return view('master.users')->with($data);
    }

    public function user_doAdd(Request $request)
    {
        if($request->status == 'on'){
            $status = 1;
        }else{
            $status = 0;
        }
        try {
            $user = Auth::user()->name;
            $tanggal = Carbon::now();
            DB::table('users')->insert([
                'name'                  => $request->name,
                'username'              => $request->username,
                'address'               => $request->address,
                't_mcountry_id'         => $request->country,
                'city'                  => $request->city,
                'postal_code'           => $request->postal_code,
                'province'              => $request->province,
                'phone1'                => $request->phone1,
                'phone2'                => $request->phone2,
                'fax'                   => $request->fax,
                'email'                 => $request->email,
                'active_flag'           => $status,      
                'password'              => bcrypt($request->password),
                'created_by'            => $user,
                'created_at'            => $tanggal
            ]);

            return redirect()->route('master.user')->with('status', 'Successfully added');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }

    public function user_doEdit(Request $request)
    {
        if($request->status == 'on'){
            $status = 1;
        }else{
            $status = 0;
        }
        try {
            $user = Auth::user()->name;
            $tanggal = Carbon::now();
            DB::table('users')
            ->where('id', $request->id)
            ->update([
                'name'                  => $request->name,
                'username'              => $request->username,
                'address'               => $request->address,
                't_mcountry_id'         => $request->country,
                'city'                  => $request->city,
                'postal_code'           => $request->postal_code,
                'province'              => $request->province,
                'phone1'                => $request->phone1,
                'phone2'                => $request->phone2,
                'fax'                   => $request->fax,
                'email'                 => $request->email,
                'active_flag'           => $status,   
                'updated_by'            => $user,
                'updated_at'            => $tanggal   
            ]);

            return redirect()->route('master.user')->with('status', 'Successfully updated');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }

    public function cek_username(Request $request)
    {
        $data = MasterModel::cek_username($request['data']);
        $return_data = ($data)? "duplicate" : "success" ;
        echo $return_data;
    }

    public function users_get(Request $request)
    {
        $data = MasterModel::users_get($request['id']);
        return json_encode($data);
    }

    public function user_delete($id)
    {
        try {
            DB::table('users')->where('id', $id)->delete();

            return redirect()->route('master.user')->with('status', 'Successfully Deleted!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }

    /** Account */
    public function account()
    {
        $data['list_data'] = MasterModel::account_get();
        $data['list_segment'] = MasterModel::segment_get();
        $data['list_parent'] = MasterModel::parent_account_get();
        return view('master.account')->with($data);
    }
 
    public function account_doAdd(Request $request)
    {
        if($request->status == 'on'){
            $status = 1;
        }else{
            $status = 0;
        }
        try {
            $user = Auth::user()->name;
            $tanggal = Carbon::now();
            DB::table('t_maccount')->insert([
                'account_number'        => $request->account_number,
                'account_name'          => $request->account_name,
                'account_type'          => $request->account_type,
                'segment_no'            => $request->segment,
                'parent_account'        => $request->parent_account,
                'beginning_ballance'    => $request->beginning_ballance,
                'start_date'            => $request->start_date,
                'active_flag'           => $status,
                'created_by'            => $user,
                'created_on'            => $tanggal
            ]);

            return redirect()->route('master.account')->with('status', 'Successfully added');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }

    public function account_get(Request $request)
    {
        $data = MasterModel::account_get_detail($request['id']);
        return json_encode($data);
    }

    public function account_doEdit(Request $request)
    {
        if($request->status == '1'){
            $status = 1;
        }else{
            $status = 0;
        }
        try {
            $user = Auth::user()->name;
            $tanggal = Carbon::now();
            DB::table('t_maccount')
            ->where('id', $request->id)
            ->update([
                'account_number'        => $request->account_number,
                'account_name'          => $request->account_name,
                'account_type'          => $request->account_type,
                'segment_no'            => $request->segment,
                'parent_account'        => $request->parent_account,
                'beginning_ballance'    => $request->beginning_ballance,
                'start_date'            => $request->start_date,
                'active_flag'           => $status,  
                'updated_by'            => $user,
                'updated_on'            => $tanggal   
            ]);

            return redirect()->route('master.account')->with('status', 'Successfully updated');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }

    public function account_delete($id)
    {
        try {
            DB::table('t_maccount')->where('id', $id)->delete();

            return redirect()->route('master.account')->with('status', 'Successfully Deleted!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }

    /** Schedule */
    public function schedule()
    {
        $data['list_data'] = MasterModel::schedule_get();
        return view('master.schedule_type')->with($data);
    }

    public function schedule_doAdd(Request $request)
    {
        if($request->status == 'on'){
            $status = 1;
        }else{
            $status = 0;
        }

        if($request->internal == 'on'){
            $internal = 1;
        }else{
            $internal = 0;
        }
        try {
            $user = Auth::user()->name;
            $tanggal = Carbon::now();
            DB::table('t_mschedule_type')->insert([
                'schedule_type'         => $request->schedule,
                'desc'                  => $request->desc,
                'internal_flag'         => $internal,
                'active_flag'           => $status,
                'created_by'            => $user,
                'created_on'            => $tanggal
            ]);

            return redirect()->route('master.schedule')->with('status', 'Successfully added');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }

    public function schedule_get(Request $request)
    {
        $data = MasterModel::schedule_get_detail($request['id']);
        return json_encode($data);
    }

    public function schedule_doEdit(Request $request)
    {
        if($request->status == '1'){
            $status = 1;
        }else{
            $status = 0;
        }

        if($request->internal == '1'){
            $internal = 1;
        }else{
            $internal = 0;
        }
        try {
            DB::table('t_mschedule_type')
            ->where('id', $request->id)
            ->update([
                'schedule_type'         => $request->schedule,
                'desc'                  => $request->desc,
                'internal_flag'         => $internal,
                'active_flag'           => $status
            ]);

            return redirect()->route('master.schedule')->with('status', 'Successfully updated');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }

    public function schedule_delete($id)
    {
        try {
            DB::table('t_mschedule_type')->where('id', $id)->delete();

            return redirect()->route('master.schedule')->with('status', 'Successfully Deleted!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }


    /** Loaded */
    public function loaded()
    {
        $data['list_data'] = MasterModel::loaded_get();
        return view('master.loaded')->with($data);
    }

    public function loaded_doAdd(Request $request)
    {
        if($request->status == 'on'){
            $status = 1;
        }else{
            $status = 0;
        }

        try {
            $user = Auth::user()->name;
            $tanggal = Carbon::now();
            DB::table('t_mloaded_type')->insert([
                'loaded_type'           => $request->loaded,
                'desc'                  => $request->desc,
                'active_flag'           => $status,
                'created_by'            => $user,
                'created_on'            => $tanggal
            ]);

            return redirect()->route('master.loaded')->with('status', 'Successfully added');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }

    public function loaded_get(Request $request)
    {
        $data = MasterModel::loaded_get_detail($request['id']);
        return json_encode($data);
    }

    public function loaded_doEdit(Request $request)
    {
        if($request->status == '1'){
            $status = 1;
        }else{
            $status = 0;
        }

        try {
            DB::table('t_mloaded_type')
            ->where('id', $request->id)
            ->update([
                'loaded_type'         => $request->loaded,
                'desc'                => $request->desc,
                'active_flag'         => $status
            ]);

            return redirect()->route('master.loaded')->with('status', 'Successfully updated');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }

    public function loaded_delete($id)
    {
        try {
            DB::table('t_mloaded_type')->where('id', $id)->delete();

            return redirect()->route('master.loaded')->with('status', 'Successfully Deleted!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }


    /** Freight */
    public function freight()
    {
        $data['list_data'] = MasterModel::freight_get();
        return view('master.freight')->with($data);
    }

    public function freight_doAdd(Request $request)
    {
        if($request->status == 'on'){
            $status = 1;
        }else{
            $status = 0;
        }

        try {
            $user = Auth::user()->name;
            $tanggal = Carbon::now();
            DB::table('t_mfreight_charges')->insert([
                'freight_charge'        => $request->freight,
                'desc'                  => $request->desc,
                'active_flag'           => $status,
                'created_by'            => $user,
                'created_on'            => $tanggal
            ]);

            return redirect()->route('master.freight')->with('status', 'Successfully added');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }

    public function freight_get(Request $request)
    {
        $data = MasterModel::freight_get_detail($request['id']);
        return json_encode($data);
    }

    public function freight_doEdit(Request $request)
    {
        if($request->status == '1'){
            $status = 1;
        }else{
            $status = 0;
        }

        try {
            DB::table('t_mfreight_charges')
            ->where('id', $request->id)
            ->update([
                'freight_charge'      => $request->freight,
                'desc'                => $request->desc,
                'active_flag'         => $status
            ]);

            return redirect()->route('master.freight')->with('status', 'Successfully updated');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }

    public function freight_delete($id)
    {
        try {
            DB::table('t_mfreight_charges')->where('id', $id)->delete();

            return redirect()->route('master.freight')->with('status', 'Successfully Deleted!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }


    /** incoterms */
    public function incoterms()
    {
        $data['list_data'] = MasterModel::incoterms_get();
        return view('master.incoterms')->with($data);
    }

    public function incoterms_doAdd(Request $request)
    {
        if($request->status == 'on'){
            $status = 1;
        }else{
            $status = 0;
        }

        try {
            $user = Auth::user()->name;
            $tanggal = Carbon::now();
            DB::table('t_mincoterms')->insert([
                'incoterns_code'        => $request->code,
                'desc'                  => $request->desc,
                'active_flag'           => $status,
                'created_by'            => $user,
                'created_on'            => $tanggal
            ]);

            return redirect()->route('master.incoterms')->with('status', 'Successfully added');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }

    public function incoterms_get(Request $request)
    {
        $data = MasterModel::incoterms_get_detail($request['id']);
        return json_encode($data);
    }

    public function incoterms_doEdit(Request $request)
    {
        if($request->status == '1'){
            $status = 1;
        }else{
            $status = 0;
        }

        try {
            DB::table('t_mincoterms')
            ->where('id', $request->id)
            ->update([
                'incoterns_code'      => $request->code,
                'desc'                => $request->desc,
                'active_flag'         => $status
            ]);

            return redirect()->route('master.incoterms')->with('status', 'Successfully updated');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }

    public function incoterms_delete($id)
    {
        try {
            DB::table('t_mincoterms')->where('id', $id)->delete();

            return redirect()->route('master.incoterms')->with('status', 'Successfully Deleted!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }


    /** container */
    public function container()
    {
        $data['list_data'] = MasterModel::container_get();
        return view('master.container')->with($data);
    }

    public function container_doAdd(Request $request)
    {
        if($request->status == 'on'){
            $status = 1;
        }else{
            $status = 0;
        }

        try {
            $user = Auth::user()->name;
            $tanggal = Carbon::now();
            DB::table('t_mcontainer_type')->insert([
                'container_type'        => $request->code,
                'desc'                  => $request->desc,
                'active_flag'           => $status,
                'created_by'            => $user,
                'created_on'            => $tanggal
            ]);

            return redirect()->route('master.container')->with('status', 'Successfully added');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }

    public function container_get(Request $request)
    {
        $data = MasterModel::container_get_detail($request['id']);
        return json_encode($data);
    }

    public function container_doEdit(Request $request)
    {
        if($request->status == '1'){
            $status = 1;
        }else{
            $status = 0;
        }

        try {
            DB::table('t_mcontainer_type')
            ->where('id', $request->id)
            ->update([
                'container_type'      => $request->code,
                'desc'                => $request->desc,
                'active_flag'         => $status
            ]);

            return redirect()->route('master.container')->with('status', 'Successfully updated');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }

    public function container_delete($id)
    {
        try {
            DB::table('t_mcontainer_type')->where('id', $id)->delete();

            return redirect()->route('master.container')->with('status', 'Successfully Deleted!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }


    /** service */
    public function service()
    {
        $data['list_data'] = MasterModel::service_get();
        return view('master.service')->with($data);
    }

    public function service_doAdd(Request $request)
    {
        if($request->status == 'on'){
            $status = 1;
        }else{
            $status = 0;
        }

        try {
            $user = Auth::user()->name;
            $tanggal = Carbon::now();
            DB::table('t_mservice_type')->insert([
                'service_type'          => $request->code,
                'desc'                  => $request->desc,
                'active_flag'           => $status,
                'created_by'            => $user,
                'created_on'            => $tanggal
            ]);

            return redirect()->route('master.service')->with('status', 'Successfully added');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }

    public function service_get(Request $request)
    {
        $data = MasterModel::service_get_detail($request['id']);
        return json_encode($data);
    }

    public function service_doEdit(Request $request)
    {
        if($request->status == '1'){
            $status = 1;
        }else{
            $status = 0;
        }

        try {
            DB::table('t_mservice_type')
            ->where('id', $request->id)
            ->update([
                'service_type'          => $request->code,
                'desc'                => $request->desc,
                'active_flag'         => $status
            ]);

            return redirect()->route('master.service')->with('status', 'Successfully updated');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }

    public function service_delete($id)
    {
        try {
            DB::table('t_mservice_type')->where('id', $id)->delete();

            return redirect()->route('master.service')->with('status', 'Successfully Deleted!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }


    /** Vehicle Type */
    public function vehicleType()
    {
        $data['list_data'] = MasterModel::vehicleType_get();
        return view('master.vehicle_type')->with($data);
    }

    public function vehicleType_doAdd(Request $request)
    {
        if($request->status == 'on'){
            $status = 1;
        }else{
            $status = 0;
        }

        try {
            $user = Auth::user()->name;
            $tanggal = Carbon::now();
            DB::table('t_mvehicle_type')->insert([
                'type'                  => $request->type,
                'description'           => $request->desc,
                'active_flag'           => $status,
                'created_by'            => $user,
                'created_on'            => $tanggal
            ]);

            return redirect()->route('master.vehicleType')->with('status', 'Successfully added');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }

    public function vehicleType_get(Request $request)
    {
        $data = MasterModel::vehicleType_get_detail($request['id']);
        return json_encode($data);
    }

    public function vehicleType_doEdit(Request $request)
    {
        if($request->status == '1'){
            $status = 1;
        }else{
            $status = 0;
        }

        try {
            DB::table('t_mvehicle_type')
            ->where('id', $request->id)
            ->update([
                'type'                => $request->type,
                'description'         => $request->desc,
                'active_flag'         => $status
            ]);

            return redirect()->route('master.vehicleType')->with('status', 'Successfully updated');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }

    public function vehicleType_delete($id)
    {
        try {
            DB::table('t_mvehicle_type')->where('id', $id)->delete();

            return redirect()->route('master.vehicleType')->with('status', 'Successfully Deleted!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }


    /** Charge Group */
    public function charge_group()
    {
        $data['list_data'] = MasterModel::charge_group();
        return view('master.charge_group')->with($data);
    }

    public function charge_group_doAdd(Request $request)
    {
        if($request->status == 'on'){
            $status = 1;
        }else{
            $status = 0;
        }

        try {
            $user = Auth::user()->name;
            $tanggal = Carbon::now();
            DB::table('t_mcharge_group')->insert([
                'name'                  => $request->name,
                'desc'                  => $request->desc,
                'active_flag'           => $status,
                'created_by'            => $user,
                'created_on'            => $tanggal
            ]);

            return redirect()->route('master.charge_group')->with('status', 'Successfully added');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }

    public function charge_group_doEdit(Request $request)
    {
        if($request->status == null){
            $status = 0;
        }else{
            $status = 1;
        }

        try {
            DB::table('t_mcharge_group')
            ->where('id', $request->id)
            ->update([
                'name'                  => $request->name,
                'desc'                  => $request->desc,
                'active_flag'           => $status
            ]);

            return redirect()->route('master.charge_group')->with('status', 'Successfully updated');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }

    public function cek_charge_group_name(Request $request)
    {
        $data = MasterModel::check_charge_group_name($request['data']);
        $return_data = ($data) ? "duplicate" : "success" ;
        echo $return_data;
    }

    public function charge_group_get(Request $request)
    {
        $data = MasterModel::charge_group_get($request['id']);
        return json_encode($data);
    }

    public function charge_group_delete($id)
    {
        try {
            DB::table('t_mcharge_group')->where('id', $id)->delete();

            return redirect()->route('master.charge_group')->with('status', 'Successfully deleted');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }


    /** Uom */
    public function uom()
    {
        $data['list_data'] = MasterModel::uom();
        return view('master.uom')->with($data);
    }

    public function uom_doAdd(Request $request)
    {
        if($request->status == 'on'){
            $status = 1;
        }else{
            $status = 0;
        }

        try {
            $user = Auth::user()->name;
            $tanggal = Carbon::now();
            DB::table('t_muom')->insert([
                'uom_code'              => $request->code,
                'desc'                  => $request->desc,
                'active_flag'           => $status,
                'created_by'            => $user,
                'created_on'            => $tanggal
            ]);

            return redirect()->route('master.uom')->with('status', 'Successfully added');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }

    public function uom_doEdit(Request $request)
    {
        if($request->status == null){
            $status = 0;
        }else{
            $status = 1;
        }

        try {
            DB::table('t_muom')
            ->where('id', $request->id)
            ->update([
                'uom_code'              => $request->code,
                'desc'                  => $request->desc,
                'active_flag'           => $status
            ]);

            return redirect()->route('master.uom')->with('status', 'Successfully updated');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }

    public function cek_uom_code(Request $request)
    {
        $data = MasterModel::check_uom_code($request['data']);
        $return_data = ($data) ? "duplicate" : "success" ;
        echo $return_data;
    }

    public function uom_get(Request $request)
    {
        $data = MasterModel::uom_get($request['id']);
        return json_encode($data);
    }

    public function uom_delete($id)
    {
        try {
            DB::table('t_muom')->where('id', $id)->delete();

            return redirect()->route('master.uom')->with('status', 'Successfully deleted');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }

}
