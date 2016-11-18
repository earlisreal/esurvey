@extends('layouts.app-with-sidebar')

@section('header')
    @include('common.header')
@endsection

{{--@section('sidebar')--}}
    {{--@include('common.sidebar')--}}
{{--@endsection--}}

@section('content')
        <div class="row">
            <div class="col-sm-3 col-md-2 no-padding">
                <div class="slimScrollDiv sidebar" style="position: relative; overflow: hidden; width: auto; height: 372px;"><div class="sidebar" id="scrollspy" style="height: 372px; overflow: hidden; width: auto;">

                        <!-- sidebar menu: : style can be found in sidebar.less -->
                        <ul class="nav sidebar-menu">
                            <li class="header">TABLE OF CONTENTS</li>
                            <li><span>Responses</span><span>12</span></li>
                            <li class=""><a href="#introduction"><i class="fa fa-circle-o"></i> Introduction</a></li>
                            <li class=""><a href="#download"><i class="fa fa-circle-o"></i> Download</a></li>
                            <li class=""><a href="#dependencies"><i class="fa fa-circle-o"></i> Dependencies</a></li>
                            <li class=""><a href="#advice"><i class="fa fa-circle-o"></i> Advice</a></li>
                            <li class=""><a href="#layout"><i class="fa fa-circle-o"></i> Layout</a></li>
                            <li class=""><a href="#adminlte-options"><i class="fa fa-circle-o"></i> Javascript Options</a></li>
                            <li class="treeview" id="scrollspy-components">
                                <a href="javascript:void(0)"><i class="fa fa-circle-o"></i> Components</a>
                                <ul class="nav treeview-menu">
                                    <li><a href="#component-main-header">Main Header</a></li>
                                    <li><a href="#component-sidebar">Sidebar</a></li>
                                    <li><a href="#component-control-sidebar">Control Sidebar</a></li>
                                    <li><a href="#component-info-box">Info Box</a></li>
                                    <li><a href="#component-box">Boxes</a></li>
                                    <li class=""><a href="#component-direct-chat">Direct Chat</a></li>
                                </ul>
                            </li>
                            <li><a href="#plugins"><i class="fa fa-circle-o"></i> Plugins</a></li>
                            <li><a href="#browsers"><i class="fa fa-circle-o"></i> Browser Support</a></li>
                            <li><a href="#upgrade"><i class="fa fa-circle-o"></i> Upgrade Guide</a></li>
                            <li><a href="#implementations"><i class="fa fa-circle-o"></i> Implementations</a></li>
                            <li><a href="#faq"><i class="fa fa-circle-o"></i> FAQ</a></li>
                            <li><a href="#license"><i class="fa fa-circle-o"></i> License</a></li>
                        </ul>
                    </div><div class="slimScrollBar" style="background: rgba(0, 0, 0, 0.2); width: 3px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 223.561px;"></div><div class="slimScrollRail" style="width: 3px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div></div>
            </div>
            <div class="col-sm-9 col-md-10 no-padding">
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

                        <p>Add the layout-top-nav class to the body tag to get this layout. This feature can also be used with a
                            sidebar! So use this class if you want to remove the custom dropdown menus from the navbar and use regular
                            links instead.</p>
                    </div>
                    <div class="callout callout-danger">
                        <h4>Warning!</h4>

                        <p>The construction of this layout differs from the normal one. In other words, the HTML markup of the navbar
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