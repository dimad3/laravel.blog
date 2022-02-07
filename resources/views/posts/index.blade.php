@extends('layouts.layout')

@section('title', "Posts' List")

@section('header')
    @include('layouts.posts-header')
@endsection

@section('content')
    @include('layouts.posts-content')
@endsection

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('row')
    @include('layouts.row1')
@endsection
