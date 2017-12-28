@extends('transcription.layout.main')

@section('title', 'Шалгах - ' . $task->id)

@section('additional_stylesheet')
    <link rel="stylesheet" href="{{ asset('assets/css/plyr.css') }}">
@endsection

@section('content')
    <div class="container" style="margin-top: 20px;">
        <div class="row">

            <div class="alert alert-warning alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    <span class="sr-only">Хаах</span>
                </button>
                <strong>Яриаг бичих мөрдлөг!</strong>

                <ol>
                    <li>Зөвхөн <b>монгол-кирил</b> үсэг ашиглан бичнэ.</li>
                    <li>Сонссон үгээ дуудлагаар нь бичнэ. Жишээ нь "байж байна" гэдэг үгийг "байжийна" гэж хэлдэг бөгөөд энэ хэлбэрээр нь бичнэ.</li>
                    <li><b>Тэмдэгт</b>: Зөвхөн өгүүлбэр төгсөгсөн цэг (.), асуултын тэмдэг (?), анхаарлын тэмдэг (!), өгүүлбэрийн дунд орсон таслалыг (,) тэмдэглэнэ</li>
                    <li><b>Томоор</b> эхлүүлж бичих дүрмийг баримтлана</li>
                    <li><b>Дутуу хэлсэн</b> Үгийн эхлэл эсвэл төгсгөл нь сонсогдохгүй, өгүүлэгч зориуд дутуу хэлсэн бол сонсогдоогүй эсвэл дутуу хэсгийг зураасаар (-) тэмдэглэнэ. Ж.нь: -азар, боло-</li>
                    <li><b>Товчлол</b>: Үсэг тус бүрээр салгаж хэлсэн товчлолын өмнө долгионтой зураас (~) тавина. Ж.нь: ~БНН.</li>
                    <li><b>Гадаад үг</b>: Гадаад үгийн өмнө долларын тэмдэг ($) тавина. Ж.нь: $Washington, $~CIA. </li>
                    <li><b>Ээрсэн аялга</b>: эдгээр нь хувийн тэмдгээр (%) тэмдэглэгдэнэ. Энэ нь нэг сегмент болно. Ж.нь: %эээ, %өөө, %ммм, %ааа, %мхм, %юуу, %ооо</li>
                    <li><b>Чимээгүй</b>: Чимээгүй бол *S тавина.</li>
                    <li><b>Тоо</b>: Тоог дуудлагаар нь бичнэ. Тоон илэрхийллээр бичихгүй. Жишээ нь: мянга есөн зуун арван хоёр гэх мэт. </li>
                </ol>
            </div>

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
                                <audio data-plyr='{ "autoplay":true }' controls src="@if($task->audio->isLocal){{ asset($task->audio->url .  $task->audio->file) }}@else{{ $task->audio->url . $task->audio->file }}@endif" type="audio/wav">
                                </audio>
                                <div class="alert alert-info"><strong>Бичвэр:</strong> <br/>{!!  $transcribed->transcription !!}</div>
                                <form method="post" action="{{ route('validate.save') }}">
                                    {{ csrf_field() }}
                                    <input type="hidden" value="{{ $task->id }}" name="task_id" class="form-control">
                                    <input type="hidden" value="{{ $transcribed->id }}" name="transcription_id" class="form-control">
                                    <div class="text-center">
                                        <button type="submit" name="validation" value="a" class="btn btn-raised btn-success" data-toggle="tooltip" data-placement="top" title="Аудио файлд ярьж буй яриа, бичвэр хоёр тохирч байна"><i class="far fa-check"></i> Зөв</button>
                                        <button type="submit" name="validation" value="d" class="btn btn-raised btn-danger" data-toggle="tooltip" data-placement="top" title="Аудио файлд ярьж буй яриа нь бичвэртэй таарахгүй байна"><i class="far fa-times"></i> Буруу</button>

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