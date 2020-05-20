<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Credit extends Model
{	
	use SoftDeletes;

    protected $table = 'tbl_credit';

    protected $fillable = ['amount', 'user_id'];

    public static $rules = [
        "amount" => "required|numeric",
        "user_id" => "required|numeric"
	];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function credit_logs()
    {
        return $this->hasMany('App\CreditLog');
    }
}