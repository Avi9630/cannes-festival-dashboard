<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use App\Exports\BestBookCinemaExportAll;
use App\Exports\ExportBestBookSearch;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\BestBookCinema;
use Illuminate\Http\Request;

class BestBookCinemaController extends Controller
{
    public function index()
    {
        // $nfaFeatures    =   NfaFeature::where('step', 13)->paginate(10);
        $bestBookCinemas    =   BestBookCinema::paginate(10);
        $count              =   BestBookCinema::count();
        $paids              =   [5 => 'Paid', 1 => 'Unpaid'];
        $steps              =   array_flip(BestBookCinema::stepsBestBook());

        session()->put('bestBookCinema', $bestBookCinemas);

        return view('best-book-cinema.index', [
            'bestBookCinemas'   =>  $bestBookCinemas,
            'paids'             =>  $paids,
            'count'             =>  $count,
            'steps'             =>  $steps,
        ]);
    }

    public function bestBookSearch(Request $request)
    {
        $payload = $request->all();
        $query = BestBookCinema::query();

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
        session()->put('bestBookCinema', $filteredData);
        $count              =   $query->count();
        $bestBookCinemas    =   $query->paginate(10);
        $steps              =   array_flip(BestBookCinema::stepsBestBook());

        $paids = [
            5 => 'Paid',
            1 => 'Unpaid',
        ];

        return view('best-book-cinema.index', [
            'bestBookCinemas'   =>  $bestBookCinemas,
            'payload'   =>  $payload,
            'paids'             =>  $paids,
            'count'             =>  $count,
            'steps'             =>  $steps
        ]);
    }

    public function bestBookExport()
    {
        if (session()->has('bestBookCinema')) {
            $nfaFeatures = session()->get('bestBookCinema');
            $fileName = 'best-book-cinema.xls';
            return Excel::download(new ExportBestBookSearch($nfaFeatures), $fileName);
        } else {
            return view('sessions.view')->with('danger', 'Session not set yet.!!');
        }
    }

    public function bestBookExportAll()
    {
        // $nfaFeatures = NfaFeature::select('*')->where('step', 9)->get();
        $bestBookCinemas = BestBookCinema::select('*')->get();
        $fileName = 'best-book-cinema.xls';
        return Excel::download(new BestBookCinemaExportAll($bestBookCinemas), $fileName);
    }
}
