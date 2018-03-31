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
                                <form action="{{ route('transcribe.save') }}" id="transcription-form" method="post">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="task_id" class="form-control" value="{{ $task->id }}">
                                    <input type="hidden" name="edit" class="form-control" value="{{ $edit }}">
                                    <textarea class="form-control transcription" id="transcription" name="transcription">{{ old('transcription') }}</textarea>
                                    <br>
                                    <p class="text-center"><strong>БИЧВЭР:</strong> <span id="status" class="text-secondary"><i class="far fa-ban"></i> ШАЛГААГҮЙ</span></p>
                                    <button type="button" class="btn btn-outline-secondary" onclick="clear_transcription()">Арилгах</button>
                                    <button type="button" class="btn btn-outline-secondary" onclick="remove_whitespace_textarea()">Хэрэггүй хоосон зай арилгах</button>
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
            $('#transcription').summernote({
                placeholder: 'Энд бичвэрээ оруулна уу...',
                height: 200,
                minHeight: 200,
                maxHeight: null,
                focus: true,
                toolbar: [
                    ['','']
                ],
                popover: {},
                callbacks: {
                    onKeyup: function(e) {
                        check_rule();
                    }
                }
            });
            $(".note-toolbar").hide();

            $('#transcription-form').submit(function() {
                var value = $('#transcription').summernote('code');
                $('#transcription').summernote('code', remove_whitespace(value));
                check_rule();
                return true;
            });
        });
        function clear_transcription(){
            $('#transcription').summernote('code', '');
            $('#transcription').summernote('focus');
            check_rule();
        }
        function remove_whitespace_textarea(){
            var value = $('#transcription').summernote('code');
            $('#transcription').summernote('code', remove_whitespace(value));
            check_rule();
        }
        function remove_whitespace(value){
            value = value.replace(/&nbsp;|<br>/g, '');
            return value.replace(/<p><\/p>/g, '');
        }
        function check_rule(){
            var value = $('#transcription').summernote('code');
            var pattern = {!! env('TRANSCRIPTION_RULE') !!}g;
            {{--var pattern = {!! substr(env('TRANSCRIPTION_RULE'), 0 ,-1) !!}gu;--}}
            // var pattern = /(^(<p>#D)?[А-Яа-яЁёӨөҮүA-Za-z \\.\\*!\\?,\\.\\(\\)~\\$%#<>\\/-]{1,}$)/gu;
            var res = pattern.test(value);
            var statusElem = $("#status");
            switch(res){
                case true:
                    statusElem.removeClass('text-danger');
                    statusElem.removeClass('text-secondary');
                    statusElem.addClass('text-success');
                    statusElem.html('<i class="far fa-check"></i> ДҮРМИЙН ДАГУУ');
                    break;
                case false:
                    statusElem.removeClass('text-success');
                    statusElem.removeClass('text-secondary');
                    statusElem.addClass('text-danger');
                    statusElem.html('<i class="far fa-times"></i> ДҮРЭМД ТААРАХГҮЙ <p class="text-muted"><strong>Яриаг бичих мөрдлөг</strong>ийн дагуу эсвэл мөрийн эхэнд эсвэл сүүлд хоосон зай авсан эсэхээ шалгаарай.</p>');
                    break;
                default:
                    statusElem.removeClass('text-danger');
                    statusElem.removeClass('text-success');
                    statusElem.addClass('text-secondary');
                    statusElem.html('<i class="far fa-ban"></i> ШАЛГААГҮЙ');
                    break;
            }
        }
    </script>
@endsection