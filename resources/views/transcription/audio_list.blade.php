@extends('transcription.layout.main')

@section('title', 'Аудио файлууд')

@section('additional_stylesheet')
    <link rel="stylesheet" href="{{ asset('assets/css/plyr.css') }}">
@endsection

@section('content')
    <div class="container" style="margin-top: 20px;">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Файлууд</h4>
                        <h6 class="card-subtitle text-muted mt-2"><strong>Нийт:</strong> {{ $total_rows }} <strong>Хүснэгтэнд:</strong> {{ $row_from }} - {{ $row_to }}</h6>
                        <hr>
                        @foreach($errors->all() as $error)
                            <div class="row justify-content-center">
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
                        @if($results == 0)
                            <div class="row justify-content-center">
                                <div class="col-md-6 col-sm-8 col-xs-12">
                                    <div class="alert-danger">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true"><i class="fal fa-times"></i></span>
                                            <span class="sr-only">Хаах</span>
                                        </button>
                                        Үр дүн олдсонгүй
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table" id="audio-table">
                                <thead>
                                <tr>
                                    <th style="width: 1%;">#</th>
                                    <th style="width: 25%;">Аудио</th>
                                    <th style="width: 50%;">Бичвэр</th>
                                    <th style="width: 1%;">Үлдсэн шалгалт</th>
                                    <th style="width: 1%;"><i class="far fa-check"></i></th>
                                    <th style="width: 1%;"><i class="far fa-times"></i></th>
                                    <th style="width: 1%;">Төлөв</th>
                                    <th style="width: 15%;">Үйлдэл /засвартай/</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($audios as $audio)
                                <tr>
                                    <td scope="row">{{ $audio->id }}</td>
                                    <td>
                                        <audio controls src="@if($audio->isLocal){{ asset($audio->url .  $audio->file) }}@else{{ $audio->url . $audio->file }}@endif" type="audio_files/wav"></audio>
                                    </td>
                                    <td>@if($audio->tasks[0]->getLatestTranscribed() != null)
                                            {{ $audio->tasks[0]->getLatestTranscribed()->transcription }}
                                        @else
                                            <i class="text-muted">Бичвэр ороогүй</i>
                                        @endif
                                    </td>
                                    <td>
                                        @if($audio->tasks[0]->getLatestTranscribed() != null)
                                            {{ $audio->tasks[0]->getLatestTranscribed()->getRequiredValidation() }}
                                        @else
                                            <i class="text-muted">-</i>
                                        @endif
                                    </td>
                                    <td>
                                        @if($audio->tasks[0]->getLatestTranscribed() != null)
                                            {{ $audio->tasks[0]->getLatestTranscribed()->getNumberOfAccepted() }}
                                        @else
                                            <i class="text-muted">-</i>
                                        @endif
                                    </td>
                                    <td>
                                        @if($audio->tasks[0]->getLatestTranscribed() != null)
                                            {{ $audio->tasks[0]->getLatestTranscribed()->getNumberOfDeclined() }}
                                        @else
                                            <i class="text-muted">-</i>
                                        @endif
                                    </td>
                                    <td>
                                        @if($audio->tasks[0]->getLatestTranscribed() != null)
                                            @if($audio->tasks[0]->getLatestTranscribed()->getRequiredValidation() == 0)
                                                @if($audio->tasks[0]->getLatestTranscribed()->getValidationStatus() > 0)
                                                    <div class="badge badge-success">Зөв</div>
                                                @else
                                                    <div class="badge badge-danger">Буруу</div>
                                                @endif
                                            @else
                                                <div class="badge badge-warning">Шалгагдаж байна</div>
                                            @endif
                                        @else
                                            <div class="badge badge-secondary">Бичвэр ороогүй</div>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-warning btn-sm disabled" data-toggle="tooltip" data-placement="top" title="Засах"><i class="far fa-edit"></i></button>
                                        <button type="button" class="btn btn-success btn-sm disabled" data-toggle="tooltip" data-placement="top" title="Зөвшөөрөх"><i class="far fa-check"></i></button>
                                        <button type="button" class="btn btn-danger btn-sm disabled" data-toggle="tooltip" data-placement="top" title="Зөвшөөрөхгүй"><i class="far fa-times"></i></button>
                                        <button type="button" class="btn btn-danger btn-sm disabled" data-toggle="tooltip" data-placement="top" title="Устгах"><i class="far fa-trash"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div aria-label="Page navigation" class="row justify-content-center">
                            <ul class="pagination">
                                <li class="page-item @if($page == 1)disabled @endif">
                                    <a class="page-link" href="{{ $request->fullUrlWithQuery(['page' => 1]) }}" aria-label="First">
                                        <span aria-hidden="true"><i class="far fa-chevron-double-left"></i></span>
                                        <span class="sr-only">Эхнийх</span>
                                    </a>
                                </li>
                                <li class="page-item @if($page == 1)disabled @endif">
                                    <a class="page-link" href="{{ $request->fullUrlWithQuery(['page' => $page - 1]) }}" aria-label="Previous">
                                        <span aria-hidden="true"><i class="far fa-chevron-left"></i></span>
                                        <span class="sr-only">Өмнөх</span>
                                    </a>
                                </li>
                                @for($i=1; $i<=$total_page; $i++)
                                    <li class="page-item @if($page == $i)active @endif"><a class="page-link" href="{{ $request->fullUrlWithQuery(['page' => $i]) }}">{{ $i }}</a></li>
                                @endfor
                                <li class="page-item @if($page == $total_page)disabled @endif">
                                    <a class="page-link" href="{{ $request->fullUrlWithQuery(['page' => $page + 1]) }}" aria-label="Next">
                                        <span aria-hidden="true"><i class="far fa-chevron-right"></i></span>
                                        <span class="sr-only">Дараах</span>
                                    </a>
                                </li>
                                <li class="page-item @if($page == $total_page)disabled @endif">
                                    <a class="page-link" href="{{ $request->fullUrlWithQuery(['page' => $total_page]) }}" aria-label="Last">
                                        <span aria-hidden="true"><i class="far fa-chevron-double-right"></i></span>
                                        <span class="sr-only">Сүүлийнх</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
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
