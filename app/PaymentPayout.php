<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentPayout extends Model
{	
	use SoftDeletes;

    protected $table = 'tbl_payment_payout';

    protected $fillable = ['payment_id', 'payout_id'];

    public static $rules = [
        "payment_id" => "required|numeric",
        "payout_id" => "required|numeric"
	];

    public function payment()
    {
        return $this->belongsTo('App\Payment');
    }
    
    public function payout()
    {
        return $this->belongsTo('App\Payout');
    }
}