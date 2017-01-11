@extends('layouts.analyze-survey')

@section('results')

    <div id="results">
        @include('ajax.analyze-summary')
    </div>

@endsection

@section('scripts')

    <script src="{{ asset('public/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
    <!-- FLOT CHARTS -->
    <script src="{{ asset('public/plugins/flot/jquery.flot.min.js') }}"></script>
    <!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
    <script src="{{ asset('public/plugins/flot/jquery.flot.resize.min.js') }}"></script>
    <!-- FLOT PIE PLUGIN - also used to draw donut charts -->
    <script src="{{ asset('public/plugins/flot/jquery.flot.pie.min.js') }}"></script>
    <!-- FLOT CATEGORIES PLUGIN - Used to draw bar charts -->
    <script src="{{ asset('public/plugins/flot/jquery.flot.categories.min.js') }}"></script>

    {{-- INITIALIZE TAB VARIABLE --}}
    <script>
        var filterUrl = '{{ url('analyze/'.$survey->id .'/summary') }}';
        var inSummaryTab = 1;
    </script>
    <!-- SCRIPT -->
    <script src="{{ asset('public/js/analyze-filter.js') }}"></script>
    <script src="{{ asset('public/js/analyze-summary.js') }}"></script>
@endsection