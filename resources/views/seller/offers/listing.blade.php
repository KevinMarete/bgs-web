<div class="sb-page-header pb-10 sb-page-header-dark bg-gradient-primary-to-secondary">
  <div class="container-fluid">
    <div class="sb-page-header-content py-5">
      <h1 class="sb-page-header-title">
        <div class="sb-page-header-icon"><i data-feather="activity"></i></div>
        <span>My Offers </span>
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
            <a href="" data-target="#offers" data-toggle="tab" class="nav-link active">My Offers</a>
          </li>
          <li class="nav-item">
            <a href="" data-target="#deals" data-toggle="tab" class="nav-link">My Deals</a>
          </li>
        </ul>
        <div class="tab-content py-4">
          <div class="tab-pane active" id="offers">
            <div class="card mb-4">
              <div class="card-header">
                Offer Listing
                <a href="/offers/new" class="btn btn-primary ml-auto"><i data-feather="plus"></i> Add Offer</a>
              </div>
              <div class="card-body">
                <div class="sb-datatable table-responsive">
                  <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        @foreach ($offers['table_headers'] as $key => $header)
                        <th>{{ ucwords($header) }}</th>
                        @endforeach
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        @foreach ($offers['table_headers'] as $header)
                        <th>{{ ucwords($header) }}</th>
                        @endforeach
                        <th>Actions</th>
                      </tr>
                    </tfoot>
                    <tbody>
                      @foreach ($offers['table_data'] as $row)
                      <tr>
                        <td>{{ $row['id'] }}</td>
                        <td>{{ $row['description'] }}</td>
                        <td>{{ $row['valid_from'] }}</td>
                        <td>{{ $row['valid_until'] }}</td>
                        <td>{{ $row['discount'] }}</td>
                        <td>{{ $row['max_discount_amount'] }}</td>
                        <td>{{ $row['organization']['name'] }}</td>
                        <td>
                          <a href="/offers/edit/{{ $row['id'] }}" class="btn sb-btn-datatable sb-btn-icon sb-btn-transparent-dark mr-2">
                            <i data-feather="more-vertical"></i>
                          </a>
                          <a href="/offers/delete/{{ $row['id'] }}" class="delete btn sb-btn-datatable sb-btn-icon sb-btn-transparent-dark">
                            <i data-feather="trash-2"></i>
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
          <div class="tab-pane" id="deals">
            <div class="card mb-4">
              <div class="card-header">
                Deals Listing
                <a href="/deals/new" class="btn btn-primary ml-auto">
                  <i data-feather="plus"></i>
                  Add Deals
                </a>
              </div>
              <div class="card-body">
                <div class="sb-datatable table-responsive">
                  <table class="table table-bordered table-hover dataTable" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        @foreach ($productdeals['table_headers'] as $key => $header)
                        <th>{{ ucwords($header) }}</th>
                        @endforeach
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        @foreach ($productdeals['table_headers'] as $header)
                        <th>{{ ucwords($header) }}</th>
                        @endforeach
                        <th>Actions</th>
                      </tr>
                    </tfoot>
                    <tbody>
                      @foreach ($productdeals['table_data'] as $row)
                      <tr>
                        <td>{{ $row['id'] }}</td>
                        <td>{{ $row['product_now']['product']['molecular_name'] }}</td>
                        <td>{{ $row['product_now']['product']['brand_name'] }}</td>
                        <td>{{ $row['minimum_order_quantity'] }}</td>
                        <td>{{ $row['product_now']['unit_price'] }}</td>
                        <td>{{ $row['offer']['discount'] }}</td>
                        <td>{{ $row['offer']['max_discount_amount'] }}</td>
                        <td>
                          <a href="/deals/edit/{{ $row['id'] }}" class="btn sb-btn-datatable sb-btn-icon sb-btn-transparent-dark mr-2">
                            <i data-feather="more-vertical"></i>
                          </a>
                          <a href="/deals/delete/{{ $row['id'] }}" class="delete btn sb-btn-datatable sb-btn-icon sb-btn-transparent-dark">
                            <i data-feather="trash-2"></i>
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
</div>