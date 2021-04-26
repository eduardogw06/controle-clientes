<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model {
    protected $fillable = [
        'zipcode',
        'address',
        'number',
        'neighborhood',
        'city',
        'state'
    ];
    protected $dates = ['deleted_at'];

    function client() {
        return $this->belongsTo('App\Client');
    }
}
