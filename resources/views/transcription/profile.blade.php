@extends('transcription.layout.main')

@section('title', 'Prototype - Index')

@section('content')
    <div class="container" style="margin-top: 20px;">
        <div class="text-center">
            <h2><i class="far fa-music"></i> <i class="far fa-arrow-right"></i> <i class="far fa-font"></i></h2>
        </div>
        <div class="row justify-content-center mt-5">
            <div class="col-md-6 col-sm-8 col-xs-12">
                <div class="card">
                    <div class="card-header">
                        Статистик
                    </div>
                    <div class="card-body">
                        <h4>Бичвэр болгох</h4>
                        <p>Нийт: 100</p>
                        <p>Зөвшөөрөгдсөн: 45</p>
                        <p>Зөвшөөрөөгүй: 25</p>
                        <p>Хүлээгдэж байгаа: 30</p>
                        <h4>Шалгах</h4>
                        <p>Нийт: 54</p>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('transcribe') }}" class="btn btn-info btn-block btn-raised"><i class="far fa-pencil"></i> Бичвэрт буулгах</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="card">
                    <div class="card-header">
                        Мэдээллээ засах
                    </div>
                    <form>
                    <div class="card-body">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="bmd-label-floating"><i class="far fa-user"></i> Хэрэглэгчийн нэр /ID/</label>
                            <input type="text" class="form-control" name="name" id="name" aria-describedby="name" value="{{ Auth::user()->name }}" required>
                            {{--@if ($errors->has('name'))--}}
                                {{--<small class="bmd-help">{{ $errors->first('name') }}</small>--}}
                            {{--@endif--}}
                        </div>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="bmd-label-floating"><i class="far fa-at"></i> Цахим шуудан</label>
                            <input type="email" class="form-control" name="email" id="email" aria-describedby="email" value="{{ Auth::user()->email }}" required>
                            {{--@if ($errors->has('email'))--}}
                                {{--<small class="bmd-help">{{ $errors->first('email') }}</small>--}}
                            {{--@endif--}}
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-block btn-raised"><i class="far fa-save"></i> Хадгалах</button>
                    </div>
                    </form>
            </div>
        </div>
    </div>
@endsection