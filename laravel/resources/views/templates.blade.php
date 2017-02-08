@extends('layouts.app')

@section('content-header')

    <section class="content-header">

        <h1 class="text-center"><i class="fa fa-file"></i> Survey Templates</h1>
    </section>

@endsection


@section('header')
    @include('common.header')
@endsection

@section('content')

<?php $templateCount = 0; ?>
<div class="content">
    <div class="row">

        @foreach($categories as $category)
            @if($category->surveys()->where('is_template', 1)->where('published', 1)->count() > 0)
                <?php $templateCount++ ?>
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">{{ $category->category }}</h3>
                        </div>
                        <div class="box-body">
                            @foreach($category->surveys()->where('is_template', 1)->where('published', 1)->get() as $template)
                                <?php
                                    $count = 0;
                                    foreach ($template->pages as $page){
                                        $count += $page->questions->count();
                                    }
                                ?>
                                    <label>
                                        <a href="{{ url('templates/'.$template->id) }}">{{ $template->survey_title }}</a>
                                    </label>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <h5>Pages: {{ $template->pages->count() }}</h5>
                                    </div>
                                    <div class="col-sm-6">
                                        <h5>Questions: {{ $count }}</h5>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12">

                                        <form action="{{ url('create') }}" method="POST">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="create_from" value="template">
                                            <input type="hidden" name="survey_template" value="{{ $template->id }}">
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-btn fa-file-archive-o"></i>Use template</button>
                                        </form>
                                    </div>
                                </div>
                                <hr>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
        @if($templateCount < 1)
            <div class="panel">
                <div class="panel-heading">

                    <h3 class="text-center">Sorry, There are No Available Templates now.</h3>
                </div>
            </div>
        @endif
    </div>
</div>

@endsection