<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;
    protected  $table = 'languages';

    public function ipApplicationForms()
    {
        return $this->hasMany(IpApplicationForm::class, 'language_id');
    }

}
