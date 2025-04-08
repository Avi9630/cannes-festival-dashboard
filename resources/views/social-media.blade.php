@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        {{-- <div class="page-header"></div> --}}
        <div class="row">
            <div class="col-md-7 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="clearfix">
                            <h4 class="card-title float-start">Facebook</h4><br>
                            <div class="fb-page" data-href=" https://www.facebook.com/IFFIGoa/" data-tabs="timeline"
                                data-width="340" data-height="500" data-small-header="false"
                                data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
                                <blockquote cite=" https://www.facebook.com/IFFIGoa/" class="fb-xfbml-parse-ignore">
                                    <a href=" https://www.facebook.com/IFFIGoa/">Facebook</a>
                                </blockquote>
                            </div>
                        </div>
                        <canvas id="visit-sale-chart" class="mt-4"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-7 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="clearfix">
                            <h4 class="card-title float-start">Instagram</h4><br>
                            <blockquote class="instagram-media" data-instgrm-permalink="https://www.instagram.com/iffigoa/"
                                data-instgrm-version="14"
                                style=" background:#21dfc5; border:0; margin: 1px; max-width:540px; padding:0; width:100%;">
                            </blockquote>
                        </div>
                        <canvas id="visit-sale-chart" class="mt-4"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-7 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="clearfix">
                            <h4 class="card-title float-start">Twitter</h4><br>
                            <div style="width: 340px; border: 1px solid #ddd; padding: 10px;">
                                <a class="twitter-timeline" data-width="340" data-height="500"
                                    href="https://twitter.com/iffigoa?ref_src=twsrc%5Etfw">
                                    Tweets by iffigoa
                                </a>
                            </div>
                        </div>
                        <canvas id="visit-sale-chart" class="mt-4"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v15.0">
</script>
<script async src="//www.instagram.com/embed.js"></script>
<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
