<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Courier extends Model
{	
	use SoftDeletes;

    protected $table = 'tbl_courier';

    protected $fillable = ['name', 'phone', 'email', 'contact'];

    public static $rules = [
        "name" => "required",
        "phone" => "required",
        "email" => "required|email",
        "contact" => "required"
	];
}