@extends('transcription.layout.main')

@section('title', 'Prototype - Index')

@section('additional_stylesheet')
    <link rel="stylesheet" href="{{ asset('assets/css/jquery.fileupload.css') }}">
@endsection

@section('content')
    <div class="container" style="margin-top: 20px;">
        <div class="text-center">
            <h2><i class="far fa-music"></i> <i class="far fa-arrow-right"></i> <i class="far fa-font"></i></h2>
        </div>
        <div class="row justify-content-center mt-5">
            <div class="col-md-6 col-sm-8 col-xs-12" id="error" style="display: none">
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                        <span class="sr-only">Хаах</span>
                    </button>
                    Алдаа гарлаа!
                </div>
            </div>
        </div>
        <div class="row justify-content-center mt-5">
            <div class="col-md-6 col-sm-8 col-xs-12">
                <div class="card">
                    <form>
                        {{ csrf_field() }}
                        <div class="card-body">
                            <div id="uploaded-items" class="bg-light" style="height: 200px; overflow-y: scroll;"></div>
                            <hr>
                            <input id="fileupload" type="file" name="audiofile" accept="audio/wav" multiple>
                        </div>
                        <div class="card-footer">
                            <strong><span class="text-info" id="progress-num"></span></strong>
                            <div id="progress" class="progress">
                                <div class="progress-bar progress-bar-success"></div>
                            </div>
                            {{--<button type="submit" class="btn btn-info btn-block btn-raised"><i class="far fa-upload"></i> Хуулах</button>--}}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('additional_scripts')
    <script src="{{ asset('assets/js/jquery.ui.widget.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.fileupload.js') }}"></script>
@endsection
@section('scripts')
    @parent
    <script>
        $(function () {
            $("#error").hide();
            'use strict';
            var url = '{{ route('audio.upload') }}';
            $('#fileupload').fileupload({
                url: url,
                dataType: 'json',
                change: function (e, data) {
                    $("#error").hide();
                },
                done: function (e, data) {
                    if(data.result == false){
                        console.log(data);
                        var item = '<p class="text-danger" style="margin-bottom: 0;">' + data.files[0].name + ' - ' + (data.files[0].size / 1024 / 1024).toFixed(1) + 'MB (*.wav файл байх ёстой)</p>';
                        $("#uploaded-items").append(item);
                    }
                    else {
                        var item = '<p style="margin-bottom: 0;">' + data.result.audiofile.filename + ' - ' + (data.result.audiofile.size / 1024 / 1024).toFixed(1) + 'MB</p>';
                        $("#uploaded-items").append(item);
                    }
                },
                progressall: function (e, data) {
                    var progress = parseInt(data.loaded / data.total * 100, 10);
                    $('#progress .progress-bar').css(
                        'width',
                        progress + '%'
                    );
                    $("#progress-num").html(progress + "%");
                },
                fail: function() {
                    $("#error").show();
                }
            })
                .prop('disabled', !$.support.fileInput)
                .parent().addClass($.support.fileInput ? undefined : 'disabled');
        });
    </script>
@endsection