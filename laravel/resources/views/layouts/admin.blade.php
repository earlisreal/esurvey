<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <title>eSurvey</title>
	<link rel="icon" href="{{ asset('public/images/icon.png') }}">

    <!-- Fonts -->
    <!-- Font Awesome 4.6.3 -->
    <link rel="stylesheet" href="{{ asset('public/plugins/font-awesome-4.6.3/css/font-awesome.min.css') }}">
    <!-- Lato Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- Miscs -->
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('public/plugins/ionicons-2.0.1/css/ionicons.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('public/plugins/datatables/dataTables.bootstrap.css') }}">
    <!-- jQuery Toast -->
    <link rel="stylesheet" href="{{ asset('public/plugins/jquery-toast-plugin/jquery.toast.min.css') }}">
    <!-- jQuery Toast -->
    <link rel="stylesheet" href="{{ asset('public/plugins/toast-plugin/jquery.toastmessage.css') }}">
    <!-- icheck -->
    <link rel="stylesheet" href="{{ asset('public/plugins/iCheck/all.css') }}">
    <!-- DateRange Picker -->
    <link rel="stylesheet" href="{{ asset('public/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- Bar rating -->
    <link rel="stylesheet" href="{{ asset('public/plugins/jquery-bar-rating/themes/bars-square.css') }}">
    <!-- Star rating -->
    <link rel="stylesheet" href="{{ asset('public/plugins/jquery-bar-rating/themes/fontawesome-stars.css') }}">


    <!-- Styles -->
    <!-- Bootstrap 3.3.7-->
    <link rel="stylesheet" href="{{ asset('public/plugins/bootstrap-3.3.7/css/bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('public/plugins/AdminLTE-2.3.5/dist/css/AdminLTE.min.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('public/plugins/AdminLTE-2.3.5/dist/css/skins/_all-skins.min.css') }}">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('public/css/main.css') }}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <!--<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>-->
    <!--<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>-->
    <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="{{ url('admin/users/') }}" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini">eS<b>A</b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg">eSurvey <b>Admin</b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                    @else

                    <!-- User Account Menu -->
                        @include('common.user-menu')
                    @endif
                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->

    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- /.search form -->
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                <li class="header">CONTROL PANEL</li>
                @foreach(Auth::user()->role->modules->where('pivot.can_read', 1) as $module)
                    <li @if(str_contains(Request::path(), $module->url)) class="active" @endif><a href="{{ url('admin/'.$module->url) }}"><i class="{{ $module->icon }}"></i> <span>{{ $module->title }}</span></a></li>
                @endforeach
                <li><a href="{{ url('mysurveys') }}" target="_self"><i class="fa fa-book"></i> <span>User Mode</span></a></li>
                <li class="header">THE DEVELOPERS</li>
                <li><a href="http://facbook.com/earlcuuute" target="_blank"><i class="fa fa-circle-o text-red"></i> <span>Savadera</span></a></li>
                <li><a href="https://www.facebook.com/mayLovesss" target="_blank"><i class="fa fa-circle-o text-yellow"></i> <span>Abalos</span></a></li>
                <li><a href="https://www.facebook.com/aeronysrael.sumilong" target="_blank"><i class="fa fa-circle-o text-aqua"></i> <span>Sumilong</span></a></li>
                <li><a href="https://www.facebook.com/kilala.moof" target="_blank"><i class="fa fa-circle-o text-green"></i> <span>Pahang</span></a></li>
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @yield('content-header')


        <!-- Main content -->

        <section class="content">
        @yield('content')
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@include('common.footer')

</div>


<!-- jQuery 2.2.3 -->
<script src="{{ asset('public/plugins/jquery/jquery-2.2.3.min.js') }}"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{{ asset('public/plugins/bootstrap-3.3.7/js/bootstrap.min.js') }}"></script>
<!-- SlimScroll -->
<script src="{{ asset('public/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('public/plugins/fastclick/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('public/plugins/AdminLTE-2.3.5/dist/js/app.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('public/plugins/AdminLTE-2.3.5/dist/js/demo.js') }}"></script>

<!-- Miscellaneous -->
<!-- To Title Case -->
<script src="{{ asset('public/plugins/to-title-case/to-title-case.js') }}"></script>
<!-- BootBox 4.4.0-->
<script src="{{ asset('public/plugins/bootbox/bootbox.min.js') }}"></script>
<!-- DataTables -->
<script src="{{ asset('public/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<!-- jQuery Toast -->
<script src="{{ asset('public/plugins/jquery-toast-plugin/jquery.toast.min.js') }}"></script>
<!-- jQuery Toast Message -->
<script src="{{ asset('public/plugins/toast-plugin/jquery.toastmessage.js') }}"></script>
<!-- icheck -->
<script src="{{ asset('public/plugins/iCheck/icheck.min.js') }}"></script>
<!-- Moment -->
<script src="{{ asset('public/plugins/daterangepicker/moment.min.js') }}"></script>
<!-- DateRange Picker -->
<script src="{{ asset('public/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Barrating -->
<script src="{{ asset('public/plugins/jquery-bar-rating/jquery.barrating.min.js') }}"></script>

<!-- GLOBAL JS -->
<script src="{{ asset('public/js/global.js') }}"></script>


@yield('scripts')


<meta name="csrf-token" content="{{ csrf_token() }}">
</body>
</html>
