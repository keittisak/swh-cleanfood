<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "code", "type", "customer_id", "total_quantity", "total_amount", "packing_charge", "discount", "shipping_fee", "net_total_amount", "shipping_zone", "shipping_zone_priority", "shipping_location_url", "shipping_phone", "shipping_name", "shipping_address", "transfer_image", "course_id", "course_started_at", "status", "created_by", "updated_by", "created_at", "updated_at"
    ];

    public function details()
    {
        return $this->hasMany('App\OrderDetail');
    }

    public function customer ()
    {
        return $this->belongsTo('App\Customer', 'customer_id')->withTrashed();
    }

    public function created_by_user()
    {
        return $this->belongsTo('App\User', 'created_by')->withTrashed();
    }

    public function updated_by_user()
    {
        return $this->belongsTo('App\User', 'updated_by')->withTrashed();
    }
}
