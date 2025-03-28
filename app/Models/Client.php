<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected  $table = 'clients';

    public function ipApplicationForms()
    {
        return $this->hasOne(IpApplicationForm::class, 'client_id');
    }

    public function cmots()
    {
        return $this->hasOne(Cmot::class, 'client_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'client_id');
    }

    public function ottForms()
    {
        return $this->hasOne(OttForm::class, 'client_id');
    }
}
