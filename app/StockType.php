<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockType extends Model
{	
	use SoftDeletes;

    protected $table = 'tbl_stock_type';

    protected $fillable = ['name', 'effect'];

    public static $rules = [
        "name" => "required",
        "effect" => "required|numeric",
	];

}