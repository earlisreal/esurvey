@extends('layouts.app-with-sidebar')

@section('header')
    @include('common.header')
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('public/css/app-sidebar.css') }}">
@endsection

{{--@section('sidebar')--}}
{{--@include('common.sidebar')--}}
{{--@endsection--}}

@section('content')
    <div class="main-page">
        <div class="sidebar">
            <div class="text-center" style="margin-top:10px; margin-bottom: 10px;">
                <a class="text-center" href="{{ url('mysurveys') }}">
                    <img src="{{ asset('public/images/side-logo.png') }}" alt="logo" style="height:90px;">
                </a>
            </div>
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                <li class="header">MAIN NAVIGATION</li>
                <li class="active"><a href=""><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href=""><i class="fa fa-edit"></i> Edit</a></li>
                <li><a href=""><i class="fa fa-share-alt"></i> Share</a></li>
                <li><a href=""><i class="fa fa-wrench"></i> Settings</a></li>
                <li class="treeview">
                    <a href="">
                        <i class="fa fa-line-chart"></i>
                        <span>Analyze</span>
                        <span class="pull-right-container">
                             <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href=""><i class="fa fa-pie-chart"></i> Summary</a></li>
                        <li><a href=""><i class="fa fa-users"></i> Individual Responses</a></li>
                    </ul>
                </li>
                <li><a href=""><i class="fa fa-file-pdf-o"></i> Quick Report</a></li>
                <li class="treeview">
                    <a href="">
                        <i class="fa fa-gears"></i>
                        <span>Other</span>
                        <span class="pull-right-container">
                             <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href=""><i class="fa fa-copy"></i> Duplicate Survey</a></li>
                        <li><a href=""><i class="fa fa-remove"></i> Delete</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="main-content">
            <section class="content-header">
                <h1>
                    Top Navigation
                    <small>Example 2.0</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li><a href="#">Layout</a></li>
                    <li class="active">Top Navigation</li>

                </ol>
            </section>
            <section class="content">
                <div class="callout callout-info">
                    <h4>Tip!</h4>

                    <p>Add the layout-top-nav class to the body tag to get this layout. This feature can also be used
                        with a
                        sidebar! So use this class if you want to remove the custom dropdown menus from the navbar and
                        use regular
                        links instead.</p>
                </div>
                <div class="callout callout-danger">
                    <h4>Warning!</h4>

                    <p>The construction of this layout differs from the normal one. In other words, the HTML markup of
                        the navbar
                        and the content will slightly differ than that of the normal layout.</p>
                </div>
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Blank Box</h3>
                    </div>
                    <div class="box-body">
                        The great content goes here
                    </div>
                    <!-- /.box-body -->
                </div>
            </section>
        </div>
    </div>
@endsection

@section('scripts')


@endsection