<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $guarded = [];

    public function permanentCmots()
    {
        return $this->hasOne(Cmot::class, 'permanent_city');
    }

    public function residenceCmots()
    {
        return $this->hasOne(Cmot::class, 'residence_city');
    }
}
