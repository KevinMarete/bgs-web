<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderLog extends Model
{	
	use SoftDeletes;

    protected $table = 'tbl_order_log';

    protected $fillable = ['status', 'user_id', 'organization_id', 'order_id'];

    public static $rules = [
        "status" => "required",
        "user_id" => "required|numeric",
        "organization_id" => "required|numeric",
        "order_id" => "required|numeric"
    ];
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function organization()
    {
        return $this->belongsTo('App\Organization');
    }

    public function order()
    {
        return $this->belongsTo('App\Order');
    }
}