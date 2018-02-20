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
                        <h6 class="card-subtitle text-muted mt-2"><strong>Нийт:</strong> {{ $total }} <strong>Хүснэгтэнд:</strong> {{ $firstItem }} - {{ $lastItem }}</h6>
                        <hr>
                        @if(session('msg'))
                            <div class="row justify-content-center">
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
                        @if($count == 0)
                            <div class="row justify-content-center">
                                <div class="col-md-6 col-sm-8 col-xs-12">
                                    <div class="alert alert-danger">
                                        Үр дүн олдсонгүй
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <div class="dropdown">
                                    <button class="btn btn-outline btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Хүснэгтэнд {{ $perPage }} мөр
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="{{ $request->fullUrlWithQuery(['item_per_page' => 5]) }}">5</a>
                                        <a class="dropdown-item" href="{{ $request->fullUrlWithQuery(['item_per_page' => 10]) }}">10</a>
                                        <a class="dropdown-item" href="{{ $request->fullUrlWithQuery(['item_per_page' => 25]) }}">25</a>
                                        <a class="dropdown-item" href="{{ $request->fullUrlWithQuery(['item_per_page' => 50]) }}">50</a>
                                        <a class="dropdown-item" href="{{ $request->fullUrlWithQuery(['item_per_page' => 75]) }}">75</a>
                                        <a class="dropdown-item" href="{{ $request->fullUrlWithQuery(['item_per_page' => 100]) }}">100</a>
                                    </div>
                                </div>
                                <hr>
                                <p>Сонгосон мөрүүдэд гүйцэтгэх үйлдлүүд</p>
                                <div class="btn-group" role="group" aria-label="First group">
                                    <button type="button" id="btn-accept" class="btn btn-raised btn-success btn-bulk-validate" value="a"><i class="far fa-check"></i> Зөв</button>
                                    <button type="button" id="btn-decline" class="btn btn-raised btn-danger btn-bulk-validate" value="d"><i class="far fa-times"></i> Буруу</button>
                                </div>
                                <div class="btn-group" role="group" aria-label="Second group">
                                    <button type="button" id="btn-delete" class="btn btn-raised btn-danger"><i class="far fa-trash"></i> Устгах</button>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h4>Хайлт</h4>
                                <form method="get">
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="form-row">
                                                <div class="form-group col-sm-6">
                                                    <label class="" for="search_col">Хайх багана</label>
                                                    <select class="form-control" name="search_col" id="search_col" required>
                                                        <option value="" @if(app('request')->input('search_col') == null) selected @endif>Сонгох...</option>
                                                        <option value="id" @if(app('request')->input('search_col') == 'id') selected @endif>Дугаар #</option>
                                                        <option value="file" @if(app('request')->input('search_col') == 'file') selected @endif>Файлын нэр</option>
                                                        <option value="transcription" @if(app('request')->input('search_col') == 'transcription') selected @endif>Бичвэр</option>
                                                        <option value="user" @if(app('request')->input('search_col') == 'user') selected @endif>Хэрэглэгч</option>
                                                        <option value="validation_required" @if(app('request')->input('search_col') == 'validation_required') selected @endif>Үлдсэн шалгалтын тоо</option>
                                                        <option value="accepted" @if(app('request')->input('search_col') == 'accepted') selected @endif>Зөвшөөрсөн тоо</option>
                                                        <option value="declined" @if(app('request')->input('search_col') == 'declined') selected @endif>Зөвшөөрөөгүй тоо</option>
                                                        <option value="status" @if(app('request')->input('search_col') == 'status') selected @endif>Төлөв</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label class="" for="search_operator">Хайх оператор</label>
                                                    <select class="form-control" name="search_operator" id="search_operator" required>
                                                        <option value="=" @if(app('request')->input('search_operator') == null || app('request')->input('search_operator') == '=') selected @endif>=</option>
                                                        <option value="!=" @if(app('request')->input('search_operator') == '!=') selected @endif>!=</option>
                                                        <option value=">" @if(app('request')->input('search_operator') == '>') selected @endif>&gt; - зөвхөн тоо</option>
                                                        <option value="<" @if(app('request')->input('search_operator') == '<') selected @endif>&lt; - зөвхөн тоо</option>
                                                        <option value=">=" @if(app('request')->input('search_operator') == '>=') selected @endif>&gt;= - зөвхөн тоо</option>
                                                        <option value="<=" @if(app('request')->input('search_operator') == '<=') selected @endif>&lt;= - зөвхөн тоо</option>
                                                        <option value="contains" @if(app('request')->input('search_operator') == 'contains') selected @endif>агуулагдсан - зөвхөн бичвэр</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="search_val" id="search_val_label" class="bmd-label-floating">Хайх утга</label>
                                                <input type="text" class="form-control" name="search_val" id="search_val" value="@if(app('request')->input('search_val') != null){{ app('request')->input('search_val') }}@endif" required/>
                                                <small class="bmd-help" id="search_val_help"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-outline btn-outline-primary"><i class="far fa-search"></i> Хайх</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <hr>
                        <div class="float-right">
                            <span class="text-muted">Баталгаажсан бичвэрүүдийг</span> <a href="{{ route('audio.export') }}" class="btn btn-info btn-sm">JSON хэлбэрээр татах</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table" id="audio-table">
                                <thead>
                                <tr>
                                    <th style="width: 1%">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" id="checkall">
                                            </label>
                                        </div>
                                    </th>
                                    <th style="width: 1%;">#</th>
                                    <th style="width: 25%;">Аудио</th>
                                    <th style="width: 50%;">Бичвэр</th>
                                    <th style="width: 1%;">Үлдсэн шалгалт</th>
                                    <th style="width: 1%;"><i class="far fa-check"></i></th>
                                    <th style="width: 1%;"><i class="far fa-times"></i></th>
                                    <th style="width: 1%;">Төлөв</th>
                                    <th style="width: 15%;">Үйлдэл</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($audios as $audio)
                                <tr id="audio_{{ $audio->id }}">
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="audios[]" value="{{ $audio->id }}"
                                                       @if($audio->tasks[0]->getLatestTranscribed() != null)
                                                           data-vtask="{{ $audio->tasks[0]->getVTask()->id }}"
                                                           data-latest="{{ $audio->tasks[0]->getLatestTranscribed()->id }}"
                                                       @else
                                                           data-vtask="0"
                                                           data-latest="0"
                                                       @endif
                                                       class="audios-checkbox">
                                            </label>
                                        </div>
                                    </td>
                                    <td scope="row">{{ $audio->id }}</td>
                                    <td>
                                        <audio controls src="@if($audio->isLocal){{ asset($audio->url .  $audio->file) }}@else{{ $audio->url . $audio->file }}@endif" type="audio_files/wav"></audio>
                                    </td>
                                    @if($audio->tasks[0]->getLatestTranscribed() != null)
                                        <td data-toggle="tooltip" data-placement="top" title="{{ $audio->tasks[0]->getLatestTranscribed()->user->name }}">
                                            {{ $audio->tasks[0]->getLatestTranscribed()->transcription }}
                                        </td>
                                        @else
                                        <td>
                                            <i class="text-muted">Бичвэр ороогүй</i>
                                        </td>
                                    @endif
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
{{--                                        @if($audio->tasks[0]->getLatestTranscribed() == null)--}}
                                        <a href="{{ route('transcribe') }}?edit={{ $audio->tasks[0]->getTTask()->id }}" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Засах"><i class="far fa-edit"></i></a>
                                        {{--@endif--}}
                                        @if($audio->tasks[0]->getLatestTranscribed() != null)
                                            @if($audio->tasks[0]->getLatestTranscribed()->getRequiredValidation() > 0)
                                                <form method="post" action="{{ route('validate.save') }}" style="display: inline;">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="list" value="1" required>
                                                    <input type="hidden" name="task_id" value="{{ $audio->tasks[0]->getVTask()->id }}" required>
                                                    <input type="hidden" name="transcription_id" value="{{ $audio->tasks[0]->getLatestTranscribed()->id }}" required>
                                                    <button type="submit" class="btn btn-success btn-sm" name="validation" value="a" data-toggle="tooltip" data-placement="top" title="Зөв"><i class="far fa-check"></i></button>
                                                    <button type="submit" class="btn btn-danger btn-sm" name="validation" value="d" data-toggle="tooltip" data-placement="top" title="Буруу"><i class="far fa-times"></i></button>
                                                </form>
                                            @endif
                                        @endif
                                        <form method="post" action="{{ route('audio.delete') }}" style="display: inline;">
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-danger btn-sm" name="delete" value="{{ $audio->id }}" onclick="return confirm('{{ $audio->id }} дугаартай файл, түүнтэй холбоотой бүх мэдээллийг устгах уу? Дахин сэргээх боломжгүй')" data-toggle="tooltip" data-placement="top" title="Устгах"><i class="far fa-trash"></i></button>
                                        </form>
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
                                        <span aria-hidden="true"><i class="far fa-chevron-double-left"></i> Эхнийх</span>
                                    </a>
                                </li>
                                <li class="page-item @if($page == 1)disabled @endif">
                                    <a class="page-link" href="{{ $request->fullUrlWithQuery(['page' => $page-1]) }}" aria-label="Previous">
                                        <span aria-hidden="true"><i class="far fa-chevron-left"></i> Өмнөх</span>
                                    </a>
                                </li>
                                <li class="page-item active">
                                    <a class="page-link" href="{{ $request->fullUrlWithQuery(['page' => $page]) }}" aria-label="Current">
                                        <span aria-hidden="true">{{ $page }}</span>
                                    </a>
                                </li>
                                <li class="page-item @if(!$hasMorePages)disabled @endif">
                                    <a class="page-link" href="{{ $request->fullUrlWithQuery(['page' => $page+1]) }}" aria-label="Next">
                                        <span aria-hidden="true">Дараах <i class="far fa-chevron-right"></i></span>
                                    </a>
                                </li>
                                <li class="page-item @if(!$hasMorePages)disabled @endif">
                                    <a class="page-link" href="{{ $request->fullUrlWithQuery(['page' => $lastPage]) }}" aria-label="Last">
                                        <span aria-hidden="true">Сүүлийнх <i class="far fa-chevron-double-right"></i></span>
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

            $("#btn-delete").click(function() {
                var r = confirm("Сонголсон аудио файлууд болон түүнтэй холбоотой мэдээллүүдийг устгахдаа итгэлтэй байна уу?");
                if(r === true) {
                    var ids = get_ids(false);
                    if (ids.length === 0) {
                        toastr["error"]("Аудио файл сонгоно уу.");
                    }
                    else {
                        for (var i = 0; i < ids.length; i++) {
                            var saveData = $.ajax({
                                url: "{{ route('audio.delete') }}",
                                type: 'POST',
                                data: {
                                    'delete': ids[i],
                                    'multiple': true,
                                    'i': i
                                },
//                            dataType: "json",
                                success: function (resultData, textStatus, jqxHR) {
                                    $("#audio_" + ids[resultData['i']]).remove();
                                    toastr["success"]("УСТГАСАН: #" + resultData['id']);
                                    if (resultData['i'] == ids.length - 1) {
                                        setTimeout(function() {
                                            location.reload(true);
                                        }, 1000);
                                    }
                                },
                                error: function (jqXHR, textStatus, errorThrown) {
                                    toastr["error"]("УСТГАЛ АМЖИЛТГҮЙ: #" + jqXHR.responseJSON.id);
                                    if (jqXHR.responseJSON.i == ids.length - 1) {
                                        setTimeout(function() {
                                            location.reload(true);
                                        }, 1000);
                                    }
                                }
                            });
                        }
                    }
                }
            });

            $(".btn-bulk-validate").click(function() {
                var value = $(this).val();
                var r = null;
                if(value == 'a'){
                    r = confirm("Сонголсон аудио файлуудад санал өгөх үү?");
                }
                else if(value == 'd') {
                    r = confirm("Сонголсон аудио файлуудад санал өгөх үү?");
                }
                if(r === true) {
                    var ids = get_ids(true);
                    if (ids.length === 0) {
                        toastr["error"]("Аудио файл сонгоно уу.");
                    }
                    else {
                        for (var i = 0; i < ids.length; i++) {
                            if(ids[i].vtask != 0 && ids[i].latest != 0) {
                                var saveData = $.ajax({
                                    url: "{{ route('validate.save') }}",
                                    type: 'POST',
                                    data: {
                                        'id': ids[i].id,
                                        'validation': value,
                                        'task_id': ids[i].vtask,
                                        'transcription_id': ids[i].latest,
                                        'multiple': true,
                                        'i': i
                                    },
                                    success: function (resultData, textStatus, jqxHR) {
                                        toastr["success"]("САНАЛ ӨГСӨН: #" + resultData['id']);
                                        if (resultData['i'] == ids.length - 1) {
                                            setTimeout(function () {
                                                location.reload(true);
                                            }, 1000);
                                        }
                                    },
                                    error: function (jqXHR, textStatus, errorThrown) {
                                        if(jqXHR.status == 404){
                                            toastr["error"]("САНАЛ ӨГӨХ БЧИВЭР ОЛДСОНГҮЙ: #" + jqXHR.responseJSON.id);
                                        }
                                        else if(jqXHR.status == 403) {
                                            toastr["error"]("САНАЛ ӨГСӨН ЭСВЭЛ ТАНЫ ОРУУЛСАН БИЧВЭР БАЙНА: #" + jqXHR.responseJSON.id);
                                        }
                                        else {
                                            toastr["error"]("САНАЛ ӨГЧ ЧАДСАНГҮЙ: #" + jqXHR.responseJSON.id);
                                        }
                                        if (jqXHR.responseJSON.i == ids.length - 1) {
                                            setTimeout(function () {
                                                location.reload(true);
                                            }, 1000);
                                        }
                                    }
                                });
                            }
                            else {
                                toastr["warning"]("САНАЛ ӨГӨХ БОЛООГҮЙ: #" + ids[i].id);
                                if (i == ids.length - 1) {
                                    setTimeout(function () {
                                        location.reload(true);
                                    }, 1000);
                                }
                            }
                        }
                    }
                }
            });

            $('#checkall').change(function() {
                var checkboxes = $(".audios-checkbox");
                if($(this).is(':checked')) {
                    checkboxes.prop('checked', true);
                } else {
                    checkboxes.prop('checked', false);
                }
            });

            function get_ids(validation){
                var ids = [];
                $('.audios-checkbox:checked').each(function(i){
                    if(validation){
                        ids[i] = {
                            'id': $(this).val(),
                            'vtask': $(this).data('vtask'),
                            'latest': $(this).data('latest')
                        };
                    }
                    else {
                        ids[i] = $(this).val();
                    }
                });
                return ids;
            }

            $("#search_col").change(function() {
                search_col($(this));
            });

            search_col($("#search_col"));

            function search_col(elem){
                var column = elem.val();
                switch (column) {
                    case 'id':
                        search_help(column, 'number', '/Тоо/', 'Аудио файлын дугаарыг оруулна уу.');
                        break;
                    case 'audio_file':
                        search_help(column, 'text', '', 'Аудио файлын нэрийг оруулна уу.');
                        break;
                    case 'transcription':
                        search_help(column, 'text', '', 'Бичвэр оруулна уу.');
                        break;
                    case 'user':
                        search_help(column, 'text', '/Sisi ID/', 'Хэрэглэгчийн нэрийг оруулна уу.');
                        break;
                    case 'validation_required':
                        search_help(column, 'number', '/Тоо/', 'Үлдсэн шалгалтын тоог оруулна уу.');
                        break;
                    case 'accepted':
                        search_help(column, 'number', '/Тоо/', 'Зөвшөөрсөн саналын тоог оруулна уу.');
                        break;
                    case 'declined':
                        search_help(column, 'number', '/Тоо/', 'Зөвшөөрөөгүй саналын тоог оруулна уу.');
                        break;
                    case 'status':
                        search_help(column, 'number', '/Тоо/', 'Төлөв оруулна уу (0 - бичвэр ороогүй, 1 - хүлээгдэж байгаа, 2 - зөвшөөрсөн, 3 - зөвшөөрөөгүй).');
                        break;
                    default:
                        search_help(column, 'text', '/Багана сонгоогүй/', 'Хайх багана сонгоно уу.');
                        break;
                }
            }

            function search_help(column, input_type, label_msg, help_msg) {
                var label = $("#search_val_label");
                var input = $("#search_val");
                var help = $("#search_val_help");
                label.html('Хайх утга ' + label_msg);
                help.html(help_msg);
                input.attr('type', input_type);
                if(input_type === "number"){
                    input.attr('min', 0);
                }
            }
        });
    </script>
@endsection
