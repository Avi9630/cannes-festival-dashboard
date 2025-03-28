<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class IpApplicationForm extends Model
{
    use HasFactory;
    protected $guarded = [];

    static function steps()
    {
        return [
            'FILM_DETAILS'          => 1,
            'PRODUCERS_DETAILS'     => 2,
            'DORECTORS_DETAILS'     => 3,
            'CREW_DETAILS'          => 4,
            'CBFC_CERTIFICATION'    => 5,
            'OTHER_DETAILS'         => 6,
            'DOCUMENTS'             => 7,
            'DECLARATION_PAYMENT'   => 8,
            'SUBMISSION'   => 9,
        ];
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'client_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }

    public function payments($id)
    {
        $payment = Payment::where([
            'context_id' => $id,
            'status' => 1,
        ])->first();

        if (is_null($payment)) {
            $payment = [];
        }
        return $payment;
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class, 'context_id', 'id')->where('website_type', 1);;
    }

    static function getLanguage($language_id)
    {
        // $langauges = DB::table('languages')->get();
        $langauges = Language::get();
        foreach ($langauges as $langauge) {
            if ($langauge->id == $language_id) {
                return $langauge->name;
            }
        }
    }
}
