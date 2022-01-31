@extends('layouts.master')
@section('title')
    Flomuvina | Dashboard
@endsection
@section('link')
    <link href="{{ URL::to('assets/node_modules/morrisjs/morris.css') }}" rel="stylesheet">

@endsection

@section('content')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Dashboard</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>

                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->

        <div class="row">
            <div class="col-lg-2">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-uppercase text-center">Food Processor</h5>
                        <div class="text-center">
                            <h3 id="total_processor">20</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-uppercase text-center">Aggregators</h5>
                        <div class="text-center">
                            <h3 id="total_aggregator">20</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-uppercase text-center">WareHouse</h5>
                        <div class="text-center">
                            <h3 id="total_warehouse">5</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-uppercase text-center">No Of Commodity</h5>
                        <div class="text-center">
                            <h3>5</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-uppercase text-center">Total Revenue (FP)</h5>
                        <div class="text-center">
                            <h3 id="total_revenue_fp">4</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-uppercase text-center">Total Revenue(WH)</h5>
                        <div class="text-center">
                            <h3 id="total_revenue_wh">4</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-2">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-uppercase text-center">ToTal Volume Supplied to FP</h5>
                        <div class="text-center">
                            <h3 id="total_volume_fp">20</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-uppercase text-center">ToTal Volume Supplied to WH</h5>
                        <div class="text-center">
                            <h3 id="total_volume_wh">20</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-uppercase text-center">ToTal Volume Supplied </h5>
                        <div class="text-center">
                            <h3 id="total_volume_all">5</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-uppercase text-center">ToTal value Supplied to FP</h5>
                        <div class="text-center">
                            <h3 id="total_value_fp">4</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-uppercase text-center">ToTal value Supplied to WH</h5>
                        <div class="text-center">
                            <h3 id="total_value_wh">4</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-uppercase text-center">ToTal value Supplied</h5>
                        <div class="text-center">
                            <h3 id="total_value_all">4</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <h5 class="card-title text-uppercase">Volume of Trade Per Month<br><small
                                    class="text-muted">All
                                    Figures are in MT</small></h5>

                        </div>
                        <div id="volume-summary-chart" style="height:375px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <h5 class="card-title text-uppercase">Value of Trade Per Month<br><small
                                    class="text-muted">All
                                    Figures are in Millions(&#8358;)</small></h5>

                        </div>
                        <div id="value-summary-chart" style="height:375px;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <h5 class="card-title text-uppercase">Trade by Commodity<br></h5>

                        </div>
                        <div id="commodity-distribution-pie-chart" style="height:375px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <h5 class="card-title text-uppercase">Trade by Commodity<br></h5>

                        </div>
                        <div id="warehouse-geo-chart" style="height:375px;"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End PAge Content -->
        <!-- ============================================================== -->

    </div>
@endsection
@section('script')
    <script src="{{ URL::to('assets/node_modules/morrisjs/morris.min.js') }}"> </script>
    <script src="{{ URL::to('assets/node_modules/raphael/raphael-min.js') }}"> </script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $.ajax({
                url: "{{ route('dashboardReport') }}",
                type: "GET",
                dataType: "json",
                success: function(data) {
                    //console.log(data);
                    $.each(data.generic, function(i, dat) {
                        var total_volume_all = parseInt(dat.total_volume_fp) + parseInt(dat
                            .total_volume_wh);
                        var total_value_all = parseInt(dat.total_value_fp) + parseInt(dat
                            .total_value_wh);
                        $('#total_processor').html(dat.total_processor);
                        $('#total_aggregator').html(dat.total_aggregator);
                        $('#total_warehouse').html(dat.total_warehouse);
                        $('#total_revenue_fp').html('&#8358;' + dat.total_revenue_fp);
                        $('#total_revenue_wh').html('&#8358;' + dat.total_revenue_wh);
                        $('#total_volume_fp').html(parseInt(dat.total_volume_fp)
                        .toLocaleString() + 'MT');
                        $('#total_volume_wh').html(parseInt(dat.total_volume_wh)
                        .toLocaleString() + 'MT');
                        $('#total_volume_all').html(total_volume_all.toLocaleString() + 'MT');
                        $('#total_value_fp').html('&#8358;' + (parseInt(dat.total_value_fp)
                            .toLocaleString()));
                        $('#total_value_wh').html('&#8358;' + parseInt(dat.total_value_wh)
                            .toLocaleString());
                        $('#total_value_all').html('&#8358;' + total_value_all.toLocaleString());

                    });
                    if (typeof Morris != 'undefined') {
                        Morris.Bar({
                            element: 'volume-summary-chart',
                            data: Object.keys(data.volumeSummary).map(function(key) {
                                return data.volumeSummary[key]
                            }),
                            xkey: 'month',
                            ykeys: ['volume'],
                            labels: ['Volume per month'],
                            barColors: ['#00c292'],
                            hideHover: 'auto',
                        });
                        Morris.Bar({
                            element: 'value-summary-chart',
                            data: Object.keys(data.valueSummary).map(function(key) {
                                return data.valueSummary[key]
                            }),
                            xkey: 'month',
                            ykeys: ['value'],
                            labels: ['Value per month'],
                            barColors: ['#00a5e5'],
                            hideHover: 'auto',
                        });
                    }

                    charts(data.pieChartReport, 'PieChart');
                    charts(data.geoChartReport, 'GeoChart');
                }
            });

            function charts(data, chartType) {
                var jsonData = data;
                google.charts.load('current', {
                    'packages': ['bar', 'corechart', 'geochart']
                });
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {
                    var data = new google.visualization.DataTable();
                    data.addColumn('string', 'state');
                    data.addColumn('number', '');
                    $.each(jsonData, function(i, jsonData) {
                        var value = parseInt(jsonData.value);
                        var name = jsonData.commodity;
                        data.addRows([
                            [name, value]
                        ]);
                    });

                    var options = {
                        animation: {
                            duration: 3000,
                            easing: 'out',
                            startup: true
                        },
                        region: 'NG',
                        displayMode: 'regions',
                        resolution: 'provinces',
                        title: 'Number of Transaction per commodity',
                        colorAxis: {
                            colors: ['blue', 'green']
                        },
                        datalessRegionColor: '#dedede',
                        defaultColor: '#dedede'
                    }

                    var chart;
                    if (chartType == 'PieChart') {
                        chart = new google.visualization.PieChart(document.getElementById(
                            'commodity-distribution-pie-chart'));
                    } else if (chartType == 'GeoChart') {
                        var geoData = new google.visualization.DataTable();
                        geoData.addColumn('string', 'State');
                        geoData.addColumn('number', 'No Of Warehouse');
                        geoData.addColumn('string', 'Code');
                        $.each(jsonData, function(i, jsonData) {
                            var value = parseInt(jsonData.value);
                            var name = jsonData.name;
                            var cCode = jsonData.code;
                            geoData.addRows([
                                [name, value, cCode]
                            ]);
                        });

                        var geoChart = new google.visualization.GeoChart(document.getElementById(
                            'warehouse-geo-chart'));

                        var formatter = new google.visualization.PatternFormat('{0}');
                        formatter.format(geoData, [0, 1], 2);

                        var view = new google.visualization.DataView(geoData);
                        view.setColumns([2, 1]);
                        geoChart.draw(view, options);
                        return;
                    }

                    chart.draw(data, options);
                }
            }


        });
    </script>
@endsection
