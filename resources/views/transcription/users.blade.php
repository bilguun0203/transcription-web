@extends('transcription.layout.main')

@section('title', 'Хэрэглэгчид')

@section('additional_stylesheet')
    <link rel="stylesheet" href="{{ asset('assets/css/plyr.css') }}">
@endsection

@section('content')
    <div class="container" style="margin-top: 20px;">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Хэрэглэгчид</h4>
                        <h6 class="card-subtitle text-muted mt-2"><strong>Нийт:</strong> {{ $total_rows }} <strong>Хүснэгтэнд:</strong> {{ $row_from }} - {{ $row_to }}</h6>
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
                        @if($results == 0)
                            <div class="row justify-content-center">
                                <div class="col-md-6 col-sm-8 col-xs-12">
                                    <div class="alert alert-danger">
                                        Үр дүн олдсонгүй
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-md-4">
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Хүснэгтэнд {{ $item_per_page }} мөр
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
                            </div>
                            <div class="col-md-8">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <form class="form-inline" method="get">
                                    <input type="hidden" name="search_col" value="name">
                                    <div class="form-group">
                                        <label for="search_id" class="bmd-label-floating">Хэрэглэгчийн нэр /Sisi ID/</label>
                                        <input type="text" class="form-control" name="search_val" id="search_val">
                                    </div>
                                    <span class="form-group bmd-form-group">
                                    <button type="submit" id="search-btn" class="btn btn-info"><i class="far fa-search"></i> Хайх</button>
                                </span>
                                </form>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table" id="user-table">
                                <thead>
                                <tr>
                                    {{--<th style="width: 1%">--}}
                                        {{--<div class="checkbox">--}}
                                            {{--<label>--}}
                                                {{--<input type="checkbox" id="checkall">--}}
                                            {{--</label>--}}
                                        {{--</div>--}}
                                    {{--</th>--}}
                                    <th style="width: 1%;">#</th>
                                    <th>Нэр</th>
                                    <th>Цахим шуудан</th>
                                    <th style="width: 1%;">Оноо</th>
                                    <th style="width: 1%;">Төлөв</th>
                                    <th style="width: 1%;">Эрх</th>
                                    <th style="width: 15%;">Үйлдэл</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                <tr id="user_{{ $user->id }}">
                                    {{--<td>--}}
                                        {{--<div class="checkbox">--}}
                                            {{--<label>--}}
                                                {{--<input type="checkbox" name="audios[]" value="{{ $audio->id }}"--}}
                                                       {{--@if($audio->tasks[0]->getLatestTranscribed() != null)--}}
                                                           {{--data-vtask="{{ $audio->tasks[0]->getVTask()->id }}"--}}
                                                           {{--data-latest="{{ $audio->tasks[0]->getLatestTranscribed()->id }}"--}}
                                                       {{--@else--}}
                                                           {{--data-vtask="0"--}}
                                                           {{--data-latest="0"--}}
                                                       {{--@endif--}}
                                                       {{--class="audios-checkbox">--}}
                                            {{--</label>--}}
                                        {{--</div>--}}
                                    {{--</td>--}}
                                    <td scope="row">{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->score()['transcribe'] + $user->score()['validate'] }}</td>
                                    <td>
                                        @if($user->isBanned())
                                            <div class="badge badge-danger">ХОРИГЛОСОН</div>
                                        @else
                                            <div class="badge badge-success">ИДЭВХТЭЙ</div>
                                        @endif
                                    </td>
                                    <td>
                                        @if($user->isAdmin)
                                            <div class="badge badge-danger">АДМИН</div>
                                        @else
                                            <div class="badge badge-success">ЭНГИЙН</div>
                                        @endif
                                    </td>
                                    <td>
                                        @if($user->isBanned())
                                            <form method="post" action="" style="display: inline;">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="user" value="{{ $user->id }}">
                                                <button type="submit" class="btn btn-success btn-sm" name="unban" value="{{ $user->id }}" onclick="return confirm('{{ $user->name }} нэртэй хэрэглэгчийн хориог гаргах уу?')" data-toggle="tooltip" data-placement="top" title="Хорио гаргах"><i class="far fa-check"></i></button>
                                            </form>
                                        @else
                                            <form method="post" action="" style="display: inline;">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="user" value="{{ $user->id }}">
                                                <button type="submit" class="btn btn-danger btn-sm" name="ban" value="{{ $user->id }}" onclick="return confirm('{{ $user->name }} нэртэй хэрэглэгчийг хориглох уу?')" data-toggle="tooltip" data-placement="top" title="Хориглох"><i class="far fa-ban"></i></button>
                                            </form>
                                        @endif
                                        @if($user->isAdmin)
                                            <form method="post" action="" style="display: inline;">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="user" value="{{ $user->id }}">
                                                <button type="submit" class="btn btn-primary btn-sm" name="demote" value="{{ $user->id }}" onclick="return confirm('{{ $user->name }} нэртэй хэрэглэгчийн админ эрхийг хураах уу?')" data-toggle="tooltip" data-placement="top" title="Админ эрх хураах"><i class="far fa-user"></i></button>
                                            </form>
                                        @else
                                            <form method="post" action="" style="display: inline;">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="user" value="{{ $user->id }}">
                                                <button type="submit" class="btn btn-warning btn-sm" name="promote" value="{{ $user->id }}" onclick="return confirm('{{ $user->name }} нэртэй хэрэглэгчид админ эрх өгөх үү?')" data-toggle="tooltip" data-placement="top" title="Админ эрх өгөх"><i class="far fa-user-secret"></i></button>
                                            </form>
                                        @endif
                                        {{--<form method="post" action="" style="display: inline;">--}}
{{--                                            {{ csrf_field() }}--}}
                                            {{--<button type="button" class="btn btn-danger btn-sm" name="delete" value="{{ $user->id }}" onclick="return confirm('{{ $user->name }} нэртэй хэрэглэгч, түүнтэй холбоотой бүх мэдээллийг устгах уу? Дахин сэргээх боломжгүй.')" data-toggle="tooltip" data-placement="top" title="Устгах"><i class="far fa-trash"></i></button>--}}
                                        {{--</form>--}}
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
                                <li class="page-item @if($page >= $total_page)disabled @endif">
                                    <a class="page-link" href="{{ $request->fullUrlWithQuery(['page' => $page + 1]) }}" aria-label="Next">
                                        <span aria-hidden="true"><i class="far fa-chevron-right"></i></span>
                                        <span class="sr-only">Дараах</span>
                                    </a>
                                </li>
                                <li class="page-item @if($page >= $total_page)disabled @endif">
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
    <script>
        $(document).ready(function() {

            $('#checkall').change(function() {
                var checkboxes = $(".users-checkbox");
                if($(this).is(':checked')) {
                    checkboxes.prop('checked', true);
                } else {
                    checkboxes.prop('checked', false);
                }
            });

            function get_ids(validation){
                var ids = [];
                $('.users-checkbox:checked').each(function(i){
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
        });
    </script>
@endsection
