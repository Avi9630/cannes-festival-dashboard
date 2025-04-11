<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use App\Exports\ExportFestivalEntries;
use App\Models\Assign;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
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
        if ($roleName['name'] === 'JURY') {

            $juryAssignIds = JuryAssign::where('user_id', $this->user->id)
                ->pluck('festival_entry_id')
                ->toArray();

            $entries = FestivalEntry::whereIn('id', $juryAssignIds)
                ->where('stage', 1)
                ->orderBy('id', 'DESC')
                ->paginate(10);
            // $juryAssign =   JuryAssign::where(['user_id' => $this->user->id])->pluck('festival_entry_id');
            // $entries    =   FestivalEntry::whereNotIn('id', $juryAssign)->orderBy('id', 'DESC')->paginate(10);
            // $count      =   FestivalEntry::where('disclaimer', 1)->whereNotIn('id', $juryAssignIds)->count();
            $count      =   $entries->count();
        } else {
            $entries            =   FestivalEntry::where('disclaimer', 1)->orderBy('id', 'DESC')->paginate(10);
            $count              =   FestivalEntry::where('disclaimer', 1)->count();
            $festivalEntries    =   FestivalEntry::where('disclaimer', 1)->orderBy('id', 'DESC')->get();
            session()->put('cannes-festival', $festivalEntries);
        }
        return view('festival-entry.index', [
            'entries' => $entries,
            'count' => $count,
        ]);
    }

    public function view($id)
    {
        $festival = FestivalEntry::find($id);
        if ($this->roleName['name'] === 'SUPERADMIN') {
<<<<<<< HEAD
            $juryAssign =   JuryAssign::where(['festival_entry_id' => $id])->get();
=======
            $juryAssign = JuryAssign::where('festival_entry_id', $id)
                ->whereNotNull('overall_score')
                ->get();
            // $juryAssign =   JuryAssign::where(['festival_entry_id' => $id])->where('overall_score', '!=', NULL)->get();
>>>>>>> f816687ded138c6fa74ba0c56ddd07d225747a14
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

        if ($juryAssign) {
            $roleName = Role::select('name')->where('id', $this->user->role_id)->first();
            if (!$roleName) {
                return redirect()->back()->with('warning', 'Role not valid.!');
            }
            $arrayToUpdate = [
                'overall_score'     =>  $payload['overall_score'],
                'total_score'       =>  $payload['overall_score'],
                'feedback'          =>  $payload['feedback'],
            ];
            $store = $juryAssign->update($arrayToUpdate);
            if ($store) {
                FestivalEntry::where('id', $id)->update(['stage' => FestivalEntry::Stages()['FEEDBACK_GIVEN_BY_JURY']]);
                return redirect()->route('cannes-entries-list')->with('success', 'You have successfully submited your scores and feedback.!!');
            } else {
                return redirect()->back()->with('warning', 'Review not updated.!');
            }
        } else {
            return redirect()->back()->with('warning', 'Something went wrong.!!');
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

            if (!empty($payload['year'])) {
                if ($payload['year'] === '1') {
                    $builder->where('disclaimer', 1);
                } elseif ($payload['year'] === '2') {
                    $builder->where('disclaimer', NULL);
                }
            } else {
                $builder->where('disclaimer', 1);
            }
        });

        $filteredData = $query->get();
        session()->put('cannes-festival', $filteredData);

        $entries    =   $query->orderBy('id', 'DESC')->paginate(10);
        $count      =   $query->count();

        return view('festival-entry.index', [
            'entries'   =>  $entries,
            'count'     =>  $count,
            'payload'   =>  $payload
        ]);
    }

    public function assignTo(Request $request, $id)
    {
        $payload = $request->all();
        $request->validate([
            'user_id' => 'required|numeric',
        ]);
        $assignTo = [
            'user_id'           =>  $payload['user_id'],
            'festival_entry_id' =>  $id,
            'assigned_by'       =>  Auth::user()->id,
        ];

        $user       =   User::find($payload['user_id']);
        $roleName   =   Role::select('name')
            ->where('id', $user['role_id'])
            ->first();

        if (in_array($roleName['name'], ['JURY'])) {

            $checkRecords = JuryAssign::where([
                // 'user_id' => $payload['user_id'],
                'festival_entry_id' => $id,
            ])->first();

            if (!empty($checkRecords)) {
                return redirect()->back()->with('warning', 'Details already assigned.!');
            }
            $x = JuryAssign::insert($assignTo);
            if ($x) {
                if ($roleName['name'] === 'JURY') {
                    FestivalEntry::where('id', $assignTo['festival_entry_id'])->update(['stage' => FestivalEntry::Stages()['ASSIGNED_TO_JURY']]);
                }
                return redirect()->back()->with('success', 'Details successfully assigned.!');
            } else {
                return redirect()->back()->with('warning', 'Something went wrong.!');
            }
        }
        return redirect()->back()->with('warning', 'Something went wrong.!');
    }

    public function exportAll()
    {
        // $festivalEntries = FestivalEntry::select('*')->limit(1)->get();
        $festivalEntries = FestivalEntry::select('*')->get();
        $fileName = 'festival_entries.xls';
        return Excel::download(new ExportFestivalEntries($festivalEntries), $fileName);
    }

    public function exportSearch()
    {
        if (session()->has('cannes-festival')) {
            $festivalEntries = session()->get('cannes-festival');
            $fileName = 'cannes-featival.xls';
            // return Excel::download(new ExportBySearch($cannesFestival), $fileName);
            return Excel::download(new ExportFestivalEntries($festivalEntries), $fileName);
        } else {
            return view('festival-entry.index')->with('danger', 'Session not set yet.!!');
        }
    }

    // public function cannesPdf(Request $request, $id)
    // {
    //     $nfaFeatures = NfaFeature::with('documents')
    //         ->where(['id' => $id])
    //         ->first();

    //     $documents = Document::where('context_id', $id)
    //         ->where('form_type', 1)
    //         ->get();

    //     $producers      =   Producer::with('featureDocuments')->where(['nfa_feature_id' => $id])->get();
    //     $directors      =   Director::with('featureDocuments')->where(['nfa_feature_id' => $id])->get();
    //     $actors         =   Actor::where('nfa_feature_id', $id)->get();
    //     $songs          =   Song::where('nfa_feature_id', $id)->get();
    //     $audiographers  =   Audiographer::where('nfa_feature_id', $id)->get();
    //     $tempDir        =   sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'mpdf';

    //     if (!file_exists($tempDir)) {
    //         mkdir($tempDir, 0777, true);
    //     }
    //     // Add Hindi font configuration
    //     $defaultConfig      =   (new ConfigVariables())->getDefaults();
    //     $fontDirs           =   $defaultConfig['fontDir'];
    //     $defaultFontConfig  =   (new FontVariables())->getDefaults();
    //     $fontData           =   $defaultFontConfig['fontdata'];
    //     $mpdf = new Mpdf([
    //         'tempDir' => $tempDir,
    //         'fontDir' => array_merge($fontDirs, [
    //             base_path('storage/fonts/static'),
    //         ]),
    //         'fontdata' => $fontData + [
    //             'hindi' => [
    //                 'R' => 'NotoSansDevanagari-Regular.ttf',
    //                 'B' => 'NotoSansDevanagari-Bold.ttf',
    //             ],
    //         ],
    //         'default_font' => 'hindi',
    //     ]);
    //     $data = [];
    //     $html = view('nfa-feature.pdf', [
    //         'title'             =>  'NFA Feature Film',
    //         'date'              =>  date('M-d-y H:i:s'),
    //         'nfaFeatures'       =>  $nfaFeatures,
    //         'documents'         =>  $documents,
    //         'producers'        =>  $producers,
    //         'directors'        =>  $directors,
    //         'actors'           =>  $actors,
    //         'songs'            =>  $songs,
    //         'audiographers'    =>  $audiographers,
    //     ]);
    //     $mpdf->WriteHTML($html);
    //     $pdfFilePath = $nfaFeatures->film_title_devnagri . '.pdf';
    //     $mpdf->Output($pdfFilePath, 'I'); // 'D' for download, 'I' for inline view
    // }
}
