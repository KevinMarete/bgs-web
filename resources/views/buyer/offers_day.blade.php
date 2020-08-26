<div class="sb-page-header pb-10 sb-page-header-dark bg-gradient-primary-to-secondary">
  <div class="container-fluid">
    <div class="sb-page-header-content py-5">
      <h1 class="sb-page-header-title">
        <div class="sb-page-header-icon"><i data-feather="activity"></i></div>
        <span>Deals</span>
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
          @if($is_sort)
          <div style="display: none" data-jplist-control="hidden-sort" data-group="products" data-path=".molecular_name" data-order="asc" data-type="text">
          </div>
          @endif

          <!-- select category filter control -->
          <select data-jplist-control="select-filter" data-group="products" data-name="categoryfilter" class="form-control input-md input-group input-group-md col-sm-12 col-md-6 col-lg-3 m-2">
            <option value="0" data-path="default">Filter by Category</option>
            @foreach ($productcategories as $index => $productcategory)
            <option value="{{ $index + 1 }}" data-path=".{{ str_replace(' ', '_', $productcategory['name']) }}">{{ strtoupper($productcategory['name']) }}</option>
            @endforeach
          </select>

          <!-- select organization filter control -->
          <select data-jplist-control="select-filter" data-group="products" data-name="organizationfilter" class="form-control input-md input-group input-group-md col-sm-12 col-md-6 col-lg-3 m-2">
            <option value="0" data-path="default">Filter by Organization</option>
            @foreach ($organizations as $index => $organization)
            <option value="{{ $index + 1 }}" data-path=".{{ str_replace(' ', '_', $organization['name']) }}">{{ strtoupper($organization['name']) }}</option>
            @endforeach
          </select>

          <!-- text filter control -->
          <div class="input-group input-group-md col-sm-12 col-md-6 col-lg-4 m-2">
            <input class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" data-jplist-control="textbox-filter" data-group="products" data-name="product-filter" data-path=".molecular_name, .brand_name" type="text" value="" data-clear-btn-id="name-clear-btn" placeholder="Search..." />

            <div class="input-group-append">
              <button type="button" class="btn btn-success btn-number" id="name-clear-btn">
                <i data-feather="refresh-cw"></i>
              </button>
            </div>
          </div>

          <a class="btn btn-success btn-sm col-sm-12 col-md-6 col-lg-1 m-2" href="/cart">
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
          @if (now() >= $product['valid_from'] && now() <= $product['valid_until']) <div class="col-12 col-md-4 col-lg-3 mb-4" data-jplist-item>
            <div class="card">
              <div class="row">
                <div class="col">
                  <img class="card-img-top img-thumbnail" src="{{ $product['display_url'] }}" alt="Card image cap" style="max-width: 100%;">
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <p class="btn btn-sm btn-warning btn-block mt-1 mb-1">KES
                    <del>{{ number_format($product['product_now']['unit_price'], 2) }}</del>
                    {{ number_format($product['product_now']['unit_price'] - ($product['discount'] * $product['product_now']['unit_price'])/100, 2) }}
                  </p>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <form role="form" action="/add-cart" method="POST">
                    @csrf
                    <input type="hidden" class="form-control" name="product_id" value="{{ $product['product_now']['id'] }}">
                    <input type="hidden" class="form-control" name="quantity" value="{{ $product['min_order_quantity'] }}">
                    <input type="hidden" class="form-control" name="price" value="{{ ($product['product_now']['unit_price'] - ($product['discount'] * $product['product_now']['unit_price'])/100) }}">
                    <input type="hidden" class="form-control" name="delivery" value="{{ $product['product_now']['delivery_cost'] }}">
                    <input type="hidden" class="form-control" name="discount" value="{{ round(($product['discount']/100), 2) }}">
                    <input type="hidden" class="form-control" name="sub_total" value="{{ ($product['product_now']['unit_price'] - ($product['discount'] * $product['product_now']['unit_price'])/100)*$product['min_order_quantity'] }}">
                    <input type="hidden" class="form-control" name="product_name" value="{{ $product['product_now']['product']['molecular_name'] }}">
                    <input type="hidden" class="form-control" name="product_description" value="{{ $product['product_now']['product']['brand_name'].' Packsize:'.$product['product_now']['product']['pack_size'].' Strength:'.$product['product_now']['product']['strength'] }}">
                    <input type="hidden" class="form-control" name="organization_id" value="{{ $product['product_now']['organization_id'] }}">
                    <input type="hidden" class="form-control" name="organization_name" value="{{ $product['product_now']['organization']['name'] }}">
                    <input type="hidden" class="form-control" name="organization_email" value="{{ $product['product_now']['user']['email'] }}">
                    <button type="submit" class="btn btn-sm btn-success btn-block">Add to cart</button>
                  </form>
                </div>
              </div>
              <div class="card-body">
                <h4 class="card-title product-title">
                  <a href="#" title="View Product" class="molecular_name">{{ strtoupper($product['product_now']['product']['brand_name']) }}</a>
                </h4>
                <hr />
                <p class="card-text product-description">
                  <strong class="brand_name">{{ strtoupper($product['product_now']['product']['molecular_name']) }}</strong> <br />
                  <strong>Packsize:</strong> {{ $product['product_now']['product']['pack_size'] }} <br />
                  <strong>Discount:</strong> {{ $product['discount']. '%'}} <br />
                  <strong>MinimumOrderQTY:</strong> {{ $product['min_order_quantity'] }} <br />
                  <strong>Category:</strong> <span class="{{ str_replace(' ', '_', $product['product_now']['product']['product_category']['name']) }}">{{ $product['product_now']['product']['product_category']['name'] }}</span> <br />
                  <strong>Vendor:</strong> <span class="{{ $product['product_now']['organization']['name'] }}">{{ $product['product_now']['organization']['name'] }}</span>
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