@extends('layouts.analyze-survey')

@section('results')
    {{--  RESPONSE DETAILS --}}

    <div class="modal fade" id="response-details-modal" tabindex="-1" page="-1" role="dialog"
         aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Response Details</h4>
                </div>
                <div class="modal-body">
                    <button id="prev-btn" data-increment="-1" type="button"
                            class="btn btn-default change-selected-index"><span class="fa fa-arrow-left"></span> Prev
                        Response
                    </button>
                    <button id="next-btn" data-increment="1" type="button"
                            class="btn btn-default change-selected-index pull-right">Next Response <span
                                class="fa fa-arrow-right"></span></button>

                    <div class="row">
                        <div id="user-response-details" class="col-xs-12" style="margin-top: 10px; ">

                        </div>
                    </div>

                    <button id="prev-btn" data-increment="-1" type="button"
                            class="btn btn-default change-selected-index"><span class="fa fa-arrow-left"></span> Prev
                        Response
                    </button>
                    <button id="next-btn" data-increment="1" type="button"
                            class="btn btn-default change-selected-index pull-right">Next Response <span
                                class="fa fa-arrow-right"></span></button>
                </div>

                <div class="modal-footer">
                    <button type="button" tabindex="-1" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{--  RESPONSE DETAILS END --}}

    <div id="results">

        @include('ajax.analyze-user')
    </div>

@endsection

@if($responseCount > 0)
@section('scripts')
    <script src="{{ asset('public/plugins/datepicker/bootstrap-datepicker.js') }}"></script>

    <script>
                {{-- INITIALIZE TAB VARIABLE --}}
        var inSummaryTab = 0;
        var filterUrl = '{{ url('analyze/'.$survey->id .'/summary') }}';
        var startDate = '{{ $survey->responses()->orderBy('created_at')->first()->created_at }}';
    </script>

    <!-- SCRIPT -->
    <script src="{{ asset('public/js/analyze-filter.js') }}"></script>
    <script src="{{ asset('public/js/result-functions.js') }}"></script>
@endsection
@endif