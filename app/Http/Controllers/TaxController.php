<?php

namespace App\Http\Controllers;

use App\Tax;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TaxController extends Controller
{
    public function index()
    {
        $taxes = Tax::all();

        return view('tax.list_tax', compact('taxes'));
    }

    public function save(Request $request)
    {
        $rules = [
            'name' => 'required',
            'value' => 'required|numeric'
        ];

        if ($request->id == 0) {
            $addition_rules = [
                'code' => 'required|unique:taxes',
            ];

        } else {
            $addition_rules = [
                'code' => [
                    'required',
                    Rule::unique('taxes')->ignore($request->code, 'code')
                ]
            ];
        }
        $rules = array_merge($rules, $addition_rules);

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->with('errorForm', $validator->errors()->messages());
        }

        try {
            $param = $request->all();
            $param['created_on'] = now();
            $param['created_by'] = Auth::user()->name;
            $param['updated_on'] = now();
            $param['updated_by'] = Auth::user()->name;

            Tax::updateOrCreate(['id' => $param['id']], $param);

            return redirect()->route('master.tax.index')->with('success', 'Data saved!');
        } catch (\Throwable $th) {
            Log::error("save tax error {$th->getMessage()}");

            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
