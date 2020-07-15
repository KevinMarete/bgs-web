<div class="sb-page-header pb-10 sb-page-header-dark bg-gradient-primary-to-secondary">
  <div class="container-fluid">
    <div class="sb-page-header-content py-5">
      <h1 class="sb-page-header-title">
        <div class="sb-page-header-icon"><i data-feather="activity"></i></div>
        <span>View RFQ#{{ $rfq['id'] }}</span>
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
      <a href="/rfq/manage/{{ $rfq['id'] }}" class="btn btn-primary ml-auto">
        <i data-feather="plus"></i>
        Manage RFQ
      </a>
    </div>
    <div class="card-body">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-5">
            <div class="sb-datatable table-responsive">
              <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                <caption style="caption-side: top">RFQSummary</caption>
                <tbody>
                  <tr>
                    <td>Status</td>
                    <td><strong>{{ $rfq['status'] }}</strong></td>
                  </tr>
                  <tr>
                    <td>RFQDate</td>
                    <td>{{ $rfq['created_at'] }}</td>
                  </tr>
                  <tr>
                    <td>Organization</td>
                    <td><strong>{{ ($role_name == 'seller' ) ? $rfq['organization']['name'] : $rfq['rfq_items'][0]['organization']['name'] }}</strong></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="col-md-7">
            <div class="sb-datatable table-responsive">
              <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                <caption style="caption-side: top">RFQLogs</caption>
                <thead>
                  <tr>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>User</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>User</th>
                  </tr>
                </tfoot>
                <tbody>
                  @foreach ($rfq['rfq_logs'] as $rfq_log)
                  <tr>
                    <td>{{ $rfq_log['status'] }}</td>
                    <td>{{ $rfq_log['created_at'] }}</td>
                    <td>{{ $rfq_log['user']['firstname'].' '.$rfq_log['user']['lastname'] }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="sb-datatable table-responsive">
              <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <caption style="caption-side: top">RFQItems</caption>
                <thead>
                  <tr>
                    <th>ProductName</th>
                    <th>Quantity</th>
                    <th>OutofStock</th>
                    <th>UnitPrice</th>
                    <th>ShippingPrice</th>
                    <th>Total</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>ProductName</th>
                    <th>Quantity</th>
                    <th>OutofStock</th>
                    <th>UnitPrice</th>
                    <th>ShippingPrice</th>
                    <th>Total</th>
                  </tr>
                </tfoot>
                <tbody>
                  @foreach ($rfq['rfq_items'] as $rfq_item)
                  <tr>
                    <td>{{ $rfq_item['product_now']['product']['molecular_name'] }}</td>
                    <td>{{ number_format($rfq_item['quantity']) }}</td>
                    <td><strong>{{ ($rfq_item['out_of_stock']) ? 'Yes' : 'No' }}</strong></td>
                    <td>KES {{ number_format($rfq_item['unit_price']) }}</td>
                    <td>KES {{ number_format($rfq_item['shipping_price']) }}</td>
                    <td>KES {{ number_format($rfq_item['total_cost']) }}</td>
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