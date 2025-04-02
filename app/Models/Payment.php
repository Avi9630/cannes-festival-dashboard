<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected  $table = 'payments';

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function ipApplicationForm()
    {
        return $this->belongsTo(IpApplicationForm::class, 'context_id');
    }
}
