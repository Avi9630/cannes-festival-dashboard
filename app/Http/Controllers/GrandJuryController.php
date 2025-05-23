<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use App\Models\FestivalEntry;
use App\Models\Level2Assign;
use Illuminate\Http\Request;
use App\Models\JuryAssign;
use App\Models\User;

class GrandJuryController extends Controller
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
        // if ($roleName['name'] === 'JURY') {
        //     $juryAssignIds = JuryAssign::where('user_id', $this->user->id)->pluck('festival_entry_id')->toArray();
        //     $entries = FestivalEntry::whereIn('id', $juryAssignIds)->where('stage', 1)->orderBy('id', 'DESC')->paginate(10);
        //     $count = $entries->count();
        // } else {
        // $entries = FestivalEntry::whereNotNull('stage')->whereIn('stage', [3])->orderBy('id', 'DESC')->get();
        // $count = $entries->count();
        // }
        $entries = FestivalEntry::whereNotNull('stage')
            ->whereIn('stage', [3])
            ->orderBy('id', 'DESC')
            ->get();
        $count = $entries->count();

        return view('grand-jury.index', [
            'entries' => $entries,
            'count' => $count,
        ]);
    }

    public function scoredEntry()
    {
        $roleName = Role::select('name')->where('id', $this->user->role_id)->first();
        if (!$roleName) {
            return redirect()->back()->with('warning', 'Role not valid.!!');
        }
        if ($roleName['name'] != 'SUPERADMIN' && $roleName['name'] != 'ADMIN') {
            return redirect()->route('cannes-entries-list')->with('warning', 'Role not valid.!!');
        }
        $festivalEntries = FestivalEntry::whereNotNull('stage')
            ->whereIn('stage', [2])
            ->orderBy('id', 'DESC')
            ->get();
        $count = $festivalEntries->count();
        return view('grand-jury.index', [
            'entries' => $festivalEntries,
            'count' => $count,
        ]);
    }

    public function view($id)
    {
        $festival = FestivalEntry::find($id);
        if ($this->roleName['name'] === 'SUPERADMIN' || $this->roleName['name'] === 'ADMIN') {
            $juryAssign = JuryAssign::where('festival_entry_id', $id)->whereNotNull('overall_score')->get();
            return view('grand-jury.show', [
                'festival' => $festival,
                'juryScores' => $juryAssign,
            ]);
        } else {
            return view('grand-jury.show', [
                'festival' => $festival,
            ]);
        }
    }

    // public function selectedBy($id)
    // {
    //     $festivalEntry = FestivalEntry::where(['id' => $id])->first();
    //     $festivalEntry->update(['stage' => FestivalEntry::Stages()['SELECTED_BY_GRAND_JURY']]);
    //     return redirect()->route('cannes-selected-list')->with('success', 'Success');
    // }

    public function finalSelect($id)
    {
        $festivalEntry = FestivalEntry::where(['id' => $id])->first();
        $festivalEntry->update(['stage' => FestivalEntry::Stages()['FINAL_SELECT_FOR_LEVEL2']]);
        return redirect()->route('scored-entries')->with('success', 'Selection done.!!');
    }

    public function level2List()
    {
        $roleName = Role::select('name')->where('id', $this->user->role_id)->first();
        if (!$roleName) {
            return redirect()->back()->with('warning', 'Role not valid.!!');
        }
        // $juryAssignIds = Level2Assign::where('user_id', $this->user->id)->pluck('festival_entry_id')->toArray();
        $juryAssignIds  =   Level2Assign::where('user_id', $this->user->id)->where('level', '!=', 2)->pluck('festival_entry_id')->toArray();
        $entries        =   FestivalEntry::whereIn('id', $juryAssignIds)->where('stage', '!=', 5)->orderBy('id', 'DESC')->get();
        $count = $entries->count();

        // if ($roleName['name'] === 'JURY') {
        //     $juryAssignIds  =   Level2Assign::where('user_id', $this->user->id)->pluck('festival_entry_id')->toArray();
        //     $entries        =   FestivalEntry::whereIn('id', $juryAssignIds)->where('stage', '!=', 5)->orderBy('id', 'DESC')->get();
        //     $count          =   $entries->count();
        // } else {
        //     $entries = FestivalEntry::whereNotNull('stage')
        //         // ->whereIn('stage', [4])
        //         ->orderBy('id', 'DESC')
        //         ->get();
        //     $count = $entries->count();
        // }

        return view('level2.index', [
            'entries' => $entries,
            'count' => $count,
        ]);
    }

    public function level2score($id)
    {
        $festival = FestivalEntry::find($id);
        return view('level2.score', [
            'festival' => $festival,
        ]);
    }

    public function level2feedback(Request $request, $id)
    {
        $payload = $request->all();
        $request->validate([
            'overall_score' => 'required|numeric|min:1|max:10',
            'feedback' => 'required',
        ]);

        $level2Assign = Level2Assign::where(['user_id' => $this->user->id, 'festival_entry_id' => $id])->first();

        if ($level2Assign) {
            $roleName = Role::select('name')->where('id', $this->user->role_id)->first();
            if (!$roleName) {
                return redirect()->back()->with('warning', 'Role not valid.!');
            }
            $arrayToUpdate = [
                'overall_score' => $payload['overall_score'],
                'total_score' => $payload['overall_score'],
                'feedback' => $payload['feedback'],
                'level' => 2,
            ];
            $store = $level2Assign->update($arrayToUpdate);
            if ($store) {
                // FestivalEntry::where('id', $id)->update(['stage' => FestivalEntry::Stages()['FEEDBACK_GIVEN_ON_LEVEL2']]);
                return redirect()->route('cannes-level2-list')->with('success', 'You have successfully submited your scores and feedback.!!');
            } else {
                return redirect()->back()->with('warning', 'Review not updated.!');
            }
        } else {
            return redirect()->back()->with('warning', 'Something went wrong.!!');
        }
    }

    public function level2view($id)
    {
        $festival = FestivalEntry::find($id);
        if ($this->roleName['name'] === 'SUPERADMIN' || $this->roleName['name'] === 'ADMIN') {
            $level2Assign = Level2Assign::where('festival_entry_id', $id)->whereNotNull('overall_score')->get();
            return view('level2.show', [
                'festival' => $festival,
                'juryScores' => $level2Assign,
            ]);
        } else {
            return view('level2.show', [
                'festival' => $festival,
            ]);
        }
    }

    public function assignTo(Request $request, $id)
    {
        $request->validate(['user_id' => 'required|numeric']);
        $userId = $request->input('user_id');

        if (JuryAssign::where(['festival_entry_id' => $id, 'user_id' => $userId])->exists()) {
            return back()->with('warning', 'Please select a different Jury.');
        }
        $assignTo = [
            'user_id' => $userId,
            'festival_entry_id' => $id,
            'assigned_by' => Auth::id(),
        ];
        $roleName = Role::where('id', User::find($userId)->role_id)->value('name');

        if ($roleName === 'JURY') {
            if (Level2Assign::where(['festival_entry_id' => $id, 'user_id' => $userId])->exists()) {
                return back()->with('warning', 'Details already assigned.');
            }
            if (Level2Assign::insert($assignTo)) {
                return back()->with('success', 'Details successfully assigned.');
            }
        }
        return back()->with('warning', 'Something went wrong.');
    }
}
