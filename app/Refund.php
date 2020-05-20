<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Refund extends Model
{	
	use SoftDeletes;

    protected $table = 'tbl_refund';

    protected $fillable = ['status', 'order_id'];

    public static $rules = [
        "status" => "required",
        "order_id" => "required|numeric"
    ];
    
    public function order()
    {
        return $this->belongsTo('App\Order');
    }
}