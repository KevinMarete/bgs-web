<div class="sb-page-header pb-10 sb-page-header-dark bg-gradient-primary-to-secondary">
    <div class="container-fluid">
        <div class="sb-page-header-content py-5">
            <h1 class="sb-page-header-title">
                <div class="sb-page-header-icon"><i data-feather="activity"></i></div>
                <span>Manage Products - {{ ucwords($manage_label) }}</span>
            </h1>
        </div>
    </div>
</div>
<div class="container-fluid mt-n10">
    <div class="card mb-4">
        <div class="card-header"> </div>
        <div class="card-body">
            <form role="form" action="/manage/products/{{ $manage_label }}" method="POST">
                @csrf
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">MolecularName</label>
                    <div class="col-lg-9">
                        <input class="form-control" type="hidden" value="{{ isset($edit['id']) ? $edit['id'] : '' }}" name="id" required>
                        <input class="form-control" type="text" value="{{ isset($edit['molecular_name']) ? $edit['molecular_name'] : '' }}" name="molecular_name" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">BrandName</label>
                    <div class="col-lg-9">
                        <input class="form-control" type="text" value="{{ isset($edit['brand_name']) ? $edit['brand_name'] : '' }}" name="brand_name" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Packsize</label>
                    <div class="col-lg-3">
                        <input class="form-control" type="text" value="{{ isset($edit['pack_size']) ? $edit['pack_size'] : '' }}" name="pack_size" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
                    </div>
                    <label class="col-lg-3 col-form-label form-control-label">MinimumOrderQty</label>
                    <div class="col-lg-3">
                        <input class="form-control" type="text" value="{{ isset($edit['minimum_order_quantity']) ? $edit['minimum_order_quantity'] : '' }}" name="minimum_order_quantity" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">UnitPrice</label>
                    <div class="col-lg-3">
                        <input class="form-control" type="text" value="{{ isset($edit['unit_price']) ? $edit['unit_price'] : '' }}" name="unit_price" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
                    </div>
                    <label class="col-lg-3 col-form-label form-control-label">DeliveryCost</label>
                    <div class="col-lg-3">
                        <input class="form-control" type="text" value="{{ isset($edit['delivery_cost']) ? $edit['delivery_cost'] : '' }}" name="delivery_cost" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">ProductCategory</label>
                    <div class="col-lg-9">
                        <select class="form-control" size="0" name="product_category_id" required>
                            <option value="">Select Product Category</option>
                            @foreach ($product_categories as $product_category)
                                @if ($product_category['id'] === (isset($edit['product_category_id']) ? $edit['product_category_id'] : ''))
                                    <option value="{{ $product_category['id'] }}" selected>{{ $product_category['name'] }}</option>
                                @else
                                    <option value="{{ $product_category['id'] }}">{{ $product_category['name'] }}</option>
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