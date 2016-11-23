@extends('layouts.app-with-sidebar')

@section('header')
    @include('common.header')
@endsection

{{--@section('sidebar')--}}
{{--@include('common.sidebar')--}}
{{--@endsection--}}

@section('content')
    <div class="row" style=" display: table;">
        <div class="col-sm-3 col-md-2 no-padding" style="float: none;
    display: table-cell;
    vertical-align: top;">
            <div class="slimScrollDiv sidebar"
                 style="position: relative; overflow: hidden; width: auto; height: 372px;">
                <div class="sidebar" id="scrollspy" style="height: 372px; overflow: hidden; width: auto;">

                    <div class="text-center" style="margin-top:10px; margin-bottom: 10px;">
                        <a class="text-center" href="{{ url('mysurveys') }}">
                            <img src="{{ asset('public/images/side-logo.png') }}" alt="logo" style="height:90px;">
                        </a>
                    </div>
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="nav sidebar-menu">
                        <li class="text-center no-padding">
                            <a href="/" style="color: #169ef4;">esurvey/answer/69</a>
                        </li>
                        <li>
                            <span class="sidebar-info">Created</span>
                            <span class="pull-right">12</span>
                        </li>
                        <li>
                            <span class="sidebar-info">Published</span>
                            <span class="pull-right">12</span>
                        </li>
                        <li>
                            <span class="sidebar-info">First Answer</span>
                            <span class="pull-right">12</span>
                        </li>
                        <li>
                            <span class="sidebar-info">Pages</span>
                            <span class="pull-right">12</span>
                        </li>
                        <li>
                            <span class="sidebar-info">Question</span>
                            <span class="pull-right">12</span>
                        </li>
                        <li>
                            <span class="sidebar-info">Link</span>
                            <span class="pull-right">12</span>
                        </li>
                        <li>
                            <span class="sidebar-info">Target Responses</span>
                            <span class="pull-right">12</span>
                        </li>
                        <li>
                            <span class="sidebar-info">Date Close</span>
                            <span class="pull-right">12</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-sm-9 col-md-10 no-padding main-content" style="float: none;
    display: table-cell;
    vertical-align: top;">
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