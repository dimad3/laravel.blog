@extends('admin.layouts.layout')


@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Создать статью</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Blank Page</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    {{-- https://adminlte.io/themes/v3/pages/forms/general.html --}}
    <form method="post" action="{{ route('posts.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="card-body">
            <div class="form-group">
                <label for="title">Название</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                    value="{{ old('title') }}">
            </div>

            <div class="form-group">
                <label for='description'>Цитата</label>
                <textarea name='description' id='description'
                    class="form-control @error('description') is-invalid @enderror" rows="2"
                    placeholder="Цитата ...">{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label for='content'>Контент</label>
                <textarea name='content' id='content' class="form-control @error('content') is-invalid @enderror" rows="4"
                    placeholder="Контент ...">{{ old('content') }}</textarea>
            </div>

            <div class="form-group">
                <label for='category_id'>Категория</label>
                <select name='category_id' id='category_id' class="form-control @error('category_id') is-invalid @enderror">
                    <option value=""></option>
                    @foreach ($categories as $key => $value)
                        <option value="{{ $key }}" {{ old('category_id') == $key ? 'selected' : '' }}>
                            {{ $value }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for='tags'>Теги</label>
                <select name='tags[]' id='tags' class="select2" multiple="multiple" data-placeholder="Выбор тегов"
                    style="width: 100%;">
                    @foreach ($tags as $key => $value)
                        {{-- dd(empty(old('tags'))) --}}
                        @if (old('tags') === null)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @else
                            <option value="{{ $key }}" {{ in_array($key, old('tags')) ? 'selected' : '' }}>
                                {{ $value }}</option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="thumbnail">Изображение</label>
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" name="thumbnail" id="thumbnail" class="custom-file-input">
                        <label class="custom-file-label" for="thumbnail">Choose file</label>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
@endsection
