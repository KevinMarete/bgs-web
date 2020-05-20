<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreditLog extends Model
{	
	use SoftDeletes;

    protected $table = 'tbl_credit_log';

    protected $fillable = ['status', 'amount', 'credit_id'];

    public static $rules = [
        "status" => "required",
        "amount" => "required|numeric",
        "credit_id" => "required|numeric"
	];

    public function credit()
    {
        return $this->belongsTo('App\Credit');
    }
}