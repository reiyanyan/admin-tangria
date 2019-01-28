<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class booking extends Model
{
    //
    protected $fillable = [
        'user_id', 'order','date','status'
    ];
    public function users() {
        return $this->belongsTo('App\User','user_id');
    }
}
