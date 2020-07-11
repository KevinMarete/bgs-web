<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentRfq extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_payment_rfq';

    protected $fillable = ['payment_id', 'rfq_id'];

    public static $rules = [
        "payment_id" => "required|numeric",
        "rfq_id" => "required|numeric"
    ];

    public function payment()
    {
        return $this->belongsTo('App\Payment');
    }

    public function rfq()
    {
        return $this->belongsTo('App\Rfq');
    }
}
