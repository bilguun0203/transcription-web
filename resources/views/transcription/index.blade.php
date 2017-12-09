@extends('transcription.layout.main')

@section('title', 'Prototype - Index')

@section('content')
    <div class="container" style="margin-top: 20px;">
        <div class="text-center">
            <h2><i class="far fa-music"></i> <i class="far fa-arrow-right"></i> <i class="far fa-font"></i></h2>
        </div>
        <div class="row justify-content-center mt-5">
            <div class="col-md-3 col-sm-4 col-xs-6">
                <div class="card">
                    <div class="card-body">
                        <p>Аудио файл дахь яриаг бичвэр болгох.</p>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('transcribe') }}" class="btn btn-info btn-block btn-raised"><i class="far fa-pencil"></i> Бичвэрт буулгах</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-6">
                <div class="card">
                    <div class="card-body">
                        <p>Бичвэр болгосон яриаг сонсож таарч байгаа эсэхийг шалгах.</p>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('validate') }}" class="btn btn-danger btn-block btn-raised"><i class="far fa-check"></i> Шалгах</a>
                    </div>
                </div>
            </div>
        </div>
        @if(Auth::user()->permission == 'admin')
            <hr>
            <div class="text-center">
                <h2>Удирдах хэсэг</h2>
            </div>
            <div class="row justify-content-center mt-5">
                <div class="col-md-3 col-sm-4 col-xs-6">
                    <div class="card">
                        <div class="card-body">
                            <p>Бүх аудио файлуудыг удирдах.</p>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('audio.list') }}" class="btn btn-primary btn-block btn-raised"><i class="far fa-file-audio"></i> Аудио файлууд</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4 col-xs-6">
                    <div class="card">
                        <div class="card-body">
                            <p>Шинэ аудио файл нэмэх.</p>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('audio.upload') }}" class="btn btn-info btn-block btn-raised"><i class="far fa-upload"></i> Файл нэмэх</a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection