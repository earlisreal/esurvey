<header class="main-header top-header">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <a href="@if (Auth::guest()){{ url('/') }} @else {{ url('mysurveys') }} @endif" class="navbar-brand"><b>e</b>Survey</a>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                    <i class="fa fa-bars"></i>
                </button>
            </div>

            <!-- Left Side Of Navbar -->
            <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                <ul class="nav navbar-nav">
                    @if (Auth::user())

                        <!-- Create Survey, Display in all pages -->
                        <li><a href="{{ url('/create') }}" id="create-survey" class="btn-facebook"><i class="fa fa-plus"></i> Create Survey</a></li>
                        <li><a href="{{ url('mysurveys') }}"><i class="fa fa-edit"></i> My Surveys</a></li>
                        <li><a href="{{ url('templates') }}"><i class="fa fa-list-alt"></i> Templates</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-area-chart"></i> Reports <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">Summary</a></li>
                                <li><a href="#">User Responses</a></li>
                                <li><a href="#">Sources</a></li>
                            </ul>
                        </li>
                        @if(Auth::user()->role->title != "User")
                        <li><a href="{{ url('admin') }}"><i class="fa fa-user"></i> Admin Mode</a></li>
                        @endif
                    @endif
                </ul>
            </div>

            <!-- Right Side Of Navbar -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">

                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                    @else

                        <!-- User Account Menu -->
                        @include('common.user-menu')
                    @endif
                </ul>
            </div>
        </div>
    </nav>
</header>