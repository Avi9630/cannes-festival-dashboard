<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
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
            $count      =   FestivalEntry::whereNotIn('id', $juryAssign)->count();
        } else {
            $entries        =   FestivalEntry::paginate(10);
            $count          =   FestivalEntry::count();
        }
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

    public function search(Request $request)
    {
        $payload = $request->all();

        $query = FestivalEntry::query();

        $query->when($payload, function (Builder $builder) use ($payload) {

            if (!empty($payload['from_date']) && !empty($payload['to_date'])) {
                $builder->whereDate('created_at', '>=', $payload['from_date']);
                $builder->whereDate('created_at', '<=', $payload['to_date']);
            } elseif (empty($payload['from_date']) && !empty($payload['to_date'])) {
                $todayDate = date('Y-m-d');
                $builder->whereDate('created_at', '>=', $todayDate);
                $builder->whereDate('created_at', '<=', $payload['to_date']);
            } elseif (!empty($payload['from_date']) && empty($payload['to_date'])) {
                $todayDate = date('Y-m-d');
                $builder->whereDate('created_at', '>=', $payload['from_date']);
                $builder->whereDate('created_at', '<=', $todayDate);
            }

            // if (!empty($payload['payment_status'])) {
            //     if ($payload['payment_status'] === '13') {
            //         $builder->where('step', $payload['payment_status']);
            //     } elseif ($payload['payment_status'] === '1') {
            //         if (!empty($payload['step'])) {
            //             $builder->where('step', $payload['step']);
            //         } else {
            //             $builder->whereIn('step', range(1, 12));
            //         }
            //     }
            // } else {
            //     $builder->where('step', 13);
            // }
        });

        // $filteredData = $query->get();
        // session()->put('festival', $filteredData);
        $entries    =   $query->paginate(10);
        $count      =   $query->count();

        return view('festival-entry.index', [
            'entries'   =>  $entries,
            'count'     =>  $count,
        ]);
    }
}
