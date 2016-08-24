<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ trans('app.app_name') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/semantic.min.css') }}" rel="stylesheet">
</head>
@if(!Auth::guest())
    <style>
        #app-layout {
            overflow: hidden;
        }
    </style>
@endif
<body id="app-layout">
<div class="ui fixed inverted menu">
    <div class="ui container">
        <a class="item"
           onclick="(function () {
                $('.ui.sidebar').sidebar('toggle');
            })()">
            {{ trans('app.menu') }}
        </a>
        <a href="#" class="header item ct-header">
            {{ trans('app.app_name') }}
        </a>
        <a href="{{ url('/home') }}" class="item"><i class="home icon"></i>&nbsp;{{ trans('app.home') }}</a>
        @if(!Auth::guest())
            <a href="{{ url('/home') }}" class="item"><i class="newspaper icon"></i>&nbsp;{{ trans('app.new') }}</a>
            <div class="ui search item">
                <div class="ui icon input">
                    <input class="prompt" type="text" placeholder="Search...">
                    <i class="search icon"></i>
                </div>
                <div class="results"></div>
            </div>
        @endif
        <div class="right item">
            @if(Auth::guest())
                <a class="item" href="{{ url('/login') }}" class="ui inverted button"><i class="sign in icon"></i>&nbsp;
                    {{ trans('login.login') }}
                </a>
            @else
                @can('is_admin', Auth::user())
                    <a href="{{ route('admin.welcome') }}" class="item"><i
                                class="newspaper icon"></i>&nbsp;{{ trans('app.new') }}</a>
                @else
                    <a href="{{ route('users.news.index') }}" class="item"><i
                                class="newspaper icon"></i>&nbsp;{{ trans('app.new') }}</a>
                @endcan

                <div class="ui simple dropdown item">
                    {{ Auth::user()->name }} <i class="dropdown icon"></i>
                    <div class="menu">
                        <a class="item" href="{{ url('/logout') }}" class="ui inverted button"><i
                                    class="sign out icon"></i>&nbsp; {{ trans('login.logout') }}</a>
                        <a class="item" href="#"><i class="user icon"></i>&nbsp;{{ trans('app.profile') }}</a>
                        <a class="item" href="#"><i class="flag outline icon"></i>&nbsp;{{ trans('app.languages') }}</a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="ui left vertical inverted labeled icon sidebar menu uncover">
        <a class="item">
            <i class="flag icon"></i>&nbsp;
            {{ trans('app.league') }}
        </a>
        <a class="item" href="{{ route('admin.teams.index') }}">
            <i class="linux icon"></i>&nbsp;
            {{ trans('app.team') }}
        </a>
        @can('is_admin', Auth::user())
            <a class="item">
                <i class="soccer icon"></i>&nbsp;
                {{ trans('app.match') }}
            </a>
        @else
            <a class="item" href="{{ route('users.matches.index') }}">
                <i class="soccer icon"></i>&nbsp;
                {{ trans('app.match') }}
            </a>
        @endcan
        @if(!Auth::guest())
            <div class="ui simple dropdown item">
                {{ Auth::user()->name }} <i class="dropdown icon"></i>
                <div class="menu">
                    <a class="item" href="{{ url('/logout') }}" class="ui inverted button">
                        <i class="sign out icon"></i>&nbsp; {{ trans('login.logout') }}
                    </a>
                    <a class="item" href="#"><i class="user icon"></i>&nbsp;{{ trans('app.profile') }}</a>
                    <a class="item" href="#"><i class="flag outline icon"></i>&nbsp;{{ trans('app.languages') }}</a>
                </div>
            </div>
        @endif
    </div>
</div>

<div class="ui sidebar inverted vertical menu">
    <div class="divider">
        <a class="item">
            <i class="flag icon"></i>&nbsp;{{ trans('app.league') }}
        </a>
        <a class="item">
            <i class="linux icon"></i>&nbsp;{{ trans('app.team') }}
        </a>
        <a class="item">
            <i class="soccer icon"></i>&nbsp;{{ trans('app.match') }}
        </a>
    </div>
</div>
<div class="pusher">
</div>

</div>
@yield('content')
@if(!Auth::guest())
    <div class="ui black inverted vertical footer segment">
        <div class="ui center aligned container">
            <div class="ui stackable inverted grid">
                <div class="three wide column">
                    <h4 class="ui inverted header">Company</h4>
                    <div class="ui inverted link list">
                        <a class="item" href="https://github.com/Semantic-Org/Semantic-UI"
                           target="_blank">{{ trans('app.company') }}</a>
                    </div>
                </div>
                <div class="seven wide right floated column">
                    <h4 class="ui inverted teal header">{{ trans('app.app_name') }}</h4>
                    <p> {{ trans('app.describe') }} </p>
                </div>
            </div>
        </div>
    </div>
@endif
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/semantic.min.js') }}"></script>
<script src="{{ asset('js/jqx-all.js') }}"></script>
</body>
</html>
