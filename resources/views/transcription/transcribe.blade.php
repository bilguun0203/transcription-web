@extends('transcription.layout.main')

@section('title', 'Бичвэрт буулгах - ' . $task->id)

@section('additional_stylesheet')
    <link rel="stylesheet" href="{{ asset('assets/css/plyr.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/summernote-bs4.css') }}">
@endsection

@section('content')
    <div class="container" style="margin-top: 20px;">
        <div class="row">

            @include('transcription._guideline')


            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-md-8 col-sm-10">

                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                                    <span class="sr-only">Хаах</span>
                                </button>
                                {{ $error }}
                            </div>
                        @endforeach
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Даалгавар - {{ $task->id }}</h4>
                                <audio data-plyr='{ "autoplay":true }' controls src="@if($task->audio->isLocal){{ asset($task->audio->url .  $task->audio->file) }}@else{{ $task->audio->url . '/'.$task->audio->file }}@endif" type="audio/wav"></audio>
                                <form action="{{ route('transcribe.save') }}" method="post">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="task_id" class="form-control" value="{{ $task->id }}">
                                    <textarea class="form-control transcription" name="transcription">{{ old('transcription') }}</textarea>
                                    <br>
                                    <button type="button" class="btn btn-outline-secondary" onclick="clear_transcription()">Арилгах</button>
                                    {{--<a href="{{ route('transcribe.skip') }}" class="btn btn-outline-danger">Алгасах <i class="far fa-arrow-right"></i></a>--}}
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
    <script src="{{ asset('assets/js/summernote-bs4.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            plyr.setup();
            $('.transcription').summernote({
                placeholder: 'Энд бичвэрээ оруулна уу...',
                height: 200,
                minHeight: 200,
                maxHeight: null,
                focus: true,
                toolbar: [
                    ['','']
                ],
                popover: {}
            });
            $(".note-toolbar").hide();
        });
        function clear_transcription(){
            $('.transcription').summernote('code', '');
            $('.transcription').summernote('focus');
        }
    </script>
@endsection