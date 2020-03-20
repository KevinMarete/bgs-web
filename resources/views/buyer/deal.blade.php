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
    <div class="card mb-4">
        <div class="card-header"> 
            <div class="container">
                <form class="form-inline my-2 my-lg-0 row">
                    <div class="input-group input-group-sm col-md-11">
                        <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" placeholder="Search...">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-secondary btn-number">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <a class="btn btn-success btn-sm col-md-1" href="/cart">
                        <i class="fa fa-shopping-cart"></i> Cart
                        <span class="badge badge-light ml-1">3</span>
                    </a>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="col">
                <div class="row">
                    @foreach ($products as $product)
                        @if ($product['offer']['valid_until'] >= now())
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="card">
                                    <img class="card-img-top img-thumbnail" src="/assets/img/medicine.png" alt="Card image cap">
                                    <div class="card-body">
                                        <h4 class="card-title"><a href="product.html" title="View Product">{{ $product['product_now']['product']['molecular_name'] }}</a></h4>
                                        <p class="card-text">
                                            <strong>{{ $product['product_now']['product']['brand_name'] }}</strong> <br/>
                                            <strong>Packsize:</strong> {{ $product['product_now']['product']['pack_size'] }} <br/>
                                            <strong>Strength:</strong> {{ $product['product_now']['product']['strength'] }} <br/>
                                            <strong>Discount:</strong> {{ $product['offer']['discount']. '%'}} <br/>
                                            <strong>MinimumOrderQTY:</strong> {{ $product['minimum_order_quantity'] }}
                                        </p>
                                        <div class="row">
                                            <div class="col">
                                                <p class="btn btn-danger btn-block">KES 
                                                    <del>{{ $product['product_now']['unit_price'] }}</del> 
                                                    {{ ($product['product_now']['unit_price'] - ($product['offer']['discount'] * $product['product_now']['unit_price'])/100) }}
                                                </p>
                                            </div>
                                            <div class="col">
                                                <a href="#" class="btn btn-success btn-block add_cart" data-product="{{ $product['id'] }}">Add to cart</a>
                                            </div>
                                        </div>
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