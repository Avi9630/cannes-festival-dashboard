<?php

namespace App\Http\Controllers;

use App\Models\IpInternationalFilmFestival;
use App\Models\IpCommerciallyOutsideIndia;
use App\Models\IpInternationalCompetition;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportNonFeature;
use App\Models\IpApplicationForm;
use App\Exports\ExportBySearch;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\ExportFeature;
use App\Models\IpCoProducer;
use Illuminate\Http\Request;
use App\Exports\ExportAllIp;
use App\Models\Transaction;
use App\Models\IpDirector;
use App\Models\Document;
use App\Models\OttForm;
use App\Models\IpAward;
use ZipArchive;
use Mpdf\Mpdf;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;

class IpApplicationFormController extends Controller
{
    public function index(Request $request)
    {
        $payload = $request->all();
        $ipRecords = IpApplicationForm::where('step', 9)->paginate(10);
        $count = IpApplicationForm::count();

        session()->put('ipRecords', $ipRecords);

        $categories = [
            1 => 'Feature',
            2 => 'Non-Feature',
        ];

        $paids = [
            9 => 'Paid',
            1 => 'Unpaid',
        ];

        return view('ips.index', [
            'ips' => $ipRecords,
            'payload' => $payload,
            'categories' => $categories,
            'paids' => $paids,
            'count' => $count,
        ]);
    }

    public function search(Request $request)
    {
        $payload = $request->all();
        // New Version of Code
        $query = IpApplicationForm::query();
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
            if (!empty($payload['category'])) {
                $builder->where('category', $payload['category']);
            }
            if (!empty($payload['payment_status'])) {
                if ($payload['payment_status'] === '9') {
                    $builder->where('step', $payload['payment_status']);
                } elseif ($payload['payment_status'] === '1') {
                    if (!empty($payload['step'])) {
                        $builder->where('step', $payload['step']);
                    } else {
                        $builder->whereIn('step', range(1, 8));
                    }
                }
            } else {
                $builder->where('step', 9);
            }
        });

        //OLD Version Code
        // $fromDate       =   !empty($payload['from_date']) ? $payload['from_date'] : '';
        // $toDate         =   !empty($payload['to_date']) ? $payload['to_date'] : '';
        // $category       =   !empty($payload['category']) ? $payload['category'] : '';
        // $paymentStatus  =   !empty($payload['payment_status']) ? $payload['payment_status'] : '';
        // $step           =   !empty($payload['step']) ? $payload['step'] : '';
        // $query = IpApplicationForm::query();
        // $todayDate = date('Y-m-d');
        // if (!empty($fromDate) && !empty($toDate)) {
        //     $query->whereDate('created_at', '>=', $fromDate);
        //     $query->whereDate('created_at', '<=', $toDate);
        // } elseif (empty($fromDate) && !empty($toDate)) {
        //     $query->whereDate('created_at', '>=', $todayDate);
        //     $query->whereDate('created_at', '<=', $toDate);
        // } elseif (!empty($fromDate) && empty($toDate)) {
        //     $query->whereDate('created_at', '>=', $fromDate);
        //     $query->whereDate('created_at', '<=', $todayDate);
        // }
        // if (!empty($category)) {
        //     $query->where('category', $category);
        // }
        // if (!empty($paymentStatus)) {
        //     if ($paymentStatus === "9") {
        //         $query->where('step', $paymentStatus);
        //     } elseif ($paymentStatus === "1") {
        //         if (!empty($step)) {
        //             $query->where('step', $step);
        //         } else {
        //             $query->where('step', '!=', 9);
        //         }
        //     }
        // }

        $filteredData = $query->get();
        session()->put('ipRecords', $filteredData);
        $count = $query->count();
        $ipRecords = $query->paginate(10);
        $categories = [
            1 => 'Feature',
            2 => 'Non-Feature',
        ];

        $paids = [
            9 => 'Paid',
            1 => 'Unpaid',
        ];

        return view('ips.index', [
            'ips' => $ipRecords,
            'payload' => $payload,
            'categories' => $categories,
            'paids' => $paids,
            'count' => $count,
        ]);
    }

    public function titleOfFilm(Request $request)
    {
        $payload = $request->all();
        $validatorArray = [
            'id' => 'required',
        ];
        $messagesArray = [];

        $validator = Validator::make($request->all(), $validatorArray, $messagesArray);

        if ($validator->fails()) {
            return response()->json([
                'status' => true,
                'message' => $validator->errors()->first(),
            ]);
        }

        try {
            $titleOfFilm = IpApplicationForm::where('id', $payload['id'])->first();
            if (is_null($titleOfFilm)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Records not found.!!',
                ]);
            } else {
                return response()->json([
                    'status' => true,
                    'data' => $titleOfFilm,
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function featureExport()
    {
        return Excel::download(new ExportFeature(), 'feature.xls'); //true, ['X-Vapor-Base64-Encode' => 'True']
    }

    public function nonFeatureExport()
    {
        return Excel::download(new ExportNonFeature(), 'non_feature.xls'); //true, ['X-Vapor-Base64-Encode' => 'True']
    }

    public function allReport()
    {
        $ipRecords = IpApplicationForm::select('*')->where('step', 9)->get();
        $fileName = 'indian-panorama.xls';
        return Excel::download(new ExportAllIp($ipRecords), $fileName);
    }

    public function exportBySearch()
    {
        if (session()->has('ipRecords')) {
            $ipRecords = session()->get('ipRecords');
            $fileName = 'IpBySearch.xls';
            return Excel::download(new ExportBySearch($ipRecords), $fileName);
        } else {
            return view('sessions.view')->with('danger', 'Session not set yet.!!');
        }
    }

    public function ottview(Request $request)
    {
        $id = 53;
        $datas = OttForm::select('ott_forms.*', 'doc1.name as documents_name', 'doc1.type as documents_type', 'doc1.file as file')
            ->leftJoin('documents as doc1', function ($join) {
                $join->on('doc1.context_id', '=', 'ott_forms.id')->where('doc1.website_type', 2);
            })
            ->where(['ott_forms.id' => $id])
            ->get();
        // echo "<pre>";print_r($datas);
        if ($datas->isEmpty()) {
            return null; // Or handle the case where no data is found
        }

        $data = $datas->first(); //->toArray();
        $data_array = $datas->first()->toArray();
        $data_array['documents'] = [];

        $data_array['payment_response'] = Transaction::where([
            'website_type' => 2,
            'context_id' => $id,
            'auth_status' => '0300',
        ])->first();
        $response = [
            'data' => $data,
        ];
        //   echo "<pre>";print_r($response);die();
        return view('ott.view', compact('data', 'data_array', 'OttCoProducer'));
    }

    public function downloadDocumentsAsZip(Request $request, $id)
    {
        $ips = IpApplicationForm::with('documents')->where('id', $id)->get();
        $zip = new ZipArchive();
        $filePath = storage_path('app/ip/' . $ips[0]->id . '/');
        File::makeDirectory($filePath, 0755, true, true);
        $filePath = $filePath . $ips[0]->english_translation_of_film . '.zip';
        if ($zip->open($filePath, ZipArchive::CREATE) === true) {
            foreach ($ips as $ip) {
                $count = 0;
                $folder = $ip->english_translation_of_film . '/';
                $hasFiles = false;
                // echo "<pre>";
                //print_r($ip);
                //die();
                $storage_url = env('STORAGE_URL', '/var/www/html/api/');
                foreach ($ip->documents as $document) {
                    $documentPath = $storage_url . 'storage/app/IP/' . $ip->id . '/' . $document->file;
                    //    echo $documentPath;
                    //   die();
                    //  $documentPath = storage_path('app/ott/' . $ottForm->id . '/' . $document->file);
                    $newFileName = ++$count . '. ' . $document->name;
                    //  echo "hdhd";

                    if (file_exists($documentPath)) {
                        //  die("data");
                        $zip->addFile($documentPath, $folder . $newFileName);
                        $hasFiles = true;
                    }
                    //die("ddd");
                }

                // Add directory to zip even if no files found
                if (!$hasFiles) {
                    $zip->addEmptyDir($folder);
                }

                // Co-producers
                $IpDirectors = IpDirector::with('documents')
                    ->where('ip_application_form_id', $ip->id)
                    ->get();

                foreach ($IpDirectors as $IpDirector) {
                    foreach ($IpDirector->documents as $document) {
                        //  $documentPath = storage_path('app/ott/' . $ottForm->id . '/' . $document->file);
                        $documentPath = $storage_url . 'storage/app/IP/' . $ip->id . '/' . $document->file;
                        $newFileName = ++$count . '. ' . $document->name;
                        if (file_exists($documentPath)) {
                            $zip->addFile($documentPath, $folder . $newFileName);
                            $hasFiles = true;
                        } else {
                            $documentPath = $storage_url . 'storage/app/ip/' . $ip->id . '/' . $document->file;
                            $newFileName = $document->name;
                            if (file_exists($documentPath)) {
                                $zip->addFile($documentPath, $folder . $newFileName);
                                $hasFiles = true;
                            }
                        }
                    }
                }
                $IpCoProducers = IpCoProducer::leftJoin('documents as doc1', function ($join) {
                    $join->on('doc1.context_id', '=', 'ip_co_producers.id')->whereIn('doc1.type', [17]);
                })
                    ->leftJoin('documents as doc2', function ($join) {
                        $join->on('doc2.context_id', '=', 'ip_co_producers.id')->whereIn('doc2.type', [18]);
                    })
                    // ->where('documents.type', [17, 18]) ss
                    ->where('ip_application_form_id', $ip->id)
                    ->select('ip_co_producers.*', 'doc1.name as documents_name', 'doc1.file as file', 'doc2.file as file1', 'doc2.name as documents_name1')
                    ->get();

                foreach ($IpCoProducers as $IpCoProducer) {
                    if ($IpCoProducer->documents_name) {
                        $documentPath = $storage_url . 'storage/app/IP/' . $ip->id . '/' . $IpCoProducer->file;

                        $newFileName = ++$count . '. ' . $IpCoProducer->documents_name;
                        if (file_exists($documentPath)) {
                            $zip->addFile($documentPath, $folder . $newFileName);
                            $hasFiles = true;
                        }
                    }
                    if ($IpCoProducer->documents_name1) {
                        $documentPath = $storage_url . 'storage/app/IP/' . $ip->id . '/' . $IpCoProducer->file1;

                        $newFileName = $IpCoProducer->documents_name1;
                        $newFileName = ++$count . '. ' . $IpCoProducer->documents_name1;
                        if (file_exists($documentPath)) {
                            $zip->addFile($documentPath, $folder . $newFileName);
                            $hasFiles = true;
                        }
                    }
                }

                // Add directory to zip even if no files found
                if (!$hasFiles) {
                    $zip->addEmptyDir($folder);
                }
            }

            $zip->close();
        } else {
            return response()->json(['error' => 'Failed to create zip file'], 500);
        }
        return response()->download($filePath);
    }

    public function ippdf(Request $request, $id)
    {
        $ipForm = IpApplicationForm::with('documents')
            ->where(['id' => $id])
            ->first();
        $documents = Document::where(['context_id' => $id])->get();
        $IpCoProducer = IpCoProducer::leftJoin('documents as doc1', function ($join) {
            $join->on('doc1.context_id', '=', 'ip_co_producers.id')->whereIn('doc1.type', [17]);
        })
            ->leftJoin('documents as doc2', function ($join) {
                $join->on('doc2.context_id', '=', 'ip_co_producers.id')->whereIn('doc2.type', [18]);
            })
            ->where('ip_application_form_id', $id)
            ->select('ip_co_producers.*', 'doc1.name as documents_name', 'doc1.file as file', 'doc2.file as file1', 'doc2.name as documents_name1')
            ->get();

        $IpInternationalFilmFestival    =   IpInternationalFilmFestival::where('ip_application_form_id', $id)->get();
        $IpCommerciallyOutsideIndia     =   IpCommerciallyOutsideIndia::where('ip_application_form_id', $id)->get();
        $IpInternationalCompetition     =   IpInternationalCompetition::where('ip_application_form_id', $id)->get();
        $IpAward                        =   IpAward::where('ip_application_form_id', $id)->get();
        $IpDirector                     =   IpDirector::with('documents')->where('ip_application_form_id', $id)->get();
        $tempDir                        =   sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'mpdf';

        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0777, true);
        }
        // $mpdf = new Mpdf([
        //     'tempDir' => $tempDir,
        // ]);

        // Add Hindi font configuration
        $defaultConfig = (new ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];
        $defaultFontConfig = (new FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];
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
        $html = view('ips.pdf', [
            'title' => 'Indian Panorama',
            'date' => date('M-d-y H:i:s'),
            'ipForm' => $ipForm,
            'IpCoProducer' => $IpCoProducer,
            'IpInternationalFilmFestival' => $IpInternationalFilmFestival,
            'IpCommerciallyOutsideIndia' => $IpCommerciallyOutsideIndia,
            'IpInternationalCompetition' => $IpInternationalCompetition,
            'IpAward' => $IpAward,
            'IpDirector' => $IpDirector,
            'documents' => $documents,
        ]);
        $mpdf->WriteHTML($html);
        $pdfFilePath = $ipForm->english_translation_of_film . '.pdf';
        $mpdf->Output($pdfFilePath, 'I'); // 'D' for download, 'I' for inline view
    }

    public function pdfGenerator()
    {
        $dds = IpApplicationForm::where('step', 9)->get();
        $outputDirectory = storage_path('app/public/pdfs/indian-panorama');
        if (!File::exists($outputDirectory)) {
            File::makeDirectory($outputDirectory, 0777, true, true);
        }
        foreach ($dds as $dd) {
            $ipForm = IpApplicationForm::with('documents')
                ->where(['id' => $dd->id])
                ->first();
            $documents = Document::where(['context_id' => $ipForm->id])->get();
            $IpCoProducer = IpCoProducer::leftJoin('documents as doc1', function ($join) {
                $join->on('doc1.context_id', '=', 'ip_co_producers.id')->whereIn('doc1.type', [17]);
            })
                ->leftJoin('documents as doc2', function ($join) {
                    $join->on('doc2.context_id', '=', 'ip_co_producers.id')->whereIn('doc2.type', [18]);
                })
                ->where('ip_application_form_id', $ipForm->id)
                ->select('ip_co_producers.*', 'doc1.name as documents_name', 'doc1.file as file', 'doc2.file as file1', 'doc2.name as documents_name1')
                ->get();

            $IpInternationalFilmFestival = IpInternationalFilmFestival::where('ip_application_form_id', $ipForm->id)->get();
            $IpCommerciallyOutsideIndia = IpCommerciallyOutsideIndia::where('ip_application_form_id', $ipForm->id)->get();
            $IpInternationalCompetition = IpInternationalCompetition::where('ip_application_form_id', $ipForm->id)->get();
            $IpAward = IpAward::where('ip_application_form_id', $ipForm->id)->get();
            $IpDirector = IpDirector::with('documents')
                ->where('ip_application_form_id', $ipForm->id)
                ->get();

            $data = [
                'title' => 'Indian Panorama',
                'date' => date('M-d-y H:i:s'),
                'ipForm' => $ipForm,
                'IpCoProducer' => $IpCoProducer,
                'IpInternationalFilmFestival' => $IpInternationalFilmFestival,
                'IpCommerciallyOutsideIndia' => $IpCommerciallyOutsideIndia,
                'IpInternationalCompetition' => $IpInternationalCompetition,
                'IpAward' => $IpAward,
                'IpDirector' => $IpDirector,
                'documents' => $documents,
            ];
            $fileName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $ipForm->english_translation_of_film) . $ipForm->id . '.pdf';
            $filePath = $outputDirectory . DIRECTORY_SEPARATOR . $fileName;
            $pdf = Pdf::loadView('ips.pdf', $data);
            $pdf->save($filePath);
            // return $pdf->stream();
        }
        // return response()->json([
        //     'message' => 'PDFs generated successfully!',
        //     'directory' => $outputDirectory,
        // ]);
    }
}
