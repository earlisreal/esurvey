@extends($adminMode ? 'layouts.admin' : 'layouts.app')

@if($adminMode)
@section('content-header')
    <section class="content-header">
        <h1>
            {{ $survey->survey_title }}
            <small>Template Summary</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Templates</li>
            <li class="active">Summary</li>
        </ol>
    </section>

@endsection

@else

@section('header')
    @include('common.header')
@endsection


@section('content-header')
    <section class="content-header">
        <h1>{{ $survey->survey_title }}</h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{ url('mysurveys') }}">My Surveys</a></li>
            <li><a href="{{ url('survey/'.$survey->id) }}">{{ $survey->survey_title }}</a></li>
        </ol>
    </section>
@endsection

@endif

@section('content')
    <div class="col-lg-offset-1 col-lg-10">
        <div class="col-lg-4">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Survey Summary</h3>
                </div>
                <div class="box-body">
                    <h4>{{ $survey->survey_title }}</h4>
                    <p>Created {{ $survey->created_at }}</p>
                    <hr>


                    <h4>Pages: {{ $survey->pages()->count() }}</h4>
                    <?php
                    $questionCount = 0;
                    foreach($survey->pages as $page){
                        $questionCount += $page->questions->count();
                    }
                    ?>
                    <p>Questions: {{ $questionCount }}</p>

                </div>
                <div class="box-footer">
                    <td class="text-center"> <a href="{{ url('/create/'.$survey->id) }}" class="btn btn-primary">{!! $survey->published ? '<i class="fa fa-eye"></i> View' : '<i class="fa fa-pencil"></i> Edit' !!}</a> </td>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="col-lg-6">
                <div class="info-box">
                    <!-- Apply any bg-* class to to the icon to color it -->
                    <span class="info-box-icon bg-aqua"><i class="fa fa-share"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">published</span>
                        <span class="info-box-number">{{ $survey->published ? 'Yes' : 'No' }}</span>
                    </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->
            </div>
            <div class="col-lg-6">
                <div class="info-box">
                    <!-- Apply any bg-* class to to the icon to color it -->
                    <span class="info-box-icon bg-aqua-active"><i class="fa fa-check"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Status</span>
                        <span class="info-box-number">
                            @if($survey->published)
                                {{ $survey->option->open ? 'Open' : 'Closed' }}
                            @else
                                Editing mode
                            @endif
                        </span>
                    </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->
            </div>
            <div class="col-lg-6">
                <div class="info-box">
                    <!-- Apply any bg-* class to to the icon to color it -->
                    <span class="info-box-icon bg-light-blue"><i class="fa fa-users"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Responses</span>
                        <span class="info-box-number">{{ $survey->responses->count() }}</span>
                    </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->
            </div>
            <div class="col-lg-6">
                <div class="info-box">
                    <!-- Apply any bg-* class to to the icon to color it -->
                    <span class="info-box-icon bg-blue"><i class="fa fa-crosshairs"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Target Responses</span>
                        <span class="info-box-number">
                            <a href="{{ url('share/'.$survey->id) }}">
                                @if($survey->option != null)
                                    {{ $survey->option->target_responses == null ? 'None' : $survey->option->target_responses }}
                                @else
                                None
                                @endif

                            </a>
                        </span>
                    </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->
            </div>
            <div class="col-lg-6">
                <div class="info-box">
                    <!-- Apply any bg-* class to to the icon to color it -->
                    <span class="info-box-icon bg-light-blue"><i class="fa fa-calendar-times-o"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Auto Close Date</span>
                        <span class="info-box-number">
                            <a href="{{ url('share/'.$survey->id) }}">
                                @if($survey->option != null)
                                    {{ $survey->option->date_close == null ? 'None' : $survey->option->date_close }}
                                @else
                                    None
                                @endif
                            </a>
                        </span>
                    </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->
            </div>
            <div class="col-lg-6">
                <div class="info-box">
                    <!-- Apply any bg-* class to to the icon to color it -->
                    <span class="info-box-icon bg-blue"><i class="fa fa-share-alt"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Share</span>
                        <span class="info-box-number"><a href="{{ url('share/'.$survey->id) }}">Share Survey</a></span>
                    </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->
            </div>
            <div class="col-lg-6">
                <div class="info-box">
                    <!-- Apply any bg-* class to to the icon to color it -->
                    <span class="info-box-icon bg-blue"><i class="fa fa-pie-chart"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Analyze</span>
                        <span class="info-box-number"><a href="{{ url('analyze/'.$survey->id) }}">Summary</a></span>
                    </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->
            </div>
            <div class="col-lg-6">
                <div class="info-box">
                    <!-- Apply any bg-* class to to the icon to color it -->
                    <span class="info-box-icon bg-blue"><i class="fa fa-comments"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Analyze</span>
                        <span class="info-box-number"><a href="{{ url('analyze/'.$survey->id .'/user') }}">User Responses</a></span>
                    </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->
            </div>
        </div>
    </div>



@endsection