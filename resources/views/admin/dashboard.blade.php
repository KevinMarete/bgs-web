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
            <div class="ml-auto">
                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                <input type="hidden" id="dash_start" value="{{ $dash_start }}" />
                <input type="hidden" id="dash_end" value="{{ $dash_end }}" />
                <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                    <i class="fa fa-calendar"></i>&nbsp;
                    <span></span> <i class="fa fa-caret-down"></i>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach($charts as $chart)
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">{{ $chart['title'] }}</div>
                        <div class="card-body">
                            <div class="{{ $chart['class'] }}">
                                <canvas id="{{ $chart['id'] }}" class="{{ $chart['class'] }}-chart" width="{{ $chart['width'] }}" height="{{ $chart['height'] }}" data-labels="{{ json_encode($chart['data']['labels']) }}" data-datasets="{{ json_encode($chart['data']['datasets']) }}"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>