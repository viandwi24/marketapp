@extends('layouts.admin', ['title' => "Dashboard"])

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="alert alert-primary">
                    Welcome Back, <b>{{ auth()->user()->name }}</b>!
                </div>
            </div>
        </div>
    </div>
@stop
