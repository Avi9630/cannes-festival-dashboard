<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class NfaFeature extends Model
{
    protected  $table   =   'nfa_features';
    protected $guarded  =   [];

    static function stepsFeature()
    {
        return [
            'GENRAL'                =>  1,
            'CENSOR'                =>  2,
            'TITLE_REGISTRATION'    =>  3,
            'COMPANY_REGISTRATION'  =>  4,
            'PRODUCER'              =>  5,
            'DIRECTOR'              =>  6,
            'ACTORS'                =>  7,
            'SONGS'                 =>  8,
            'AUDIOGRAPHER'          =>  9,
            'OTHER'                 =>  10,
            'RETURN_ADDRESS'        =>  11,
            'DECLARATION'           =>  12,
            'FINAL_SUBMIT'          =>  13
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

    // public function documents(): HasMany
    // {
    //     return $this->hasMany(Document::class, 'context_id', 'id')->where(['form_type' => 1, 'website_type' => 5]);
    // }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class, 'context_id', 'id')
            ->where(['form_type' => 1, 'website_type' => 5])
            ->whereIn('document_type', [1, 2, 3]);
    }
}
