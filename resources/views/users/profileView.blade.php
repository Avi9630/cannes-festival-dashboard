@extends('layouts.app')
@section('main')

    <main id="main" class="main">

        <section class="section">

            <div class="row">
    
                <div class="col-lg-12">
    
                    <div class="card">

                        <div class="card-body">
                            
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                
                                <div class="modal-dialog">

                                    <div class="modal-content">

                                        <div class="modal-body">

                                            <ul>

                                                @if (!empty($user->dob))
                                                    <li>
                                                        <label for="name" class="col-md-4 col-form-label text-md-end text-start"><strong>DOB:</strong></label>
                                                        {{$user->dob}}
                                                    </li>
                                                @endif

                                                @if (!empty($user->designation))
                                                    <li>
                                                        <label for="name" class="col-md-4 col-form-label text-md-end text-start"><strong>Designation:</strong></label>
                                                        {{$user->designation}}
                                                    </li>
                                                @endif

                                                @if (!empty($user->pan_number))
                                                    <li>
                                                        <label for="name" class="col-md-4 col-form-label text-md-end text-start"><strong>Pan-Number:</strong></label>
                                                        {{$user->pan_number}}
                                                    </li>
                                                @endif

                                                @if (!empty($user->address))
                                                    <li>
                                                        <label for="name" class="col-md-4 col-form-label text-md-end text-start"><strong>Address:</strong></label>
                                                        {{$user->address}}
                                                    </li>
                                                @endif
                                                
                                                @if (!empty($user->state_id))
                                                    @foreach ($state as $s)
                                                        @if ($user->state_id == $s->id)
                                                            <li>
                                                                <label for="name" class="col-md-4 col-form-label text-md-end text-start"><strong>State Name:</strong></label>
                                                                {{$s->state_name}}
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                @endif

                                                @foreach ($city as $c)
                                                    @if ($user->city_id == $c->id)
                                                        <li>
                                                            <label for="name" class="col-md-4 col-form-label text-md-end text-start"><strong>City Name:</strong></label>
                                                            {{$c->city_name}}
                                                        </li>                                                    
                                                    @endif
                                                @endforeach
                                                
                                                @if (!empty($user->pincode))
                                                    <li>
                                                        <label for="name" class="col-md-4 col-form-label text-md-end text-start"><strong>Pincode:</strong></label>
                                                        {{$user->pincode}}
                                                    </li>
                                                @endif

                                                @if (!empty($user->gst_number))
                                                    <li>
                                                        <label for="name" class="col-md-4 col-form-label text-md-end text-start"><strong>GST Number:</strong></label>
                                                        {{$user->gst_number}}
                                                    </li>
                                                @endif

                                            </ul>

                                        </div>

                                    </div>

                                </div>

                            </div>
                            
                        </div>

                    </div>

                </div>
    
            </div>
    
        </section>

    </main>

@endsection