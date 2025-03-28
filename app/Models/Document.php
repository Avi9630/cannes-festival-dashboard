<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $guarded = [];

    // public function documents()
    // {
    //     return $this->hasMany(IpApplicationDocument::class);
    // }

    static function  documentType()
    {
        return [
            "CENSOR_CERTIFICATE_FILE"       =>  1,  //censor_certificate_file
            "COMPANY_REG_DOC"               =>  2,  //company_reg_doc
            "ORIGINAL_WORK_COPY"            =>  3,  //original_work_copy
            "PRODUCER_SELF_ATTESTED_DOC"    =>  4,  //producer_self_attested_doc
            "DIRECTOR_SELF_ATTESTED_DOC"    =>  5,  //director_self_attested_doc
            "CRITIC_AADHAAR_CARD"           =>  6,  //critic_aadhaar_card
            "AUTHOR_AADHAAR_CARD"           =>  7,  //author_aadhaar_card
        ];
    }

    public static function uploadDocument($args, $fileDetails)
    {
        //     $website_type = COMMONTrait::websiteType()['CMOT'];
        //     $document   =   new Document();
        //     $document->context_id   =   $request['last_id'];
        //     $document->type         =   $fileDetails['type'];
        //     $document->file         =   $fileDetails['file'];
        //     $document->name         =   $fileDetails['name'];
        //     $fileDetails['website_type'] = $website_type;
        //     $args = [
        //         "context_id"    =>  $request['last_id'],
        //         "website_type"  =>  $website_type,
        //         "type"          =>  $fileDetails['type']
        //     ];
        //      echo "<pre>";
        //      print_r(array_merge($args, $fileDetails));
        //      die();
        $Document = Document::where($args)->first();


        if ($Document) {
            $Document->update($fileDetails);
        } else {
            Document::create($fileDetails);
        }
    }

    public static function saveDocument($data)
    {
        return Document::firstOrCreate($data->toArray());
        // $data['ip_application_form_id'] = $this->ip_application_form_id;
        // return  $this::create($args, array_merge($args, $param));
        // return  Document::firstOrCreate($args, array_merge($args, $param));
    }
}
