<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Loyalty extends Model
{	
	use SoftDeletes;

    protected $table = 'tbl_loyalty';

    protected $fillable = ['points', 'user_id'];

    public static $rules = [
        "points" => "required|numeric",
        "user_id" => "required|numeric"
	];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function loyalty_logs()
    {
        return $this->hasMany('App\LoyaltyLog');
    }
}