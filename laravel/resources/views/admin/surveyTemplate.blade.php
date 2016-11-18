@extends('layouts.admin')

@section('content-header')
    <section class="content-header">
        <h1>
            Survey Templates
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Survey Templates</li>
        </ol>
    </section>
@endsection

@section('content')
    @if($rights['read'])
    <div class="form-group">
        <a href="{{ url('admin/templates/create') }}" class="btn btn-lg btn-success" data-toggle="tooltop" title="Create New Survey Template">
            <i class="fa fa-plus"></i> New Template
        </a>
    </div>
    @endif

    <table class="dataTable table table-bordered">
        <thead>
        <tr>
            <td width="30%">Title</td>
            <td>Category</td>
            <td>Last Update</td>
            <td>Active</td>
            <td>Created By</td>
            @if($rights['write'])
                <td>Edit</td>
                <td>Delete</td>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach($surveys as $survey)
            <tr>
                <td>{{ $survey->survey_title }}<br><small>{{ \Carbon\Carbon::parse( $survey->created_at )->format('F d, Y h:m A ') }}</small></td>
                <td>{{ $survey->category == null ? "General" : $survey->category->category }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse( $survey->updated_at )->format('F d, Y h:m A ') }}</td>
                <td class="text-center">{{ $survey->published ? "Yes" : "No" }}</td>
                <td class="text-center">{{ $survey->user->first_name ." " .$survey->user->last_name }}</td>
                @if($rights['write'])
                    <td class="text-center"><a href="{{ url('admin/templates/create/'.$survey->id) }}" class="btn btn-primary">{!! $survey->published ? '<i class="fa fa-eye"></i> View' : '<i class="fa fa-pencil"></i> Edit' !!}</a></td>
                    <td class="text-center">
                        <form id="delete{{ $survey->id }}" method="POST" action="{{ url('/create/'.$survey->id) }}" class="delete-form">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="button" class="btn btn-danger delete-survey" data-id="{{ $survey->id }}" data-toggle="tooltip" title="Delete this survey"><i class="fa fa-remove"></i> Delete</button>
                        </form>
                    </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>


@endsection

@section('scripts')
    <!-- MySurveyScript -->
    <script src="{{ asset('public/js/my-survey.js') }}"></script>
@endsection
