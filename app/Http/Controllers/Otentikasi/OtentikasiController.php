<?php

namespace App\Http\Controllers\otentikasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class OtentikasiController extends Controller
{
    public function index(){
        return view('otentikasi.login');
    }

    public function logout(Request $request){
        Auth::logout();
        return redirect('/');
    }
}
