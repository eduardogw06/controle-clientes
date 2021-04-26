<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model {
    protected $fillable = ['name', 'email', 'birthday'];
    protected $dates = ['deleted_at'];

    public function address(){
        return $this->hasOne('App\Address');
    }
}
