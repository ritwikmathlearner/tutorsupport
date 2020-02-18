<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <a class="nav-link" href="{{ route('tasks.index')  }}">Tasks</a>
                    <ul class="navbar-nav mr-auto">
                        <form class="form-inline" action={{ route('tags.index') }} method="POST" onsubmit="return checkSearchForm();">
                            @csrf
                            @method('GET')
                            <input id="search_tasks_using_tag" name="tag" class="form-control mr-sm-2" type="search" placeholder="Search tasks" aria-label="Search" required>
                        </form>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container mt-3">
            @if(session()->has('status'))
                <p class="alert alert-success">{{ session()->get('status') }}</p>
            @endif
            @if(session()->has('status_danger'))
                <p class="alert alert-danger">{{ session()->get('status_danger') }}</p>
            @endif
        </div>
        <main class="py-4 m-5">
            @yield('content')
        </main>
        <footer class="page-footer font-small blue bg-primary text-white fixed-bottom">
            <div class="footer-copyright text-center py-3">© 2020 Copyright;
                <strong>Developed and Maintained by Ritwik Math</strong>
            </div>
        </footer>
    </div>
    <script>
        function checkForm(){
            return confirm('Delet this task?');
        }
        function dateForm(){
            let startDate = document.getElementById('startDate').value;
            let endDate = document.getElementById('endDate').value;
            if(startDate === '' || endDate === ''){
                alert('Please select both dates');
                return false;
            } else {
                return true;
            }
        }
        function checkTagDelete(){
            return confirm('Delet this tag?');
        }

        function checkSearchForm(){
            $searchTerm = document.getElementById('search_tasks_using_tag').value;
            if($searchTerm.length < 3) {
                alert('Type minimum 3 characters');
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
