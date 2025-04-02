@extends('layouts.app')
@section('main')
<main id="main" class="main">

    <div class="pagetitle">
        @foreach (['success', 'info', 'danger', 'warning'] as $msg)
            @if(Session::has($msg))
                <div id="flash-message" class="alert alert-{{ $msg }}" role="alert">
                    {{ Session::get($msg)}}
                </div>
            @endif
        @endforeach
    </div>

    <section class="section">

        <div class="row">

            <div class="col-lg-12">

                <div class="card">

                    <div class="card-body">

                        <h5 class="card-title">Update User Profile</h5>

                        <form action="{{ url('profile_update',[$user->id]) }}" method="POST" enctype="multipart/form-data" class="row g-3"> @csrf @method('POST')

                            <div class="row gy-4">

                                <div class="col-md-6">
                                    <input type="text" name="dob" id="datepicker" class="form-control @error('dob') is-invalid @enderror" placeholder="DOB" value="{{ $user->dob}}" autofocus>
                                    @error('dob')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6 ">
                                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" placeholder="Select your Image">
                                    @error('image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    @if (!is_null($user->image))
                                        <img src="{{ asset('storage/images/')}}/{{$user->image}}" alt="{{$user->name}}" height="90px" width="80px" class="rounded-circle">
                                    @endif
                                </div>

                                <div class="col-md-6">
                                    <input type="text" name="designation" class="form-control @error('designation') is-invalid @enderror" placeholder="Yor designation" value="{{ $user->designation }}">
                                    @error('designation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <input type="text" name="pan_number" class="form-control @error('pan_number') is-invalid @enderror" placeholder="Select Pan Number" value="{{ $user->pan_number }}">
                                    @error('pan_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" placeholder="Address" value="{{ $user->address }}">
                                    @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <select id="state_id" name="state_id" class="form-control @error('state_id') is-invalid @enderror">
                                        <option value="" selected disabled>Select State</option>
                                        @foreach($states as $state)
                                            <option value="{{$state->id}}" @if($state->id == $user->state_id) selected @endif>{{$state->state_name}}</option>
                                        @endforeach
                                    </select>
                                    @error('state_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6">
                                    <select id="city_id" name="city_id" class="form-control @error('city_id') is-invalid @enderror">
                                        <option value="" selected disabled>Select City</option>
                                        @foreach ($cities as $city)
                                            {{-- <option value="{{$city->id}}" @if($city->id == $user->city_id) selected @endif>{{$city->city_name}}</option> --}}
                                            @if ($city->id == $user->city_id)
                                                <option value="{{$city->id}}" selected> {{$city->city_name}} </option>
                                            @else
                                                <option value="{{$city->id}}"> {{$city->city_name}} </option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('city_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <input type="text" name="pincode" class="form-control @error('pincode') is-invalid @enderror" placeholder="Pincode" value="{{ $user->pincode }}">
                                    @error('pincode')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <input type="text" name="gst_number" class="form-control @error('gst_number') is-invalid @enderror" placeholder="Gst-number" value="{{ $user->gst_number }}">
                                    @error('gst_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>

                            </div>

                        </form>

                    </div>
                </div>

            </div>

        </div>

    </section>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.js"></script> 
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.css" rel="stylesheet">
     
    <script>
        $(document).ready(function () {

            $('#state_id').on('change', function () {
                var options = '';
                var state_id = this.value;
                $("#city_id").html('');
                $.ajax({
                    url: "http://127.0.0.1:8000/api/all_cities",
                    type: "POST",
                    data: {
                        state_id: state_id,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (result) {
                        
                        options = '<option value="">Select City</option>';
                        $.each(result.data, function (key, value) {
                            console.log(value);
                            options += `<option value="`+value.id + `">` + value.city_name + `</option>`;
                        });
                        $('#city_id').html(options);
                    }
                });
            });
        });
    </script>

    <script type="text/javascript">
        $('#datepicker').datepicker({
            dateFormat: "yy-mm-dd"
        });
    </script>

</main>
@endsection