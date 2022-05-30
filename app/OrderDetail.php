<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'order_id', 'product_id', 'name', 'type', 'price', 'menu_id', 'menu_name' ,'menu_type', 'quantity', 'total_amount','remark', 'status', 'delivered_at', "created_by", "updated_by", "created_at", "updated_at"
    ];

    public function order()
    {
        return $this->belongsTo('App\Order');
    }

    public function product ()
    {
        return $this->belongsTo('App\Product');
    }

    public function menu ()
    {
        return $this->belongsTo('App\Menu');
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
