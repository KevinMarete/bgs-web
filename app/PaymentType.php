<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentType extends Model
{	
	use SoftDeletes;

    protected $table = 'tbl_payment_type';

    protected $fillable = ['name', 'details'];

    public static $rules = [
        "name" => "required|unique:tbl_payment_type",
        "details" => "required|JSON",
	];

}