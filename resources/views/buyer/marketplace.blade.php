<div class="sb-page-header pb-10 sb-page-header-dark">
</div>
<div class="container-fluid mt-n10">
  @if (Session::has('bgs_msg'))
  {!! session('bgs_msg') !!}
  @endif
  <div class="row mt-2">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header p-2">
          <h6 class="mb-0">PROMOTIONS</h6>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-2 col-md-2 col-12 p-0">
              @foreach ($promotions['static-left'] as $promotion)
              <div class="text-center pb-2">
                <div class="product tumbnail thumbnail-3">
                  @if(!$promotion['is_promotion'])
                  <a href="#"><img src="{{ $promotion['display_url'] }}" alt="" height="80"></a>
                  <div class="caption">
                    <h6 class="text-truncate" data-toggle="tooltip" data-placement="top" title="{{ $promotion['product_now']['product']['brand_name'] }}">
                      <small>{{ $promotion['product_now']['product']['brand_name'] }}</small>
                    </h6>
                    <span class="price">KES {{ number_format($promotion['product_now']['unit_price'], 2) }}</span>
                  </div>
                  <a href="/ordernow/{{ $promotion['product_now']['product_id'].'/'.$promotion['product_now']['organization_id'] }}" class="btn btn-sm btn-warning">Shop Now</a>
                  @else
                  <div class="img-wrapper">
                    <img class="img-responsive mb-1 w-100 rounded" height="190" src="{{ $promotion['display_url'] }}">
                    <div class="img-overlay text-right">
                      <a href="/ordernow/{{ $promotion['product_now']['product_id'].'/'.$promotion['product_now']['organization_id'] }}" class="btn btn-sm btn-warning">Shop Now</a>
                    </div>
                  </div>
                  @endif
                </div>
              </div>
              @endforeach
            </div>
            <div class="col-lg-8 col-md-8 col-12">
              <div class="row">
                <div class="col-12">
                  <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                      <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                      @foreach ($promotions['slider'] as $key=>$promotion)
                      <li data-target="#carouselExampleIndicators" data-slide-to="{{ $key+1 }}"></li>
                      @endforeach
                    </ol>
                    <div class="carousel-inner">
                      <div class="carousel-item active">
                        <img class="d-block w-100 rounded mx-auto" src="{{ env('PROMOTIONS_DEFAULT_IMAGE') }}" alt="Default Promotion" height="395">
                      </div>
                      @foreach ($promotions['slider'] as $promotion)
                      <div class="carousel-item">
                        <img class="d-block w-100 rounded mx-auto" src="{{ $promotion['display_url'] }}" alt="Promotion Image" height="395">
                        <div class="carousel-caption d-none d-md-block text-right">
                          <a href="/ordernow/{{ $promotion['product_now']['product_id'].'/'.$promotion['product_now']['organization_id'] }}" class="btn btn-sm btn-warning">Shop Now</a>
                        </div>
                      </div>
                      @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                      <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="sr-only">Next</span>
                    </a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-2 col-md-2 col-12">
              @foreach ($promotions['static-right'] as $promotion)
              <div class="text-center p-2">
                <div class="product tumbnail thumbnail-3">
                  @if(!$promotion['is_promotion'])
                  <a href="#"><img src="{{ $promotion['display_url'] }}" alt="" height="80"></a>
                  <div class="caption">
                    <h6 class="text-truncate" data-toggle="tooltip" data-placement="top" title="{{ $promotion['product_now']['product']['brand_name'] }}">
                      <small>{{ $promotion['product_now']['product']['brand_name'] }}</small>
                    </h6>
                    <span class="price">KES {{ number_format($promotion['product_now']['unit_price'], 2) }}</span>
                  </div>
                  <a href="/ordernow/{{ $promotion['product_now']['product_id'].'/'.$promotion['product_now']['organization_id'] }}" class="btn btn-sm btn-warning">Shop Now</a>
                  @else
                  <div class="img-wrapper">
                    <img class="img-responsive mb-1 w-100 rounded" height="190" src="{{ $promotion['display_url'] }}">
                    <div class="img-overlay text-right">
                      <a href="/ordernow/{{ $promotion['product_now']['product_id'].'/'.$promotion['product_now']['organization_id'] }}" class="btn btn-sm btn-warning">Shop Now</a>
                    </div>
                  </div>
                  @endif
                </div>
              </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row mt-2">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header p-2">
          <h6 class="mb-0">OFFERS OF THE DAY</h6>
          <a href="/offers-day" class="ml-auto p-2">View All Offers</a>
        </div>
        <div class="card-body">
          <div class="row">
            @if(empty($offers))
            <p class="bg-info p-2">
              There are no offers at the moment!
            </p>
            @endif
            @foreach ($offers as $offer)
            <div class="col-lg-2 col-md-2 col-sm-4 col-6 p-2">
              <div class="product tumbnail thumbnail-3"><a href="#"><img src="{{ $offer['display_url'] }}" alt="" height="80" width="100%"></a>
                <div class="caption">
                  <h6 class="text-truncate" data-toggle="tooltip" data-placement="top" title="{{ $offer['product_now']['product']['brand_name'] }}">
                    <small>{{ $offer['product_now']['product']['brand_name'] }}</small>
                  </h6>
                  <h6><small><b>Valid Until:</b> {{ $offer['valid_until'] }}</small></h6>
                  <h6><small><b>Organization:</b> {{ $offer['organization']['name'] }}</small></h6>
                  <hr />
                  <span class="price">
                    <del class="text-danger">KES {{ number_format($offer['product_now']['unit_price'], 2) }}</del>
                  </span>
                  <span class="price sale">KES {{ number_format(((100 - $offer['discount'])/100) * $offer['product_now']['unit_price'], 2) }}</span>
                </div>
                <a href="/offers-day/{{ $offer['product_now']['product_id'] }}" class="btn btn-sm btn-warning">Shop Now</a>
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row mt-2">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header p-2">
          <h6 class="mb-0">TOP SELLING PRODUCTS</h6>
          <a href="/ordernow" class="ml-auto p-2">View All Products</a>
        </div>
        <div class="card-body">
          <div class="row">
            @foreach ($top_products as $top_product)
            <div class="col-lg-2 col-md-2 col-sm-4 col-6 p-2">
              <div class="product tumbnail thumbnail-3"><a href="#"><img src="{{ env('PRODUCT_DEFAULT_IMAGE') }}" alt="" height="80"></a>
                <div class="caption">
                  <h6 class="text-truncate" data-toggle="tooltip" data-placement="top" title="{{ $top_product['product']['brand_name'] }}"><small>{{ $top_product['product']['brand_name'] }}</small></h6><span class="price">KES {{ number_format($top_product['unit_price'], 2) }}</span>
                </div>
                <a href="/ordernow/{{ $top_product['product']['id'] }}" class="btn btn-sm btn-warning">Shop Now</a>
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</div>