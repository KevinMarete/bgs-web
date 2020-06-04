<div class="sb-page-header pb-10 sb-page-header-dark bg-gradient-primary-to-secondary">
  <div class="container-fluid">
    <div class="sb-page-header-content py-5">
      <h1 class="sb-page-header-title">
        <div class="sb-page-header-icon"><i data-feather="activity"></i></div>
        <span>Bulk PriceList Actions</span>
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
            <a href="" data-target="#unpublished" data-toggle="tab" class="nav-link active">My Unpublished Items</a>
          </li>
          <li class="nav-item">
            <a href="" data-target="#published" data-toggle="tab" class="nav-link">My Published Items</a>
          </li>
        </ul>
        <div class="tab-content py-4">
          <div class="tab-pane active" id="unpublished">
            <form role="form" action="/pricelist/publish" method="POST">
              @csrf
              <input type="hidden" name="is_published" value="1">
              <input type="hidden" name="currently_published" value="{{ sizeof($published['table_data']) }}">
              <input type="hidden" name="pricelist_ids" value="" class="pricelist_ids">
              <div class="card mb-4">
                <div class="card-header">
                  Unpublished Listing
                  <button type="submit" class="btn btn-primary ml-auto">
                    <i data-feather="maximize"></i> &nbsp; Bulk Publish
                  </button>
                </div>
                <div class="card-body">
                  <div class="sb-datatable table-responsive">
                    <table class="table table-bordered table-hover table-condensed" id="dataTable" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>
                            <input type="checkbox" class="bulk_all_unpublish">
                          </th>
                          @foreach ($unpublished['table_headers'] as $header)
                          <th>{{ ucwords($header) }}</th>
                          @endforeach
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th></th>
                          @foreach ($unpublished['table_headers'] as $header)
                          <th>{{ ucwords($header) }}</th>
                          @endforeach
                        </tr>
                      </tfoot>
                      <tbody>
                        @foreach ($unpublished['table_data'] as $row)
                        <tr>
                          <td>
                            <input type="checkbox" class="bulk_item_unpublish" value="{{ $row['id'] }}">
                          </td>
                          <td>{{ $row['id'] }}</td>
                          <td>{{ $row['product']['brand_name'] }}</td>
                          <td>{{ $row['product']['molecular_name'] }}</td>
                          <td>{{ $row['product']['pack_size'] }}</td>
                          <td>{{ ($row['is_published'] ? 'Yes' : 'No') }}</td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="tab-pane" id="published">
            <form role="form" action="/pricelist/publish" method="POST">
              @csrf
              <input type="hidden" name="is_published" value="0">
              <input type="hidden" name="currently_published" value="{{ sizeof($published['table_data']) }}">
              <input type="hidden" name="pricelist_ids" value="" class="pricelist_ids">
              <div class="card mb-4">
                <div class="card-header">
                  Published Listing
                  <button type="submit" class="btn btn-primary ml-auto">
                    <i data-feather="maximize"></i> &nbsp; Bulk Unpublish
                  </button>
                </div>
                <div class="card-body">
                  <div class="sb-datatable table-responsive">
                    <table class="table table-bordered table-hover table-condensed dataTable" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>
                            <input type="checkbox" class="bulk_all_publish">
                          </th>
                          @foreach ($published['table_headers'] as $header)
                          <th>{{ ucwords($header) }}</th>
                          @endforeach
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th></th>
                          @foreach ($published['table_headers'] as $header)
                          <th>{{ ucwords($header) }}</th>
                          @endforeach
                        </tr>
                      </tfoot>
                      <tbody>
                        @foreach ($published['table_data'] as $row)
                        <tr>
                          <td><input type="checkbox" class="bulk_item_publish" value="{{ $row['id'] }}"></td>
                          <td>{{ $row['id'] }}</td>
                          <td>{{ $row['product']['brand_name'] }}</td>
                          <td>{{ $row['product']['molecular_name'] }}</td>
                          <td>{{ $row['product']['pack_size'] }}</td>
                          <td>{{ ($row['is_published'] ? 'Yes' : 'No') }}</td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>