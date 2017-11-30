<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    @section('stylesheet')
    <!-- Material Design for Bootstrap fonts and icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons">

    <!-- Material Design for Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-material-design.min.css') }}">
    @yield('additional_stylesheet')
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <!-- FontAwesome 5 icons -->
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome-pro-solid.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome-pro-regular.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome-pro-light.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome-pro-core.css') }}">
    @show

    <title>@yield('title')</title>
</head>
<body>

@section('navbar')
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown"
            aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('index') }}">Нүүр</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Хуудаснууд
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="{{ route('login') }}">Нэвтрэх</a>
                    <a class="dropdown-item" href="{{ route('register') }}">Бүртгүүлэх</a>
                    <a class="dropdown-item" href="{{ route('audio') }}">Transcribe</a>
                    <a class="dropdown-item" href="{{ route('validation') }}">Шалгах</a>
                </div>
            </li>
        </ul>
        <ul class="navbar-nav navbar-right">
            @guest
                <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Нэвтрэх</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Бүртгүүлэх</a></li>
            @else
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="far fa-user"></i> {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <div class="dropdown-item">
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                Гарах
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
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://unpkg.com/popper.js@1.12.6/dist/umd/popper.js" integrity="sha384-fA23ZRQ3G/J53mElWqVJEGJzU0sTs+SvzG8fXVWP+kJQ1lwFAOkcUOysnlKJC33U" crossorigin="anonymous"></script>
<script src="{{ asset('assets/js/bootstrap-material-design.min.js') }}"></script>
@yield('additional_scripts')
<script>
    $(document).ready(function() {
        $('body').bootstrapMaterialDesign();
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@show
</body>
</html>