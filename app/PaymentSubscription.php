<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentSubscription extends Model
{	
	use SoftDeletes;

    protected $table = 'tbl_payment_subscription';

    protected $fillable = ['payment_id', 'subscription_id'];

    public static $rules = [
        "payment_id" => "required|numeric",
        "subscription_id" => "required|numeric"
	];

    public function payment()
    {
        return $this->belongsTo('App\Payment');
    }
    
    public function subscription()
    {
        return $this->belongsTo('App\Subscription');
    }
}