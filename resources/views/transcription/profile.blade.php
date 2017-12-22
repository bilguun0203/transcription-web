@extends('transcription.layout.main')

@section('title', 'Миний булан')

@section('content')
    <div class="container" style="margin-top: 20px;">
        <div class="text-center">
            <h2><i class="far fa-music"></i> <i class="far fa-arrow-right"></i> <i class="far fa-font"></i></h2>
        </div>
        <div class="row justify-content-center mt-5">
            <div class="col-md-6 col-sm-8 col-xs-12">
                @if(session('msg'))
                    <div class="alert alert-info">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true"><i class="fal fa-times"></i></span>
                            <span class="sr-only">Хаах</span>
                        </button>
                        {{ session('msg') }}
                    </div>
                @endif
                @foreach($errors->all() as $error)
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true"><i class="fal fa-times"></i></span>
                            <span class="sr-only">Хаах</span>
                        </button>
                        {{ $error }}
                    </div>
                @endforeach
            </div>
        </div>
        <div class="row justify-content-center mt-5">
            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="card">
                    <div class="card-header">
                        Мэдээллээ засах
                    </div>
                    <form method="post" action="{{ route('profile.info') }}">
                        <div class="card-body">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="bmd-label-floating"><i class="far fa-user"></i> Хэрэглэгчийн нэр /Sisi ID/</label>
                                <input type="text" class="form-control" name="name" id="name" aria-describedby="name" value="{{ Auth::user()->name }}" required>
                                @if ($errors->has('name'))
                                    <small class="bmd-help">{{ $errors->first('name') }}</small>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="bmd-label-floating"><i class="far fa-at"></i> Цахим шуудан</label>
                                <input type="email" class="form-control" name="email" id="email" aria-describedby="email" value="{{ Auth::user()->email }}" required>
                                @if ($errors->has('email'))
                                    <small class="bmd-help">{{ $errors->first('email') }}</small>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-block btn-raised"><i class="far fa-save"></i> Хадгалах</button>
                    </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="card">
                    <div class="card-header">
                        Нууц үг солих
                    </div>
                    <form method="post" action="{{ route('profile.password') }}">
                        <div class="card-body">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('current_password') ? ' has-error' : '' }}">
                                <label for="current_password" class="bmd-label-floating"><i class="far fa-key"></i> Одоогийн нууц үг</label>
                                <input type="password" class="form-control" name="current_password" id="current_password" aria-describedby="current_password" required>
                                @if ($errors->has('current_password'))
                                    <small class="bmd-help">{{ $errors->first('current_password') }}</small>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="bmd-label-floating"><i class="far fa-key"></i> Шинэ нууц үг</label>
                                <input type="password" class="form-control" name="password" id="password" aria-describedby="password" required>
                                @if ($errors->has('password'))
                                <small class="bmd-help">{{ $errors->first('password') }}</small>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <label for="password_confirmation" class="bmd-label-floating"><i class="far fa-key"></i> Шинэ нууц үг давтах</label>
                                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" aria-describedby="password_confirmation" required>
                                @if ($errors->has('email'))
                                <small class="bmd-help">{{ $errors->first('password_confirmation') }}</small>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-block btn-raised"><i class="far fa-save"></i> Хадгалах</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection