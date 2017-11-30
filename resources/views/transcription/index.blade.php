@extends('transcription.layout.main')

@section('title', 'Prototype - Index')

@section('content')
    <div class="container" style="margin-top: 20px;">
        <!--<div class="row">-->
        <div class="row justify-content-center mt-5">
            <div class="col-md-5 col-sm-8 col-xs-12">
                <a href="#" class="btn btn-outline-primary btn-block">Нэвтрэх хуудас</a>
                <a href="#" class="btn btn-outline-secondary btn-block">Бүртгүүлэх хуудас</a>
                <a href="{{ route('validation') }}" class="btn btn-outline-info btn-block">Transcribe хийх хуудас</a>
                <a href="{{ route('validation') }}" class="btn btn-outline-danger btn-block">Шалгах хэсэг</a>

                <!-- <div class="card"> -->
                <!-- </div> -->
            </div>
        </div>
        <!--</div>-->
    </div>
@endsection