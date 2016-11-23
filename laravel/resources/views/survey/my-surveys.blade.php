@extends('layouts.app')

@section('header')
    @include('common.header')
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('public/css/card.css') }}">
@endsection

@section('content')
    <div class="content">
        <div class="form-group">
            <a href="{{ url('/create') }}" class="btn btn-lg btn-success" data-toggle="tooltop" title="Delete this survey"><i class="fa fa-plus"></i> New Survey</a>
        </div>

        <div class="row">

            <div class="card weather-forecast">
                <div class="city-key" hidden=""></div>
                <div class="card-last-updated" hidden="">2016-11-23T02:49:32Z</div>
                <div class="location">New York, NY</div>
                <div class="date">Tue, 22 Nov 2016 09:00 PM EST</div>
                <div class="description">Clear</div>
                <div class="current">
                    <div class="visual">
                        <div class="icon windy cloudy"></div>
                        <div class="temperature">
                            <span class="value">38</span><span class="scale">°F</span>
                        </div>
                    </div>
                    <div class="description">
                        <div class="humidity">54%</div>
                        <div class="wind">
                            <span class="value">22</span>
                            <span class="scale">mph</span>
                            <span class="direction">300</span>°
                        </div>
                        <div class="sunrise">6:52 am</div>
                        <div class="sunset">4:33 pm</div>
                    </div>
                </div>
                <div class="future">
                    <div class="oneday">
                        <div class="date">Thu</div>
                        <div class="icon partly-cloudy-day windy"></div>
                        <div class="temp-high">
                            <span class="value">44</span>°
                        </div>
                        <div class="temp-low">
                            <span class="value">35</span>°
                        </div>
                    </div>
                    <div class="oneday">
                        <div class="date">Fri</div>
                        <div class="icon partly-cloudy-day"></div>
                        <div class="temp-high">
                            <span class="value">47</span>°
                        </div>
                        <div class="temp-low">
                            <span class="value">33</span>°
                        </div>
                    </div>
                    <div class="oneday">
                        <div class="date">Sat</div>
                        <div class="icon thunderstorms cloudy"></div>
                        <div class="temp-high">
                            <span class="value">50</span>°
                        </div>
                        <div class="temp-low">
                            <span class="value">38</span>°
                        </div>
                    </div>
                    <div class="oneday">
                        <div class="date">Sun</div>
                        <div class="icon windy cloudy"></div>
                        <div class="temp-high">
                            <span class="value">54</span>°
                        </div>
                        <div class="temp-low">
                            <span class="value">44</span>°
                        </div>
                    </div>
                    <div class="oneday">
                        <div class="date">Mon</div>
                        <div class="icon windy partly-cloudy-day"></div>
                        <div class="temp-high">
                            <span class="value">52</span>°
                        </div>
                        <div class="temp-low">
                            <span class="value">44</span>°
                        </div>
                    </div>
                    <div class="oneday">
                        <div class="date">Tue</div>
                        <div class="icon partly-cloudy-day clear-day"></div>
                        <div class="temp-high">
                            <span class="value">49</span>°
                        </div>
                        <div class="temp-low">
                            <span class="value">39</span>°
                        </div>
                    </div>
                    <div class="oneday">
                        <div class="date">Wed</div>
                        <div class="icon partly-cloudy-day"></div>
                        <div class="temp-high">
                            <span class="value">50</span>°
                        </div>
                        <div class="temp-low">
                            <span class="value">37</span>°
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-wpforms"></i> My Survey List</h3>
            </div>
            <div class="panel-body">

                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#all" aria-controls="question" role="tab" data-toggle="tab"><i class="fa fa-list"></i> All({{ $surveys->count() }})</a></li>
                    <li role="presentation"><a href="#drafts" aria-controls="question" role="tab" data-toggle="tab"> <i class="fa fa-pencil-square-o"></i> Drafts({{ $surveys->where('published', 0)->count() }})</a></li>
                    <li role="presentation"><a href="#published" aria-controls="settings" role="tab" data-toggle="tab"><i class="fa fa-check"></i> Published({{ $surveys->where('published', 1)->count() }})</a></li>
                </ul>
                <div class="tab-content">

                    <div role="tabpanel" class="tab-pane active" id="all">
                        <div class="table-responsive" style="margin-top: 10px">
                            <table class="dataTable table table-bordered">
                                <thead>
                                <tr>
                                    <td width="30%">Title</td>
                                    <td>Last Update</td>
                                    <td>Published</td>
                                    <td>Responses</td>
                                    <td>Edit</td>
                                    <td>Share</td>
                                    <td>Analyze</td>
                                    <td>Delete</td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($surveys as $survey)
                                    <tr>
                                        <td>
                                            <a href="survey/{{$survey->id}}">{{ $survey->survey_title }}</a>
                                            <br>
                                            <small>created: {{ $eDate->parse($survey->created_at)->toFormattedDateString() }}</small>
                                        </td>
                                        <td>{{ $eDate->toDateWithTime($survey->updated_at) }}</td>
                                        <td class="text-center">{{ $survey->published ? "Yes" : "No" }}</td>
                                        <td class="text-center"><a href="{{ url('/analyze/'.$survey->id.'?tab=user') }}">{{ $survey->responses()->count() }}</a></td>
                                        <td class="text-center"> <a href="{{ url('/create/'.$survey->id) }}" class="btn {{ $survey->published ? 'btn-twitter' : 'btn-primary' }}">{!! $survey->published ? '<i class="fa fa-eye"></i> View' : '<i class="fa fa-pencil"></i> Edit' !!}</a> </td>
                                        <td class="text-center"><a href="{{ url('/share/'.$survey->id) }}" class="btn btn-dropbox"><i class="fa fa-share-alt"></i> Share</a></td>
                                        <td class="text-center"> <a href="{{ url('/analyze/'.$survey->id) }}" class="btn btn-facebook"><i class="fa fa-line-chart"></i> Analyze</a>  </td>
                                        <td class="text-center">
                                            <form id="delete{{ $survey->id }}" method="POST" action="{{ url('/create/'.$survey->id) }}" class="delete-form">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <button type="button" class="btn btn-danger delete-survey" data-id="{{ $survey->id }}" data-toggle="tooltop" title="Delete this survey"><i class="fa fa-remove"></i> Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="drafts">
                        <div class="table-responsive" style="margin-top: 10px">
                            <table class="dataTable table table-bordered">
                                <thead>
                                <tr>
                                    <td>Title</td>
                                    <td>Last Update</td>
                                    <td>Edit</td>
                                    <td>Publish</td>
                                    <td>Delete</td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($surveys->where('published', 0) as $survey)
                                    <tr>
                                        <td>
                                            <a href="survey/{{$survey->id}}">{{ $survey->survey_title }}</a>
                                            <br>
                                            <small>created: {{ $eDate->parse($survey->created_at)->toFormattedDateString() }}</small>
                                        </td>
                                        <td class="text-center">{{ $eDate->toDateWithTime($survey->updated_at) }}</td>
                                        <td class="text-center"> <a href="{{ url('/create/'.$survey->id) }}" class="btn btn-primary"><i class="fa fa-btn fa-pencil"></i>Edit</a> </td>
                                        <td class="text-center"><a href="{{ url('/publish/'.$survey->id) }}" class="btn btn-dropbox"><i class="fa fa-btn fa-share-alt"></i>Share</a></td>
                                        <td class="text-center">
                                            <form id="delete{{ $survey->id }}" method="POST" action="{{ url('/create/'.$survey->id) }}" class="delete-form">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <button type="button" class="btn btn-danger delete-survey" data-id="{{ $survey->id }}" data-toggle="tooltop" title="Delete this survey"><i class="fa fa-btn fa-remove"></i>Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="published">
                        <div class="table-responsive" style="margin-top: 10px">
                            <table class="dataTable table table-bordered">
                                <thead>
                                <tr>
                                    <td>Title</td>
                                    <td>Last Response</td>
                                    <td>Responses</td>
                                    <td>View</td>
                                    <td>Share</td>
                                    <td>Analyze</td>
                                    <td>Delete</td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($surveys->where('published', 1) as $survey)
                                    <tr>
                                        <td>
                                            <a href="survey/{{$survey->id}}">{{ $survey->survey_title }}</a>
                                            <br>
                                            <small>created: {{ $eDate->parse($survey->created_at)->toFormattedDateString() }}</small>
                                        </td>
                                        <td class="text-center">
                                            @if($survey->responses->count() > 0)
                                                {{ $eDate->toDateWithTime($survey->responses()->orderBy('created_at', 'desc')->first()->created_at) }}
                                            @else
                                                No Responses
                                            @endif
                                        </td>
                                        <td class="text-center"><a href="{{ url('/analyze/'.$survey->id.'?tab=user') }}">{{ $survey->responses()->count() }}</a></td>
                                        <td class="text-center"> <a href="{{ url('/create/'.$survey->id) }}" class="btn btn-twitter"><i class="fa fa-btn fa-eye"></i>Preview</a></td>
                                        <td class="text-center"> <a href="{{ url('/share/'.$survey->id) }}" class="btn btn-primary"><i class="fa fa-btn fa-share-alt"></i>Share</a></td>
                                        <td class="text-center"><a href="{{ url('/analyze/'.$survey->id.'?tab=summary') }}" class="btn btn-dropbox"><i class="fa fa-btn fa-line-chart"></i>Analyze</a></td>
                                        <td class="text-center">
                                            <form id="delete{{ $survey->id }}" method="POST" action="{{ url('/create/'.$survey->id) }}" class="delete-form">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <button type="button" class="btn btn-danger delete-survey" data-id="{{ $survey->id }}" data-toggle="tooltop" title="Delete this survey"><i class="fa fa-btn fa-remove"></i>Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


@endsection

@section('scripts')
    <!-- MySurveyScript -->
    <script src="{{ asset('public/js/my-survey.js') }}"></script>
@endsection
