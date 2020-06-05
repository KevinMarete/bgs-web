<div class="sb-page-header pb-10 sb-page-header-dark bg-gradient-primary-to-secondary">
  <div class="container-fluid">
    <div class="sb-page-header-content py-5">
      <h1 class="sb-page-header-title">
        <div class="sb-page-header-icon"><i data-feather="activity"></i></div>
        <span>New PriceList Item(s)</span>
      </h1>
    </div>
  </div>
</div>
<div class="container-fluid mt-n10">
  <div class="card mb-4">
    <div class="card-header"> </div>
    <div class="card-body">
      <form role="form" action="/pricelist/save" method="POST">
        @csrf
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="sb-datatable table-responsive">
                <table class="table table-bordered table-hover transactions-tbl" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Product Name</th>
                      <th>Unit Price</th>
                      <th>Delivery Cost</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Product Name</th>
                      <th>Unit Price</th>
                      <th>Delivery Cost</th>
                      <th>Actions</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <tr class="tr_clone">
                      <td>
                        <select class="product col-md-12" size="0" name="product_id[]" required>
                          <option value="">Select Product</option>
                          @foreach ($products as $product)
                          <option value="{{ $product['product_id'] }}">{{ $product['molecular_name']  }}</option>
                          @endforeach
                        </select>
                      </td>
                      <td>
                        <input type="text" class="unit_price" value="" name="unit_price[]" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required />
                      </td>
                      <td>
                        <input type="text" class="delivery_cost" value="" name="delivery_cost[]" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required />
                        <input type="hidden" name="is_published[]" value="0">
                      </td>
                      <td>
                        <a href="#" class="add"><i class="fa fa-plus"></i></a> |
                        <a href="#" class="remove"><i class="fa fa-minus"></i></a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;Save</button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>