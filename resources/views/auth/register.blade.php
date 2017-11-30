@extends('transcription.layout.main')

@section('title', 'Prototype - Register')

@section('content')
    <div class="container" style="margin-top: 20px;">
        <!--<div class="row">-->
        <div class="row justify-content-center mt-5">
            <div class="col-md-5 col-sm-8 col-xs-12">
                <div class="card">
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        <div class="card-body">
                            <h4 class="card-title">Бүртгүүлэх</h4>
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="bmd-label-floating"><i class="far fa-user"></i> Хэрэглэгчийн нэр /Оюутны ID/</label>
                                <input type="text" class="form-control" name="name" id="name" aria-describedby="name" value="{{ old('name') }}" required autofocus>
                                @if ($errors->has('name'))
                                    <small class="bmd-help">{{ $errors->first('name') }}</small>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="bmd-label-floating"><i class="far fa-at"></i> Цахим шуудан</label>
                                <input type="email" class="form-control" name="email" id="email" aria-describedby="email" value="{{ old('email') }}" required>
                                @if ($errors->has('email'))
                                    <small class="bmd-help">{{ $errors->first('email') }}</small>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="bmd-label-floating"><i class="far fa-key"></i> Нууц үг</label>
                                <input type="password" class="form-control" name="password" id="password" aria-describedby="password" required>
                                @if ($errors->has('password'))
                                    <small class="bmd-help">{{ $errors->first('password') }}</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="password-confirm" class="bmd-label-floating"><i class="far fa-key"></i> Нууц үг давтах</label>
                                <input type="password" class="form-control" name="password_confirmation" id="password-confirm" aria-describedby="password-confirm" required>
                                {{--<small class="bmd-help">******</small>--}}
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('login') }}" class="btn btn-outline-info"><i class="far fa-sign-in"></i> Нэвтрэх хуудас руу буцах</a>
                            <button type="submit" class="btn btn-raised btn-primary"><i class="far fa-user-plus"></i> Бүртгүүлэх</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--</div>-->
    </div>
@endsection
