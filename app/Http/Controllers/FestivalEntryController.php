<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use App\Models\FestivalEntry;
use Illuminate\Http\Request;
use App\Models\JuryAssign;
use App\Models\User;

class FestivalEntryController extends Controller
{

    public function __construct()
    {
        $this->user = Auth::user();
        $this->roleName = Role::select('name')->where('id', $this->user->role_id)->first();
    }

    public function index()
    {

        $roleName = Role::select('name')->where('id', $this->user->role_id)->first();
        if (!$roleName) {
            return redirect()->back()->with('warning', 'Role not valid.!!');
        }
        //CASE :- JURY
        if ($roleName['name'] === 'JURY') {
            $juryAssign =   JuryAssign::where(['user_id' => $this->user->id])->pluck('festival_entry_id');
            $entries    =   FestivalEntry::whereNotIn('id', $juryAssign)->paginate(10);
        } else {
            $entries        =   FestivalEntry::paginate(10);
        }
        $count          =   FestivalEntry::count();
        // session()->put('nfaFeatures', $nfaFeatures);
        return view('festival-entry.index', [
            'entries' => $entries,
            'count' => $count,
        ]);
    }

    public function view($id)
    {
        $festival = FestivalEntry::find($id);
        if ($this->roleName['name'] === 'SUPERADMIN') {
            // $juryList   =   User::where('role_id', 3)->pluck('id');
            $juryAssign =   JuryAssign::where('festival_entry_id', $id)->get();
            return view('festival-entry.show', [
                'festival'      =>  $festival,
                'juryScores'    =>  $juryAssign,
            ]);
        } else {
            return view('festival-entry.show', [
                'festival' => $festival,
            ]);
        }
    }

    public function score($id)
    {
        $festival = FestivalEntry::find($id);
        return view('festival-entry.score', [
            'festival' => $festival,
        ]);
    }

    public function feedback(Request $request, $id)
    {
        $payload = $request->all();
        $request->validate([
            'overall_score' =>  'required|numeric|min:1|max:10',
            'feedback'      =>  'required',
        ]);

        $juryAssign = JuryAssign::where(['user_id' => $this->user->id, 'festival_entry_id' => $id])->first();

        if (empty($juryAssign)) {

            $roleName = Role::select('name')->where('id', $this->user->role_id)->first();
            if (!$roleName) {
                return redirect()->back()->with('warning', 'Role not valid.!');
            }
            $arrayToUpdate = [
                'user_id'           =>  $this->user->id,
                'festival_entry_id' =>  $id,
                'overall_score'     =>  $payload['overall_score'],
                'feedback'          =>  $payload['feedback'],
                'total_score'       =>  $payload['overall_score'],
                'active'            =>  0,
            ];
            $store = JuryAssign::create($arrayToUpdate);
            if ($store) {
                return redirect()->route('cannes-entries-list')->with('success', 'You have successfully submited your scores and feedback.!!');
                // return redirect()->back()->with('success', 'You have successfully submited your scores and feedback.!!');
            } else {
                return redirect()->back()->with('warning', 'Review not updated.!');
            }
        } else {
            return redirect()->back()->with('warning', 'You have already given your score.!!'); //->with('Something went wrong.!');
        }
    }
}
