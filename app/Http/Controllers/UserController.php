<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Validator;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index($id)
    {
        $data['user'] = DB::table('users')->where('id', $id)->first();
        return view('profile.profile')->with($data);
    }

    public function user_doAdd(Request $request)
    {
        try {
            $user = Auth::user()->name;
            $tanggal = Carbon::now();
            DB::table('users')->where('id', $request->id)
            ->update([
                'name'       => $request->name,
                'username'   => $request->username,
                'address'    => $request->address,
                'email'      => $request->email,
                'updated_by' => $user,
                'updated_at' => $tanggal
            ]);

            return redirect('user/'.$request->id)->with('status', 'Successfully Update');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }


    public function doChangePassword(Request $request)
    {
        $rules = [
            'new_password' => 'required',
            'confirm_password' => 'required',
        ];

        $message = [
            'required' => ':attribute tidak boleh kosong!',
        ];

        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $new_password = bcrypt($request->new_password);

        if (Auth::attempt(['id' => session('user.user_id'), 'password' => $request->old_password])) {
            try {
                DB::table('users')->where('id', session('user.user_id'))->update([
                    'password' => $new_password,
                    'updated_at' => date('Y-m-d h:i:s'),
                ]);

                return redirect()->back()->with('status', 'Password has been successfully updated.');
            } catch (\Exception $e) {
                return redirect()->back()->withErrors([$e->getMessage()]);
            }
        } else {
            return redirect()->back()->withErrors('Your old password is wrong.');
        }
        
        
    }
}
