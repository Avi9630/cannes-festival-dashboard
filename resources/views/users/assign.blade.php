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

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Assign View</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-warning" href="{{ route('users.index') }}"> Back</a><br><br>
            </div>
        </div>
    </div>

    <section class="section">
        
        <div class="row">

            <div class="col-lg-12">
    
                <div class="card">

                    <div class="card-body">
        
                        <form action="{{ url('post_assign_role',$user->id) }}" method="POST"  class="row g-3"> @csrf @method('POST')
                            {{-- {!! Form::open(['route' => 'users.assign','method'=>'POST']) !!} @csrf @method('POST') --}}
                            <div class="row gy-4">
                                <div class="col-md-6">
                                    <input type="text" name="usertype" class="form-control " value="{{ $user->usertype == 1 ? 'ADMIN' : ($user->usertype == 2 ? 'CORPORATE' : ($user->usertype == 3 ? 'USER' : ($user->usertype == 4 ? 'MOBILE-USER' : NULL)))}}" readonly>
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
</main>
@endsection