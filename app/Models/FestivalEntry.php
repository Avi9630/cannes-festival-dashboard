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

    // public function permanentCountry()
    // {
    //     return $this->hasOne(Country::class, 'id');
    // }

    // public function residenceCountry()
    // {
    //     return $this->hasOne(Country::class, 'id');
    // }

    // public function permanentState()
    // {
    //     return $this->hasOne(State::class, 'id');
    // }

    // public function residenceState()
    // {
    //     return $this->hasOne(State::class, 'id');
    // }

    // public function permanentCity()
    // {
    //     return $this->hasOne(City::class, 'id');
    // }

    // public function residenceCity()
    // {
    //     return $this->hasOne(City::class, 'id');
    // }

    // public function age($dob)
    // {
    //     return $years = Carbon::parse($dob)->age;
    // }

    // public function category(): HasOne
    // {
    //     return $this->hasOne(CmotCategory::class, 'id', 'category_id');
    // }

    // public function user(): HasOne
    // {
    //     return $this->hasOne(User::class, 'id', 'user_id');
    // }

    // public function cmotJuryAssign()
    // {
    //     return $this->hasMany(CmotJuryAssign::class, 'cmot_id');
    // }

    // public function calculateScore($level1FinalScore, $level2FinalScore)
    // {
    //     $finalScore = ($this->weightageLevel1($level1FinalScore)) + ($this->weightageLevel2($level2FinalScore));
    //     return $finalScore;
    // }

    // public function weightageLevel1($leve1FinalScore)
    // {
    //     $percentage = 30;
    //     $result = ($leve1FinalScore * $percentage) / 100;
    //     return $result;
    // }

    // public function weightageLevel2($leve2FinalScore)
    // {
    //     $percentage = 70;
    //     $result = ($leve2FinalScore * $percentage) / 100;
    //     return $result;
    // }

    public static function Stages()
    {
        return [
            'ASSIGNED_TO_JURY'              =>  1,
            'FEEDBACK_GIVEN_BY_JURY'        =>  2,
            'SELECTED_BY_GRAND_JURY'        =>  3,
            // 'FEEDBACK_GIVEN_BY_GRAND_JURY'  =>  4,
        ];
    }

    // static function highestQualification()
    // {
    //     $data['10']    =   '10th Std';
    //     $data['15']    =   '12th Std';
    //     $data['20']    =   'Diploma';
    //     $data['25']    =   'Graduate';
    //     $data['30']    =   'Post Graduate';
    //     $data['35']    =   'Mphil';
    //     $data['40']    =   'PhD';
    //     $data['45']    =   'Post Doctoral';
    //     return $data;
    // }

    // public function getCv($id)
    // {
    //     return Document::where([
    //         'context_id' => $id,
    //         'website_type' => $this->websiteType()['CMOT'],
    //         'type' => Document::documentCmotType()[strtoupper('upload_cv')],
    //     ])->first();
    // }

    // public function getReel($id)
    // {
    //     return Document::where([
    //         'context_id' => $id,
    //         'website_type' => $this->websiteType()['CMOT'],
    //         'type' => Document::documentCmotType()[strtoupper('Upload_reel')],
    //     ])->first();
    // }

    // public function getProfile($id)
    // {
    //     return  Document::where([
    //         'context_id' => $id,
    //         'website_type' => $this->websiteType()['CMOT'],
    //         'type' => Document::documentCmotType()[strtoupper('passport_photo')], //PASSPORT_PHOTO
    //     ])->first();
    // }

    // public function firstGovtProof($id)
    // {
    //     return Document::where([
    //         'context_id' => $id,
    //         'website_type' => $this->websiteType()['CMOT'],
    //         'type' => Document::documentCmotType()[strtoupper('FIRST_GOV_ID_PROOF')], //PASSPORT_PHOTO
    //     ])->first();
    // }

    // public function secondGovtProof($id)
    // {
    //     return Document::where([
    //         'context_id' => $id,
    //         'website_type' => $this->websiteType()['CMOT'],
    //         'type' => Document::documentCmotType()[strtoupper('FIRST_GOV_ID_PROOF')], //PASSPORT_PHOTO
    //     ])->first();
    // }
}
