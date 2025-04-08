<?php

namespace App\Http\Controllers;

use App\Models\FestivalEntry;
use App\Models\JuryAssign;
use Illuminate\Support\Facades\Auth;
use App\Models\NfaNonFeature;
use App\Models\NfaFeature;

class WelcomeController extends Controller
{
    public function __construct()
    {
        $this->user = Auth::user();
    }

    public function index()
    {
        //Cannes Entries
        $entries =  FestivalEntry::selectRaw('COUNT(*) as totalForms')->first();
        $totalEntries = $entries->totalForms;

        $scoreByJury    =   JuryAssign::where('user_id', $this->user->id)->get();

        //feature
        // $feature = NfaFeature::selectRaw('
        //             COUNT(*) as totalForms,
        //             SUM(step = 13) as paidForms
        //         ')->first();
        // $totalFeature       =   $feature->totalForms;
        // $paidFeature        =   $feature->paidForms;

        // non-feature
        // $nonFeature = NfaNonFeature::selectRaw('
        //             COUNT(*) as totalForms,
        //             SUM(step = 10) as paidForms
        //         ')->first();
        // $totalNonFeature       =   $nonFeature->totalForms;
        // $paidNonFeature        =   $nonFeature->paidForms;

        // return view('welcome', [
        //     //feature
        //     'totalFeature'   =>  $totalFeature,
        //     'paidFeature'    =>  $paidFeature,
        //     //non-feature
        //     'totalNonFeature'   =>  $totalNonFeature,
        //     'paidNonFeature'    =>  $paidNonFeature,
        // ]);

        return view('welcome', ['totalEntries' => $totalEntries, 'scoreByJury' => $scoreByJury]);
    }
}
