<!DOCTYPE html>
<html lang="mn">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @section('stylesheet')
    <!-- Material Design for Bootstrap fonts and icons -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&amp;subset=cyrillic,cyrillic-ext" rel="stylesheet">

    <!-- Material Design for Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-material-design.min.css') }}">
    @yield('additional_stylesheet')
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <!-- FontAwesome 5 icons -->
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome-all.min.css') }}">
    @show

    <title>Transcription Web - @yield('title')</title>
</head>
<body>

@section('navbar')
<nav class="navbar navbar-expand-lg navbar-dark bg-primary justify-content-between">
    <a class="navbar-brand" href="{{ route('home') }}"><i class="far fa-music"></i> <i class="far fa-arrow-right"></i> <i class="far fa-font"></i></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown"
            aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('home') }}">Эхлэл</a>
            </li>
            <li class="nav-item"><a class="nav-link" href="{{ route('transcribe') }}">Бичвэрт буулгах</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('validate') }}">Шалгах</a></li>
            @auth
                @if(Auth::user()->isAdmin())
                    <li class="nav-item"><a class="nav-link" href="{{ route('audio.list') }}">Аудио файлууд</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('audio.add') }}">Файл нэмэх</a></li>
                @endif
            @endauth
        </ul>
        <ul class="navbar-nav ml-auto">
            @guest
                <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Нэвтрэх</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Бүртгүүлэх</a></li>
            @else
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="far fa-user"></i> {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                        <a href="{{ route('profile') }}" class="dropdown-item">Миний булан</a>
                        <div>
                            <a href="{{ route('logout') }}" class="dropdown-item"
                               onclick="event.preventDefault();document.getElementById('logout-form').submit();">Гарах
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </div>
                </li>
            @endguest
        </ul>
    </div>
</nav>
@show

@section('content')
@show

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
@section('scripts')
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<script src="https://unpkg.com/popper.js@1.12.6/dist/umd/popper.js" integrity="sha384-fA23ZRQ3G/J53mElWqVJEGJzU0sTs+SvzG8fXVWP+kJQ1lwFAOkcUOysnlKJC33U" crossorigin="anonymous"></script>
<script src="{{ asset('assets/js/bootstrap-material-design.min.js') }}"></script>
@yield('additional_scripts')
<script>
    $(document).ready(function() {
        $('body').bootstrapMaterialDesign();
        $('[data-toggle="tooltip"]').tooltip();
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });
    });
</script>
@show
</body>
</html>