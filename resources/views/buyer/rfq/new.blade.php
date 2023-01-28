<div class="sb-page-header pb-10 sb-page-header-dark bg-gradient-primary-to-secondary">
  <div class="container-fluid">
    <div class="sb-page-header-content py-5">
      <h1 class="sb-page-header-title">
        <div class="sb-page-header-icon"><i data-feather="activity"></i></div>
        <span>New RFQ</span>
      </h1>
    </div>
  </div>
</div>
<div class="container-fluid mt-n10">
  <div class="card mb-4">
    <div class="card-header"> </div>
    <div class="card-body">
      <form role="form" action="/rfq/save" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group row">
          <div class="col-lg-9 mx-auto text-center">
            <label for="rfq_organizations">Seller(s)</label>
            <input type="hidden" id="rfq_cost" value="{{ $rfq_cost }}" />
            <input type="hidden" id="rfq_discount" value="{{ $rfq_discount }}" />
            <input type="hidden" id="total_rfq_cost" name="total_rfq_cost" value="" />
            <select class="form-control btn btn-outline-primary" size="0" name="organizations[]" id="rfq_organizations" multiple="multiple" required>
              @foreach ($supplier_categories as $supplier_category => $organizations)
                    <optgroup label="{{ $supplier_category }}">
                        @foreach ($organizations as $organization)
                            <option value="{{ $organization['id'].'@'.implode(',', array_map(function($user){ return $user['email']; }, $organization['users'])) }}">{{ strtoupper($organization['name']) }}</option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
          </div>
        </div>
        <div class="form-group row">
          <div class="col-lg-9 mx-auto text-center">
            <p class="bg-info mt-2 p-2">
              RFQ charges are at KES. {{ number_format($rfq_cost) }} per seller [ <b>{{ $rfq_discount }}</b> discounted ]
            </p>
            <p class="bg-warning mt-2 p-2">
              Please note you will be charged a total of <strong>KES.<span id="total_rfq_cost_display">0</span></strong> for this transaction
            </p>
          </div>
        </div>
        <div class="form-group row">
          <div class="col-lg-9 mx-auto text-center">
            <div class="sb-datatable table-responsive">
              <table class="table table-bordered table-hover transactions-tbl" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Actions</th>
                  </tr>
                </tfoot>
                <tbody id="contents">
                  <tr class="tr_clone">
                    <td>
                      <input type="hidden" id="rfq_product_list" data-products="[]" />
                      <select class="rfq_product col-md-12" size="0" name="product_nows[]" required>
                        <option value="">Select Product</option>
                        @foreach ($productnows as $productnow_id => $productnow_name)
                        <option value="{{ $productnow_id.'@'.$productnow_name }}">{{ $productnow_name }}</option>
                        @endforeach
                      </select>
                    </td>
                    <td>
                      <input type="text" class="quantity" value="" name="quantity[]" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required />
                    </td>
                    <td>
                      <a href="#" class="add_rfq_product"><i class="fa fa-plus"></i></a> |
                      <a href="#" class="remove"><i class="fa fa-minus"></i></a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label"></label>
          <div class="col-lg-9">
            <button type="reset" class="btn btn-secondary"><i class="fa fa-refresh"></i>&nbsp;Cancel</button>
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;Submit RFQ</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
