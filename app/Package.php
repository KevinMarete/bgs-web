<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{	
	use SoftDeletes;

    protected $table = 'tbl_package';

    protected $fillable = ['name', 'price', 'details'];

    public static $rules = [
      "name" => "required",
      "price" => "required|numeric",
      "details" => "required|JSON"
    ];

}