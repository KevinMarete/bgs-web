<div class="sb-page-header pb-10 sb-page-header-dark bg-gradient-primary-to-secondary">
    <div class="container-fluid">
        <div class="sb-page-header-content py-5">
            <h1 class="sb-page-header-title">
                <div class="sb-page-header-icon"><i data-feather="activity"></i></div>
                <span>New {{ ucwords($type) }} Promotion</span>
            </h1>
        </div>
    </div>
</div>
<div class="container-fluid mt-n10">
    @if (Session::has('bgs_msg'))
    {!! session('bgs_msg') !!}
    @endif
    <div class="card mb-4">
        <div class="card-header"> </div>
        <div class="card-body">
            <form role="form" action="/promotions/save" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">DisplayDates</label>
                    <div class="col-lg-6">
                        <input class="form-control" type="hidden" id="booking_Limit" value="{{ $booking_limit }}" />
                        <input class="form-control" type="hidden" id="bookings" value="{{ $bookings }}" />
                        <input class="form-control" type="hidden" name="type" value="{{ $type }}" />
                        <input class="form-control" type="hidden" id="promotion_cost" name="promotion_cost" value="{{ $promotion_cost }}" />
                        <input class="form-control" type="hidden" name="display_date" value="" />
                        <div class="display_date"></div>
                        <p class="bg-info mt-2 p-2">
                            {!!$promotion_discount_description!!}
                        </p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">DisplayImage</label>
                    <div class="col-lg-6">
                        <input type="file" name="upload" accept="image/x-png,image/jpeg" required />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">PricelistProduct</label>
                    <div class="col-lg-6">
                        <select class="form-control" size="0" name="product_now_id" required>
                            <option value="">Select Product</option>
                            @foreach ($productnows as $productnow)
                            <option value="{{ $productnow['id'] }}">{{ $productnow['product']['brand_name'].'-'.$productnow['product']['molecular_name'] }}</option>
                            @endforeach
                        </select>
                        <p class="bg-warning mt-2 p-2">
                            Please note you will be charged a total of <strong>KES.<span id="total_promotion_cost">0</span></strong> for this transaction
                        </p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label"></label>
                    <div class="col-lg-9">
                        <button type="reset" class="btn btn-secondary"><i class="fa fa-refresh"></i>&nbsp;Cancel</button>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>