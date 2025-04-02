<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{$header->name}}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<style>
    .pdf {
        font-family: 'arial';
        font-size: 14px;
        color: #000
    }

    .pdf .container {
        width: 90%;
        margin: 0 auto;
        max-width: 1200px;
    }

    .pdf p {
        margin-bottom: 5px;
    }

    .pdf h3 {
        background: #f5f5f5;
        padding: 6px 15px;
        margin-bottom: 15px;
        font-size: 16px;
        font-weight: 600;
    }

    .pdf h3 span {
        font-weight: 400;
    }

    .text-center {
        text-align: center;
    }
</style>

<style type="text/css">
    @page{
        padding: 15px;
    }
    <?php if($header->lang== 'Guj'){ ?> 
    * {
        font-family: 'noto serif gujarati', sans-serif;
      }
    <?php } else if($header->lang == 'Hindi'){ ?>
    * { 
        font-family: 'tiro devanagari hindi', sans-serif; 
      }
    <?php } ?>
   </style>

<body>
    <h1 class="text-center">{{ $title }} || {{ $date }}</h1>

    <div class=" m-1 pdf">

        <h3> Category of the Film :
            <span>{{ $ipForm->category == 1 ? 'Feature Film' : 'Non-feature Film' }}</b>
        </h3>

        <h3> Title of the Film</h3>

        <p>
            <b>(a) Title of the Film in Roman Script :-</b> {{ $ipForm->title_of_film_in_roman }}
        </p>

        <p><b>(b) Title of the Film in Devanagari :- </b>
            {{ $ipForm->title_of_film_in_devanagari }}
        </p>

        <p>
            <b>(c) English translation of the Film:</b>
            {{ $ipForm->english_translation_of_film }}
        </p>

        <p>
            <b>(d) Title of the Film in the script of the language of
                the Film:
            </b>
            {{ $ipForm->title_of_script_langauge }}
        </p>



        <h3> Language of the Film</h3>
        <p><b>(a) Language of the
                Film:</b>{{ $ipForm->language_id ? $language[$ipForm->language_id] ?? '' : '' }}</p>
        @if ($ipForm->language_id == 20)
            <p><b> Other language name:</b>
                {{ $ipForm->other_language_name }}</p>
        @endif

        <p><b>(b) Whether Subtitled in English:</b>
            {{ $ipForm->whether_subtitle_english ? 'Yes' : 'No' }}</p>

        <h3> Format of the submitted Film</h3>
        <p><b>Feature Film:</b>
            {{ $ipForm->dcp == 1 ? 'DCP' : ($ipForm->dcp == 2 ? 'Blu-ray' : ($ipForm->dcp == 3 ? 'Pendrive' : '')) }}
        </p>

        @if ($ipForm->dcp == 1)
            <p><b>DCI Compliant JPEG2000 (J2K) Interop or SMPTE DCP
                    (Note: J2K Interop DCP to be only in 24 fps):</b>
                {{ $ipForm->dci_compliant_jpeg_2000 == 1 ? 'Yes' : 'No' }}
            </p>
            <p><b>The subtitles to be burned in the picture or in TI
                    CineCanvas™ Format:</b>
                {{ $ipForm->subtitle_to_be_burned_in_picture == 1 ? 'Yes' : 'No' }}
            </p>
            <p><b>The Hard Disk partition format shall be NTFS or EXT2/EXT3
                    (with Inode size 128 bytes):</b>
                {{ $ipForm->hard_disk_format_ext2_ext3 == 1 ? 'Yes' : 'No' }}
            </p>
            <p><b>The DCP should be preferably sent in CRU Hard Disk:</b>
                {{ $ipForm->dcp_should_cru_hard_disk == 1 ? 'Yes' : 'No' }}
            </p>
            <p><b>Is the DCP Unencrypted?</b>
                {{ $ipForm->is_dcp_unencrypted == 1 ? 'Yes' : 'No' }}
            </p>
        @elseif($ipForm->dcp == 2)
            <p><b>Is the Blu-ray region free PAL?</b>
                {{ $ipForm->blueray_region_free_pal ? 'Yes' : 'No' }}
            </p>
        @endif

        <p><b>
                {{ $ipForm->category == 2 ? 'Value of the DCP/Blu-ray/Pendrive' : 'Value of the DCP/Blu-ray' }}:</b>
            {{ $ipForm->value_of_dcp_or_blueray }}
        </p>


        <h3> Producer(s) Details</h3>


        <p><b>(a) Whether Producer is:</b>
            {{ $ipForm->producer_is == 1 ? 'Individual' : 'Company/Institute/Other Such Entity' }}
        </p>

        @if ($ipForm->producer_is == 1)
            <p><b>(b) Whether any proprietor firm is owned by the individual
                    making entry:</b>
                {{ $ipForm->firm_is_owned_by_individual ? 'Yes' : 'No' }}
            </p>

            @if ($ipForm->firm_is_owned_by_individual)
                <p><b>
                        (i) Name of the firm: </b>
                    {{ $ipForm->name_of_firm }}
                </p>
            @endif
        @else
            @if (
                $ipForm->producer_is == 2 &&
                    ($ipForm->firm_is_owned_by_individual == 0 || $ipForm->firm_is_owned_by_individual == 1))
                <p><b>(i) Name of the producer making the entry:</b>
                    {{ $ipForm->name_of_the_producer_making_entry }}</p>
            @else
                <p><b>
                        (i) Name of the production house:
                    </b>
                    {{ $ipForm->name_of_production_house }}</p>
            @endif
        @endif


        <p><b>(ii) E-mail: </b> {{ $ipForm->producer_email }}</p>
        <p><b>(iii) Address: </b> {{ $ipForm->producer_address }}</p>
        <p><b>(iv) Landline: </b> {{ $ipForm->producer_landline }}</p>
        <p><b> (v) Mobile:</b> {{ $ipForm->producer_mobile }}</p>
        <p><b>(vi) Website: </b> {{ $ipForm->producer_website }}</p>

        <p><b>(b) Whether Company is Registered as an Indian entity - Public Ltd./Private
                Ltd./Partnership/Proprietorship or Whether Indian national (as per the clause number 2(d)) :- </b>
            {{ $ipForm->company_is_registered_as_indian_entity ? 'Yes' : 'No' }}
        </p>
        <p><b> (c) Attach Photo ID issued by the Govt. of India (for Indian National) :- </b>

            @if (!empty($ipForm->documentData[1]))
                @php
                    $document = $ipForm->documentData[1];
                @endphp
                {{ $document->name }}
            @else
                <p>No document is available for download.</p>
            @endif
        </p>

        <h3> DCP/Blu-ray of the Film to be returned to</h3>

        <p><b>(a) Is the address same as Producer:</b>
            {{ $ipForm->is_address_same_as_producer ? 'Yes' : 'No' }}
        </p>

        @if (!$ipForm->is_address_same_as_producer)
            <p><b>(i) Name:</b>
                {{ $ipForm->return_address_name }}
            </p>
            <p><b>(ii) E-mail:</b>
                {{ $ipForm->return_address_email }}
            </p>
            <p><b>(iii) Landline:</b>
                {{ $ipForm->return_address_landline }}
            </p>
            <p><b>(iv) Mobile Number:</b>
                {{ $ipForm->return_address_mobile }}
            </p>
            <p><b>(v) Address:</b>
                {{ $ipForm->return_address }}
            </p>
        @endif

        @foreach ($IpCoProducer as $index => $item)
            <p><b>({{ $index + 1 }}) Co-Producer Details</b></p>
            <p><b>Whether Co-producer is :-
                </b>{{ $item->co_producer_is == 1 ? 'Individual' : 'Company / Institute /Other such entity' }}
            </p>
            <p><b>Name :- </b> {{ $item->name }}</p>
            <p><b>E-mail :- </b> {{ $item->email }}</p>
            <p><b>Landline :- </b>{{ $item->landline }}</p>
            <p><b>Mobile Number :- </b>{{ $item->mobile }}</p>
            <p><b>Address :- </b> {{ $item->address }}</p>

            @if ($item->co_producer_is == 1)
                <p><b>Whether the Individual is an Indian
                        National :- </b>Yes</p>
            @else
                <p><b>Whether the company(s) is registered
                        as an Indian Entity, Mention (In accordance with clause
                        6.2.2) :- </b>No</p>
            @endif

            @if ($item->is_indian_entity == 1)
                <p><b>Attach Photo ID issued by the Govt.
                        of India (for Indian National):</b></p>
                <span style="color: rgb(13, 28, 158)">{{ $item->documents_name }}</span>
            @else
                <p><b>Attach copy of Passport :- </b> <span
                        style="color: rgb(13, 28, 158)">{{ $item->documents_name1 }}</span></p>
            @endif

            @if ($item->co_producer_is == 2)
                <p><b>Registration Details :- </b>{{ $item->registration_details }}</p>
                <p><b>The name of the Producer along with
                        Co-Producers(s), if any, who is to be credited in the
                        Certificate:</b> {{ $item->name_of_producers }}</p>
            @endif
        @endforeach

        <p><b>(b) Whether the Indian and Foreign right holder is
                same :- </b> {{ $ipForm->whether_indian_foreign_right_holder_same ? 'Yes' : 'No' }}</p>


        @if ($ipForm->whether_indian_foreign_right_holder_same == 0)
            @if ($ipForm->right_holder_name)
                <p><b>(i) Name :- </b> {{ $ipForm->right_holder_name }}</p>
            @endif
            <p><b>(ii) E-mail :- </b> {{ $ipForm->right_holder_email }}</p>

            @if ($ipForm->right_holder_landline)
                <p><b>(iii) Landline :- </b>{{ $ipForm->right_holder_landline }}</p>
            @endif
            <p><b>(iv) Mobile :- </b> {{ $ipForm->right_holder_mobile }}</p>
            <p><b>(v) Address :- </b>{{ $ipForm->right_holder_address }}</p>
        @endif

        <!-- Director(s) Details -->
        <h3> Director(s) Details</h3>
        @foreach ($IpDirector as $index => $item)
            <p>({{ $index + 1 }}) Director Details</p>
            <p><b>(a) Name :- </b> {{ $item->name }}</p>
            <p><b>(b) E-mail :- </b> {{ $item->email }}</p>
            <p><b>(c) Landline :- </b> {{ $item->landline }}</p>
            <p><b>(d) Mobile :- </b> {{ $item->mobile }}</p>
            <p><b>(e) Website :- </b>{{ $item->website }}</p>
            <p><b>(f) Address :- </b> {{ $item->address }}</p>
            <p><b>(g) Indian National :- </b>{{ $item->indian_nationality ? 'Yes' : 'No' }}</p>
            <p><b>(h) Upload Your File in PDF Format Only:</b></p>
        @endforeach
        <!-- Crew Details -->
        <h3> Crew Details</h3>

        <p><b>(a) Story Writer/ Author :- </b> {{ $ipForm->story_write_aurthor }}</p>

        <p><b>(b) Screenplay/ Script Writer :- </b> {{ $ipForm->screenplay_script_write }}</p>

        <p><b>(c) Director of Photography :-</b> {{ $ipForm->director_of_photography }}</p>

        <p><b>(d) Editor :- </b> {{ $ipForm->editor }}</p>

        <p><b>(e) Art Director :- </b> {{ $ipForm->art_director }}</p>

        <p><b>(f) Costume Designer :- </b> {{ $ipForm->costume_designer }}</p>

        <p><b>(g) Music Director :- </b> {{ $ipForm->music_director }}</p>

        <p><b>(h) Sound Recordist :- </b> {{ $ipForm->sound_recordist }}</p>

        <p><b>(i) Sound Re-recordist (Optional) :- </b> {{ $ipForm->sound_re_recordist }}</p>

        <p><b>(j) Principal Cast :- </b> {{ $ipForm->principal_cast }}</p>

        <p><b>(k) Duration/Running time (in minutes) :- </b> {{ $ipForm->duration_running_time }}</p>

        <p><b>(l) No. of DCP/Blu-ray (Optional) :- </b> {{ $ipForm->no_of_dcp_blueray }}</p>

        <p><b>(m) Colour or B&W :- </b> {{ $ipForm->color_b_w }}</p>

        <p><b>(n) Aspect Ratio :- </b> {{ $ipForm->aspect_ratio }}</p>

        <p><b>(o) Sound System :- </b> {{ $ipForm->sound_system }}</p>

        <!-- Panel 9: CBFC Certification -->

        <h3> CBFC Certification</h3>

        <p><b>Whether the Film is certified by CBFC or
                uncensored:</b>{{ $ipForm->film_is_certified_by_cbfc_or_uncensored == 1 ? 'Certified by CBFC' : 'Uncensored' }}
        </p>

        @if ($ipForm->film_is_certified_by_cbfc_or_uncensored == 1)
            <!-- Certified by CBFC -->
            <p><b>(a) Date of CBFC
                    certificate:</b>{{ \Carbon\Carbon::parse($ipForm->date_of_cbfc_certificate)->format('d-m-Y') }}
            </p>

            <p><b>(b) Certification No:</b>{{ $ipForm->certificate_no }}
            </p>

            <p><b>(c) Attach Copy Of CBFC Certificate:</b></p>
        @else
            <!-- Not Certified by CBFC -->
            <p><b>(a) Date of Completion of Production:</b>
                {{ \Carbon\Carbon::parse($ipForm->date_of_completion_production)->format('d-m-Y') }}
            </p>
            <p><b>(b) Attach Copy Of Declaration As per Clause
                    (7.2(C)):</b>
            </p>
        @endif


        <!-- Panel 10: Other Details -->

        <h3> Other Details</h3>
        <p>
            <b>A. Whether the Film has been completed during the last 12
                months preceding the festival i.e 1st August, 2023 to 31st July, 2024:</b>
            {{ $ipForm->film_comletion_during_12month ? 'Yes' : 'No' }}
        </p>

        <p>
            <b>B. Whether the Film has been screened in any Indian or
                International Film Festival:</b>
            {{ $ipForm->film_screened ? 'Yes' : 'No' }}
        </p>

        @if ($ipForm->film_screened == 1)
            @foreach ($IpInternationalFilmFestival as $index => $item)
                <p>({{ $index + 1 }}) Festival Details</p>
                <p>
                    <b>Name of the festival:</b>
                    {{ $item->name_of_festival }}
                </p>
                <p>
                    <b>Address of the Festival:</b>
                    {{ $item->address_of_festival }}
                </p>
                <p>
                    <b>Date of the Festival:</b>
                    {{ \Carbon\Carbon::parse($item->date_of_festival)->format('d-m-Y') }}
                </p>
            @endforeach
        @endif

        <p>
            <b>C. Whether the Film has been shown/broadcasted on the
                Internet/TV or other media:</b>
            {{ $ipForm->film_broadcast_tv ? 'Yes' : 'No' }}
        </p>

        <p>
            <b>D. Whether the Film has been screened commercially inside
                India:</b>
            {{ $ipForm->film_screened_inside_india == 1 ? 'Yes' : 'No' }}
        </p>

        @if ($ipForm->film_screened_inside_india == 1)
            <p>
                <b>Date Of Release:</b>
                {{ \Carbon\Carbon::parse($ipForm->date_of_release)->format('d-m-Y') }}
            </p>
        @endif

        <p>
            <b>E. Whether Film has been screened commercially outside
                India:</b>
            {{ $ipForm->film_screened_outside_india ? 'Yes' : 'No' }}
        </p>

        @if ($ipForm->film_screened_outside_india == 1)
            @foreach ($IpCommerciallyOutsideIndia as $index => $item)
                <p>
                    <b>({{ $index + 1 }}) Name of the
                        Country:</b>
                    {{ $item->country }}
                </p>
                <p>
                    <b>Release Date:</b>
                    {{ \Carbon\Carbon::parse($item->release_date)->format('d-m-Y') }}
                </p>
            @endforeach
        @endif

        <p>
            <b>F. Whether Film has participated in any International
                Competition:</b>
            {{ $ipForm->film_participated_compentitaion ? 'Yes' : 'No' }}
        </p>

        @if ($ipForm->film_participated_compentitaion == 1)
            @foreach ($IpInternationalCompetition as $index => $item)
                <p>
                    <b>({{ $index + 1 }}) Name of the
                        festival:</b>
                    {{ $item->name }}
                </p>
            @endforeach
        @endif

        <p>
            <b>G. Whether, it is Director's Debut Film:</b>
            {{ $ipForm->is_directore_debute_film ? 'Yes' : 'No' }}
        </p>

        <p>
            <b>H. Whether Film's distribution is limited to India only:</b>
            {{ $ipForm->film_distribution_limited_to_india_only ? 'Yes' : 'No' }}
        </p>

        @foreach ($IpAward as $index => $item)
            <p>
                <b>({{ $index + 1 }}) Details of the Awards
                    won(if any):</b>
                {{ $item->details }}
            </p>
        @endforeach



        <!-- Panel 11: Documents -->

        <h3> Documents (For Feature Film and Non-Feature
            Film)</h3>

        <p>
            <b>A. Upload Documents:</b>
        </p>

        <p>
            <b>(a) Authorisation Letter in Favour Of NFDC (FORM I.P.-11) in PDF:</b>
            @php
                $document = $documents->where('type', 5)->first();
            @endphp
            @if ($document)
                <span style="color: rgb(13, 28, 158)">{{ $document->name }}</span>
            @else
                <p>No document available for download.</p>
            @endif

        </p>

        <p>
            <b>(b) Declaration Letter (As Per The Clause No 7.2(C)) in
                PDF:</b>
            @php
                $document = $documents->where('type', 6)->first();
            @endphp
            @if ($document)
                <span style="color: rgb(13, 28, 158)">{{ $document->name }}</span>
            @else
                <p>No document available for download.</p>
            @endif
        </p>

        <p>
            <b>(c) Synopsis in English (Not Exceeding 200 Words) In
                PDF:</b>
            @php
                $document = $documents->where('type', 7)->first();
            @endphp

            @if ($document)
                <span style="color: rgb(13, 28, 158)">{{ $document->name }}</span>
            @else
                <p>No document of this type is available for download.</p>
            @endif

        </p>

        <p>
            <b>(d) Director's Profile (Not Exceeding 100 words) & Note (Not
                Exceeding 30 words) In Doc Format:</b>
            @php
                $document = $documents->where('type', 8)->first();
            @endphp

            @if ($document)
                <span style="color: rgb(13, 28, 158)">{{ $document->name }}</span>
            @else
                <p>No document of this type is available for download.</p>
            @endif

        </p>

        <p>
            <b>(e) Producer's Profile (Not Exceeding 100 words) In Doc
                Format:</b>
            @php
                $document = $documents->where('type', 9)->first();
            @endphp

            @if ($document)
                <span style="color: rgb(13, 28, 158)">{{ $document->name }}</span>
            @else
                <p>No document of this type is available for download.</p>
            @endif

        </p>

        <p>
            <b>(f) Details Of Cast & Crew In Doc Format:</b>
            @php
                $document = $documents->where('type', 10)->first();
            @endphp

            @if ($document)
                <span style="color: rgb(13, 28, 158)">{{ $document->name }}</span>
            @else
                <p>No document of this type is available for download.</p>
            @endif

        </p>

        <p>
            <b>B. Following must be mailed to <span
                    style="color: #AD4172; font-weight: 800;">indianpanorama@nfdcindia.com:</b></b>
        </p>

        <p>
            <b>A: Film stills (5 nos.), 200-300 dpi<sup class="text-danger">*</sup></b>
        </p>
        <p>
            <b>B: Director(s) working stills (2 nos.), 200-300 dpi<sup class="text-danger">*</sup></b>
        </p>
        <p>
            <b>C: Producer(s) still or logo, 200-300 dpi<sup class="text-danger">*</sup></b>
        </p>
        <p>
            <b>D: Posters<sup class="text-danger">*</sup></b>
        </p>

        <p>
            <b>Whether the requisite documents - (A) (B) (C) & (D) are sent by
                email:</b>
        </p>

    </div>
</body>

</html>
