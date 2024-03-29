@include('survey.analyze.filters')

@if($totalResponse > 0)
    <?php
    $questionNo = 1;
    ?>
    @foreach($results as $result)
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3><b> {{ $questionNo }}.  </b> {{ $result['questionTitle'] }}</h3>
            </div>
            <div class="panel-body">

                @if($result['type'] == "Likert Scale")
                    <?php $grid = $result['grid'] ?>
                    <div id="chart{{ $questionNo }}" style="height: 300px;  "></div>
                    <table class="table dataable">
                        Out of {{ $totalResponse }} responses - {{ $result['respondents'] }}
                        answered,
                        {{ $totalResponse - $result['respondents'] }} skipped
                        <thead>
                        <tr>
                            <th></th>
                            @foreach($grid['headers'] as $header)
                                <th>{{ $header['label'] }}</th>
                            @endforeach
                            <th>Total</th>
                            <th>Average</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($grid['rows'] as $row)
                            <tr>
                                <th>{{ $row['label'] }}</th>
                                @foreach($row['cols'] as $col)
                                    <td>{{ $col }}</td>
                                @endforeach
                                <td><b>{{ $row['total'] }}</b></td>
                                <td><b>{{ $row['average'] }}</b></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <div id="chart-holder">
                        <div id="chart{{ $questionNo }}" style="height: 300px;"></div>
                        <label id="chart-data{{ $questionNo }}"
                               style="position: relative; bottom: 200px; left: 47.25%;"></label>
                    </div>
                    <table class="table table-bordered datatable">
                        Out of {{ $totalResponse }} responses - {{ $result['respondents'] }}
                        answered,
                        {{ $totalResponse - $result['respondents'] }} skipped

                        <thead>
                        <tr>
                            <th>Choice Label</th>
                            <th>Responses</th>
                            <th>Percentage</th>
                        </tr>
                        </thead>
                        @foreach($result['datas'] as $data)
                            <tr>
                                <td>{{ $data['label'] }}</td>
                                <td>{{ $data['data'] }}</td>
                                <td>{{ $result['total'] > 0 ? number_format($data['data'] / $result['total'] * 100, 2, '.', ',') : 0 }}
                                    %
                                </td>
                            </tr>
                        @endforeach
                        <tfoot>
                        <tr>
                            <th>Total</th>
                            <th>{{ $result['total'] }}</th>
                            <th>{{ $result['total'] > 0 ? 100 : 0 }}%</th>
                        </tr>
                        @if($result['type'] == "Rating Scale")
                            <tr>
                                <th>Average</th>
                                <td colspan="2">{{ $result['average'] }}</td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    Standard Deviation of
                                    <b>{{ $result['standardDeviation'] }}</b>
                                    - A standard deviation of small value means that the values, in
                                    a distribution are scattered or spread out near the mean and
                                    vice versa.
                                </td>
                            </tr>
                        @endif
                        </tfoot>
                    </table>
                @endif
            </div>
        </div>
        <?php $questionNo++ ?>
    @endforeach
@else
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3>No Responses Found</h3>
        </div>
    </div>
@endif

<script>
    var results = <?php echo json_encode($results) ?>;
</script>