<div class="sb-page-header pb-10 sb-page-header-dark bg-gradient-primary-to-secondary">
    <div class="container-fluid">
        <div class="sb-page-header-content py-5">
            <h1 class="sb-page-header-title">
                <div class="sb-page-header-icon"><i data-feather="activity"></i></div>
                <span>Stocks</span>
            </h1>
        </div>
    </div>
</div>
<div class="container-fluid mt-n10">
    @if (Session::has('bgs_msg'))
    {!! session('bgs_msg') !!}
    @endif
    <div class="card mb-4">
        <div class="card-header">
            {{ $resource_name }} Listing
            <a href="/stocks/new" class="btn btn-primary ml-auto"><i data-feather="plus"></i> Manage Stocks</a>
        </div>
        <div class="card-body">
            <div class="sb-datatable table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            @foreach ($table_headers as $key => $header)
                            <th>{{ ucwords($header) }}</th>
                            @endforeach
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            @foreach ($table_headers as $header)
                            <th>{{ ucwords($header) }}</th>
                            @endforeach
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($table_data as $row)
                        <tr>
                            @foreach ($table_headers as $header)
                            <td>{{ $row[$header] }}</td>
                            @endforeach
                            <td>
                                <a href="/stocks/view/{{ $row['product_id'] }}" class="btn sb-btn-datatable sb-btn-icon sb-btn-transparent-dark mr-2">
                                    <i data-feather="eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>