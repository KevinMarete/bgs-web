<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{	
	use SoftDeletes;

    protected $table = 'tbl_payment';

    protected $fillable = ['amount', 'details', 'organization_id', 'user_id'];

    public static $rules = [
        "amount" => "required|numeric",
        "details" => "required|JSON",
        "organization_id" => "required|numeric",
        "user_id" => "required|numeric"
	];

    public function organization()
    {
        return $this->belongsTo('App\Organization');
    }
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}