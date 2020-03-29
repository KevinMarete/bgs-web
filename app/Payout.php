<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payout extends Model
{	
	use SoftDeletes;

    protected $table = 'tbl_payout';

    protected $fillable = ['order_id', 'organization_id'];

    public static $rules = [
        "order_id" => "required|numeric",
        "organization_id" => "required|numeric"
    ];
    
    public function order()
    {
        return $this->belongsTo('App\Order');
    }
    
    public function organization()
    {
        return $this->belongsTo('App\Organization');
    }
}