@extends('transcription.layout.main')

@section('title', 'Нэвтрэх')

@section('content')
    <div class="container" style="margin-top: 20px;">
        <!--<div class="row">-->
        <div class="row justify-content-center mt-5">
            <div class="col-md-5 col-sm-8 col-xs-12">
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
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        <div class="card-body">
                            <h4 class="card-title">Нэвтрэх</h4>
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="bmd-label-floating"><i class="far fa-at"></i> Цахим шуудан</label>
                                <input type="email" class="form-control" name="email" id="email" aria-describedby="email" value="{{ old('email') }}" required autofocus>
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
                                <div class="col-md-6 col-md-offset-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Намайг сана
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('register') }}" class="btn btn-info"><i class="far fa-user-plus"></i> Бүртгүүлэх</a>
                            <a href="{{ route('password.request') }}" class="btn btn-danger"><i class="far fa-key"></i> Нууц үгээ мартсан?</a>
                            <button type="submit" class="btn btn-raised btn-primary"><i class="far fa-sign-in"></i> Нэвтрэх</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--</div>-->
    </div>
@endsection
