@include('survey.analyze.filters')

@if($responseCount > 0)
    <table id="response-table" class="dataTable table table-bordered table-hover">
        <thead>
        <tr>
            <th>No</th>
            <th>Date Time</th>
            <th>Source</th>
            <th>IP</th>
            <th>Gender</th>
            <th>Age</th>
            <th>Contact</th>
            <th>Location</th>
            {{--<th>{{ $survey->pages->first()->questions->first()->question_title }}</th>--}}
        </tr>
        </thead>
        <tbody>
        <?php $no = 1; ?>
        @foreach($responses as $response)
            <?php $user = $response->user; ?>
            <tr class="editable response-row" data-response-id="{{ $response->id }}">
                <td>{{ $no++ }}</td>
                <td class="response-date">{{ \Carbon\Carbon::parse($response->created_at)->toDayDateTimeString() }}</td>
                <td>{{ $response->source }}</td>
                <td>{{ $response->source_ip }}</td>
                @if($user != null)
                    <td>{{ $user->gender }}</td>
                    <td>{{ \Carbon\Carbon::parse($user->birthday)->age }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ $user->state .', ' .$user->country }}</td>
                @else
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                @endif

            </tr>
        @endforeach


        </tbody>
    </table>

@else

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3>No Responses</h3>
        </div>
    </div>

@endif

<script>
    var responseCount = {{ $no-1 }};
    var results = <?php echo json_encode($results) ?>;
</script>