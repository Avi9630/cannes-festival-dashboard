<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Models\Transaction;
use App\Models\Director;
use App\Models\Producer;
use App\Models\Client;

class ExportNonFeatureBySearch implements FromCollection, WithHeadings, WithMapping  //FromView
{
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        $searchData = $this->data;
        return $searchData;
    }

    public function map($nfaFeature): array
    {
        $client =   Client::find($nfaFeature->client_id);
        if (!is_null($client)) {
            $clientName = $client->first_name . ' ' . $client->last_name;
            $clientEmail = $client->email;
        } else {
            $clientName = '';
            $clientEmail = '';
        }

        //  NFA-FEATURE-DIRECTORS
        $nfaFeatureDirectors = Director::where(['nfa_non_feature_id' => $nfaFeature->id, 'client_id' => $nfaFeature->client_id])->get();
        foreach ($nfaFeatureDirectors as $key => $nfaFeatureDirector) {

            if ($key == 0) {
                $Director1Name          =   $nfaFeatureDirector->name;
                $Director1Email         =   $nfaFeatureDirector->email;
                $Director1Address       =   $nfaFeatureDirector->address;
                $Director1Nationality   =   isset($nfaFeatureDirector->indian_national) && $nfaFeatureDirector->indian_national == 1 ? 'Indian' : NULL;
            }
            if ($key == 1) {
                $Director2Name          =   $nfaFeatureDirector->name;
                $Director2Email         =   $nfaFeatureDirector->email;
                $Director2Address       =   $nfaFeatureDirector->address;
                $Director2Nationality   =   isset($nfaFeatureDirector->indian_national) && $nfaFeatureDirector->indian_national == 1 ? 'Indian' : NULL;
            }
            if ($key == 2) {
                $Director3Name          =   $nfaFeatureDirector->name;
                $Director3Email         =   $nfaFeatureDirector->email;
                $Director3Address       =   $nfaFeatureDirector->address;
                $Director3Nationality   =   isset($nfaFeatureDirector->indian_national) && $nfaFeatureDirector->indian_national == 1 ? 'Indian' : NULL;
            }
            if ($key == 3) {
                $Director4Name          =   $nfaFeatureDirector->name;
                $Director4Email         =   $nfaFeatureDirector->email;
                $Director4Address       =   $nfaFeatureDirector->address;
                $Director4Nationality   =   isset($nfaFeatureDirector->indian_national) && $nfaFeatureDirector->indian_national == 1 ? 'Indian' : NULL;
            }
            if ($key == 4) {
                $Director5Name          =   $nfaFeatureDirector->name;
                $Director5Email         =   $nfaFeatureDirector->email;
                $Director5Address       =   $nfaFeatureDirector->address;
                $Director5Nationality   =   isset($nfaFeatureDirector->indian_national) && $nfaFeatureDirector->indian_national == 1 ? 'Indian' : NULL;
            }
        }

        //  NFA-FEATURE-PRODUCERS
        $nfaFeatureProducers = Producer::where(['nfa_non_feature_id' => $nfaFeature->id, 'client_id' => $nfaFeature->client_id])->get();
        foreach ($nfaFeatureProducers as $key => $nfaFeatureProducer) {

            if ($key == 0) {
                $Producer1Name          =   $nfaFeatureProducer->name;
                $Producer1Email         =   $nfaFeatureProducer->email;
                $Producer1Mobile        =   $nfaFeatureProducer->contact_nom;
                $Producer1Address       =   $nfaFeatureProducer->address;
                $Producer1Nationality   =   isset($nfaFeatureProducer->indian_national) && $nfaFeatureProducer->indian_national == 1 ? 'Indian' : NULL;
            }

            if ($key == 1) {
                $Producer2Name          =   $nfaFeatureProducer->name;
                $Producer2Email         =   $nfaFeatureProducer->email;
                $Producer2Mobile        =   $nfaFeatureProducer->contact_nom;
                $Producer2Address       =   $nfaFeatureProducer->address;
                $Producer2Nationality   =   isset($nfaFeatureProducer->indian_national) && $nfaFeatureProducer->indian_national == 1 ? 'Indian' : NULL;
            }

            if ($key == 2) {
                $Producer3Name          =   $nfaFeatureProducer->name;
                $Producer3Email         =   $nfaFeatureProducer->email;
                $Producer3Mobile        =   $nfaFeatureProducer->contact_nom;
                $Producer3Address       =   $nfaFeatureProducer->address;
                $Producer3Nationality   =   isset($nfaFeatureProducer->indian_national) && $nfaFeatureProducer->indian_national == 1 ? 'Indian' : NULL;
            }

            if ($key == 3) {
                $Producer4Name          =   $nfaFeatureProducer->name;
                $Producer4Email         =   $nfaFeatureProducer->email;
                $Producer4Mobile        =   $nfaFeatureProducer->contact_nom;
                $Producer4Address       =   $nfaFeatureProducer->address;
                $Producer4Nationality   =   isset($nfaFeatureProducer->indian_national) && $nfaFeatureProducer->indian_national == 1 ? 'Indian' : NULL;
            }

            if ($key == 4) {
                $Producer5Name          =   $nfaFeatureProducer->name;
                $Producer5Email         =   $nfaFeatureProducer->email;
                $Producer5Mobile        =   $nfaFeatureProducer->contact_nom;
                $Producer5Address       =   $nfaFeatureProducer->address;
                $Producer5Nationality   =   isset($nfaFeatureProducer->indian_national) && $nfaFeatureProducer->indian_national == 1 ? 'Indian' : NULL;
            }
        }

        $payment   =   Transaction::where([
            'website_type'  =>  1,
            'client_id'     =>  $nfaFeature['client_id'],
            'context_id'    =>  $nfaFeature['id'],
            'auth_status'   =>  '0300',
        ])->first();

        if (!is_null($payment)) {
            $paymentDate    =   $payment->payment_date;
            $paymentAmount  =   $payment->amount;
            $paymentReceipt =   $payment->bank_ref_no;
        } else {
            $paymentDate    =   '';
            $paymentAmount  =   '';
            $paymentReceipt =   '';
        }

        $data =  [

            //Client Details
            $nfaFeature->id,
            $clientName,
            $clientEmail,

            //Step:- 1 GENERAL
            $nfaFeature->film_title_roman,
            $nfaFeature->film_title_devnagri,
            $nfaFeature->film_title_english,
            $nfaFeature->language,
            isset($nfaFeature->english_subtitle) && $nfaFeature->english_subtitle === 1 ? 'Yes' : 'No',
            isset($nfaFeature->director_debut) && $nfaFeature->director_debut === 1 ? 'Yes' : 'No',
            $nfaFeature->nom_reels_tapes,
            $nfaFeature->aspect_ratio,
            isset($nfaFeature->format) && $nfaFeature->format === 1 ? '35 mm' : ($nfaFeature->format === 2 ? 'DCP' : ($nfaFeature->format === 3 ? 'BlueRay' : '')),
            isset($nfaFeature->sound_system) && $nfaFeature->sound_system === 1 ? 'Optical Mono' : ($nfaFeature->sound_system === 2 ? 'Dolby' : ($nfaFeature->sound_system === 3 ? 'DTS' : ($nfaFeature->sound_system === 4 ? 'Others' : ''))),
            $nfaFeature->running_time,
            isset($nfaFeature->color_bw) && $nfaFeature->color_bw === 1 ? 'Color' : ($nfaFeature->color_bw === 2 ? 'B/W' : ''),
            // $nfaFeature->film_synopsis,

            //Step:- 2 CENSOR
            $nfaFeature->censor_certificate_nom,
            $nfaFeature->censor_certificate_date,

            //Step:- 5 PRODUCER
            isset($Producer1Name) ? $Producer1Name : '',
            isset($Producer1Email) ? $Producer1Email : '',
            isset($Producer1Mobile) ? $Producer1Mobile : '',
            isset($Producer1Address) ? $Producer1Address : '',
            isset($Producer1Nationality) ? $Producer1Nationality : '',

            isset($Producer2Name) ? $Producer2Name : '',
            isset($Producer2Email) ? $Producer2Email : '',
            isset($Producer2Mobile) ? $Producer2Mobile : '',
            isset($Producer2Address) ? $Producer2Address : '',
            isset($Producer2Nationality) ? $Producer2Nationality : '',

            isset($Producer3Name) ? $Producer3Name : '',
            isset($Producer3Email) ? $Producer3Email : '',
            isset($Producer3Mobile) ? $Producer3Mobile : '',
            isset($Producer3Address) ? $Producer3Address : '',
            isset($Producer3Nationality) ? $Producer3Nationality : '',

            isset($Producer4Name) ? $Producer4Name : '',
            isset($Producer4Email) ? $Producer4Email : '',
            isset($Producer4Mobile) ? $Producer4Mobile : '',
            isset($Producer4Address) ? $Producer4Address : '',
            isset($Producer4Nationality) ? $Producer4Nationality : '',

            isset($Producer5Name) ? $Producer5Name : '',
            isset($Producer5Email) ? $Producer5Email : '',
            isset($Producer5Mobile) ? $Producer5Mobile : '',
            isset($Producer5Address) ? $Producer5Address : '',
            isset($Producer5Nationality) ? $Producer5Nationality : '',

            //Step:- 6 DIRECTOR
            isset($Director1Name) ? $Director1Name : '',
            isset($Director1Email) ? $Director1Email : '',
            isset($Director1Address) ? $Director1Address : '',
            isset($Director1Nationality) ? $Director1Nationality : '',

            isset($Director2Name) ? $Director2Name : '',
            isset($Director2Email) ? $Director2Email : '',
            isset($Director2Address) ? $Director2Address : '',
            isset($Director2Nationality) ? $Director2Nationality : '',

            isset($Director3Name) ? $Director3Name : '',
            isset($Director3Email) ? $Director3Email : '',
            isset($Director3Address) ? $Director3Address : '',
            isset($Director3Nationality) ? $Director3Nationality : '',

            isset($Director4Name) ? $Director4Name : '',
            isset($Director4Email) ? $Director4Email : '',
            isset($Director4Address) ? $Director4Address : '',
            isset($Director4Nationality) ? $Director4Nationality : '',

            isset($Director5Name) ? $Director5Name : '',
            isset($Director5Email) ? $Director5Email : '',
            isset($Director5Address) ? $Director5Address : '',
            isset($Director5Nationality) ? $Director5Nationality : '',

            //Step:- 10 OTHER
            $nfaFeature->original_screenplay_name,
            $nfaFeature->adapted_screenplay_name,

            //Step:- 11 RETURN
            $nfaFeature->return_name,
            $nfaFeature->return_email,
            $nfaFeature->return_mobile,
            $nfaFeature->return_address,
            $nfaFeature->return_pincode,

            //PAYMENT
            $paymentDate,
            $paymentAmount,
            $paymentReceipt,
        ];
        return $data;
    }

    public function headings(): array
    {
        return [

            //Client Details
            'Movie Ref',
            'Client Name',
            'Client Email',

            //Step:- 1 GENERAL
            'Film Title (Roman Script)',
            'Film Title (Roman Devnagri)',
            'Film Title (English translation of the film title)',
            'Language (If the film has no dialogues)',
            'English Subtitle',
            'Director Debut',
            'No.of Reels/Tapes',
            'Aspect Reatio',
            'Format',
            'Sound System',
            'Running Time',
            'Color/ Black & white',
            // 'File Synopsis',

            //Step:- 2 CENSOR
            'Censor certificate Number',
            'Censor certificate date',

            //Step:- 5 PRODUCER
            'Producer 1 Name',
            'Producer 1 Email',
            'Producer 1 Mobile',
            'Producer 1 Address',
            'Producer 1 Nationality',

            'Producer 2 Name',
            'Producer 2 Email',
            'Producer 2 Mobile',
            'Producer 2 Address',
            'Producer 2 Nationality',

            'Producer 3 Name',
            'Producer 3 Email',
            'Producer 3 Mobile',
            'Producer 3 Address',
            'Producer 3 Nationality',

            'Producer 4 Name',
            'Producer 4 Email',
            'Producer 4 Mobile',
            'Producer 4 Address',
            'Producer 4 Nationality',

            'Producer 5 Name',
            'Producer 5 Email',
            'Producer 5 Mobile',
            'Producer 5 Address',
            'Producer 5 Nationality',

            //Step:- 6 DIRECTOR
            'Director 1 Name',
            'Director 1 Email',
            'Director 1 Address',
            'Director 1 Nationality',

            'Director 2 Name',
            'Director 2 Email',
            'Director 2 Address',
            'Director 2 Nationality',

            'Director 3 Name',
            'Director 3 Email',
            'Director 3 Address',
            'Director 3 Nationality',

            'Director 4 Name',
            'Director 4 Email',
            'Director 4 Address',
            'Director 4 Nationality',

            'Director 5 Name',
            'Director 5 Email',
            'Director 5 Address',
            'Director 5 Nationality',

            //Step:- 10 OTHER
            'Name of Original Sreenplay',
            'Name of Adapted Screenplay',

            //Step:- 11 RETURN
            'Return Name',
            'Return Email',
            'Return Mobile',
            'Return Address',
            'Return Pincode',

            //PAYMENT
            'Payment Date & Time',
            'Payment Amount',
            'Payment Receipt No',
        ];
    }
}
