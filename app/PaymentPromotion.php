<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentPromotion extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_payment_promotion';

    protected $fillable = ['payment_id', 'promotion_id'];

    public static $rules = [
        "payment_id" => "required|numeric",
        "promotion_id" => "required|numeric"
    ];

    public function payment()
    {
        return $this->belongsTo('App\Payment');
    }

    public function promotion()
    {
        return $this->belongsTo('App\Promotion');
    }
}
