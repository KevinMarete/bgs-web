<div class="sb-page-header pb-10 sb-page-header-dark bg-gradient-primary-to-secondary">
    <div class="container-fluid">
        <div class="sb-page-header-content py-5">
            <h1 class="sb-page-header-title">
                <div class="sb-page-header-icon"><i data-feather="activity"></i></div>
                <span>Promos</span>
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
                    <div
                        style="display: none"
                        data-jplist-control="hidden-sort"
                        data-group="products"
                        data-path=".molecular_name"
                        data-order="asc"
                        data-type="text">
                    </div>

                    <!-- text filter control -->
                    <div class="input-group input-group-md col-md-11">
                        <input
                            class="form-control" 
                            aria-label="Small" 
                            aria-describedby="inputGroup-sizing-sm"
                            data-jplist-control="textbox-filter"
                            data-group="products"
                            data-name="product-filter"
                            data-path=".molecular_name, .brand_name"
                            type="text"
                            value=""
                            data-clear-btn-id="name-clear-btn"
                            placeholder="Search..." />

                        <div class="input-group-append">
                            <button type="button" class="btn btn-success btn-number" id="name-clear-btn">
                                <i data-feather="refresh-cw"></i>
                            </button>
                        </div>
                    </div>

                    <a class="btn btn-success btn-sm col-md-1" href="/cart">
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
                        @if ($product['offer']['valid_until'] >= now())
                            <div class="col-12 col-md-4 col-lg-3" data-jplist-item>
                                <div class="card">
                                    <div class="row">
                                        <div class="col">
                                            <img class="card-img-top img-thumbnail" src="/assets/img/medicine.png" alt="Card image cap" width="300" height="200">
                                        </div>
                                        <div class="col">
                                            <p class="btn btn-warning btn-block">KES 
                                                <del>{{ number_format($product['product_now']['unit_price']) }}</del> 
                                                {{ number_format($product['product_now']['unit_price'] - ($product['offer']['discount'] * $product['product_now']['unit_price'])/100) }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <form role="form" action="/add-cart" method="POST">
                                                @csrf
                                                <input type="hidden" class="form-control" name="product_id" value="{{ $product['product_now']['id'] }}">
                                                <input type="hidden" class="form-control" name="quantity" value="1">
                                                <input type="hidden" class="form-control" name="price" value="{{ ($product['product_now']['unit_price'] - ($product['offer']['discount'] * $product['product_now']['unit_price'])/100) }}">
                                                <input type="hidden" class="form-control" name="delivery" value="{{ $product['product_now']['delivery_cost'] }}">
                                                <input type="hidden" class="form-control" name="discount" value="{{ round(($product['offer']['discount']/100), 2) }}">
                                                <input type="hidden" class="form-control" name="sub_total" value="{{ ($product['product_now']['unit_price'] - ($product['offer']['discount'] * $product['product_now']['unit_price'])/100)*1 }}">
                                                <input type="hidden" class="form-control" name="product_name" value="{{ $product['product_now']['product']['molecular_name'] }}">
                                                <input type="hidden" class="form-control" name="product_description" value="{{ $product['product_now']['product']['brand_name'].' Packsize:'.$product['product_now']['product']['pack_size'].' Strength:'.$product['product_now']['product']['strength'] }}">
                                                <input type="hidden" class="form-control" name="organization_id" value="{{ $product['product_now']['organization_id'] }}">
                                                <input type="hidden" class="form-control" name="organization_name" value="{{ $product['product_now']['organization']['name'] }}">
                                                <input type="hidden" class="form-control" name="organization_email" value="{{ $product['product_now']['user']['email'] }}">
                                                <button type="submit" class="btn btn-success btn-block">Add to cart</button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <h4 class="card-title product-title">
                                            <a href="#" title="View Product" class="molecular_name">{{ strtoupper($product['product_now']['product']['molecular_name']) }}</a>
                                        </h4>
                                        <hr/>
                                        <p class="card-text product-description">
                                            <strong class="brand_name">{{ strtoupper($product['product_now']['product']['brand_name']) }}</strong> <br/>
                                            <strong>Packsize:</strong> {{ $product['product_now']['product']['pack_size'] }} <br/>
                                            <strong>Strength:</strong> {{ $product['product_now']['product']['strength'] }} <br/>
                                            <strong>Discount:</strong> {{ $product['offer']['discount']. '%'}} <br/>
                                            <strong>CouponCode:</strong> {{ $product['coupon_code'] }} <br/>
                                            <strong>Vendor:</strong> {{ $product['product_now']['organization']['name'] }}
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
                    <nav    
                            class="mt-3"
                            data-jplist-control="pagination"
                            data-group="products"
                            data-items-per-page="{{ $products_per_page }}"
                            data-current-page="0"
                            data-disabled-class="disabled"
                            data-selected-class="active"
                            data-name="pagination1">

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