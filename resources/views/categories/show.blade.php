@extends('layouts.layout')

@section('title', "Category's posts" )

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
    @include('layouts.row2')
@endsection
