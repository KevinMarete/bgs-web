<div class="sb-page-header pb-10 sb-page-header-dark bg-gradient-primary-to-secondary">
    <div class="container-fluid">
        <div class="sb-page-header-content py-5">
            <h1 class="sb-page-header-title">
                <div class="sb-page-header-icon"><i data-feather="activity"></i></div>
                <span>Update Deal Item</span>
            </h1>
        </div>
    </div>
</div>
<div class="container-fluid mt-n10">
    <div class="card mb-4">
        <div class="card-header"> </div>
        <div class="card-body">
            <form role="form" action="/deals/{{ $manage_label }}" method="POST">
                @csrf
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">MinimumOrderQuantity</label>
                    <div class="col-lg-9">
                        <input class="form-control" type="hidden" value="{{ isset($edit['id']) ? $edit['id'] : '' }}" name="id" required>
                        <input class="form-control" type="text" value="{{ isset($edit['minimum_order_quantity']) ? $edit['minimum_order_quantity'] : '' }}" name="minimum_order_quantity" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Offer</label>
                    <div class="col-lg-9">
                        <select class="form-control" size="0" name="offer_id" required>
                            <option value="">Select Offer</option>
                            @foreach ($offers as $offer)
                            @if ($offer['id'] === $edit['offer_id'])
                            <option value="{{ $offer['id'] }}" selected>{{ $offer['description'].'('.$offer['valid_from'].' to '.$offer['valid_until'].') ('.$offer['discount'].'% Discount)' }}</option>
                            @else
                            <option value="{{ $offer['id'] }}">{{ $offer['description'].'('.$offer['valid_from'].' to '.$offer['valid_until'].') ('.$offer['discount'].'%' }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Product</label>
                    <div class="col-lg-9">
                        <select class="form-control" size="0" name="product_now_id" readonly>
                            @foreach ($productnows as $productnow)
                            @if ($productnow['product']['id'] === $edit['product_now']['product_id'])
                            <option value="{{ $productnow['id'] }}" selected>{{ $productnow['product']['molecular_name'].'-'.$productnow['product']['brand_name'] }}</option>
                            @endif
                            @endforeach
                        </select>
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