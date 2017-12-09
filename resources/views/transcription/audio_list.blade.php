@extends('transcription.layout.main')

@section('title', 'Prototype - Validation')

@section('additional_stylesheet')
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plyr.css') }}">
@endsection

@section('content')
    <div class="container" style="margin-top: 20px;">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <!--<div class="row justify-content-center">-->
                <!--<div class="col-lg-12 col-md-8 col-sm-10">-->
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Файлууд /0 - 100/</h4>
                        <!--<h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>-->
                        <!--<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>-->
                        <!--<a href="#" class="card-link">Card link</a>-->
                        <!--<a href="#" class="card-link">Another link</a>-->

                        <div class="table-responsive">
                            <table class="table" id="audio-table">
                                <thead>
                                <tr>
                                    <th style="width: 1%;">#</th>
                                    <th style="width: 25%;">Аудио</th>
                                    <th style="width: 50%;">Бичвэр</th>
                                    <th>Төлөв</th>
                                    <th style="width: 15%;">Үйлдэл</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td scope="row">1</td>
                                    <td>
                                        <audio controls>
                                            <source src="{{ asset('audio_files/agent-9009-1468979090-74251.wav') }}" type="audio_files/mp3">
                                            <!--<source src="/path/to/audio.ogg" type="audio_files/ogg">-->
                                        </audio>
                                    </td>
                                    <td>Domuss sunt fluctuis de altus brodium.</td>
                                    <td><div class="badge badge-danger">Зөвшөөрөөгүй</div></td>
                                    <td>
                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Засах"><i class="far fa-edit"></i></button>
                                        <button type="button" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Зөвшөөрөх"><i class="far fa-check"></i></button>
                                        <button type="button" class="btn btn-danger btn-sm disabled" data-toggle="tooltip" data-placement="top" title="Зөвшөөрөхгүй"><i class="far fa-times"></i></button>
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Устгах"><i class="far fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="row">2</td>
                                    <td>
                                        <audio controls>
                                            <source src="{{ asset('audio_files/agent-9009-1468979090-74251.wav') }}" type="audio_files/mp3">
                                            <!--<source src="/path/to/audio.ogg" type="audio_files/ogg">-->
                                        </audio>
                                    </td>
                                    <td>Ratione de festus victrix, magicae nix!</td>
                                    <td><div class="badge badge-success">Зөвшөөрсөн</div></td>
                                    <td>
                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Засах"><i class="far fa-edit"></i></button>
                                        <button type="button" class="btn btn-success btn-sm disabled" data-toggle="tooltip" data-placement="top" title="Зөвшөөрөх"><i class="far fa-check"></i></button>
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Зөвшөөрөхгүй"><i class="far fa-times"></i></button>
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Устгах"><i class="far fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="row">2</td>
                                    <td>
                                        <audio controls>
                                            <source src="{{ asset('audio_files/agent-9009-1468979090-74251.wav') }}" type="audio_files/mp3">
                                            <!--<source src="/path/to/audio.ogg" type="audio_files/ogg">-->
                                        </audio>
                                    </td>
                                    <td>Ratione de festus victrix, magicae nix!</td>
                                    <td><div class="badge badge-warning">Зөвшөөрөл хүлээж байна</div></td>
                                    <td>
                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Засах"><i class="far fa-edit"></i></button>
                                        <button type="button" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Зөвшөөрөх"><i class="far fa-check"></i></button>
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Зөвшөөрөхгүй"><i class="far fa-times"></i></button>
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Устгах"><i class="far fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="row">2</td>
                                    <td>
                                        <audio controls>
                                            <source src="{{ asset('audio_files/agent-9009-1468979090-74251.wav') }}" type="audio_files/mp3">
                                            <!--<source src="/path/to/audio.ogg" type="audio_files/ogg">-->
                                        </audio>
                                    </td>
                                    <td></td>
                                    <td><div class="badge badge-secondary">Бичвэргүй</div></td>
                                    <td>
                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Засах"><i class="far fa-edit"></i></button>
                                        <button type="button" class="btn btn-success btn-sm disabled" data-toggle="tooltip" data-placement="top" title="Зөвшөөрөх"><i class="far fa-check"></i></button>
                                        <button type="button" class="btn btn-danger btn-sm disabled" data-toggle="tooltip" data-placement="top" title="Зөвшөөрөхгүй"><i class="far fa-times"></i></button>
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Устгах"><i class="far fa-trash"></i></button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--</div>-->
                    <!--</div>-->
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
    {{--<script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>--}}
    {{--<script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>--}}
    <script>
        $(document).ready(function() {
            plyr.setup();
//            var table = $('#audio-table').DataTable({
//                language: {
//                    oPaginate: {
//                        sNext: '<i class="far fa-arrow-right"></i>',
//                        sPrevious: '<i class="far fa-arrow-left"></i>',
//                        sFirst: '<i class="far fa-arrow-to-left"></i>',
//                        sLast: '<i class="far fa-arrow-to-right"></i>'
//                    }
//
//                } ,
//                pagingType: 'full_numbers'
//            });
//            $('[data-toggle="tooltip"]').tooltip();
//            plyr.setup();
//
//            plyr.on('destroyed', function () {
//
//            });
//            table.on('draw', function () {
//                plyr.destroy();
//            })
        });
    </script>
@endsection
