@extends('layouts.app', [
    'title' => 'Home'
])

@section('content')
    <div class="container" style="padding-top: 5rem;">
        <div class="row">
            @foreach ($products as $product)
                <div class="col-lg-3 mb-4">
                    <div class="card">
                        <img src="{{ url('images/products/' . $product->image->filename) }}" alt="" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">
                                {{ $product->description }}
                            </p>
                            <a href="" class="btn btn-outline-success btn-sm">Read More</a>
                            <a href="" class="btn btn-outline-primary btn-sm"><i class="fa fa-cart-plus"></i></a>
                        </div>
                    </div>
                </div>                
            @endforeach
        </div>
    </div>
@endsection