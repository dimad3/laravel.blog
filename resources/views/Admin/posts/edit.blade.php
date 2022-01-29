@extends('admin.layouts.layout')


@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Редактирование статьи</h1>
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
    <form method="post" action='{{ route('posts.update', ['post' => $post->id]) }}' enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card-body">
            <div class="form-group">
                <label for="title">Название</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                    value='{{ $post->title }}'>
            </div>

            <div class="form-group">
                <label for='description'>Цитата</label>
                <textarea name='description' id='description'
                    class="form-control @error('description') is-invalid @enderror"
                    rows="2">{{ $post->description }}</textarea>
            </div>

            <div class="form-group">
                <label for='content'>Контент</label>
                <textarea name='content' id='content' class="form-control @error('content') is-invalid @enderror"
                    rows="4">{{ $post->content }}</textarea>
            </div>

            <div class="form-group">
                <label for='category_id'>Категория</label>
                <select name='category_id' id='category_id' class="form-control @error('category_id') is-invalid @enderror">
                    <option value=""></option>
                    @foreach ($categories as $key => $value)
                        <option value="{{ $key }}" @if ($post->category_id === $key) selected @endif>{{ $value }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for='tags'>Теги</label>
                <select name='tags[]' id='tags' class="select2" multiple="multiple" data-placeholder="Выбор тегов"
                    style="width: 100%;">
                    @foreach ($tags as $key => $value)
                        {{-- in_array() function searches an array for a specific value.
                        Syntax: in_array(search, array, type)
                        Parameters:
                        `search Required. Specifies the what to search for
                        `array` Required. Specifies the array to search
                        `type` Optional. If this parameter is set to TRUE, the in_array() function searches for the
                        search-string and specific type in the array.
                        Returns true if needle is found in the array, false otherwise --}}
                        <option value="{{ $key }}" @if (in_array($key, $post->tags->pluck('id')->all())) selected @endif>{{ $value }}</option>
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
                <div><img src="{{ $post->getImage() }}" alt="" class="img-thumbnail mt-2" width="200"></div>
            </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
@endsection
