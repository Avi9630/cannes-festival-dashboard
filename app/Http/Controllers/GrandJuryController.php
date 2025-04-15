<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use App\Models\FestivalEntry;
use App\Models\JuryAssign;

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
        $entries = FestivalEntry::whereNotNull('stage')
            ->whereIn('stage', [2, 3])
            ->orderBy('id', 'DESC')
            ->paginate(10);
        $count      =   $entries->count();
        return view('grand-jury.index', [
            'entries' => $entries,
            'count' => $count,
        ]);
    }

    public function view($id)
    {
        $festival = FestivalEntry::find($id);
        if ($this->roleName['name'] === 'SUPERADMIN' || $this->roleName['name'] === 'ADMIN' || $this->roleName['name'] === 'GRANDJURY') {
            $juryAssign = JuryAssign::where('festival_entry_id', $id)
                ->whereNotNull('overall_score')
                ->get();
            return view('grand-jury.show', [
                'festival'      =>  $festival,
                'juryScores'    =>  $juryAssign,
            ]);
        } else {
            return view('grand-jury.show', [
                'festival' => $festival,
            ]);
        }
    }

    public function selectedBy($id)
    {
        $festivalEntry = FestivalEntry::where(['id' => $id])->first();
        $festivalEntry->update(['stage' => FestivalEntry::Stages()['SELECTED_BY_GRAND_JURY']]);
        return redirect()->route('cannes-selected-list')->with('success', 'Success');
    }
}
