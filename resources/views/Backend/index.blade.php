@extends('Backend.masterpage.masterpage')
@section('titleForm')
<h4>Trang chủ</h4>
@endsection
@section('content')

<div class="main-content">
  @if (session('success'))
  <div class="alert alert-success">{{session('success')}}</div>
  @endif
  <div class="content-dashboard">
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-yellow"><i class="fa fa-users" aria-hidden="true"></i></span>
        <div class="info-box-content">
          <a href="{{ asset('admin/users') }}">
            <span class="info-box-text">Người dùng</span>
          </a>
          <span class="info-box-number">{{ $totalUsers }}</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-aqua"><i class="fa fa-edit" aria-hidden="true"></i></span>
        <div class="info-box-content">
          <a href="{{ asset('admin/quizs') }}">
            <span class="info-box-text">Kho câu hỏi</span>
          </a>
          <span class="info-box-number">{{ $totalTests }}</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
    {{-- <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-red"><i class="fa fa-newspaper-o"></i></span>
        <div class="info-box-content">
          <a href="{{ asset('bunpos') }}">
            <span class="info-box-text">Từ Vựng</span>
          </a>
          <span class="info-box-number">{{ $totalBunpos }}</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div> --}}
    <!-- /.col -->
    {{-- <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-green"><i class="fa fa-video-camera" aria-hidden="true"></i></span>
        <div class="info-box-content">
          <a href="{{ asset('videos') }}">
            <span class="info-box-text">Video</span>
          </a>
          <span class="info-box-number">{{$totalVideos}}</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    --}}
  </div>

</div>
<script>
  /*$(function () {

    'use strict';

    // -----------------------
    // - MONTHLY SALES CHART -
    // -----------------------

    // Get context with jQuery - using jQuery's .get() method.
    var statisticsChartCanvas = $('#statisticsChart').get(0).getContext('2d');
    // This will get the first returned node in the jQuery collection.
    var statisticsChart       = new Chart(statisticsChartCanvas);

    var statisticsChartData = {
      labels  : ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
      datasets: [
      {
        label               : 'Electronics',
        fillColor           : 'rgb(210, 214, 222)',
        strokeColor         : 'rgb(210, 214, 222)',
        pointColor          : 'rgb(210, 214, 222)',
        pointStrokeColor    : '#c1c7d1',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgb(220,220,220)',
        data                : [65, 59, 80, 81, 56, 55, 40, 59, 80, 81, 56, 55]
      },
      {
        label               : 'Digital Goods',
        fillColor           : 'rgba(60,141,188,0.9)',
        strokeColor         : 'rgba(60,141,188,0.8)',
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
        data                : [28, 48, 40, 19, 86, 27, 90, 48, 40, 19, 86, 27]
      }
      ]
    };

    var statisticsChartOptions = {
      // Boolean - If we should show the scale at all
      showScale               : true,
      // Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines      : false,
      // String - Colour of the grid lines
      scaleGridLineColor      : 'rgba(0,0,0,.05)',
      // Number - Width of the grid lines
      scaleGridLineWidth      : 1,
      // Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      // Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines  : true,
      // Boolean - Whether the line is curved between points
      bezierCurve             : true,
      // Number - Tension of the bezier curve between points
      bezierCurveTension      : 0.3,
      // Boolean - Whether to show a dot for each point
      pointDot                : false,
      // Number - Radius of each point dot in pixels
      pointDotRadius          : 4,
      // Number - Pixel width of point dot stroke
      pointDotStrokeWidth     : 1,
      // Number - amount extra to add to the radius to cater for hit detection outside the drawn point
      pointHitDetectionRadius : 20,
      // Boolean - Whether to show a stroke for datasets
      datasetStroke           : true,
      // Number - Pixel width of dataset stroke
      datasetStrokeWidth      : 2,
      // Boolean - Whether to fill the dataset with a color
      datasetFill             : true,
      // String - A legend template
      legendTemplate          : '<ul class=\'<%=name.toLowerCase()%>-legend\'><% for (var i=0; i<datasets.length; i++){%><li><span style=\'background-color:<%=datasets[i].lineColor%>\'></span><%=datasets[i].label%></li><%}%></ul>',
      // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio     : true,
      // Boolean - whether to make the chart responsive to window resizing
      responsive              : true
    };

    // Create the line chart
    statisticsChart.Line(statisticsChartData, statisticsChartOptions);

    // ---------------------------
    // - END MONTHLY SALES CHART -
    // ---------------------------
  });*/
</script>
@endsection