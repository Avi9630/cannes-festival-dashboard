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
        $entries =  FestivalEntry::where('disclaimer', 1)->selectRaw('COUNT(*) as totalForms')->first();
        $totalEntries = $entries->totalForms;
        $scoreByJury    =   JuryAssign::where('user_id', $this->user->id)->get();
        return view('welcome', ['totalEntries' => $totalEntries, 'scoreByJury' => $scoreByJury]);
    }
}
