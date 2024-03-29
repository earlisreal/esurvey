/**
 * Created by ching on 1/30/2017.
 */

function showPieChart(){

    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $("#platformChart").get(0).getContext("2d");
    var pieChart = new Chart(pieChartCanvas);
    var pieOptions = {
        //Boolean - Whether we should show a stroke on each segment
        segmentShowStroke: true,
        //String - The colour of each segment stroke
        segmentStrokeColor: "#fff",
        //Number - The width of each segment stroke
        segmentStrokeWidth: 2,
        //Number - The percentage of the chart that we cut out of the middle
        percentageInnerCutout: 0, // This is 0 for Pie charts
        //Number - Amount of animation steps
        animationSteps: 100,
        //String - Animation easing effect
        animationEasing: "easeOutBounce",
        //Boolean - Whether we animate the rotation of the Doughnut
        animateRotate: true,
        //Boolean - Whether we animate scaling the Doughnut from the centre
        animateScale: false,
        //Boolean - whether to make the chart responsive to window resizing
        responsive: true,
        // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
        maintainAspectRatio: true,
        tooltipEvents: [],
        showTooltips: true,
        onAnimationComplete: function () {
            this.showTooltip(this.segments, true);
        },
        tooltipTemplate: "<%= label %> - <%= value %>"
    };
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.3

    pieChart.Pie(PieData, pieOptions);
}

function showBarChart(){
    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $("#dateChart").get(0).getContext("2d");
    var barChart = new Chart(barChartCanvas);
    var barChartData = {
        labels: barLabels,
        datasets: [
            {
                label: "Total Respondents",
                fillColor: "rgba(60,141,188,0.9)",
                strokeColor: "rgba(60,141,188,0.8)",
                pointColor: "#3b8bba",
                pointStrokeColor: "rgba(60,141,188,1)",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(60,141,188,1)",
                data: barData
            }
        ]
    };
    console.log(barChartData);
//        barChartData.datasets[1].fillColor = "#00a65a";
//        barChartData.datasets[1].strokeColor = "#00a65a";
//        barChartData.datasets[1].pointColor = "#00a65a";
    var barChartOptions = {
        hovermode: "Total Respondents",
        //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
        scaleBeginAtZero: true,
        //Boolean - Whether grid lines are shown across the chart
        scaleShowGridLines: true,
        //String - Colour of the grid lines
        scaleGridLineColor: "rgba(0,0,0,.05)",
        //Number - Width of the grid lines
        scaleGridLineWidth: 1,
        //Boolean - Whether to show horizontal lines (except X axis)
        scaleShowHorizontalLines: true,
        //Boolean - Whether to show vertical lines (except Y axis)
        scaleShowVerticalLines: true,
        //Boolean - If there is a stroke on each bar
        barShowStroke: true,
        //Number - Pixel width of the bar stroke
        barStrokeWidth: 2,
        //Number - Spacing between each of the X value sets
        barValueSpacing: 5,
        //Number - Spacing between data sets within X values
        barDatasetSpacing: 1,
        tooltipTemplate: "<%if (label){%>Total Respondents: <%}%><%= value + ' ' %>",
        <!--            multiTooltipTemplate: "Total Respondents : <%%= value %>",-->
        //String - A legend template
        legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
        //Boolean - whether to make the chart responsive
        responsive: true,
        maintainAspectRatio: true
    };

    barChartOptions.datasetFill = false;

    barChart.Bar(barChartData, barChartOptions);
}