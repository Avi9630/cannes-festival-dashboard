<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use App\Exports\ExportNonFeatureBySearch;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportAllNonFeature;
use Illuminate\Support\Facades\File;
use App\Exports\ExportAllFeature;
use Mpdf\Config\ConfigVariables;
use App\Exports\ExportBySearch;
use Mpdf\Config\FontVariables;
use App\Models\NfaNonFeature;
use App\Models\Audiographer;
use Illuminate\Http\Request;
use App\Models\NfaFeature;
use App\Models\Producer;
use App\Models\Document;
use App\Models\Director;
use App\Models\Actor;
use App\Models\Song;
use ZipArchive;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NfaController extends Controller
{
    //************************** FOR FEATURE *****************************//

    public function nfaFeature()
    {
        // $nfaFeatures    =   NfaFeature::where('step', 13)->paginate(10);
        $nfaFeatures    =   NfaFeature::paginate(10);
        $count          =   NfaFeature::count();
        $paids          =   [13 => 'Paid', 1 => 'Unpaid'];
        $steps          =   array_flip(NfaFeature::stepsFeature());

        session()->put('nfaFeatures', $nfaFeatures);

        return view('nfa-feature.index', [
            'features' => $nfaFeatures,
            'paids' => $paids,
            'count' => $count,
            'steps' => $steps,
        ]);
    }

    public function featureSearch(Request $request)
    {
        $payload = $request->all();
        $query = NfaFeature::query();

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
                if ($payload['payment_status'] === '13') {
                    $builder->where('step', $payload['payment_status']);
                } elseif ($payload['payment_status'] === '1') {
                    if (!empty($payload['step'])) {
                        $builder->where('step', $payload['step']);
                    } else {
                        $builder->whereIn('step', range(1, 12));
                    }
                }
            } else {
                $builder->where('step', 13);
            }
        });

        $filteredData = $query->get();
        session()->put('nfaFeatures', $filteredData);
        $count          =   $query->count();
        $nfaFeatures    =   $query->paginate(10);
        $steps          =   array_flip(NfaFeature::stepsFeature());

        $paids = [
            13 => 'Paid',
            1 => 'Unpaid',
        ];

        return view('nfa-feature.index', [
            'features'  =>  $nfaFeatures,
            'payload'   =>  $payload,
            'paids'     =>  $paids,
            'count'     =>  $count,
            'steps'     =>  $steps,
        ]);
    }

    public function featureExportAll()
    {
        // $nfaFeatures = NfaFeature::select('*')->where('step', 9)->get();
        $nfaFeatures = NfaFeature::select('*')->get();
        $fileName = 'nfa-feature.xls';
        return Excel::download(new ExportAllFeature($nfaFeatures), $fileName);
    }

    public function featureExportSearch()
    {
        if (session()->has('nfaFeatures')) {
            $nfaFeatures = session()->get('nfaFeatures');
            $fileName = 'nfa-feature.xls';
            return Excel::download(new ExportBySearch($nfaFeatures), $fileName);
        } else {
            return view('sessions.view')->with('danger', 'Session not set yet.!!');
        }
    }

    public function featurePdf(Request $request, $id)
    {
        $nfaFeatures = NfaFeature::with('documents')
            ->where(['id' => $id])
            ->first();

        $documents = Document::where('context_id', $id)
            ->where('form_type', 1)
            ->get();

        $producers      =   Producer::with('featureDocuments')->where(['nfa_feature_id' => $id])->get();
        $directors      =   Director::with('featureDocuments')->where(['nfa_feature_id' => $id])->get();
        $actors         =   Actor::where('nfa_feature_id', $id)->get();
        $songs          =   Song::where('nfa_feature_id', $id)->get();
        $audiographers  =   Audiographer::where('nfa_feature_id', $id)->get();
        $tempDir        =   sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'mpdf';

        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0777, true);
        }
        // Add Hindi font configuration
        $defaultConfig      =   (new ConfigVariables())->getDefaults();
        $fontDirs           =   $defaultConfig['fontDir'];
        $defaultFontConfig  =   (new FontVariables())->getDefaults();
        $fontData           =   $defaultFontConfig['fontdata'];
        $mpdf = new Mpdf([
            'tempDir' => $tempDir,
            'fontDir' => array_merge($fontDirs, [
                base_path('storage/fonts/static'),
            ]),
            'fontdata' => $fontData + [
                'hindi' => [
                    'R' => 'NotoSansDevanagari-Regular.ttf',
                    'B' => 'NotoSansDevanagari-Bold.ttf',
                ],
            ],
            'default_font' => 'hindi',
        ]);
        $data = [];
        $html = view('nfa-feature.pdf', [
            'title'             =>  'NFA Feature Film',
            'date'              =>  date('M-d-y H:i:s'),
            'nfaFeatures'       =>  $nfaFeatures,
            'documents'         =>  $documents,
            'producers'        =>  $producers,
            'directors'        =>  $directors,
            'actors'           =>  $actors,
            'songs'            =>  $songs,
            'audiographers'    =>  $audiographers,
        ]);
        $mpdf->WriteHTML($html);
        $pdfFilePath = $nfaFeatures->film_title_devnagri . '.pdf';
        $mpdf->Output($pdfFilePath, 'I'); // 'D' for download, 'I' for inline view
    }

    public function nfaFeatureDocsAsZip(Request $request, $id)
    {
        $nfaFeature = NfaFeature::with('documents')->where('id', $id)->first();

        if (!$nfaFeature) {
            return response()->json(['error' => 'Feature not found'], 404);
        }

        $zip = new ZipArchive();

        $storagePath = storage_path('app/NFA/');

        if (!File::exists($storagePath)) {
            File::makeDirectory($storagePath, 0755, true, true);
        }

        $zipFileName    =   Str::slug($nfaFeature->film_title_devnagri, '_') . '.zip';
        $zipFilePath    =   $storagePath . $zipFileName;

        if ($zip->open($zipFilePath, ZipArchive::CREATE) === true) {

            $count      =   0;
            $folder     =   Str::slug($nfaFeature->film_title_devnagri, '_') . '/';
            $hasFiles   =   false;

            foreach ($nfaFeature->documents as $document) {
                $documentPath   =   env('STORAGE_URL', '/var/www/html/NFA/storage/app/NFA/' . $document->file);
                $newFileName = ++$count . '. ' . $document->name;
                if (file_exists($documentPath)) {
                    $zip->addFile($documentPath, $folder . $newFileName);
                    $hasFiles = true;
                }
            }

            //PRODUCER
            $producers  =   Producer::with('featureDocuments')
                ->where('nfa_feature_id', $nfaFeature->id)
                ->get();
            foreach ($producers as $producer) {
                foreach ($producer->featureDocuments as $document) {
                    $documentPath   =   env('STORAGE_URL', '/var/www/html/NFA/storage/app/NFA/' . $document->file);
                    $newFileName = ++$count . '. ' . $document->name;
                    if (file_exists($documentPath)) {
                        $zip->addFile($documentPath, $folder . $newFileName);
                        $hasFiles = true;
                    }
                }
            }

            //DIRECTORS
            $directors  =   Director::with('featureDocuments')
                ->where('nfa_feature_id', $nfaFeature->id)
                ->get();
            foreach ($directors as $director) {
                foreach ($director->featureDocuments as $document) {
                    $documentPath   =   env('STORAGE_URL', '/var/www/html/NFA/storage/app/NFA/' . $document->file);
                    $newFileName    =   ++$count . '. ' . $document->name;
                    if (file_exists($documentPath)) {
                        $zip->addFile($documentPath, $folder . $newFileName);
                        $hasFiles = true;
                    }
                }
            }
            if (!$hasFiles) {
                $zip->addEmptyDir($folder);
            }
            $zip->close();
        } else {
            return response()->json(['error' => 'Failed to create zip file'], 500);
        }
        return response()->download($zipFilePath)->deleteFileAfterSend(true);
    }

    //************************** FOR NON-FEATURE *****************************//

    public function nfaNonFeature()
    {
        // $nfaFeatures    =   NfaFeature::where('step', 13)->paginate(10);
        $nfaNonFeatures =   NfaNonFeature::paginate(10);
        $count          =   NfaNonFeature::count();
        $paids          =   [13 => 'Paid', 1 => 'Unpaid'];
        $steps          =   array_flip(NfaNonFeature::stepsNonFeature());

        session()->put('nfaNonFeatures', $nfaNonFeatures);

        return view('nfa-non-feature.index', [
            'nonFeatures'   =>  $nfaNonFeatures,
            'paids'         =>  $paids,
            'count'         =>  $count,
            'steps'         =>  $steps,
        ]);
    }

    public function nonFeatureSearch(Request $request)
    {
        $payload = $request->all();
        $query = NfaNonFeature::query();

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
                if ($payload['payment_status'] === '13') {
                    $builder->where('step', $payload['payment_status']);
                } elseif ($payload['payment_status'] === '1') {
                    if (!empty($payload['step'])) {
                        $builder->where('step', $payload['step']);
                    } else {
                        $builder->whereIn('step', range(1, 12));
                    }
                }
            } else {
                $builder->where('step', 13);
            }
        });

        $filteredData = $query->get();
        session()->put('nfaNonFeatures', $filteredData);
        $count          =   $query->count();
        $nfaNonFeatures =   $query->paginate(10);
        $steps          =   array_flip(NfaNonFeature::stepsNonFeature());

        $paids = [
            13 => 'Paid',
            1 => 'Unpaid',
        ];

        return view('nfa-non-feature.index', [
            'nonFeatures'   =>  $nfaNonFeatures,
            'payload'       =>  $payload,
            'paids'         =>  $paids,
            'count'         =>  $count,
            'steps'         =>  $steps,
        ]);
    }

    public function nonFeatureExportAll()
    {
        // $nfaFeatures = NfaFeature::select('*')->where('step', 9)->get();
        $nfaFeatures = NfaNonFeature::select('*')->get();
        $fileName = 'nfa-non-feature.xls';
        return Excel::download(new ExportAllNonFeature($nfaFeatures), $fileName);
    }

    public function nonFeatureExportSearch()
    {
        if (session()->has('nfaNonFeatures')) {
            $nfaFeatures = session()->get('nfaNonFeatures');
            $fileName = 'nfa-non-feature.xls';
            return Excel::download(new ExportNonFeatureBySearch($nfaFeatures), $fileName);
        } else {
            return view('sessions.view')->with('danger', 'Session not set yet.!!');
        }
    }

    public function nonFeaturePdf(Request $request, $id)
    {
        $nfaNonFeature = NfaNonFeature::with('documents')
            ->where(['id' => $id])
            ->first();

        $producers      =   Producer::with('nonFeatureDocuments')->where(['nfa_feature_id' => $id])->get();
        $directors      =   Director::with('nonFeatureDocuments')->where(['nfa_feature_id' => $id])->get();
        $tempDir        =   sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'mpdf';

        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0777, true);
        }
        // Add Hindi font configuration
        $defaultConfig      =   (new ConfigVariables())->getDefaults();
        $fontDirs           =   $defaultConfig['fontDir'];
        $defaultFontConfig  =   (new FontVariables())->getDefaults();
        $fontData           =   $defaultFontConfig['fontdata'];
        $mpdf = new Mpdf([
            'tempDir' => $tempDir,
            'fontDir' => array_merge($fontDirs, [
                base_path('storage/fonts/static'),
            ]),
            'fontdata' => $fontData + [
                'hindi' => [
                    'R' => 'NotoSansDevanagari-Regular.ttf',
                    'B' => 'NotoSansDevanagari-Bold.ttf',
                ],
            ],
            'default_font' => 'hindi',
        ]);
        $data = [];
        $html = view('nfa-non-feature.pdf', [
            'title'             =>  'NFA Non-Feature Film',
            'date'              =>  date('M-d-y H:i:s'),
            'nfaNonFeature'    =>  $nfaNonFeature,
            'producers'         =>  $producers,
            'directors'         =>  $directors,
        ]);
        $mpdf->WriteHTML($html);
        $pdfFilePath = $nfaNonFeature->film_title_devnagri . '.pdf';
        $mpdf->Output($pdfFilePath, 'I'); // 'D' for download, 'I' for inline view
    }

    // public function nfaNonFeatureDocsAsZip(Request $request, $id)
    // {
    //     $nfaNonFeatures =   NfaNonFeature::with('documents')->where('id', $id)->get();
    //     $zip            =   new ZipArchive();
    //     $filePath       =   storage_path('app/NFA/');

    //     File::makeDirectory($filePath, 0755, true, true);

    //     $filePath   =   $filePath . $nfaNonFeatures[0]->english_translation_of_film . '.zip';

    //     if ($zip->open($filePath, ZipArchive::CREATE) === true) {

    //         foreach ($nfaNonFeatures as $feature) {
    //             $count  =   0;
    //             $folder =   $feature->english_translation_of_film . '/';
    //             $hasFiles   =   false;
    //             $storage_url    =   env('STORAGE_URL', '/var/www/html/api/');

    //             foreach ($feature->documents as $document) {

    //                 $documentPath   =   $storage_url . 'storage/app/NFA/' . $document->file;
    //                 $newFileName    =   ++$count . '. ' . $document->name;
    //                 if (file_exists($documentPath)) {
    //                     $zip->addFile($documentPath, $folder . $newFileName);
    //                     $hasFiles = true;
    //                 }
    //             }
    //             if (!$hasFiles) {
    //                 $zip->addEmptyDir($folder);
    //             }

    //             // $IpDirectors = IpDirector::with('documents')
    //             //     ->where('ip_application_form_id', $feature->id)
    //             //     ->get();

    //             // foreach ($IpDirectors as $IpDirector) {
    //             //     foreach ($IpDirector->documents as $document) {
    //             //         $documentPath = $storage_url . 'storage/app/IP/' . $feature->id . '/' . $document->file;
    //             //         $newFileName = ++$count . '. ' . $document->name;
    //             //         if (file_exists($documentPath)) {
    //             //             $zip->addFile($documentPath, $folder . $newFileName);
    //             //             $hasFiles = true;
    //             //         } else {
    //             //             $documentPath = $storage_url . 'storage/app/ip/' . $feature->id . '/' . $document->file;
    //             //             $newFileName = $document->name;
    //             //             if (file_exists($documentPath)) {
    //             //                 $zip->addFile($documentPath, $folder . $newFileName);
    //             //                 $hasFiles = true;
    //             //             }
    //             //         }
    //             //     }
    //             // }

    //             // $IpCoProducers = IpCoProducer::leftJoin('documents as doc1', function ($join) {
    //             //     $join->on('doc1.context_id', '=', 'ip_co_producers.id')->whereIn('doc1.type', [17]);
    //             // })
    //             //     ->leftJoin('documents as doc2', function ($join) {
    //             //         $join->on('doc2.context_id', '=', 'ip_co_producers.id')->whereIn('doc2.type', [18]);
    //             //     })
    //             //     // ->where('documents.type', [17, 18]) ss
    //             //     ->where('ip_application_form_id', $feature->id)
    //             //     ->select('ip_co_producers.*', 'doc1.name as documents_name', 'doc1.file as file', 'doc2.file as file1', 'doc2.name as documents_name1')
    //             //     ->get();

    //             // foreach ($IpCoProducers as $IpCoProducer) {
    //             //     if ($IpCoProducer->documents_name) {
    //             //         $documentPath = $storage_url . 'storage/app/IP/' . $feature->id . '/' . $IpCoProducer->file;

    //             //         $newFileName = ++$count . '. ' . $IpCoProducer->documents_name;
    //             //         if (file_exists($documentPath)) {
    //             //             $zip->addFile($documentPath, $folder . $newFileName);
    //             //             $hasFiles = true;
    //             //         }
    //             //     }
    //             //     if ($IpCoProducer->documents_name1) {
    //             //         $documentPath = $storage_url . 'storage/app/IP/' . $feature->id . '/' . $IpCoProducer->file1;

    //             //         $newFileName = $IpCoProducer->documents_name1;
    //             //         $newFileName = ++$count . '. ' . $IpCoProducer->documents_name1;
    //             //         if (file_exists($documentPath)) {
    //             //             $zip->addFile($documentPath, $folder . $newFileName);
    //             //             $hasFiles = true;
    //             //         }
    //             //     }
    //             // }
    //             // Add directory to zip even if no files found
    //             if (!$hasFiles) {
    //                 $zip->addEmptyDir($folder);
    //             }
    //         }
    //         $zip->close();
    //     } else {
    //         return response()->json(['error' => 'Failed to create zip file'], 500);
    //     }
    //     return response()->download($filePath);
    // }

    public function nfaNonFeatureDocsAsZip(Request $request, $id)
    {
        $nfaNonFeature = NfaNonFeature::with('documents')->where('id', $id)->first();

        if (!$nfaNonFeature) {
            return response()->json(['error' => 'Feature not found'], 404);
        }

        $zip = new ZipArchive();

        $storagePath = storage_path('app/NFA/');

        if (!File::exists($storagePath)) {
            File::makeDirectory($storagePath, 0755, true, true);
        }

        $zipFileName    =   Str::slug($nfaNonFeature->film_title_devnagri, '_') . '.zip';
        $zipFilePath    =   $storagePath . $zipFileName;

        if ($zip->open($zipFilePath, ZipArchive::CREATE) === true) {

            $count      =   0;
            $folder     =   Str::slug($nfaNonFeature->film_title_devnagri, '_') . '/';
            $hasFiles   =   false;

            foreach ($nfaNonFeature->documents as $document) {
                $documentPath   =   env('STORAGE_URL', '/var/www/html/NFA/storage/app/NFA/' . $document->file);
                $newFileName = ++$count . '. ' . $document->name;
                if (file_exists($documentPath)) {
                    $zip->addFile($documentPath, $folder . $newFileName);
                    $hasFiles = true;
                }
            }

            //PRODUCER
            $producers  =   Producer::with('featureDocuments')->where('nfa_non_feature_id', $nfaNonFeature->id)->get();

            foreach ($producers as $producer) {
                foreach ($producer->featureDocuments as $document) {
                    $documentPath   =   env('STORAGE_URL', '/var/www/html/NFA/storage/app/NFA/' . $document->file);
                    $newFileName = ++$count . '. ' . $document->name;
                    if (file_exists($documentPath)) {
                        $zip->addFile($documentPath, $folder . $newFileName);
                        $hasFiles = true;
                    }
                }
            }

            //DIRECTORS
            $directors  =   Director::with('featureDocuments')->where('nfa_non_feature_id', $nfaNonFeature->id)->get();

            foreach ($directors as $director) {
                foreach ($director->featureDocuments as $document) {
                    $documentPath   =   env('STORAGE_URL', '/var/www/html/NFA/storage/app/NFA/' . $document->file);
                    $newFileName    =   ++$count . '. ' . $document->name;
                    if (file_exists($documentPath)) {
                        $zip->addFile($documentPath, $folder . $newFileName);
                        $hasFiles = true;
                    }
                }
            }
            if (!$hasFiles) {
                $zip->addEmptyDir($folder);
            }
            $zip->close();
        } else {
            return response()->json(['error' => 'Failed to create zip file'], 500);
        }
        return response()->download($zipFilePath)->deleteFileAfterSend(true);
    }
}
