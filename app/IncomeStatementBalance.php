<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IncomeStatementBalance extends Model
{
    protected $table = 't_income_statement_balances';
    protected $guarded = [];
    public $timestamps = false;
}
