@extends('layouts.portal')

@section('title')
 QuasarEsh's Testing (test 1) Page
@endsection

@section('styles')
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.css" />
@endsection


@section('precontent')
{{-- precontent --}}
@endsection

@section('content')
<div class="row">
 <div class="col-sm">
  <div class="bg-gradient-orange p-3 p-xl-5 text-white mb-3">
   a box to show things
  </div>
 </div>
 <div class="col-sm">
  <div class="bg-gradient-cyan p-3 p-xl-5 text-white mb-3">
   a box to show things
  </div>
 </div>
 <div class="col-sm">
  <div class="bg-gradient-purple p-3 p-xl-5 text-white mb-3">
   a box to show things
  </div>
 </div>
</div>
<div class="card card-body p-3 mb-3">
 <div class="row">
  <div class="col-sm-6 order-2 order-xl-1 col-xl-3 mb-3">
   <h4 class="mb-3 poppins">
    Requests
   </h4>
   <div class="chart-container d-none d-lg-block">
    <canvas id="bar-chart-horizontal"></canvas>
   </div>
   <div class="row poppins">
    <div class="col col-lg-12 mb-3">
     <div class="xx p-3 mb-0">
      stats
     </div><!-- /.card -->
    </div>
    <div class="col col-lg-12 mb-3">
     <div class="xx p-3 mb-0">
      stats
     </div><!-- /.card -->
    </div>
   </div>
   <a href="#" class="btn btn-primary d-lg-block">
    button here
   </a>
  </div>
  <div class="col-sm-12 order-1 order-xl-2 col-xl-6 mb-3">
   {{-- <div class="chart-container" style="position: relative;">
    <canvas id="mixedChart"></canvas>
   </div> --}}
   <div class="chart-container">
    <canvas id="testChart"></canvas>
   </div>
  </div>
  <div class="col-sm-6 order-3 col-xl-3 mb-3">
   <h4 class="mb-3 poppins">
    Users
   </h4>
   <div class="chart-container d-none d-lg-block">
    <canvas id="doughnut"></canvas>
   </div>
   <div class="row poppins">
    <div class="col col-lg-12 mb-3">
     <div class="xx p-3 mb-0">
      stats
     </div><!-- /.card -->
    </div>
    <div class="col col-lg-12 mb-3">
     <div class="xx p-3 mb-0">
      stats
     </div><!-- /.card -->
    </div>
   </div>
   <a href="#" class="btn btn-primary d-lg-block">
    button here
   </a>
  </div>
 </div><!-- /.row -->
 <hr class="mt-3 mb-3" />
 <div class="row">
  <div class="col-sm-6 col-lg">
   <div class="row ml-0 mr-0 mb-3 alert-secondary">
    <div class="col-auto p-2 bg-secondary text-white">
     [icon]
    </div>
    <div class="col p-2">
     box
    </div>
   </div><!-- /.row -->
  </div>
  <div class="col-sm-6 col-lg">
   <div class="row ml-0 mr-0 mb-3 alert-secondary">
    <div class="col-auto p-2 bg-secondary text-white">
     [icon]
    </div>
    <div class="col p-2">
     box
    </div>
   </div><!-- /.row -->
  </div>
  <div class="col-sm-6 col-lg">
   <div class="row ml-0 mr-0 mb-3 alert-secondary">
    <div class="col-auto p-2 bg-secondary text-white">
     [icon]
    </div>
    <div class="col p-2">
     box
    </div>
   </div><!-- /.row -->
  </div>
  <div class="col-sm-6 col-lg">
   <div class="row ml-0 mr-0 mb-3 alert-secondary">
    <div class="col-auto p-2 bg-secondary text-white">
     [icon]
    </div>
    <div class="col p-2">
     box
    </div>
   </div><!-- /.row -->
  </div>
 </div><!-- /.row -->
</div>
content
@endsection

@section('scripts')
 <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js"></script> 
 <script>
  !function($) {
   var ChartJs = function() {};
   ChartJs.prototype.respChart = function(selector,type,data, options) {
    // get selector by context
    var ctx = selector.get(0).getContext("2d");
    // pointing parent container to make chart js inherit its width
    var container = $(selector).parent();
    // enable resizing matter
    $(window).resize( generateChart );
    // this function produce the responsive Chart JS
    function generateChart(){
     // make chart width fit with its container
     var ww = selector.attr('width', $(container).width() );
     switch(type){
      case 'Line':
       new Chart(ctx, {type: 'line', data: data, options: options});
       break;
      case 'Doughnut':
       new Chart(ctx, {type: 'doughnut', data: data, options: options});
       break;
      case 'Pie':
       new Chart(ctx, {type: 'pie', data: data, options: options});
       break;
      case 'Bar':
       new Chart(ctx, {type: 'bar', data: data, options: options});
       break;
      case 'Radar':
       new Chart(ctx, {type: 'radar', data: data, options: options});
       break;
      case 'PolarArea':
       new Chart(ctx, {data: data, type: 'polarArea', options: options});
       break;
     }
     // Initiate new chart or Redraw
    };
    // run function - render chart at first load
    generateChart();
   },
   //init

   ChartJs.prototype.init = function() {
    new Chart(document.getElementById("doughnut"), {
     type: 'doughnut',
     data: {
      labels: ["Physician Users", "Pharma Users", "EAC Users"],
      datasets: [{
       borderWidth: 0,
       label: "Approved User Types",
       backgroundColor: ["#89c442", "#f79223","#024e82"],
       data: [50,17,14]
      }]
     },
     options: {
      legend: {
       display: true,
       labels: {
        fontSize: 15,
        fontFamily: 'Poppins'
       },
       position: 'right'
      },
      title: {
       display: false,
       text: 'Approved User Types'
      }
     }
    });


    new Chart(document.getElementById("bar-chart-horizontal"), {
     type: 'horizontalBar',
     data: {
      labels: ["ATB200", "Rimegepant", "Migalastat (Galafold)", "MT1621", "BHV-0223"],
      datasets: [{
       label: "Requests",
       backgroundColor: ["#f79223", "#8e5ea2","#89c442","#e8c3b9","#024e82"],
       data: [3,2,13,8,71]
      }]
     },
     options: {
      scales: {
       yAxes: [{
        display: true,
        ticks: {
         fontFamily: "Poppins",
         beginAtZero: true,   // minimum value will be 0.
        }
       }],
       xAxes: [{
        ticks: {
         fontFamily: "Poppins",
        }
       }],
      },

      legend: { display: false },
      title: {
      display: true,
      text: 'Drugs Requested'
     }}
    });

    new Chart(document.getElementById("testChart"), {
     type: 'line',
     data: {
      labels: [1,2,3,4,5,6,7,8],
      datasets: [{ 
       data: [0, 5, 6, 8, 25, 9, 8, 24],
       label: "Teal",
       borderColor: "#4FC3F7",
       pointBackgroundColor: "#4FC3F7",
       backgroundColor: "rgba(79,195,247,.2)"
      }, { 
       data: [0, 3, 1, 2, 8, 1, 5, 1],
       label: "Purple",
       borderColor: "#7460EE",
       pointBackgroundColor: "#7460EE",
       backgroundColor: "rgba(116,96,238,.2)"
      }]
     },
     options: {
      scales: {
       yAxes: [{
        gridLines: {
         color: "rgba(0,0,0,.05)",
         display: true
        }
       }],
       xAxes: [{
        gridLines: {
         color: "rgba(0,0,0,.05)",
         display: true
        }
       }]
      },
      legend: { display: false },
      title: {
       display: false
      }
     }
    });

    new Chart(document.getElementById("mixedChart"), {
     type: 'bar',
     data: {
      labels: ["<?= date('Y') ?>", "{{date('Y', strtotime('-1 year')) }}", "{{date('Y', strtotime('-2 year')) }}", "{{date('Y', strtotime('-3 year')) }}"],
      datasets: [{
       label: "Requests",
       type: "bar",
       backgroundColor: "rgba(0,0,0,0.2)",
       borderWidth: "0",
       data: ["47", "68", "57", "51"],
      }, {
       label: "Shipments",
       type: "bar",
       backgroundColor: "rgba(0,0,0,0.5)",
       borderWidth: "0",
       data: ["42", "68", "57", "51"],
       fill: false
      }]
     },
     options: {
      title: {
       display: true,
       text: 'Requests & Shipments'
      }
     }
    });

   },
   $.ChartJs = new ChartJs, $.ChartJs.Constructor = ChartJs

  }(window.jQuery),

  //initializing
  function($) {
   "use strict";
   $.ChartJs.init()
  }(window.jQuery);
 </script>
@endsection