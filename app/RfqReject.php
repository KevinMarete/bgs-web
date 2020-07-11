<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RfqReject extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_rfq_reject';

    protected $fillable = ['rfq_id', 'reject_reason_id'];

    public static $rules = [
        "rfq_id" => "required|numeric",
        "reject_reason_id" => "required|numeric"
    ];

    public function rfq()
    {
        return $this->belongsTo('App\Rfq');
    }

    public function reject_reason()
    {
        return $this->belongsTo('App\RejectReason');
    }
}
