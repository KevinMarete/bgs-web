<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentRefund extends Model
{	
	use SoftDeletes;

    protected $table = 'tbl_payment_refund';

    protected $fillable = ['payment_id', 'refund_id'];

    public static $rules = [
        "payment_id" => "required|numeric",
        "refund_id" => "required|numeric"
	];

    public function payment()
    {
        return $this->belongsTo('App\Payment');
    }
    
    public function refund()
    {
        return $this->belongsTo('App\Refund');
    }
}