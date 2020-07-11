<div class="sb-page-header pb-10 sb-page-header-dark bg-gradient-primary-to-secondary">
  <div class="container-fluid">
    <div class="sb-page-header-content py-5">
      <h1 class="sb-page-header-title">
        <div class="sb-page-header-icon"><i data-feather="activity"></i></div>
        <span>Manage RFQ#{{ $rfq['id'] }}</span>
      </h1>
    </div>
  </div>
</div>
<div class="container-fluid mt-n10">
  <div class="card mb-4">
    <div class="card-header"></div>
    <div class="card-body">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="sb-datatable table-responsive">
              <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                <caption style="caption-side: top">RFQSummary</caption>
                <thead>
                  <tr>
                    <th>Status</th>
                    <th>RFQDate</th>
                    <th>Organization</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><strong>{{ $rfq['status'] }}</strong></td>
                    <td>{{ $rfq['created_at'] }}</td>
                    <td><strong>{{ ($role_name == 'seller' ) ? $rfq['organization']['name'] : $rfq['rfq_items'][0]['organization']['name'] }}</strong></td>
                  <tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <form role="form" action="/rfq/action/{{ $rfq['id'] }}" method="POST">
          @csrf
          <div class="row">
            <div class="col-md-3">
              @if(!empty($actions))
              @if($role_name == 'seller' && $rfq['status'] == 'created, awaiting_quotation')
              <div class="form-group">
                <label for="terms" class="col-form-label">RFQ Terms</label>
                <textarea name="terms" id="terms" style="min-width: 100%" required>{{ $rfq['terms'] }}</textarea>
              </div>
              @endif
              <div class="form-group">
                <label for="status" class="col-form-label">RFQ Status</label>
                <select class="form-control" name="status" id="status" required>
                  <option value="">Select Action</option>
                  @foreach($actions as $label => $action_status)
                  <option value="{{ $action_status }}"> {{ ucwords($label) }}</option>
                  @endforeach
                </select>
              </div>
              @if($role_name == 'buyer' && $rfq['status'] == 'quotation_sent, awaiting_confirmation' )
              <div class="form-group">
                <label for="reject_reason" class="col-form-label">Reject Reason</label>
                <select class="form-control" name="reject_reason_id" id="reject_reason" required>
                  <option value="">Select Reject Reason</option>
                  @foreach($rejectreasons as $rejectreason)
                  <option value="{{ $rejectreason['id'] }}"> {{ $rejectreason['name'] }}</option>
                  @endforeach
                </select>
              </div>
              @endif
              <div class="form-group">
                <label class="col-form-label"></label>
                <input type="hidden" name="id" value="{{ $rfq['id'] }}" />
                <input type="hidden" name="organization_id" value="{{ $rfq['organization_id'] }}" />
                <button type="submit" class="form-control btn btn-primary">
                  <i class="fa fa-save"></i> &nbsp; Save Action
                </button>
              </div>
              @else
              <span class="badge badge-success">No Action Required</span>
              @endif
            </div>
            <div class="col-md-9">
              <div class="sb-datatable table-responsive">
                <table class="table table-bordered table-hover" id="dataTable-" width="100%" cellspacing="0">
                  <caption style="caption-side: top">RFQItems</caption>
                  <thead>
                    <tr>
                      <th>ProductName</th>
                      <th>Quantity</th>
                      <th>OutofStock</th>
                      <th>UnitPrice</th>
                      <th>ShippingPrice</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>ProductName</th>
                      <th>Quantity</th>
                      <th>OutofStock</th>
                      <th>UnitPrice</th>
                      <th>ShippingPrice</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    @foreach ($rfq['rfq_items'] as $rfq_item)
                    <tr>
                      <td>{{ $rfq_item['product_now']['product']['molecular_name'] }}</td>
                      <td>{{ number_format($rfq_item['quantity']) }}</td>
                      @if($role_name == 'seller' && $rfq['status'] == 'created, awaiting_quotation')
                      <td>
                        <select name="out_of_stock[]">
                          <option value="0" {{ ($rfq_item['out_of_stock'] == 0) ? 'selected' : '' }}>No</option>
                          <option value="1" {{ ($rfq_item['out_of_stock'] == 1) ? 'selected' : '' }}>Yes</option>
                        </select>
                      <td>KES <input type="text" name="unit_price[]" value="{{ number_format($rfq_item['unit_price']) }}" required onkeypress="return event.charCode >= 48 && event.charCode <= 57" /></td>
                      <td>KES <input type="text" name="shipping_price[]" value="{{ number_format($rfq_item['shipping_price']) }}" required onkeypress="return event.charCode >= 48 && event.charCode <= 57" /></td>
                      @else
                      <td><strong>{{ ($rfq_item['out_of_stock']) ? 'Yes' : 'No' }}</strong></td>
                      <td>KES {{ number_format($rfq_item['unit_price']) }}</td>
                      <td>KES {{ number_format($rfq_item['shipping_price']) }}</td>
                      @endif
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