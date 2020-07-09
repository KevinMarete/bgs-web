<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RfqLog extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_rfq_log';

    protected $fillable = ['status', 'user_id', 'organization_id', 'rfq_id'];

    public static $rules = [
        "status" => "required",
        "user_id" => "required|numeric",
        "organization_id" => "required|numeric",
        "rfq_id" => "required|numeric"
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function organization()
    {
        return $this->belongsTo('App\Organization');
    }

    public function rfq()
    {
        return $this->belongsTo('App\Rfq');
    }
}
