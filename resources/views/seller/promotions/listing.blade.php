<div class="sb-page-header pb-10 sb-page-header-dark bg-gradient-primary-to-secondary">
  <div class="container-fluid">
    <div class="sb-page-header-content py-5">
      <h1 class="sb-page-header-title">
        <div class="sb-page-header-icon"><i data-feather="activity"></i></div>
        <span>Promotions</span>
      </h1>
    </div>
  </div>
</div>
<div class="container-fluid mt-n10">
  @if (Session::has('bgs_msg'))
  {!! session('bgs_msg') !!}
  @endif
  <div class="card mb-4">
    <div class="card-header"> </div>
    <div class="card-body">
      <div class="col-lg-12">
        <ul class="nav nav-tabs">
          <li class="nav-item">
            <a href="" data-target="#slider" data-toggle="tab" class="nav-link active">Slider</a>
          </li>
          <li class="nav-item">
            <a href="" data-target="#static" data-toggle="tab" class="nav-link">Static</a>
          </li>
        </ul>
        <div class="tab-content py-4">
          <div class="tab-pane active" id="slider">
            <div class="card mb-4">
              <div class="card-header">
                Slider Promotion Listing
                <a href="/promotions/new/slider" class="btn btn-primary ml-auto">
                  <i data-feather="plus"></i>
                  Add Slider Promotion
                </a>
              </div>
              <div class="card-body">
                <div class="sb-datatable table-responsive">
                  <table class="table table-bordered table-hover dataTable" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        @foreach ($slider['table_headers'] as $header)
                        <th>{{ ucwords($header) }}</th>
                        @endforeach
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        @foreach ($slider['table_headers'] as $header)
                        <th>{{ ucwords($header) }}</th>
                        @endforeach
                        <th>Actions</th>
                      </tr>
                    </tfoot>
                    <tbody>
                      @foreach ($slider['table_data'] as $row)
                      <tr>
                        <td>{{ $row['id'] }}</td>
                        <td>{{ $row['status'] }}</td>
                        <td>{{ $row['display_date'] }}</td>
                        <td>{{ $row['product_now']['product']['brand_name'] }}</td>
                        <td>
                          <a href="/promotions/edit/slider/{{ $row['id'] }}" class="btn sb-btn-datatable sb-btn-icon sb-btn-transparent-dark mr-2">
                            <i data-feather="edit"></i>
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
          <div class="tab-pane" id="static">
            <div class="card mb-4">
              <div class="card-header">
                Static Promotion Listing
                <a href="/promotions/new/static" class="btn btn-primary ml-auto">
                  <i data-feather="plus"></i>
                  Add Static Promotion
                </a>
              </div>
              <div class="card-body">
                <div class="sb-datatable table-responsive">
                  <table class="table table-bordered table-hover dataTable" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        @foreach ($static['table_headers'] as $header)
                        <th>{{ ucwords($header) }}</th>
                        @endforeach
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        @foreach ($static['table_headers'] as $header)
                        <th>{{ ucwords($header) }}</th>
                        @endforeach
                        <th>Actions</th>
                      </tr>
                    </tfoot>
                    <tbody>
                      @foreach ($static['table_data'] as $row)
                      <tr>
                        <td>{{ $row['id'] }}</td>
                        <td>{{ $row['status'] }}</td>
                        <td>{{ $row['display_date'] }}</td>
                        <td>{{ $row['product_now']['product']['brand_name'] }}</td>
                        <td>
                          <a href="/promotions/edit/static/{{ $row['id'] }}" class="btn sb-btn-datatable sb-btn-icon sb-btn-transparent-dark mr-2">
                            <i data-feather="edit"></i>
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
        </div>
      </div>
    </div>
  </div>