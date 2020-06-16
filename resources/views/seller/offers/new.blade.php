<div class="sb-page-header pb-10 sb-page-header-dark bg-gradient-primary-to-secondary">
  <div class="container-fluid">
    <div class="sb-page-header-content py-5">
      <h1 class="sb-page-header-title">
        <div class="sb-page-header-icon"><i data-feather="activity"></i></div>
        <span>{{ ucwords($manage_label) }} Offer</span>
      </h1>
    </div>
  </div>
</div>
<div class="container-fluid mt-n10">
  <div class="card mb-4">
    <div class="card-header"> </div>
    <div class="card-body">
      <form role="form" action="/offers/{{ $manage_label }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">PricelistProduct(s)</label>
          <div class="col-lg-6">
            <input type="hidden" id="offer_cost" value="{{ $offer_cost }}" />
            <input type="hidden" id="valid_from" name="valid_from" value="" />
            <input type="hidden" id="valid_until" name="valid_until" value="" />
            <input type="hidden" id="total_offer_cost" name="total_offer_cost" value="" />
            <select class="form-control btn btn-outline-primary" size="0" name="product_now_ids[]" id="offer_productnows" multiple="multiple" required>
              @foreach ($productnows as $productnow)
              <option value="{{ $productnow['id'] }}">{{ $productnow['product']['brand_name'].'-'.$productnow['product']['molecular_name'] }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">ValidPeriod</label>
          <div class="col-lg-6">
            <input class="form-control valid_period" type="text" required />
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">DisplayImage</label>
          <div class="col-lg-6">
            <input type="file" name="upload" accept="image/x-png,image/jpeg" required />
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">Discount(%)</label>
          <div class="col-lg-6">
            <input class="form-control" type="text" value="" name="discount" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">MinimumOrderQuantity</label>
          <div class="col-lg-6">
            <input class="form-control" type="text" value="" name="min_order_quantity" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">MaximumDiscountAmount</label>
          <div class="col-lg-6">
            <input class="form-control" type="text" value="" placeholder="None" name="max_discount_amount" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
            <p class="bg-info mt-2 p-2">
              Offer charges are at KES. {{ number_format($offer_cost) }} per Day per Product
            </p>
            <p class="bg-warning mt-2 p-2">
              Please note you will be charged a total of <strong>KES.<span id="total_offer_cost_display">0</span></strong> for this transaction
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