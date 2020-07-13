@extends('layouts.app', [
    'title' => 'Home'
])

@section('content')
    <div class="container" style="padding-top: 5rem;">
        <div class="row">
            @for ($i = 0; $i < 4; $i++)
                <div class="col-lg-3 mb-4">
                    <div class="card">
                        <img src="https://images.unsplash.com/photo-1477862096227-3a1bb3b08330?ixlib=rb-1.2.1&auto=format&fit=crop&w=700&q=60" alt="" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title">Sunset</h5>
                            <p class="card-text">
                                {{ \Str::random(100) }}
                            </p>
                            <a href="" class="btn btn-outline-success btn-sm">Read More</a>
                            <a href="" class="btn btn-outline-danger btn-sm"><i class="far fa-heart"></i></a>
                        </div>
                    </div>
                </div>            
            @endfor
        </div>
    </div>
@endsection