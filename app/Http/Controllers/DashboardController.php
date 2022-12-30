<?php

namespace App\Http\Controllers;

use App\Deposit;
use App\DepositDetail;
use App\MasterModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class DepositController extends Controller
{
    public function index()
    {
        $user = DB::table('users AS a')
            ->leftJoin('t_mmatrix AS b', 'a.id', '=', 'b.t_muser_id')
            ->leftJoin('t_mresponsibility AS c', 'b.t_mresponsibility_id', '=', 'c.id')
            ->select('a.*', 'c.responsibility_name')
            ->where('a.id', Auth::guard()->id())->first();

        $auth = [
            'user_id'     => $user->id,
            'role'        => $user->responsibility_name,
            'email'       => $user->email,
            'name'        => $user->name,
        ];

        Session::put('user', $auth);
        return view('content');
    }
}
