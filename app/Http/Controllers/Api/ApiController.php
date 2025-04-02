<?php

namespace App\Http\Controllers\Api;

use App\Models\IpInternationalFilmFestival;
use App\Models\DdInternationalFilmFestival;
use App\Models\OttInternationalCompetition;
use App\Models\DdInternationalCompetition;
use App\Models\IpCommerciallyOutsideIndia;
use App\Models\IpInternationalCompetition;
use App\Models\DdCommerciallyOutsideIndia;
use App\Models\OttThreatricalScreening;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use App\Models\OttStreamedCountry;
use App\Models\DdApplicationForm;
use App\Models\OttCreatorsDetail;
use App\Models\IpApplicationForm;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\OttBroadcasted;
use App\Models\OttCoProducer;
use App\Models\DdCoProducer;
use App\Models\IpCoProducer;
use Illuminate\Http\Request;
use App\Models\DdDirectors;
use App\Models\Transaction;
use App\Models\IpDirector;
use App\Models\OttEpisode;
use App\Models\Document;
use App\Models\OttForm;
use App\Models\Country;
use App\Models\DdAward;
use App\Models\IpAward;
use ZipArchive;

class ApiController extends Controller
{
    public function Test()
    {
        return response()->json([
            'status' => true,
            'message' => 'Testing successfully.....'
        ]);
    }

    public function downloadFolder(Request $request)
    {
        $payload = $request->all();
        if (isset($payload['folder']) && !empty($payload['folder'])) {
            $folderPath = storage_path('app/public/pdfs/' . $payload['folder']);
            $zipFileName    =   $zipFileName = $payload['folder'] . '.zip';
        } else {
            $folderPath     =   storage_path('app/public/pdf');
            $zipFileName    =   'output_files.zip';
        }
        if (!File::exists($folderPath)) {
            return response()->json([
                'status' => false,
                'message' => "The specified folder does not exist: {$folderPath}",
            ]);
        }
        try {
            $zipFilePath    =   storage_path("app/public/{$zipFileName}");
            $zip = new ZipArchive;
            if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
                $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($folderPath));
                foreach ($files as $file) {
                    if (!$file->isDir()) {
                        $filePath = $file->getRealPath();
                        $relativePath = substr($filePath, strlen($folderPath) + 1);
                        $zip->addFile($filePath, $relativePath);
                    }
                }
                $zip->close();
            } else {
                return response()->json(['message' => 'Failed to create ZIP file'], 500);
            }
            $downloadUrl = Storage::url($zipFileName);
            return response()->json([
                'message' => 'PDFs generated successfully!',
                'directory' => $downloadUrl,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function ipPdfGenerator(Request $request)
    {
        $payload = $request->all();
        try {
            $ips    =   IpApplicationForm::where('step', 9)->get();
            $outputDirectory = storage_path('app/public/pdfs/indian-panorama');
            if (!File::exists($outputDirectory)) {
                File::makeDirectory($outputDirectory, 0777, true, true);
            }
            foreach ($ips as $ip) {

                $ipForm     =   IpApplicationForm::with('documents')->where(['id' => $ip->id])->first();
                $documents  =   Document::where(['context_id' => $ipForm->id])->get();

                $IpCoProducer = IpCoProducer::leftJoin('documents as doc1', function ($join) {
                    $join->on('doc1.context_id', '=', 'ip_co_producers.id')
                        ->whereIn('doc1.type', [17]);
                })->leftJoin('documents as doc2', function ($join) {
                    $join->on('doc2.context_id', '=', 'ip_co_producers.id')
                        ->whereIn('doc2.type', [18]);
                })
                    ->where('ip_application_form_id', $ipForm->id)
                    ->select(
                        'ip_co_producers.*',
                        'doc1.name as documents_name',
                        'doc1.file as file',
                        'doc2.file as file1',
                        'doc2.name as documents_name1'
                    )
                    ->get();

                $IpInternationalFilmFestival    =   IpInternationalFilmFestival::where('ip_application_form_id', $ipForm->id)->get();
                $IpCommerciallyOutsideIndia     =   IpCommerciallyOutsideIndia::where('ip_application_form_id', $ipForm->id)->get();
                $IpInternationalCompetition     =   IpInternationalCompetition::where('ip_application_form_id', $ipForm->id)->get();
                $IpAward                        =   IpAward::where('ip_application_form_id', $ipForm->id)->get();
                $IpDirector                     =   IpDirector::with('documents')->where('ip_application_form_id', $ipForm->id)->get();

                $data = [
                    'title'                         =>  'Indian Panorama',
                    'date'                          =>  date('M-d-y H:i:s'),
                    'ipForm'                        =>  $ipForm,
                    'IpCoProducer'                  =>  $IpCoProducer,
                    'IpInternationalFilmFestival'   =>  $IpInternationalFilmFestival,
                    'IpCommerciallyOutsideIndia'    =>  $IpCommerciallyOutsideIndia,
                    'IpInternationalCompetition'    =>  $IpInternationalCompetition,
                    'IpAward'                       =>  $IpAward,
                    'IpDirector'                    =>  $IpDirector,
                    'documents'                     =>  $documents,
                ];

                $fileName   =   preg_replace('/[^A-Za-z0-9_\-]/', '_', $ipForm->english_translation_of_film) . $ipForm->id . '.pdf';
                $filePath   =   $outputDirectory . DIRECTORY_SEPARATOR . $fileName;
                $pdf        =   Pdf::loadView('ips.pdf', $data);
                // $pdf->save($filePath);
                return $pdf->stream($filePath);
            }
            // return response()->json([
            //     'message' => 'PDFs generated successfully!',
            //     'directory' => $outputDirectory,
            // ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function ddPdfGenerator(Request $request)
    {
        $payload = $request->all();
        try {

            $dds    =   DdApplicationForm::where('step', 9)->get();
            $outputDirectory = storage_path('app/public/pdfs/director-debute');
            if (!File::exists($outputDirectory)) {
                File::makeDirectory($outputDirectory, 0777, true, true);
            }
            foreach ($dds as $dd) {
                $ddForm     =   DdApplicationForm::with('documents')->where(['id' => $dd->id])->first();
                $documents  =   Document::where(['context_id' => $ddForm->id, 'website_type' => 4])->get();
                $ddCoProducer = DdCoProducer::leftJoin('documents as doc1', function ($join) {
                    $join->on('doc1.context_id', '=', 'dd_co_producers.id')
                        ->whereIn('doc1.type', [17]);
                })->leftJoin('documents as doc2', function ($join) {
                    $join->on('doc2.context_id', '=', 'dd_co_producers.id')
                        ->whereIn('doc2.type', [18]);
                })
                    ->where('dd_application_form_id', $ddForm->id)
                    ->select(
                        'dd_co_producers.*',
                        'doc1.name as documents_name',
                        'doc1.file as file',
                        'doc2.file as file1',
                        'doc2.name as documents_name1'
                    )
                    ->get();
                $ddInternationalFilmFestival    =   DdInternationalFilmFestival::where('dd_application_form_id', $ddForm->id)->get();
                $ddCommerciallyOutsideIndia     =   DdCommerciallyOutsideIndia::where('dd_application_form_id', $ddForm->id)->get();
                $ddInternationalCompetition     =   DdInternationalCompetition::where('dd_application_form_id', $ddForm->id)->get();
                $ddAward                        =   DdAward::where('dd_application_form_id', $ddForm->id)->get();
                $ddDirector                     =   DdDirectors::with('documents')->where('dd_application_form_id', $ddForm->id)->get();
                $data = [
                    'title'                         =>  'Debute Director',
                    'date'                          =>  date('M-d-y H:i:s'),
                    'ipForm'                        =>  $ddForm,
                    'IpCoProducer'                  =>  $ddCoProducer,
                    'IpInternationalFilmFestival'   =>  $ddInternationalFilmFestival,
                    'IpCommerciallyOutsideIndia'    =>  $ddCommerciallyOutsideIndia,
                    'IpInternationalCompetition'    =>  $ddInternationalCompetition,
                    'IpAward'                       =>  $ddAward,
                    'IpDirector'                    =>  $ddDirector,
                    'documents'                     =>  $documents,
                ];
                $fileName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $ddForm->english_translation_of_film) . $ddForm->id . '.pdf';
                $filePath = $outputDirectory . DIRECTORY_SEPARATOR . $fileName;
                $pdf = Pdf::loadView('director-debute.myPdf', $data);
                // $pdf->save($filePath);
                return $pdf->stream($filePath);
            }
            // return response()->json([
            //     'message' => 'PDFs generated successfully!',
            //     'directory' => $outputDirectory,
            // ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function ottPdfGenerator(Request $request)
    {
        $id = 32;
        // $otts    =   OttForm::where('step', 8)->get();
        // $otts    =   OttForm::where('step', 8)->find($id);
        $otts    =   OttForm::where(['step' => 8, 'id' => $id])->get();

        $outputDirectory = storage_path('app/public/pdfs/OTT');
        if (!File::exists($outputDirectory)) {
            File::makeDirectory($outputDirectory, 0777, true, true);
        }

        foreach ($otts as $ott) {

            $datas = OttForm::select(
                'ott_forms.*',
                'doc1.name as documents_name',
                'doc1.type as documents_type',
                'doc1.file as file'
            )
                ->leftJoin('documents as doc1', function ($join) {
                    $join->on('doc1.context_id', '=', 'ott_forms.id')
                        ->where('doc1.website_type', 2);
                })
                ->where(['ott_forms.id' => $ott->id])
                ->get();
            if ($datas->isEmpty()) {
                return null;
            }
            $data                       =   $datas->first();
            $data_array                 =   $datas->first()->toArray();
            $data_array['documents']    =   [];

            $data_array['payment_response'] = Transaction::where([
                'website_type' => 2,
                'context_id' => $ott->id,
                'auth_status' => '0300',
            ])->first();

            $OttCoProducer                  =   OttCoProducer::with('documents')->where('ott_form_id', $ott->id)->get();
            $OttEpisode                     =   OttEpisode::where('ott_form_id', $ott->id)->get();
            $createrDetails                 =   OttCreatorsDetail::where('ott_form_id', $ott->id)->where('type', 1)->get();
            $Country                        =   Country::pluck('country_name', 'id')->toArray();
            $OttStreamedCountry             =   OttStreamedCountry::where('ott_form_id', $ott->id)->get();
            $OttThreatricalScreening        =   OttThreatricalScreening::where('ott_form_id', $ott->id)->get();
            $OttBroadcasted                 =   OttBroadcasted::where('ott_form_id', $ott->id)->get();
            $OttInternationalCompetition    =   OttInternationalCompetition::where('ott_form_id', $ott->id)->get();
            $OttDirectorDetail              =   OttCreatorsDetail::where('ott_form_id', $ott->id)->where('type', 2)->get();
            $OttDocs                        =   Document::where(['context_id' => $ott->id, "website_type" => 2])->get()->toArray();
            $OttDoc = [];

            foreach ($OttDocs as $document) {
                $OttDoc[$document['type']] = [
                    'name' => $document['name'],
                    'file' => $document['file'],
                ];
            }
            $data = [
                'title'                         =>  'OTT',
                'date'                          =>  date('M-d-y H:i:s'),
                'data_array'                    =>  $data_array,
                'OttCoProducer'                 =>  $OttCoProducer,
                'OttStreamedCountry'            =>  $OttStreamedCountry,
                'Country'                       =>  $Country,
                'OttThreatricalScreening'       =>  $OttThreatricalScreening,
                'OttInternationalCompetition'   =>  $OttInternationalCompetition,
                'OttBroadcasted'                =>  $OttBroadcasted,
                'OttEpisode'                    =>  $OttEpisode,
                'createrDetails'                =>  $createrDetails,
                'OttDirectorDetail'             =>  $OttDirectorDetail,
                'OttDoc'                        =>  $OttDoc
            ];
            // $fileName   =   preg_replace('/[^A-Za-z0-9_\-]/', '_', $data_array['title']) . $data_array['title'] . '.pdf';
            $fileName   =   preg_replace('/[^A-Za-z0-9_\-]/', '_', $data_array['title']) . '.pdf';
            $filePath   =   $outputDirectory . DIRECTORY_SEPARATOR . $fileName;
            // dd($data);
            $pdf        =   Pdf::loadView('ott.myPdf', $data);
            $pdf->save($filePath);
            // return $pdf->stream($filePath);
        }
        return response()->json([
            'message' => 'PDFs generated successfully!',
            'directory' => $outputDirectory,
        ]);
    }
}
