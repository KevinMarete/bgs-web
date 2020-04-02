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
                    <div class="input-group input-group-sm col-md-11">
                        <input type="text" class="form-control search" aria-label="Small" aria-describedby="inputGroup-sizing-sm" placeholder="Search...">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-secondary btn-number">
                                <i class="fa fa-search"></i>
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
                <div class="row product_list">
                    @foreach ($products as $product)
                        @if ($product['offer']['valid_until'] >= now())
                            <div class="col-12 col-md-4 col-lg-3  box">
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
                                            <a href="#" title="View Product" class="molecular_name">{{ $product['product_now']['product']['molecular_name'] }}</a>
                                        </h4>
                                        <hr/>
                                        <p class="card-text product-description">
                                            <strong class="brand_name">{{ $product['product_now']['product']['brand_name'] }}</strong> <br/>
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
                </div>
            </div>
        </div>
    </div>
</div>