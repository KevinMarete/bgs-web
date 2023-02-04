<div class="sb-page-header pb-10 sb-page-header-dark bg-gradient-primary-to-secondary">
    <div class="container-fluid">
        <div class="sb-page-header-content py-5">
            <h1 class="sb-page-header-title">
                <div class="sb-page-header-icon"><i data-feather="activity"></i></div>
                <span>Manage OrganizationSupplierCategories - {{ ucwords($manage_label) }}</span>
            </h1>
        </div>
    </div>
</div>
<div class="container-fluid mt-n10">
    <div class="card mb-4">
        <div class="card-header"></div>
        <div class="card-body">
            <form role="form" action="/manage/organizationsuppliercategories/{{ $manage_label }}" method="POST">
                @csrf
                @if($role_name == 'admin')
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label">Supplier</label>
                        <div class="col-lg-9">
                            <select class="form-control" size="0" name="organization_id" required>
                                <option value="">Select Supplier</option>
                                @foreach ($sellers as $seller)
                                    @if ($seller['id'] === (isset($edit['organization_id']) ? $edit['organization_id'] : ''))
                                        <option value="{{ $seller['id'] }}" selected>{{ $seller['name'] }}</option>
                                    @else
                                        <option value="{{ $seller['id'] }}">{{ $seller['name'] }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                @else
                    <input type="hidden" name="organization_id"
                           value="{{ isset($edit['organization_id']) ? $edit['organization_id'] : $organization_id }}">
                @endif
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">SupplierCategory</label>
                    <div class="col-lg-9">
                        <input class="form-control" type="hidden" value="{{ isset($edit['id']) ? $edit['id'] : '' }}"
                               name="id" required>
                        <select class="form-control" size="0" name="supplier_category_id" required>
                            <option value="">Select SupplierCategory</option>
                            @foreach ($product_categories as $product_category)
                                @if ($product_category['id'] === (isset($edit['supplier_category_id']) ? $edit['supplier_category_id'] : ''))
                                    <option value="{{ $product_category['id'] }}"
                                            selected>{{ $product_category['name'] }}</option>
                                @else
                                    <option
                                        value="{{ $product_category['id'] }}">{{ $product_category['name'] }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label"></label>
                    <div class="col-lg-9">
                        <button type="reset" class="btn btn-secondary"><i class="fa fa-refresh"></i>&nbsp;Cancel
                        </button>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
