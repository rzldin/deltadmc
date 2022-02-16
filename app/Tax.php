<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    protected $table = 'm_taxes';
    protected $guarded = [];
    public $timestamps = false;
}
