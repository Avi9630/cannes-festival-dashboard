<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\FestivalEntry;
use App\Models\JuryAssign;

class WelcomeController extends Controller
{
    public function __construct()
    {
        $this->user = Auth::user();
    }

    public function index()
    {
        $entries            =   FestivalEntry::where('disclaimer', 1)->selectRaw('COUNT(*) as totalForms')->first();
        $totalEntries       =   $entries->totalForms;
        $festivalEntries    =   FestivalEntry::where('disclaimer', 1)->get();
        $scored             =   $festivalEntries->where('stage', 2)->count();
        $assigned           =   $festivalEntries->where('stage', 1)->count();
        $scoreByJury        =   JuryAssign::where('user_id', $this->user->id)->get();

        $festivalEntries = FestivalEntry::where('disclaimer', 1)
            ->whereIn('stage', [1, 2]) // Only Assigned or Scored
            ->get(['id', 'film_title', 'stage']); // Adjust field names accordingly

        return view(
            'welcome',
            [
                'totalEntries'  =>  $totalEntries,
                'scoreByJury'   =>  $scoreByJury,
                'scored'        => $scored,
                'assigned'      => $assigned,
                'festivalEntries'      => $festivalEntries,
            ]
        );
    }
}
