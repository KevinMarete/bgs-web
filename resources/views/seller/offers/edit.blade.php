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
            <input type="hidden" id="id" value="{{ isset($edit['id']) ? $edit['id'] : '' }}" name="id" required>
            <input class="form-control" type="hidden" value="{{ isset($edit['status']) ? $edit['status'] : '' }}" name="status" required>
            <input class="form-control" type="hidden" value="{{ isset($edit['display_url']) ? $edit['display_url'] : '' }}" name="display_url" required>
            <input class="form-control" type="hidden" value="{{ isset($edit['organization_id']) ? $edit['organization_id'] : '' }}" name="organization_id" required>
            <select class="form-control" size="0" name="product_now_id" required>
              @foreach ($productnows as $productnow)
              @if ($productnow['product']['id'] === $edit['product_now']['product_id'])
              <option value="{{ $productnow['id'] }}" selected>{{ $productnow['product']['molecular_name'].'-'.$productnow['product']['brand_name'] }}</option>
              @else
              <option value="{{ $productnow['id'] }}">{{ $productnow['product']['molecular_name'].'-'.$productnow['product']['brand_name'] }}</option>
              @endif
              @endforeach
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">ValidFrom</label>
          <div class="col-lg-6">
            <input class="form-control" type="text" name="valid_from" value="{{ $edit['valid_from'] }}" readonly required />
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">ValidUntil</label>
          <div class="col-lg-6">
            <input class="form-control" type="text" name="valid_until" value="{{ $edit['valid_until'] }}" readonly required />
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">DisplayImage</label>
          <div class="col-lg-3">
            <img src="{{ isset($edit['display_url']) ? '/'.$edit['display_url'] : '' }}" alt="Image not loaded" width="100" height="100" class="img-fluid img-thumbnail">
          </div>
          <div class="col-lg-3">
            <input type="file" name="upload" accept="image/x-png,image/jpeg" />
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">Discount(%)</label>
          <div class="col-lg-6">
            <input class="form-control" type="text" value="{{ $edit['discount'] }}" name="discount" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">MinimumOrderQuantity</label>
          <div class="col-lg-6">
            <input class="form-control" type="text" value="{{ $edit['min_order_quantity'] }}" name="min_order_quantity" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">MaximumDiscountAmount</label>
          <div class="col-lg-6">
            <input class="form-control" type="text" value="{{ $edit['max_discount_amount'] }}" placeholder="None" name="max_discount_amount" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
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