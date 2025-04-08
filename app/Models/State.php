<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $guarded = [];
    public function permanentCmots()
    {
        return $this->hasOne(Cmot::class, 'permanent_state');
    }
    public function residenceCmots()
    {
        return $this->hasOne(Cmot::class, 'residence_state');
    }
}
