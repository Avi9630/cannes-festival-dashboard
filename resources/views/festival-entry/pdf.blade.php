<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PDF</title>
    <style type="text/css">
        body {
            font-family: 'arial';
            font-size: 14px;
        }

        .list-group-item {
            border-bottom: solid 1px #ddd;
            padding-bottom: 5px;
            margin-top: 5px;
            width: 100%;
            display: inline-block;
            font-size: 14px;
        }

        .noborder {
            border-bottom: none;
            margin-bottom: 0px;
        }

        .box {
            margin-bottom: 15px;
            width: 100%;
            display: inline-block;
            font-size: 14px;
        }

        .w-60 {
            width: 60%;
            float: left;
            padding: 0;
            margin: 0;
        }

        .w-40 {
            width: 40%;
            float: left;
            padding: 0;
            margin: 0;
        }
    </style>
</head>

<body>
    <div class="box">
        <h4 style="text-align: center">{{ $title ?? '' }} || {{ $date ?? '' }}</h4>
        <div style="background:#FFF;">

            {{-- GENRAL --}}
            <div class="card-header"
                style="background: #000; 
                color:#ffffff; 
                font-size: 16px; 
                font-weight: 600; 
                padding: 10px 15px; 
                border-radius: 5px 5px 0px 0px;">
                GENRAL
            </div>
            <div
                style="font-size: 15px;  
                padding: 10px 15px; 
                border-radius: 0px 0px 5px 5px ; 
                border: solid 1px #ddd; 
                margin-bottom:10px;">

                <div class="list-group-item w-40">
                    <b>Film Title (Roman script) : </b>
                    {{ $nfaFeatures->film_title_roman ?? '' }}
                </div>

                <div class="list-group-item w-60">
                    <b>Film Title (Devnagri) : </b>
                    {{ $nfaFeatures->film_title_devnagri ?? '' }}
                </div>

                <div class="list-group-item">
                    <b>Film Title (English translation of the film title) : </b>
                    {{ $nfaFeatures->film_title_devnagri ?? '' }}
                </div>

                <div class="list-group-item">
                    <b>Language (Please mention if the film has no dialogues) : </b>
                    {{ $nfaFeatures->language ?? '' }}
                </div>

                <div class="list-group-item w-40">
                    <b>English subtitled : </b>
                    {{ $nfaFeatures->english_subtitle === 1 ? 'Yes' : 'No' }}
                </div>

                <div class="list-group-item w-60">
                    <b>Director Debut : </b>
                    {{ $nfaFeatures->director_debut === 1 ? 'Yes' : 'No' }}
                </div>

                <div class="list-group-item w-40">
                    <b>No. of Reels/Tapes: </b>
                    {{ $nfaFeatures->nom_reels_tapes ?? '' }}
                </div>

                <div class="list-group-item w-60">
                    <b>Aspect ratio: </b>
                    {{ $nfaFeatures->aspect_ratio ?? '' }}
                </div>

                <div class="list-group-item w-40">
                    <b>Format: </b>
                    {{ $nfaFeatures->format ? 'Yes' : 'No' }}
                </div>

                <div class="list-group-item w-40">
                    <b>Sound system: </b>
                    {{ $nfaFeatures->sound_system ? 'Yes' : 'No' }}
                </div>

                <div class="list-group-item w-60">
                    <b>Running Time(mns): </b>
                    {{ $nfaFeatures->running_time ?? '' }}
                </div>

                <div class="list-group-item w-40">
                    <b>Color/Black & White: </b>
                    {{ $nfaFeatures->color_bw ? 'Yes' : 'No' }}
                </div>

                <div class="list-group-item w-60 noborder">
                    <b>Film synopsis: </b>
                    {{ $nfaFeatures->film_synopsis ?? '' }}
                </div>
            </div>

            {{-- CENSOR --}}
            <div class="card-header"
                style="background: #000; color:#ffffff; font-size: 16px; font-weight: 600; padding: 10px 15px; border-radius: 5px 5px 0px 0px;">
                CENSOR
            </div>
            <div
                style=" font-size: 15px;  padding: 10px 15px; border-radius: 0px 0px 5px 5px ; border: solid 1px #ddd; margin-bottom:10px;">
                <div class="list-group-item">
                    <b>Censor Certificate Number : </b>
                    {{ $nfaFeatures->censor_certificate_nom ?? '' }}
                </div>

                <div class="list-group-item w-40">
                    <b>Censor Certificate Date : </b>
                    {{ $nfaFeatures->censor_certificate_date ?? '' }}
                </div>

                <div class="list-group-item w-60 noborder">
                    <b>Censor Certificate File : </b>
                    @empty(!$nfaFeatures->censor_certificate_file)
                        <a
                            href="{{ 'http://localhost/NFA/api/download-file/NFA/' . $nfaFeatures->documents->where('document_type', 1)->first()->file }}">
                            {{ $nfaFeatures->censor_certificate_file ?? '' }}
                        </a>
                    @endempty
                </div>
            </div>

            {{-- COMPANY REGISTRATION & PAYMENT --}}
            <div class="card-header"
                style="background: #000; color:#ffffff; font-size: 16px; font-weight: 600; padding: 10px 15px; border-radius: 5px 5px 0px 0px;">
                COMPANY REGISTRATION & PAYMENT
            </div>
            <div
                style=" font-size: 15px;  padding: 10px 15px; border-radius: 0px 0px 5px 5px ; border: solid 1px #ddd; margin-bottom:10px;">
                <div class="list-group-item">
                    <b>Title Registration Details : </b>
                    {{ $nfaFeatures->title_registratin_detils ?? '' }}
                </div>

                <div class="list-group-item">
                    <b>Company Registration Details : </b>
                    {{ $nfaFeatures->company_reg_details ?? '' }}
                </div>

                <div class="list-group-item noborder">
                    <b>Company Registration Doc : </b>
                    @empty(!$nfaFeatures->company_reg_doc)
                        <a
                            href="{{ 'http://localhost/NFA/api/download-file/NFA/' . $nfaFeatures->documents->where('document_type', 2)->first()->file }}">
                            {{ $nfaFeatures->company_reg_doc ?? '' }}
                        </a>
                    @endempty
                </div>
            </div>

            {{-- PRODUCER --}}
            <div class="card-header"
                style="background: #000; 
                color:#ffffff; 
                font-size: 16px; 
                font-weight: 600; 
                padding: 10px 15px; 
                border-radius: 5px 5px 0px 0px;
                ">
                PRODUCER
            </div>
            <div
                style="
                        font-size: 15px;  
                        padding: 10px 15px; 
                        border-radius: 0px 0px 5px 5px ; 
                        border: solid 1px #ddd;
                        margin-bottom:10px;
                        ">
                @foreach ($producers as $producer)
                    <div
                        style="background:#ddd; 
                                margin-bottom:10px; 
                                border-bottom :solid 2px #fff ; 
                                padding:15px;">

                        <div class="list-group-item w-60 ">
                            <b>Whether indian national : </b>
                            {{ $producer->indian_national === 1 ? 'Yes' : 'No' }}
                        </div>

                        <div class="list-group-item w-40">
                            <b>Producer Name : </b>
                            {{ $producer->name ?? '' }}
                        </div>

                        <div class="list-group-item w-60">
                            <b>Email : </b>
                            {{ $producer->email ?? '' }}
                        </div>

                        <div class="list-group-item w-40">
                            <b>Contact No. : </b>
                            {{ $producer->contact_nom ?? '' }}
                        </div>

                        <div class="list-group-item w-60">
                            <b>Address : </b>
                            {{ $producer->address ?? '' }}
                        </div>

                        <div class="list-group-item w-40">
                            <b>Pincode : </b>
                            {{ $producer->pincode ?? '' }}
                        </div>

                        <div class="list-group-item w-60 ">
                            <b>Self attested Doc : </b>
                            @empty(!$producer->producer_self_attested_doc)
                                <a
                                    href="{{ 'http://localhost/NFA/api/download-file/NFA/' . $producer->featureDocuments->where('document_type', 4)->first()->file }}">
                                    {{ $producer->producer_self_attested_doc ?? '' }}
                                </a>
                            @endempty
                        </div>
                    </div>
                @endforeach

            </div>

            {{-- DIRECTOR --}}
            <div class="card-header"
                style="background: #000; 
                color:#ffffff; 
                font-size: 16px; 
                font-weight: 600; 
                padding: 10px 15px; 
                border-radius: 5px 5px 0px 0px;
                ">
                DIRECTOR
            </div>
            <div
                style="
                        font-size: 15px;  
                        padding: 10px 15px; 
                        border-radius: 0px 0px 5px 5px ; 
                        border: solid 1px #ddd;
                        margin-bottom:10px;
                        ">

                @foreach ($directors as $director)
                    <div
                        style="background:#ddd; 
                            margin-bottom:10px; 
                            border-bottom :solid 2px #fff ; 
                            padding:15px;">

                        <div class="list-group-item w-60 ">
                            <b>Whether indian national : </b>
                            {{ $director->indian_national === 1 ? 'Yes' : 'No' }}
                        </div>

                        <div class="list-group-item w-40">
                            <b>Director Name : </b>
                            {{ $director->name ?? '' }}
                        </div>

                        <div class="list-group-item w-60">
                            <b>Email : </b>
                            {{ $director->email ?? '' }}
                        </div>

                        <div class="list-group-item w-40">
                            <b>Contact No. : </b>
                            {{ $director->contact_nom ?? '' }}
                        </div>

                        <div class="list-group-item w-60">
                            <b>Address : </b>
                            {{ $director->address ?? '' }}
                        </div>

                        <div class="list-group-item w-40">
                            <b>Pincode : </b>
                            {{ $director->pincode ?? '' }}
                        </div>

                        <div class="list-group-item w-60 ">
                            <b>Director Self attested Doc : </b>
                            @empty(!$director->director_self_attested_doc)
                                <a
                                    href="{{ 'http://localhost/NFA/api/download-file/NFA/' . $director->featureDocuments->where('document_type', 5)->first()->file }}">
                                    {{ $director->director_self_attested_doc ?? '' }}
                                </a>
                            @endempty
                        </div>
                    </div>
                @endforeach

            </div>

            {{-- ACTORS --}}
            <div class="card-header"
                style="background: #000; 
                color:#ffffff; 
                font-size: 16px; 
                font-weight: 600; 
                padding: 10px 15px; 
                border-radius: 5px 5px 0px 0px;">
                ACTOR
            </div>
            <div
                style="
                        font-size: 15px;  
                        padding: 10px 15px; 
                        border-radius: 0px 0px 5px 5px ; 
                        border: solid 1px #ddd;
                        margin-bottom:10px;
                        ">

                @foreach ($actors as $actor)
                    <div
                        style="background:#ddd; 
                            margin-bottom:10px; 
                            border-bottom :solid 2px #fff ; 
                            padding:15px;">

                        <div class="list-group-item w-60 ">
                            <b>Category : </b>
                            {{ $actor->actor_category_id ?? '' }}
                        </div>

                        <div class="list-group-item w-40">
                            <b>Actor Name : </b>
                            {{ $actor->name ?? '' }}
                        </div>

                        <div class="list-group-item w-60">
                            <b>Screen Name : </b>
                            {{ $actor->screen_name ?? '' }}
                        </div>

                        <div class="list-group-item w-40">
                            <b>Voice dubbed : </b>
                            {{ $actor->if_voice_dubbed === 1 ? 'Yes' : '' }}
                        </div>

                    </div>
                @endforeach

            </div>

            {{-- SONGS --}}
            <div class="card-header"
                style="background: #000; color:#ffffff; font-size: 16px; font-weight: 600; padding: 10px 15px; border-radius: 5px 5px 0px 0px;">
                SONGS
            </div>
            <div
                style="
                        font-size: 15px;  
                        padding: 10px 15px; 
                        border-radius: 0px 0px 5px 5px ; 
                        border: solid 1px #ddd;
                        margin-bottom:10px;
                        ">

                @foreach ($songs as $song)
                    <div
                        style="background:#ddd; 
                            margin-bottom:10px; 
                            border-bottom :solid 2px #fff ; 
                            padding:15px;">

                        <div class="list-group-item w-60 ">
                            <b>Song Title : </b>
                            {{ $song->song_title ?? '' }}
                        </div>

                        <div class="list-group-item w-60 ">
                            <b>Music Director : </b>
                            {{ $song->music_director ?? '' }}
                        </div>

                        <div class="list-group-item w-60 ">
                            <b>Music Director Background Music : </b>
                            {{ $song->music_director_bkgd_music ?? '' }}
                        </div>

                        <div class="list-group-item w-60 ">
                            <b>Lyricist : </b>
                            {{ $song->lyricist ?? '' }}
                        </div>

                        <div class="list-group-item w-60 ">
                            <b>Playback Singer Male : </b>
                            {{ $song->playback_singer_male ?? '' }}
                        </div>

                        <div class="list-group-item w-60 ">
                            <b>Playback Singer Female : </b>
                            {{ $song->playback_singer_female ?? '' }}
                        </div>
                    </div>
                @endforeach

            </div>

            {{-- AUDIOGRAPHER --}}
            <div class="card-header"
                style="background: #000; color:#ffffff; font-size: 16px; font-weight: 600; padding: 10px 15px; border-radius: 5px 5px 0px 0px;">
                AUDIOGRAPHER
            </div>
            <div
                style="
                        font-size: 15px;  
                        padding: 10px 15px; 
                        border-radius: 0px 0px 5px 5px ; 
                        border: solid 1px #ddd;
                        margin-bottom:10px;
                        ">

                @foreach ($audiographers as $audiographer)
                    <div
                        style="background:#ddd; 
                            margin-bottom:10px; 
                            border-bottom :solid 2px #fff ; 
                            padding:15px;">

                        <div class="list-group-item w-60 ">
                            <b>Production Sound Recordist (Location/Sync Sound): </b>
                            {{ $audiographer->production_sound_recordist ?? '' }}
                        </div>

                        <div class="list-group-item w-60 ">
                            <b>Sound Designer: </b>
                            {{ $audiographer->sound_designer ?? '' }}
                        </div>

                        <div class="list-group-item w-60 ">
                            <b>Re-recordist of the Final Mixed Track: </b>
                            {{ $audiographer->re_recordist_filnal ?? '' }}
                        </div>
                    </div>
                @endforeach

            </div>

            {{-- OTHER --}}
            <div class="card-header"
                style="background: #000; 
                        color:#ffffff; 
                        font-size: 16px; 
                        font-weight: 600; 
                        padding: 10px 15px; 
                        border-radius: 5px 5px 0px 0px;">
                OTHER
            </div>
            <div
                style="font-size: 15px;  
                        padding: 10px 15px; 
                        border-radius: 0px 0px 5px 5px ; 
                        border: solid 1px #ddd;">

                <p><strong>Screenplay Writer</strong></p>

                <div class="list-group-item">
                    <b>Name of original screenplay : </b>
                    {{ $nfaFeatures->original_screenplay_name ?? '' }}
                </div>

                <div class="list-group-item">
                    <b>Name of adapted screenplay : </b>
                    {{ $nfaFeatures->adapted_screenplay_name ?? '' }}
                </div>

                <p>Note :- For adapted screenplay, Please mention/submit the following (!)(!!)(!!!)</p>

                <div class="list-group-item">
                    <ol type="I">
                        <li>
                            <b>Name of story writer :</b>
                            {{ $nfaFeatures->story_writer_name ?? '' }}
                        </li>
                        <li>
                            <b>Whther the work is under public domain</b>
                            {{ $nfaFeatures->work_under_public_domain ? 'Yes' : 'No' }}
                        </li>
                        <li>
                            <b>A copy of original work</b>
                            @empty(!$nfaFeatures->original_work_copy)
                                <a
                                    href="{{ 'http://localhost/NFA/api/download-file/NFA/' . $nfaFeatures->documents->where('document_type', 3)->first()->file }}">
                                    {{ $nfaFeatures->original_work_copy ?? '' }}
                                </a>
                            @endempty
                        </li>
                    </ol>
                </div>

                <div class="list-group-item">
                    <b>Dialogues : </b>
                    {{ $nfaFeatures->dialogue ?? '' }}
                </div>

                <div class="list-group-item">
                    <b>Special effects creator: </b>
                    {{ $nfaFeatures->special_effect_creator ?? '' }}
                </div>

                <div class="list-group-item">
                    <b>Cinemetographer(s): </b>
                    {{ $nfaFeatures->cinemetographer ?? '' }}
                </div>

                <div class="list-group-item">
                    <b>Whether the film was on a shot digital / video format : </b>
                    {{ $nfaFeatures->shot_digital_video_format === 1 ? 'Yes' : 'No' }}
                </div>

                <div class="list-group-item">
                    <b>Editor : </b>
                    {{ $nfaFeatures->editor ?? '' }}
                </div>

                <div class="list-group-item">
                    <b>Production Designer : </b>
                    {{ $nfaFeatures->production_designer ?? '' }}
                </div>

                <div class="list-group-item">
                    <b>Costume Designer : </b>
                    {{ $nfaFeatures->costume_designer ?? '' }}
                </div>

                <div class="list-group-item">
                    <b>Make-Up Director : </b>
                    {{ $nfaFeatures->make_up_director ?? '' }}
                </div>

                <div class="list-group-item">
                    <b>Animator (in case od an animation film) : </b>
                    {{ $nfaFeatures->animator ?? '' }}
                </div>

                <div class="list-group-item">
                    <b>Choreographer (s) : </b>
                    {{ $nfaFeatures->choreographer ?? '' }}
                </div>

                <div class="list-group-item">
                    <b>Stunt Choreographer : </b>
                    {{ $nfaFeatures->stunt_choreographer ?? '' }}
                </div>

                <div class="list-group-item">
                    <b>Music Director (Background score): </b>
                    {{ $nfaFeatures->stunt_choreographer ?? '' }}
                </div>
            </div>

            {{-- RETURN --}}
            <div class="card-header"
                style="background: #000; color:#ffffff; font-size: 16px; font-weight: 600; padding: 10px 15px; border-radius: 5px 5px 0px 0px;">
                RETURN
            </div>
            <div
                style="font-size: 15px;  
                        padding: 10px 15px; 
                        border-radius: 0px 0px 5px 5px ; 
                        border: solid 1px #ddd;">

                <div class="list-group-item w-40">
                    <b>Name : </b>
                    {{ $nfaFeatures->return_name ?? '' }}
                </div>

                <div class="list-group-item w-60">
                    <b>Email : </b>
                    {{ $nfaFeatures->return_email ?? '' }}
                </div>

                <div class="list-group-item w-40">
                    <b>Tele (M) : </b>
                    {{ $nfaFeatures->return_mobile ?? '' }}
                </div>

                <div class="list-group-item w-60">
                    <b>Address : </b>
                    {{ $nfaFeatures->return_address ?? '' }}
                </div>

                <div class="list-group-item w-40">
                    <b>Pincode : </b>
                    {{ $nfaFeatures->return_pincode ?? '' }}
                </div>

                <div class="list-group-item w-60 noborder">
                    <b>Website : </b>
                    {{ $nfaFeatures->return_website ?? '' }}
                </div>
            </div>

        </div>
    </div>
</body>

</html>
