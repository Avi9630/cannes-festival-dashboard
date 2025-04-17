<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\COMMONTrait;
use Carbon\Carbon;

class FestivalEntry extends Model
{
    use HasFactory, COMMONTrait;
    protected $table = 'festival_entries';
    protected $guarded  =   [];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public static function Stages()
    {
        return [
            'ASSIGNED_TO_JURY'          =>  1,
            'FEEDBACK_GIVEN_BY_JURY'    =>  2,
            'FINAL_SELECT_FOR_LEVEL2'   =>  3,
            'ASSIGNED_TO_LEVEL2'        =>  4,
            'FEEDBACK_GIVEN_ON_LEVEL2'  =>  5,
        ];
    }
}
