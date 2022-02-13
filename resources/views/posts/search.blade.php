@extends('layouts.layout')

@section('title', "Search for: '$search'")

@section('page-title')
    <div class="page-title db">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                    <h2> Search for: <small class="hidden-xs-down hidden-sm-down">'{{ $search }}'</small></h2>
                </div><!-- end col -->
                <div class="col-lg-4 col-md-4 col-sm-12 hidden-xs-down hidden-sm-down">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Search</li>
                    </ol>
                </div><!-- end col -->
            </div><!-- end row -->
        </div><!-- end container -->
    </div><!-- end page-title -->
@endsection

@section('content')
    @include('layouts.posts-content')
@endsection

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('row')
    @include('layouts.row2')
@endsection
