<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoyaltyLog extends Model
{	
	use SoftDeletes;

    protected $table = 'tbl_loyalty_log';

    protected $fillable = ['status', 'points', 'order_id', 'loyalty_id'];

    public static $rules = [
        "status" => "required",
        "points" => "required|numeric",
        "order_id" => "required|numeric",
        "loyalty_id" => "required|numeric"
	];

    public function order()
    {
        return $this->belongsTo('App\Order');
    }

    public function loyalty()
    {
        return $this->belongsTo('App\Loyalty');
    }
}