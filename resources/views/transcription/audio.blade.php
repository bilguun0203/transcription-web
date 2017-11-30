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
                                <audio controls>
                                    <source src="{{ asset('audio_files/agent-9009-1468979090-74251.wav') }}" type="audio/mp3">
                                    <!--<source src="/path/to/audio.ogg" type="audio/ogg">-->
                                </audio>
                                <form>
                                    <div class="form-group">
                                        <label for="text" class="bmd-label-floating">Text</label>
                                        <input type="text" class="form-control" id="text" required>
                                        <span class="bmd-help">...</span>
                                    </div>
                                    <br>
                                    <a href="#prev" class="btn btn-outline-danger" data-toggle="tooltip" data-placement="top" title="audio1.wav"><i class="far fa-arrow-left"></i> Өмнөх</a>
                                    <a href="#next" class="btn btn-outline-danger" data-toggle="tooltip" data-placement="top" title="audio3.wav">Дараах <i class="far fa-arrow-right"></i></a>
                                    <!--<button type="button" class="btn btn-outline-secondary" onclick="document.getElementById('text').value = '';document.getElementById('text').focus()">Арилгах</button>-->
                                    <div class="float-right">
                                        <button type="submit" class="btn btn-raised btn-info" data-toggle="tooltip" data-placement="top" title="Хадгалаад дараагийн файл руу шилжих"><i class="far fa-save"></i> Хадгалах</button>
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
        plyr.setup();
    </script>
@endsection