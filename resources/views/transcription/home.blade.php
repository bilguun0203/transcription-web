@extends('transcription.layout.main')

@section('title', 'Home')

@section('content')
    <div class="container" style="margin-top: 20px;">
        <div class="text-center">
            <h2><i class="far fa-music"></i> <i class="far fa-arrow-right"></i> <i class="far fa-font"></i></h2>
        </div>
        @foreach($errors->all() as $error)
            <div class="row justify-content-center mt-5">
                <div class="col-md-6 col-sm-8 col-xs-12">
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true"><i class="fal fa-times"></i></span>
                            <span class="sr-only">Хаах</span>
                        </button>
                        {{ $error }}
                    </div>
                </div>
            </div>
        @endforeach
        @if(session('msg'))
        <div class="row justify-content-center mt-5">
            <div class="col-md-6 col-sm-8 col-xs-12">
                <div class="alert alert-info">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                        <span class="sr-only">Хаах</span>
                    </button>
                    {{ session('msg') }}
                </div>
            </div>
        </div>
        @endif

        <div class="row justify-content-center mt-5">
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-8">
                <div class="card">
                    <div class="card-body">
                        <p>Аудио файл дахь яриаг бичвэр болгох.</p>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('transcribe') }}" class="btn btn-info btn-block btn-raised"><i class="far fa-pencil"></i> Бичвэрт буулгах</a>
                    </div>
                </div>
            </div>
            @auth
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-8">
                <div class="card">
                    <div class="card-header">
                        Тоон үзүүлэлт
                    </div>
                    <div class="card-body">
                        <h6>Миний бичвэр болгосон</h6>
                        <ul>
                            <li>Нийт: {{ $statust['a'] + $statust['d'] + $statust['p'] }}</li>
                            <li>Зөвшөөрөгдсөн: {{ $statust['a'] }}</li>
                            <li>Зөвшөөрөөгүй: {{ $statust['d'] }}</li>
                            <li>Хүлээгдэж байгаа: {{ $statust['p'] }}</li>
                            <li><strong>Оноо:</strong> {{ Auth::user()->score()['transcribe'] }}</li>
                        </ul>
                        <h6>Миний шалгасан</h6>
                        <ul>
                            <li>Нийт: {{ $statusv['a'] + $statusv['d'] }}</li>
                            <li>Зөв: {{ $statusv['a'] }}</li>
                            <li>Буруу: {{ $statusv['d'] }}</li>
                            <li><strong>Оноо:</strong> {{ Auth::user()->score()['validate'] }}</li>
                        </ul>
                        <h6>Нийт оноо: {{ Auth::user()->score()['transcribe'] + Auth::user()->score()['validate'] }}</h6>
                    </div>
                </div>
            </div>
            @endauth
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-8">
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
        <div class="row justify-content-center mt-5">
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-8">
                <div class="card">
                    <div class="card-body">
                        <p>Аудио файлын бичвэрийг засах.</p>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('edit_transcription') }}" class="btn btn-primary btn-block btn-raised"><i class="far fa-pencil"></i> Бичвэр засах</a>
                    </div>
                </div>
            </div>
        </div>
        @auth
            @if(Auth::user()->isAdmin())
                <hr>
                <div class="text-center">
                    <h2>Удирдах хэсэг</h2>
                </div>
                <div class="row justify-content-center mt-5">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-8">
                        <div class="card">
                            <div class="card-body">
                                <p>Бүх аудио файлуудыг удирдах.</p>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('audio.list') }}" class="btn btn-primary btn-block btn-raised"><i class="far fa-file-audio"></i> Аудио файлууд</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-8">
                        <div class="card">
                            <div class="card-body">
                                <p>Шинэ аудио файл нэмэх.</p>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('audio.upload') }}" class="btn btn-info btn-block btn-raised"><i class="far fa-upload"></i> Файл нэмэх</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-8">
                        <div class="card">
                            <div class="card-body">
                                <p>Хэрэглэгчдийн жагсаалт.</p>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('user.list') }}" class="btn btn-warning btn-block btn-raised"><i class="far fa-users"></i> Хэрэглэгчид</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endauth
    </div>
@endsection