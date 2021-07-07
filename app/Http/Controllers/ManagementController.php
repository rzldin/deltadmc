<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Carbon\Carbon;
use App\ManagementModel;

class ManagementController extends Controller
{
    /** User Management */
    public function user_access()
    {
        $data['list_user'] = ManagementModel::get_user();
        $data['list_menu'] = ManagementModel::menu();
        $data['list_data'] = ManagementModel::user_access();
        return view('management.user_access')->with($data);
    }


    public function user_accessdoAdd(Request $request)
    {
        if($request->status == 'on'){
            $status = 1;
        }else{
            $status = 0;
        }

        try {
            $user = Auth::user()->name;
            $tanggal = Carbon::now();
            $num = count($request->menu);

            for($i=0;$i<$num;$i++){
                DB::table('t_maccess_control')->insert([
                    't_mresponsibility_id'  => $request->role,
                    't_mapps_menu_id'       => $request->menu[$i],
                    'active_flag'           => $status,
                    'created_by'            => $user,
                    'created_on'            => $tanggal
                ]);
            }
            

            return redirect()->route('user.access')->with('status', 'Successfully added');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }
    

    public function user_accessDelete($id)
    {
        try {
            DB::table('t_maccess_control')->where('id', $id)->delete();

            return redirect()->route('user.access')->with('status', 'Successfully deleted');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }

    public function user_access_get(Request $request)
    {
        $data = ManagementModel::users_access_get($request['id']);
        return json_encode($data);
    }

    public function user_accessdoEdit(Request $request)
    {
        if($request->status == null){
            $status = 0;
        }else{
            $status = 1;
        }

        try {
            DB::table('t_maccess_control')
            ->where('id', $request->id)
            ->update([
                't_mresponsibility_id'  => $request->role,
                't_mapps_menu_id'       => $request->menu[0],
                'active_flag'           => $status
            ]);

            return redirect()->route('user.access')->with('status', 'Successfully updated');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }
}
