<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrganizationPaymentType extends Model
{	
	use SoftDeletes;

    protected $table = 'tbl_organization_payment_type';

    protected $fillable = ['details', 'organization_id', 'payment_type_id'];

    public static $rules = [
        "details" => "required|JSON",
        "organization_id" => "required|numeric",
        "payment_type_id" => "required|numeric",
    ];
    
    public function organization()
    {
        return $this->belongsTo('App\Organization');
    }

    public function payment_type()
    {
        return $this->belongsTo('App\PaymentType');
    }

}