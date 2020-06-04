<div class="sb-page-header pb-10 sb-page-header-dark bg-gradient-primary-to-secondary">
  <div class="container-fluid">
    <div class="sb-page-header-content py-5">
      <h1 class="sb-page-header-title">
        <div class="sb-page-header-icon"><i data-feather="activity"></i></div>
        <span>Import PriceList Item(s)</span>
      </h1>
    </div>
  </div>
</div>
<div class="container-fluid mt-n10">
  <div class="card mb-4">
    <div class="card-header"> </div>
    <div class="card-body">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-12 col-md-6 col-lg-8">
            <div class="card">
              <div class="card-header bg-primary text-white"><i class="fa fa-upload"></i> &nbsp; Import Template
              </div>
              <div class="card-body">
                <form role="form" action="/pricelist/import" method="POST">
                  @csrf
                  <div class="form-group">
                    <label for="product_category">Products Category</label>
                    <select class="form-control" id="product_category" name="product_category_id" aria-describedby="productCategory" required>
                      <option value="">Select Products Category</option>
                      @foreach ($product_categories as $product_category)
                      <option value="{{ $product_category['id'] }}">{{ $product_category['name']  }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="upload">Upload</label>
                    <input type="file" class="form-control" id="upload" name="template" accept=".csv" required>
                  </div>
                  <div class="mx-auto">
                    <button type="submit" class="btn btn-primary text-right">Import File</button></div>
                </form>
              </div>
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-4">
            <div class="card bg-light mb-3">
              <div class="card-header bg-primary text-white"><i class="fa fa-download"></i> &nbsp; Download Template</div>
              <div class="card-body">
                <p>
                  <i class="fa fa-file-csv"></i>
                  <a href="/assets/files/pricelist_template.csv" download>
                    Pricelist Template
                  </a>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>