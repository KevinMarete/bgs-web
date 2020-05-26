<div class="sb-page-header pb-10 sb-page-header-dark bg-gradient-primary-to-secondary">
    <div class="container-fluid">
        <div class="sb-page-header-content py-5">
            <h1 class="sb-page-header-title">
                <div class="sb-page-header-icon"><i data-feather="activity"></i></div>
                <span>Update PriceList Item</span>
            </h1>
        </div>
    </div>
</div>
<div class="container-fluid mt-n10">
    <div class="card mb-4">
        <div class="card-header"> </div>
        <div class="card-body">
            <form role="form" action="/pricelist/{{ $manage_label }}" method="POST">
                @csrf
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">UnitPrice</label>
                    <div class="col-lg-9">
                        <input type="hidden" value="{{ session()->get('organization_id') }}" name="organization_id" />
                        <input type="hidden" value="{{ session()->get('id') }}" name="user_id" />
                        <input class="form-control" type="hidden" value="{{ isset($edit['id']) ? $edit['id'] : '' }}" name="id" required>
                        <input class="form-control" type="text" value="{{ isset($edit['unit_price']) ? $edit['unit_price'] : '' }}" name="unit_price" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">DeliveryCost</label>
                    <div class="col-lg-9">
                        <input class="form-control" type="text" value="{{ isset($edit['delivery_cost']) ? $edit['delivery_cost'] : '' }}" name="delivery_cost" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Is_Published</label>
                    <div class="col-lg-9">
                        <select class="form-control" size="0" name="is_published" required>
                            @if ($edit['is_published'])
                            <option value="1" selected>Yes</option>
                            <option value="0">No</option>
                            @else
                            <option value="1">Yes</option>
                            <option value="0" selected>No</option>
                            @endif
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Product</label>
                    <div class="col-lg-9">
                        <select class="form-control" size="0" readonly name="product_id">
                            @foreach ($products as $product)
                            @if ($product['product_id'] === $edit['product_id'])
                            <option value="{{ $product['product_id'] }}" selected>{{ $product['molecular_name'].'-'.$product['brand_name'] }}</option>
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