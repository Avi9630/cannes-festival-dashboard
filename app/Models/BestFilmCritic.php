<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BestFilmCritic extends Model
{
    protected  $table   =   'best_film_critics';
    protected $guarded  =   [];

    static function stepsBestFilmCritic()
    {
        return [
            'BEST_FILM_CRITIC'      =>  1,
            'CRITIC'                =>  2,
            'PUBLISHER'             =>  3,
            'DECLARATION'           =>  4,
            'FINAL_SUBMIT'          =>  5,
        ];
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
