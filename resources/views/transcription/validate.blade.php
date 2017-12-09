@extends('transcription.layout.main')

@section('title', 'Prototype - Audio')

@section('additional_stylesheet')
    <link rel="stylesheet" href="{{ asset('assets/css/plyr.css') }}">
@endsection

@section('content')
    <div class="container" style="margin-top: 20px;">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-md-8 col-sm-10">
                        <div class="alert alert-warning alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true"><i class="fal fa-times"></i></span>
                                <span class="sr-only">Хаах</span>
                            </button>
                            <strong>Санамж!</strong> Cum ratione volare, omnes fideses aperto bi-color, fidelis amicitiaes.
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Файл - audio2.wav</h4>
                                <!--<h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>-->
                                <!--<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>-->
                                <!--<a href="#" class="card-link">Card link</a>-->
                                <!--<a href="#" class="card-link">Another link</a>-->
                                <audio data-plyr='{ "autoplay":true }' controls>
                                    <source src="{{ asset('audio_files/agent-9009-1468979090-74251.wav') }}" type="audio/mp3">
                                    <!--<source src="/path/to/audio.ogg" type="audio/ogg">-->
                                </audio>
                                <div class="alert alert-info">Peregrinationes saepe ducunt ad nobilis historia.</div>
                                <form>
                                    {{ csrf_field() }}
                                    <div class="text-center">
                                        <button type="submit" name="validation" value="d" class="btn btn-raised btn-danger" data-toggle="tooltip" data-placement="top" title="Аудио файлд ярьж буй яриа болон бичвэртэй таарахгүй байна"><i class="far fa-times"></i> Зөвшөөрөхгүй</button>
                                        <button type="submit" name="validation" value="a" class="btn btn-raised btn-success" data-toggle="tooltip" data-placement="top" title="Аудио файлд ярьж буй яриа, бичвэр хоёр тохирч байна"><i class="far fa-check"></i> Зөвшөөрөх</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--<div class="col-lg-4 col-md-4 col-sm-10">-->
                    <!---->
                    <!--</div>-->
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    <script src="{{ asset('assets/js/plyr.js') }}"></script>
    <script>
        $(document).ready(function() {
            plyr.setup();
        });
    </script>
@endsection