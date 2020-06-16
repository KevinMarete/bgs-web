<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentOffer extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_payment_offer';

    protected $fillable = ['payment_id', 'offer_id'];

    public static $rules = [
        "payment_id" => "required|numeric",
        "offer_id" => "required|numeric"
    ];

    public function payment()
    {
        return $this->belongsTo('App\Payment');
    }

    public function offer()
    {
        return $this->belongsTo('App\Offer');
    }
}
