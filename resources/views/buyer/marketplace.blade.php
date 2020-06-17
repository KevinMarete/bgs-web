<div class="sb-page-header pb-10 sb-page-header-dark">
</div>
<div class="container-fluid mt-n10" style="height: 100vh;">
  @if (Session::has('bgs_msg'))
  {!! session('bgs_msg') !!}
  @endif
  <div class="row mt-2" style="height: 40%">
    <div class="col-9">
      <div class="col-12" style="height:100%;border: 1px solid;">
        Promotion-Slider
      </div>
    </div>
    <div class="col-3">
      <div class="col-12" style="height:50%;border: 1px solid;">
        Promotion-Static-1
      </div>
      <div class="col-12" style="height:50%;border: 1px solid;">
        Promotion-Static-2
      </div>
    </div>
  </div>
  <div class="row mt-2" style="height: 30%">
    <div class="col-3">
      <div class="col-12" style="height:50%;border: 1px solid;">
        Promotion-Static-3
      </div>
      <div class="col-12" style="height:50%;border: 1px solid;">
        Promotion-Static-4
      </div>
    </div>
    <div class="col-9">
      <div class="col-12" style="height:100%;border: 1px solid;">
        Top Selling Products
      </div>
    </div>
  </div>
  <div class="row mt-2" style="height: 30%">
    <div class="col-12">
      <div class="col-12" style="height:100%;border: 1px solid;">
        Offers of the Day
      </div>
    </div>
  </div>
</div>