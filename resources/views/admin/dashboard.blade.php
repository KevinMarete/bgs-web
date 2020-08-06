<div class="sb-page-header pb-10 sb-page-header-dark bg-gradient-primary-to-secondary">
    <div class="container-fluid">
        <div class="sb-page-header-content py-5">
            <h1 class="sb-page-header-title">
                <div class="sb-page-header-icon"><i data-feather="activity"></i></div>
                <span>Dashboard</span>
            </h1>
        </div>
    </div>
</div>
<div class="container-fluid mt-n10">
    <div class="card mb-4">
        <div class="card-header">
            <div class="ml-auto">Filter Here</div>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach($charts as $chart)
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">{{ $chart['title'] }}</div>
                        <div class="card-body">
                            <div class="{{ $chart['class'] }}"><canvas id="{{ $chart['id'] }}" class="{{ $chart['class'] }}-chart" width="{{ $chart['width'] }}" height="{{ $chart['height'] }}"></canvas></div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <script src="libs/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>