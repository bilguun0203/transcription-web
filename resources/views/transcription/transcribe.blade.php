@extends('transcription.layout.main')

@section('title', 'Transcribe - Task ' . $result->id)

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
                        @if($errors->has('task_id'))
                            <div class="alert alert-danger">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                                    <span class="sr-only">Хаах</span>
                                </button>
                                <strong>Алдаа!</strong> {{ $errors->first('task_id') }}
                            </div>
                        @endif
                        @if($errors->has('transcription'))
                            <div class="alert alert-danger">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                                    <span class="sr-only">Хаах</span>
                                </button>
                                <strong>Алдаа!</strong> {{ $errors->first('transcription') }}
                            </div>
                        @endif
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Даалгавар - {{ $result->id }}</h4>
                                <audio data-plyr='{ "autoplay":true }' controls>
                                    <source src="{{ asset($result->audio->file) }}" type="audio/wav">
                                </audio>
                                <form action="{{ route('transcribe.save') }}" method="post">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="task_id" class="form-control" value="{{ $result->id }}">
                                    <div class="form-group">
                                        <label for="transcription" class="bmd-label-floating">Энд бичнэ үү</label>
                                        <textarea class="form-control" rows="3" maxlength="255" id="transcription" name="transcription" required autofocus>{{ old('transcription') }}</textarea>
                                        <span class="bmd-help">Криллээр бичнэ үү.</span>
                                    </div>
                                    <br>
                                    <button type="button" class="btn btn-outline-secondary" onclick="document.getElementById('transcription').value = '';document.getElementById('transcription').focus()">Арилгах</button>
                                    <a href="{{ route('transcribe.skip') }}" class="btn btn-outline-danger">Алгасах <i class="far fa-arrow-right"></i></a>
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
        $(document).ready(function() {
            plyr.setup();
        });
    </script>
@endsection