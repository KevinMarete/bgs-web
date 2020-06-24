<div class="sb-page-header pb-10 sb-page-header-dark bg-gradient-primary-to-secondary">
  <div class="container-fluid">
    <div class="sb-page-header-content py-5">
      <h1 class="sb-page-header-title">
        <div class="sb-page-header-icon"><i data-feather="activity"></i></div>
        <span>OrderNow</span>
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
      <div class="container">
        <form class="form-inline my-2 my-lg-0 row">
          <!-- hidden sort control -->
          <div style="display: none" data-jplist-control="hidden-sort" data-group="products" data-path=".molecular_name" data-order="asc" data-type="text">
          </div>

          <!-- text filter control -->
          <div class="input-group input-group-md col-md-11">
            <input class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" data-jplist-control="textbox-filter" data-group="products" data-name="product-filter" data-path=".molecular_name, .brand_name" type="text" value="" data-clear-btn-id="name-clear-btn" placeholder="Search..." />

            <div class="input-group-append">
              <button type="button" class="btn btn-success btn-number" id="name-clear-btn">
                <i data-feather="refresh-cw"></i>
              </button>
            </div>
          </div>

          <a class="btn btn-success btn-md col-md-1" href="/cart">
            <i class="fa fa-shopping-cart"></i> Cart
            <span class="badge badge-light ml-1">{{ sizeof(session()->get('cart')) }}</span>
          </a>
        </form>
      </div>
    </div>

    <div class="card-body">
      <div class="col">
        <div class="row" data-jplist-group="products">
          @foreach ($products as $product)
          @if ($product['is_published'])
          <div class="col-12 col-md-4 col-lg-3 mb-4" data-jplist-item>
            <div class="card">
              <div class="row">
                <div class="col">
                  <img class="card-img-top img-thumbnail mx-auto d-block" src="/assets/img/medicine.png" alt="Card image cap">
                </div>
                <div class="col">
                  <p class="btn btn-sm btn-warning btn-block">KES {{ number_format($product['unit_price'], 2) }}</p>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <form role="form" action="/add-cart" method="POST">
                    @csrf
                    <input type="hidden" class="form-control" name="product_id" value="{{ $product['id'] }}">
                    <input type="hidden" class="form-control" name="quantity" value="1">
                    <input type="hidden" class="form-control" name="price" value="{{ $product['unit_price'] }}">
                    <input type="hidden" class="form-control" name="delivery" value="{{ $product['delivery_cost'] }}">
                    <input type="hidden" class="form-control" name="discount" value="0">
                    <input type="hidden" class="form-control" name="sub_total" value="{{ $product['unit_price']*1 }}">
                    <input type="hidden" class="form-control" name="product_name" value="{{ $product['product']['molecular_name'] }}">
                    <input type="hidden" class="form-control" name="product_description" value="{{ $product['product']['brand_name'].' Packsize:'.$product['product']['pack_size'].' Strength:'.$product['product']['strength'] }}">
                    <input type="hidden" class="form-control" name="organization_id" value="{{ $product['organization_id'] }}">
                    <input type="hidden" class="form-control" name="organization_name" value="{{ $product['organization']['name'] }}">
                    <input type="hidden" class="form-control" name="organization_email" value="{{ $product['user']['email'] }}">
                    <button type="submit" class="btn btn-sm btn-success btn-block">Add to cart</button>
                  </form>
                </div>
              </div>
              <div class="card-body">
                <h4 class="card-title product-title">
                  <a href="#" title="View Product" class="molecular_name">{{ strtoupper($product['product']['molecular_name']) }}</a>
                </h4>
                <hr />
                <p class="card-text product-description">
                  <strong class="brand_name">{{ strtoupper($product['product']['brand_name']) }}</strong> <br />
                  <strong>Packsize:</strong> {{ $product['product']['pack_size'] }} <br />
                  <strong>Vendor:</strong> {{ $product['organization']['name'] }}
                </p>
              </div>
            </div>
          </div>
          @endif
          @endforeach
          <!-- no results control -->
          <div data-jplist-control="no-results" data-group="products" data-name="no-results">No Results Found</div>
        </div>
        <!-- pagination control -->
        <div class="row justify-content-center">
          <nav class="mt-3" data-jplist-control="pagination" data-group="products" data-items-per-page="{{ $products_per_page }}" data-current-page="0" data-disabled-class="disabled" data-selected-class="active" data-name="pagination1">

            <!-- first and previous buttons -->
            <ul class="pagination d-inline-flex">
              <li class="page-item" data-type="first"><a class="page-link" href="#">First</a></li>
              <li class="page-item" data-type="prev"><a class="page-link" href="#">Previous</a></li>
            </ul>

            <!-- pages buttons -->
            <ul class="pagination d-inline-flex" data-type="pages">
              <li class="page-item" data-type="page"><a class="page-link" href="#">{pageNumber}</a></li>
            </ul>

            <!-- next and last buttons -->
            <ul class="pagination d-inline-flex">
              <li class="page-item" data-type="next"><a class="page-link" href="#">Next</a></li>
              <li class="page-item" data-type="last"><a class="page-link" href="#">Last</a></li>
            </ul>

            <!-- information labels -->
            <span data-type="info" class="badge badge-warning ml-3 p-2">
              Page {pageNumber} of {pagesNumber}
            </span>

          </nav>
        </div>
      </div>
    </div>
  </div>
</div>