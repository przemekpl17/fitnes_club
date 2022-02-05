@extends('layouts.app')

@section('content')
    <script src="https://cdn.tiny.cloud/1/t9v2ji60nrrp2j9a591rebjtz2fw58nzi7sug37dkh667c2h/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script type="text/javascript">
        tinymce.init({
            selector: 'textarea.tinymce-editor',
            height: 500,
            menubar: false,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount'
            ],
            toolbar: 'undo redo | formatselect | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help',
            content_css: '//www.tiny.cloud/css/codepen.min.css'
        });
    </script>

    <a href="/articlesList" class="btn btn-primary">Powrót</a>
    {!! Form::open(['action' => 'AdminController@createArticle', 'method' => 'POST', 'files' => true]) !!}

    <div class="form-row">
        <div class="form-group col-md-12">
            {{Form::label('title', 'Tytuł artykułu')}}
            {{Form::text('title','', ['class' => 'form-control', 'placeholder' => 'tytuł'])}}
        </div>

        <div class="form-group col-md-12">
            {{Form::label('title', 'Dodaj zdjęcia')}}
            {{Form::file('article_id[]',['multiple' => 'multiple'], ['class' => 'form-control'])}}
        </div>

        <div class="form-group col-md-12">
            {{Form::label('title', 'Treść')}}
            {{Form::textarea('description','', ['class' => 'form-control tinymce-editor'])}}
        </div>
    </div>

    {{Form::submit('Utwórz', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}

@endsection
