<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BestBookCinema extends Model
{

    protected  $table   =   'best_book_cinemas';
    protected $guarded  =   [];

    static function stepsBestBook()
    {
        return [
            'BEST_BOOK_ON_CINEMA'   =>  1,
            'AUTHOR'                =>  2,
            'PUBLISHER_EDITOR'      =>  3,
            'DECLARATION'           =>  4,
            'FINAL_SUBMIT'          =>  5,
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
        return $this->hasMany(Document::class, 'context_id', 'id')->where('website_type', 5);;
    }
}
