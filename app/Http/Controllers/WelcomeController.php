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
        //SUPERADMIN
        $totals = FestivalEntry::selectRaw("
            COUNT(*) as totalForms,
            SUM(CASE WHEN stage = 1 THEN 1 ELSE 0 END) as totalAssignedToJury,
            SUM(CASE WHEN stage = 2 THEN 1 ELSE 0 END) as totalScoreByJury,
            SUM(CASE WHEN stage = 3 THEN 1 ELSE 0 END) as totalSelectByGrandJury")
            ->where('disclaimer', 1)
            ->where('status', 1)
            ->first();

        $totalEntries           = $totals->totalForms;
        $totalAssignedToJury    = $totals->totalAssignedToJury;
        $totalScoreByJury       = $totals->totalScoreByJury;
        $totalSelectByGrandJury = $totals->totalSelectByGrandJury;

        // $festivalEntries        =   FestivalEntry::where('disclaimer', 1)->get();
        //GRAPH
        // $assignedToJury     =   $festivalEntries->where('stage', 1)->count();
        // $scoredByJury       =   $festivalEntries->where('stage', 2)->count();

        //JURY
        $assign             =   JuryAssign::where(['user_id' => $this->user->id])->pluck('festival_entry_id');
        $totalPendingByYou  =   FestivalEntry::whereIn('id', $assign)->where('stage', 1)->get();
        $totalScoredByYou   =   FestivalEntry::whereIn('id', $assign)->where('stage', 2)->get();

        return view(
            'welcome',
            [
                "totalEntries"              =>  $totalEntries,
                "totalAssignedToJury"       =>  $totalAssignedToJury,
                "totalScoreByJury"          =>  $totalScoreByJury,
                "totalSelectByGrandJury"    =>  $totalSelectByGrandJury,
                // JURY
                "totalAssign"               =>  count($assign),
                "pendingByYou"              =>  count($totalPendingByYou),
                "scoreByYou"                =>  count($totalScoredByYou),
            ]
        );
    }
}
