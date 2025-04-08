<?php

namespace App\Http\Controllers;

use App\Exports\BestFilmCriticExportAll;
use App\Exports\ExportBestFilmCriticSearch;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\BestBookCinema;
use App\Models\BestFilmCritic;

class BestFilmCriticController extends Controller
{
    public function index()
    {
        // $nfaFeatures    =   NfaFeature::where('step', 13)->paginate(10);
        $bestFilmCritics    =   BestFilmCritic::paginate(10);
        $count              =   BestFilmCritic::count();
        $paids              =   [5 => 'Paid', 1 => 'Unpaid'];
        $steps              =   array_flip(BestFilmCritic::stepsBestFilmCritic());

        session()->put('bestFilmCritic', $bestFilmCritics);

        return view('best-film-critic.index', [
            'bestFilmCritics'   =>  $bestFilmCritics,
            'paids'             =>  $paids,
            'count'             =>  $count,
            'steps'             =>  $steps,
        ]);
    }

    public function bestFilmCriticSearch(Request $request)
    {
        $payload = $request->all();
        $query = BestFilmCritic::query();

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

            if (!empty($payload['payment_status'])) {
                if ($payload['payment_status'] === '5') {
                    $builder->where('step', $payload['payment_status']);
                } elseif ($payload['payment_status'] === '1') {
                    if (!empty($payload['step'])) {
                        $builder->where('step', $payload['step']);
                    } else {
                        $builder->whereIn('step', range(1, 4));
                    }
                }
            } else {
                $builder->where('step', 5);
            }
        });

        $filteredData = $query->get();
        session()->put('bestFilmCritic', $filteredData);
        $count              =   $query->count();
        $bestFilmCritics    =   $query->paginate(10);
        $steps              =   array_flip(BestFilmCritic::stepsBestFilmCritic());

        $paids = [
            5 => 'Paid',
            1 => 'Unpaid',
        ];

        return view('best-film-critic.index', [
            'bestFilmCritics'   =>  $bestFilmCritics,
            'payload'           =>  $payload,
            'paids'             =>  $paids,
            'count'             =>  $count,
            'steps'             =>  $steps
        ]);
    }

    public function bestFilmCriticExport()
    {
        if (session()->has('bestFilmCritic')) {
            $nfaFeatures = session()->get('bestFilmCritic');
            $fileName = 'best-film-critic.xls';
            return Excel::download(new ExportBestFilmCriticSearch($nfaFeatures), $fileName);
        } else {
            return view('sessions.view')->with('danger', 'Session not set yet.!!');
        }
    }

    public function bestFilmCriticExportAll()
    {
        // $nfaFeatures = NfaFeature::select('*')->where('step', 9)->get();
        $bestBookCinemas = BestFilmCritic::select('*')->get();
        $fileName = 'best-film-critic.xls';
        return Excel::download(new BestFilmCriticExportAll($bestBookCinemas), $fileName);
    }
}
